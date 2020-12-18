<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\User\Controller', 'middleware' => 'api', 'prefix' => 'api/users'], function () {
    Route::post('', 'UserController@create');
    Route::get('/{id}', 'UserController@get')->middleware('actionsOnUser');
    Route::get('', 'UserController@getAllPagination')->middleware('admin');
    Route::put('', 'UserController@update')->middleware('actionsOnUser');
    Route::delete('/{id}', 'UserController@delete')->middleware('actionsOnUser');
    Route::post('/login', 'UserController@login')->middleware('login');
    Route::post('/logout', 'UserController@logout')->middleware('logout');
});
