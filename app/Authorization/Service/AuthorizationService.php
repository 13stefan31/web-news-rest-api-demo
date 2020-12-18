<?php

namespace App\Authorization\Service;

use App\CustomException\ExceptionsCustomModel;
use phpDocumentor\Reflection\Types\True_;

class AuthorizationService
{
    public function isAdmin($user): bool
    {
        $this->checkIsNull($user);

        return $this->checkUserPermission($user, "admin");
    }

    public function isAuthor($user): bool
    {
        $this->checkIsNull($user);

        return $this->checkUserPermission($user, "author");
    }

    public function isVisitor($user): bool
    {
        $this->checkIsNull($user);

        return $this->checkUserPermission($user, "visitor");
    }

    public function isAllowedForUpdateUser($user, $userEmail): bool
    {
        $this->checkIsNull($user);

        if ($user->email === $userEmail){
            return true;
        }

        $customException = new ExceptionsCustomModel("You can't execute this action",
            "You are not authorize for this action",
            401);
        $customException->raiseCustomException();
    }

    public function isAllowedForDeleteUser($user, $id): bool
    {
        $this->checkIsNull($user);

        if ($user->id === (int)$id){
            return true;
        }

        $customException = new ExceptionsCustomModel("You can't execute this action",
            "You are not authorize for this action",
            401);
        $customException->raiseCustomException();
    }

    public function isAllowedForDeleteOrUpdatePost($user, $postOwner): bool
    {
        $this->checkIsNull($user);

        if ($user->id === $postOwner) {
            return true;
        } else {
            $customException = new ExceptionsCustomModel("You can't execute this action",
                "You are not authorize for this action",
                401);
            $customException->raiseCustomException();
        }
    }

    public function checkIsOwner($authorId, $objectOwnerId): bool
    {
        if ($authorId != $objectOwnerId) {
            $customException = new ExceptionsCustomModel("You can't execute this action",
                "Only owner of comment can update or delete it",
                401);
            $customException->raiseCustomException();
        }

        return true;
    }

    public function isAllowedForDeleteOrUpdateComment($user, $commentOwner): bool
    {
        $this->checkIsNull($user);

        if ($user->id === $commentOwner) {
            return true;
        } else {
            $customException = new ExceptionsCustomModel("You can't execute this action",
                "You are not authorize for this action",
                401);
            $customException->raiseCustomException();
        }

    }

    public function isRegisterUser($user): bool
    {
        return $this->checkIsNull($user);
    }

    public function canCreateUser($user, $position): bool
    {
        try {
            $isAdmin = $this->isAdmin($user);
        } catch (\Exception $e) {
            $isAdmin = false;
        }

        if ($isAdmin === true || $position === 'visitor') {
            return true;
        } else {
            $custom_exception = new ExceptionsCustomModel("You can't execute this action",
                "You are not authorize for this action",
                401);
            $custom_exception->raiseCustomException();
        }

    }

    private function checkIsNull($user)
    {
        if (is_null($user)) {
            $custom_exception = new ExceptionsCustomModel("You can't execute this action",
                "You are not authorize for this action",
                401);
            $custom_exception->raiseCustomException();
        }

        return true;
    }

    private function checkUserPermission($user, $role)
    {
        if ($user->position === $role) {
            return true;
        } else {
            $customException = new ExceptionsCustomModel("You can't execute this action",
                "You are not authorize for this action",
                401);
            $customException->raiseCustomException();
        }
    }
}
