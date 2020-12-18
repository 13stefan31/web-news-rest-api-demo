<?php

namespace App\Post\Transformer;

use League\Fractal;

use App\Post\Model\Post;
use App\CustomException\ExceptionsCustomModel;

class PostTransformer extends Fractal\TransformerAbstract
{
    public function transform_response($objects)
    {
        $paginationArray = $objects->toArray();
        $responseArray = [];

        $responseArray["data"] = $paginationArray["data"];

        foreach ($responseArray["data"] as &$object) {
            $user = $this->mapToPost($object);
            $object = $this->transform($user);
        }

        $responseArray["last_page"] = $this->isLastPage($paginationArray["current_page"], $paginationArray["last_page"]);

        return $responseArray;
    }


    public function transform(Post $post)
    {

        return [
            'id' => $post->id,
            'header_main' => $post->header_main,
            'subheader' => $post->subheader,
            'category' => $post->category,
            'posts_content' => $post->posts_content,
            'picture_links' => (!is_null($post->picture_links) ? $this->stringToList($post->picture_links) : null),
            'owner' => $post->owner,
            'recommended' => $post->recommended,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'is_active' => $post->is_active,
        ];
    }

    private function mapToPost($array_data)
    {
        $post = new Post;

        $post->id = $array_data["id"];
        $post->header_main = $array_data["header_main"];
        $post->subheader = $array_data["subheader"];
        $post->category = $array_data["category"];
        $post->posts_content = $array_data["posts_content"];
        $post->picture_links = $array_data["picture_links"];
        $post->owner = $array_data["owner"];
        $post->recommended = $array_data["recommended"];
        $post->is_active = $array_data["is_active"];
        $post->created_at = $array_data["created_at"];
        $post->updated_at = $array_data["updated_at"];

        return $post;
    }

    private function stringToList($picturesDatabase)
    {
        return explode("----", $picturesDatabase);
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
