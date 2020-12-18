<?php

namespace App\User\Repository;

use Illuminate\Support\Facades\Hash;

use App\Base\Repository\BaseRepository;

use App\User\Model\User;

use App\CustomException\ExceptionsCustomModel;


class UserRepository extends BaseRepository
{
    function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllPaginate($category, $search, $dataNum)
    {
        $q = $this->model::query();

        if (is_null($category) === False) {
            $q->whereHas('role', function ($query) use ($category) {
                $query->Where('role_name', $category);
            });
        }

        if (is_null($search) === False) {
            $q->when($search, function ($query) use ($search) {
                $query->Where(function ($query) use ($search) {
                    $query->where('email', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('surname', 'like', '%' . $search . '%');
                });
            });

        }

        $results = $q->paginate($dataNum);

        return $results;
    }

    public function getByEmail($email, $password)
    {
        try {
            $userObject = User::where('email', $email)->firstOrFail();
        } catch (\Exception  $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Can't find user with given email",
                404);
            $customException->raiseCustomException();
        }

        if (Hash::check($password, $userObject->password)) {
            return $userObject;
        } else {
            $customException = new ExceptionsCustomModel("Incorrect password",
                "Your password is not correct",
                401);
            $customException->raiseCustomException();
        }
    }

}
