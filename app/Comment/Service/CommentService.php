<?php

namespace App\Comment\Service;

use App\Authorization\Service\AuthorizationService;

use App\Base\Service\BaseService;

use App\Comment\Model\Comment;
use App\Comment\Repository\CommentRepository;
use App\Comment\Transformer\CommentTransformer;

use App\User\Repository\UserRepository;

use App\Notifications\RankComment;


class CommentService extends BaseService
{
    private $transformer;

    function __construct(CommentRepository $repository,
                         AuthorizationService $authService,
                         UserRepository $userRepository,
                         CommentTransformer $commentTransformer)
    {
        $this->transformer = $commentTransformer;
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        parent::__construct($repository);
    }

    public function createComment($object, $authorId)
    {
        $this->validator->validateCommentCreationData($object);
        $comment = $this->createNewComment($object, $authorId);

        return $this->transformer->transform(parent::create($comment));
    }


    public function deleteComment($id, $visitorId)
    {

        $comment = $this->get($id);
        $this->authService->checkIsOwner($visitorId, $comment->user_id);


        return $this->transformer->transform(parent::delete($id));
    }

    public function updateComment($object, $visitorId)
    {
        $comment = $this->get($object->id);

        $this->authService->checkIsOwner($visitorId, $comment->user_id);

        $updatedComment = $this->updateCommentModel($comment, $object);

        return $this->transformer->transform($this->repository->create($updatedComment));
    }

    public function getAllPaginate($request)
    {
        $postId = $request->post_id;
        $dataNum = $request->data_num;
        $page = $request->page;

        return $this->transformer->transform_response($this->repository
            ->getAllPaginate($postId, $dataNum));
    }

    public function voteComment($id, $request)
    {
        $comment = $this->get($id);
        if ($request->vote < 0) {
            $comment->comment_votes = $comment->comment_votes - 1;
        } else {
            $comment->comment_votes = $comment->comment_votes + 1;
        }

        $updatedComment = $this->transformer->transform($this->repository->create($comment));
        $user = $this->userRepository->get($comment->user_id);

        $user->notify(new RankComment($request->vote, $comment->comment_votes));

        return $updatedComment;
    }


    private function createNewComment($request, $visitorId)
    {
        $comment = new Comment;

        $comment->post_id = $request->post_id;
        $comment->user_id = $visitorId;
        $comment->content = $request->content;

        return $comment;

    }

    private function updateCommentModel($comment, $object)
    {
        $comment->content = $object->content;
        return $comment;
    }

}
