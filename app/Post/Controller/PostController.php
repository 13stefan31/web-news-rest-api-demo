<?php

namespace App\Post\Controller;

use Illuminate\Support\Facades\Auth;

use App\Base\Controller\BaseController;
use Illuminate\Http\Request;

use App\Post\Service\PostService;

class PostController extends BaseController
{
    function __construct(PostService $service)
    {
        parent::__construct($service);
    }

    public function createPost(Request $request)
    {
        $author = Auth::guard('api')->user();
        return $this->service->createPost($request, $author->id);
    }

    public function getAllPagination(Request $request)
    {
        return $this->service->getAllPaginate($request);
    }

    public function updatePost(Request $request)
    {
        $author = Auth::guard('api')->user();
        return $this->service->updatePost($request, $author->id);
    }

    public function suggestChanges(Request $request)
    {
        $admin = Auth::guard('api')->user();
        $this->service->suggestPostChanges($request, $admin->name, $admin->surname);
        return Response()->json(["message" => "Email with changes is sent to author"]);
    }

    public function publish($id)
    {
        $admin = Auth::guard('api')->user();
        $this->service->publish($id, $admin->name, $admin->surname);
        return Response()->json(["message" => "Post is published"]);
    }

    public function recommend($id)
    {
        return $this->service->recommend($id);
    }

    public function unrecommend($id)
    {
        return $this->service->unrecommend($id);
    }

    public function getAllComments(Request $request)
    {
        return $this->service->getAllComments($request);
    }
}
