<?php

namespace App\UserNotification\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function latestNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        return $user->notifications->first();
    }

    public function allNotifications(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ((int)$request->readed === 1) {
            return $user->readNotifications->toArray();
        }

        return $user->unreadNotifications->toArray();

    }

    public function readNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->notifications->where('id', $request->id)->first()->markAsRead();
        return $user->notifications->where('id', $request->id)->first();
    }
}
