<?php

namespace App\Base\Repository;

use App\CustomException\ExceptionsCustomModel;

class BaseRepository
{
    protected $model;

    function __construct($model)
    {
        $this->model = $model;

    }

    public function create($object)
    {
        try {
            $object->save();
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Category can't be saved",
                500);
            $customException->raiseCustomException();
        }

        return $object;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function get($id)
    {
        try {
            return $this->model::findOrFail($id);
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Object can't be found",
                404);
            $customException->raiseCustomException();
        }
    }

    public function delete($id)
    {
        $requestedObject = $this->get($id);
        try {
            $requestedObject->delete();
            return $requestedObject;
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Category can't be saved",
                500);
            $customException->raiseCustomException();
        }
    }


}
