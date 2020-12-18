<?php

namespace App\PostCategory\Service;

use App\Base\Service\BaseService;

use App\PostCategory\Model\PostCategory;
use App\PostCategory\Repository\PostCategoryRepository;

use App\PostCategory\Transformer\PostCategoryTransformer;


class PostCategoryService extends BaseService
{
    public $transformer;

    function __construct(PostCategoryRepository $repository, PostCategoryTransformer $postCategoryTransformer)
    {
        $this->transformer = $postCategoryTransformer;
        parent::__construct($repository);
    }

    public function create($object)
    {
        $post_category = new PostCategory;
        $this->validator->validatePostCategory($object);

        $post_category->category_name = $object->category_name;

        return $this->transformer->transform(parent::create($post_category));
    }

    public function getAll()
    {
        return $this->transformer->transform_response(parent::getAll());
    }

    public function get($categoryName)
    {
        return $this->transformer->transform(parent::get($categoryName));
    }

    public function delete($categoryName)
    {
        return $this->transformer->transform(parent::delete($categoryName));
    }
}
