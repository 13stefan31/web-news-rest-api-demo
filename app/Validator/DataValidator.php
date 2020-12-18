<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\CustomException\ExceptionsCustomModel;

use App\UserRole\Rule\RolesNamingRule;
use App\User\Rule\NamingRule;
use App\User\Rule\MailRule;
use App\User\Rule\PasswordRule;
use App\PostCategory\Rule\CategoryNamingRule;

class DataValidator
{
    public function validateUserRoles(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'role_name' => ['required', 'string', 'unique:roles', new RolesNamingRule]
        ]);

        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error,
                "Bad data format",
                400);
            $customException->raiseCustomException();
        }

        return true;
    }

    public function validateUserCreationData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', new NamingRule],
            'surname' => ['required', 'string', new NamingRule],
            'email' => ['required', 'string', 'unique:users', new MailRule],
            'password' => ['required', 'string', 'unique:users', new PasswordRule],
            'position' => ['required', 'string', new RolesNamingRule]
        ]);


        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error, "Bad data format", 500);
            $customException->raiseCustomException();
        }
        return true;
    }

    public function validateUserUpdateData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', new MailRule],
            'password' => ['required', 'string', 'unique:users', new PasswordRule],
        ]);


        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error, "Bad data format", 500);
            $customException->raiseCustomException();
        }
        return true;
    }

    public function validatePostCategory(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'category_name' => ['required', 'string', 'unique:categories', new CategoryNamingRule],
        ]);


        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error, "Bad data format", 500);
            $customException->raiseCustomException();
        }
        return true;
    }

    public function validatePostCreationData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'header_main' => ['required', 'string'],
            'subheader' => ['required', 'string'],
            'category' => ['required', 'string', new CategoryNamingRule],
            'posts_content' => ['required'],
        ]);


        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error, "Bad data format", 500);
            $customException->raiseCustomException();
        }
        return true;
    }

    public function validateCommentCreationData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'post_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
        ]);


        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            $customException = new ExceptionsCustomModel($error, "Bad data format", 500);
            $customException->raiseCustomException();
        }
        return true;
    }


}
