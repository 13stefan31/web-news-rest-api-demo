<?php

namespace App\Base\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Authorization\Service\AuthorizationService;

class BaseMiddleware
{
    protected $authServices;

    function __construct()
    {
        $this->authServices = new AuthorizationService;
    }
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

}
