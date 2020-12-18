<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\PostCategory\Controller', 'middleware' => 'api','prefix' => 'api/categories'], function () {
    Route::post('', 'PostCategoryController@create')->middleware('admin');
    Route::get('', 'PostCategoryController@getAll');
    Route::get('/{category_name}', 'PostCategoryController@get');
    Route::delete('/{category_name}', 'PostCategoryController@delete')->middleware('admin');
});
