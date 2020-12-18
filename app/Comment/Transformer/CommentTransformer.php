<?php

namespace App\Comment\Transformer;

use League\Fractal;

use App\Comment\Model\Comment;
use App\CustomException\ExceptionsCustomModel;

class CommentTransformer extends Fractal\TransformerAbstract
{
    public function transform_response($objects): array
    {
        $paginationArray = $objects->toArray();
        $responseArray = [];

        $responseArray["data"] = $paginationArray["data"];

        foreach ($responseArray["data"] as &$object) {
            $user = $this->mapToComment($object);
            $object = $this->transform($user);
        }

        $responseArray["last_page"] = $this->isLastPage($paginationArray["current_page"], $paginationArray["last_page"]);

        return $responseArray;
    }


    public function transform(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'user' => $comment->user_id,
            'content' => $comment->content,
            'votes' => $comment->comment_votes,
        ];
    }


    private function mapToComment($array_data): Comment
    {
        $comment = new Comment;

        $comment->id = $array_data["id"];
        $comment->user_id = $array_data['user']["email"];
        $comment->post_id = $array_data["post_id"];
        $comment->content = $array_data["content"];
        $comment->comment_votes = $array_data["comment_votes"];
        $comment->created_at = $array_data["created_at"];
        $comment->updated_at = $array_data["updated_at"];


        return $comment;
    }

    private function isLastPage($currentPage, $lastPage): bool
    {
        if ($currentPage === $lastPage) {
            return true;
        } else if ($currentPage > $lastPage) {
            $customException = new ExceptionsCustomModel("Can't found data",
                "You're excited load more limit",
                404);
            $customException->raiseCustomException();
        } else {
            return false;
        }
    }

}
