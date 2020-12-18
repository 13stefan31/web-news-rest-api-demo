<?php

namespace App\Post\Repository;

use App\Base\Repository\BaseRepository;

use App\Post\Model\Post;

use App\CustomException\ExceptionsCustomModel;


class PostRepository extends BaseRepository
{
    function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate($ownerId, $category, $search, $dataNum, $recommended)
    {
        $q = $this->model::query();
        $default_value = True;

        $q->when($default_value, function ($query) use ($default_value) {
            $query->Where('is_active', $default_value);
        });

        if (!is_null($ownerId)) {
            $q->whereHas('author', function ($query) use ($ownerId) {
                $query->Where('id', $ownerId);
            });
        }

        if (!is_null($search)) {
            $q->when($search, function ($query) use ($search) {
                $query->Where('header_main', 'like', '%' . $search . '%');
            });
        }

        if (!is_null($category)) {
            $q->whereHas('category', function ($query) use ($category) {
                $query->Where('category_name', $category);
            });
        }

        if ($recommended) {
            $q->when($recommended, function ($query) use ($recommended) {
                $query->Where('recommended', True);
            });
        }

        $results = $q->paginate($dataNum);

        return $results;
    }

    public function getInactivePost($id)
    {

        try {
            $post = $this->model::with('author')->findOrFail($id);
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Post can't be found",
                404);
            $customException->raiseCustomException();
        }

        return $post;

    }

}
