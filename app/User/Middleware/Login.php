<?php

namespace App\User\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\CustomException\ExceptionsCustomModel;

class Login
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
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            $customException = new ExceptionsCustomModel("Incorect email/password credentials",
                "Incorrect credentials",
                401);
            $customException->raiseCustomException();
        }

        return Response()->json(['token' => $token]);
    }
}
