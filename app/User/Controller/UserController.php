<?php

namespace App\User\Controller;

use App\Base\Controller\BaseController;
use App\User\Service\UserService;

use Illuminate\Http\Request;



class UserController extends BaseController
{
    function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    public function getAllPagination(Request $request)
    {
        return $this->service->getAllPaginate($request);
    }

    public function login(Request $request)
    {
        pass;
    }


    public function logout()
    {
        return response()->json(['message' => 'Successfully logged out']);
    }
}
