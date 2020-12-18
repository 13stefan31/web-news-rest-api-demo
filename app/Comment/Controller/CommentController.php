<?php

namespace App\Comment\Controller;

use App\Base\Controller\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Comment\Service\CommentService;

class CommentController extends BaseController
{
    function __construct(CommentService $service)
    {
        parent::__construct($service);
    }

    public function create(Request $request)
    {
        $visitor = Auth::guard('api')->user();
        return $this->service->createComment($request, $visitor->id);
    }

    public function updateComment(Request $request)
    {
        $visitor = Auth::guard('api')->user();
        return $this->service->updateComment($request, $visitor->id);
    }

    public function voteComment($id, Request $request)
    {
        return $this->service->voteComment($id, $request);
    }

    public function deleteComment($id, Request $request)
    {
        $visitor = Auth::guard('api')->user();
        return $this->service->deleteComment($id, $visitor->id);
    }
}
