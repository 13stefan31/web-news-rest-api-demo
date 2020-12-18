<?php

namespace App\Comment\Repository;

use App\Base\Repository\BaseRepository;

use App\Comment\Model\Comment;


class CommentRepository extends BaseRepository
{
    function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate($postId, $dataNum)
    {
        return $this->model::with('user')->where('post_id', $postId)->paginate($dataNum);
    }


}
