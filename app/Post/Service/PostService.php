<?php

namespace App\Post\Service;

use Illuminate\Support\Facades\Storage;

use App\Base\Service\BaseService;

use App\Post\Model\Post;
use App\Post\Repository\PostRepository;

use App\Comment\Service\CommentService;

use App\Post\Transformer\PostTransformer;

use Illuminate\Support\Facades\Mail;
use App\Mail\PostChanges;
use App\Mail\PostAccepted;

use App\Authorization\Service\AuthorizationService;

use App\PostCategory\Repository\PostCategoryRepository;


class PostService extends BaseService
{
    public $transformer;

    function __construct(PostRepository $repository,
                         AuthorizationService $authServices,
                         PostTransformer $postTransformer,
                         CommentService $commentService,
                         PostCategoryRepository $postCategoryRepository)
    {
        $this->authServices = $authServices;
        $this->transformer = $postTransformer;
        $this->commentService = $commentService;
        $this->postCategoryRepository = $postCategoryRepository;

        parent::__construct($repository);
    }

    public function createPost($object, $authorId)
    {
        $this->validator->validatePostCreationData($object);
        $post = $this->createNewPost($object, $authorId);

        return $this->transformer->transform(parent::create($post));
    }

    public function get($id)
    {
        return $this->transformer->transform(parent::get($id));
    }

    public function delete($id)
    {
        return $this->transformer->transform(parent::delete($id));
    }

    public function updatePost($object, $authorId)
    {
        $this->validator->validatePostCreationData($object);
        $post = $this->repository->getInactivePost($object->id);

        $this->authServices->checkIsOwner($authorId, $post->owner);

        $updatedPost = $this->updatePostModel($post, $object, $authorId);

        return $this->transformer->transform($this->repository->create($updatedPost));
    }

    public function getAllPaginate($request)
    {
        $category = $request->category;
        $search = $request->search;
        $dataNum = $request->data_num;
        $ownerId = $request->owner;
        $recommended = $request->recommended;

        return $this->transformer->transform_response($this->repository
            ->getAllPaginate($ownerId, $category, $search, $dataNum, $recommended));
    }

    public function suggestPostChanges($request, $adminName, $adminSurname)
    {
        $post = $this->repository->getInactivePost($request->post_id);
        $postInfo = $this->takePostsInfo($post);

        $authorEmail = $postInfo[4];
        $authorName = $postInfo[0];
        $authorSurname = $postInfo[1];
        $postId = $postInfo[2];
        $postHeader = $postInfo[3];

        Mail::to($authorEmail)
            ->send(new PostChanges($authorName, $authorSurname,
                $postId, $postHeader,
                $request->changes, $adminName, $adminSurname));
    }

    public function publish($id, $adminName, $adminSurname)
    {
        $post = $this->repository->getInactivePost($id);
        $postInfo = $this->takePostsInfo($post);
        $publishedPost = $this->publishPost($post);

        $realPublished = $this->transformer->transform($this->getRepository()->create($publishedPost));

        $authorEmail = $postInfo[4];
        $authorName = $postInfo[0];
        $authorSurname = $postInfo[1];
        $postId = $postInfo[2];
        $postHeader = $postInfo[3];

        Mail::to($authorEmail)
            ->send(new PostAccepted($authorName, $authorSurname, $postId,
                $postHeader, $adminName, $adminSurname));

        return $realPublished;
    }

    public function getAllComments($request)
    {
        return $this->commentService->getAllPaginate($request);
    }


    private function createNewPost($request, $authorId)
    {
        $post = new Post;

        $postCategoryId = $this->takeCategoryId($request->category);

        $post->header_main = $request->header_main;
        $post->subheader = $request->subheader;
        $post->category = $postCategoryId;
        $post->posts_content = $request->posts_content;
        $post->owner = $authorId;
        $post->picture_links = (!is_null($request->pictures) ? collect($this->storeToFolder($request->pictures))->implode('----') : null);

        return $post;


    }

    private function takeCategoryId($categoryName)
    {
        $postCategory = $this->postCategoryRepository->get($categoryName);
        return $postCategory->id;

    }

    public function recommend($id)
    {
        $post = $this->repository->getInactivePost($id);
        $post->recommended = true;

        return $this->transformer->transform($this->getRepository()->create($post));
    }

    public function unrecommend($id)
    {
        $post = $this->repository->getInactivePost($id);
        $post->recommended = false;

        return $this->transformer->transform($this->getRepository()->create($post));
    }

    private function updatePostModel($post, $request, $authorId)
    {

        $postCategoryId = $this->takeCategoryId($request->category);

        $post->id = $request->id;
        $post->header_main = $request->header_main;
        $post->subheader = $request->subheader;
        $post->category = $postCategoryId;
        $post->posts_content = $request->posts_content;
        $post->owner = $authorId;
        $post->recommended = $request->recommended;
        $post->is_active = $request->is_active;
        $post->created_at = $request->created_at;
        $post->updated_at = $request->updated_at;

        return $post;
    }

    private function publishPost($post)
    {
        $post->is_active = true;
        return $post;
    }

    private function storeToFolder($listOfFiles)
    {
        $picturesPath = array();

        foreach ($listOfFiles as $file) {
            $name = $file->getClientOriginalName();
            $path = $file->storeAs('', $name, 'local');
            $completePath = Storage::disk('local')->path($path);
            array_push($picturesPath, $completePath);
        }

        return $picturesPath;
    }

    private function takePostsInfo($post)
    {
        $postArrayObject = $post->toArray();

        $responseArray = [$postArrayObject["author"]["name"],
            $postArrayObject["author"]["surname"], $postArrayObject["id"],
            $postArrayObject["header_main"], $postArrayObject["author"]["email"]];

        return $responseArray;
    }

}
