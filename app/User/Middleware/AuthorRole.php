<?php

namespace App\User\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Base\Middleware\BaseMiddleware;

class AuthorRole extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user();

        if ($this->authServices->isAuthor($user)) {
            return $next($request);
        }
    }
}
