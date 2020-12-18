<?php

namespace App\PostCategory\Repository;

use App\Base\Repository\BaseRepository;

use App\CustomException\ExceptionsCustomModel;

use App\PostCategory\Model\PostCategory;

class PostCategoryRepository extends BaseRepository
{
    function __construct(PostCategory $model)
    {
        parent::__construct($model);
    }

    public function get($categoryName)
    {
        try {
            return $this->model::where('category_name', $categoryName)->firstOrFail();
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Category can't be found",
                404);
            $customException->raiseCustomException();
        }
    }

    public function delete($categoryName)
    {
        $requestedObject = $this->get($categoryName);

        try {
            $requestedObject->delete();
            return $requestedObject;
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Category can't be deleted",
                500);
            $customException->raiseCustomException();
        }
    }

}
