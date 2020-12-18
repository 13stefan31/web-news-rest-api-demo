<?php

namespace App\User\Transformer;

use App\CustomException\ExceptionsCustomModel;
use League\Fractal;

use App\User\Model\User;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform_response($objects):array
    {
        $paginationArray = $objects->toArray();

        $responseArray = [];

        $responseArray["current_page"] = $paginationArray["current_page"];
        $responseArray["data"] = $paginationArray["data"];
        $responseArray["from"] = $paginationArray["from"];
        $responseArray["last_page"] = $paginationArray["last_page"];
        $responseArray["per_page"] = $paginationArray["per_page"];
        $responseArray["total"] = $paginationArray["total"];

        $this->isExcitedPageLimit($paginationArray["current_page"], $paginationArray["last_page"]);

        foreach ($responseArray["data"] as &$object) {
            $user = $this->mapToUser($object);
            $object = $this->transform($user);
        }

        return $responseArray;
    }


    public function transform(User $user):array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'position' => $user->position,
            'is_active' => $user->is_active,
            'created_at' => $user->created_at,
        ];
    }

    private function mapToUser($array_data): User
    {
        $user = new User;

        $user->id = $array_data["id"];
        $user->name = $array_data["name"];
        $user->surname = $array_data["surname"];
        $user->email = $array_data["email"];
        $user->password = $array_data["password"];
        $user->position = $array_data["position"];
        $user->is_active = $array_data["is_active"];
        $user->created_at = $array_data["created_at"];
//        $user->updated_at = $array_data["updated_at"];

        return $user;
    }


    private function isExcitedPageLimit($currentPage, $lastPage): bool
    {
        if ($currentPage === $lastPage) {
            return true;
        } else if ($currentPage > $lastPage) {
            $customException = new ExceptionsCustomModel("Can't found data",
                "You're excited page limit",
                404);
            $customException->raiseCustomException();
        } else {
            return false;
        }
    }
}
