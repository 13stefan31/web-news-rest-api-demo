<?php
namespace App\Base\Service;

use App\Validator\DataValidator;

class BaseService
{
    protected $repository;
    protected $validator;

    function __construct($repository)
    {
        $this->validator = new DataValidator();
        $this->repository = $repository;

    }

    protected function create($object)
    {
        return $this->repository->create($object);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get($id)
    {
        return $this->repository->get($id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    protected function update($object)
    {
        return $this->create($object);
    }

    public function getRepository(){
        return $this->repository;
    }
}
