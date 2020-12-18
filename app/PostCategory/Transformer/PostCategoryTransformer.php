<?php

namespace App\PostCategory\Transformer;

use League\Fractal;

use App\PostCategory\Model\PostCategory;

class PostCategoryTransformer extends Fractal\TransformerAbstract
{
    public function transform_response($objects): array
    {
        $responseArray = [];
        foreach ($objects as $object) {
            $convertedObj = $this->transform($object);
            array_push($responseArray, $convertedObj);
        }
        return $responseArray;
    }


    public function transform(PostCategory $category): array
    {
        return [
            'id' => $category->id,
            'category_name' => $category->category_name,
        ];
    }
}
