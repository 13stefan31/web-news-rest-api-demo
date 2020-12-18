<?php

namespace App\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\CustomException\ExceptionsCustomModel;

class Logout
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
        try {
            Auth::guard('api')->logout();
            Auth::guard('api')->invalidate(true);
            return $next($request);
        } catch (\Exception $e) {
            $customException = new ExceptionsCustomModel($e->getMessage(),
                "Bad token",
                404);
            $customException->raiseCustomException();
        }
    }
}
