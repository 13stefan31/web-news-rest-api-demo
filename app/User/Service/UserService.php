<?php

namespace App\User\Service;

use Illuminate\Support\Facades\Hash;

use App\Base\Service\BaseService;

use App\User\Model\User;
use App\User\Repository\UserRepository;

use App\User\Transformer\UserTransformer;


class UserService extends BaseService
{
    public $transformer;

    function __construct(UserRepository $repository, UserTransformer $userTransformer)
    {
        $this->transformer = $userTransformer;
        parent::__construct($repository);
    }

    public function create($object)
    {
        $this->validator->validateUserCreationData($object);
        $user = $this->createNewUser($object);

        return $this->transformer->transform(parent::create($user));
    }


    public function get($id)
    {
        return $this->transformer->transform(parent::get($id));
    }

    public function delete($id)
    {
        return $this->transformer->transform(parent::delete($id));
    }

    public function update($object)
    {
        $this->validator->validateUserUpdateData($object);
        $email = $object->email;
        $password = $object->password_old;
        $user = $this->repository->getByEmail($email, $password);
        $updatedUser = $this->updateUser($user, $object);

        return $this->transformer->transform($this->repository->create($updatedUser));
    }

    public function getAllPaginate($request)
    {
        $category = $request->role;
        $search = $request->search;
        $dataNum = $request->data_num;

        return $this->transformer->transform_response($this->repository
            ->getAllPaginate($category, $search, $dataNum));
    }

    private function createNewUser($request)
    {
        $user = new User;

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->position = $request->position;

        return $user;

    }

    private function updateUser($user, $request)
    {
        $user->password = Hash::make($request->password);

        return $user;
    }

}
