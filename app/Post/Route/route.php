<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Post\Controller', 'middleware' => 'api', 'prefix' => 'api/posts'], function () {
    Route::post('', 'PostController@createPost')->middleware('author');
    Route::get('', 'PostController@getAllPagination');
    Route::put('', 'PostController@updatePost')->middleware('author');
    Route::delete('/{id}', 'PostController@delete')->middleware('admin');
    Route::get('/{id}', 'PostController@get');
    Route::put('/recommend/{id}', 'PostController@recommend')->middleware('admin');
    Route::put('/unrecommend/{id}', 'PostController@unrecommend')->middleware('admin');
    Route::put('/publish/{id}', 'PostController@publish')->middleware('admin');
    Route::post('/suggest_changes', 'PostController@suggestChanges')->middleware('admin');
    Route::get('/{id}/comments', 'PostController@getAllComments');
});
