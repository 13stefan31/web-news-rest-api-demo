<?php

namespace App\User\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Base\Middleware\BaseMiddleware;

class UpdateOrDeleteUser extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user();

        if($request->method() === "PUT")
        {
            if ($this->authServices->isAllowedForUpdateUser($user, $request->email)) {
                return $next($request);
            }
        }

        if($request->method() === "GET")
        {
            if ($this->authServices->isAdmin($user)) {
                return $next($request);
            }
        }

        if ($this->authServices->isAllowedForDeleteUser($user, $request->id)) {
            return $next($request);
        }
    }
}
