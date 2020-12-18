<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\UserNotification\Controller', 'middleware' => 'api', 'prefix' => 'api/notifications'], function () {
    Route::get('', 'UserNotificationController@latestNotification')->middleware('register');
    Route::get('/all', 'UserNotificationController@allNotifications')->middleware('register');
    Route::put('', 'UserNotificationController@readNotification')->middleware('register');
});
