<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Comment\Controller', 'middleware' => 'api', 'prefix' => 'api/comments'], function () {
    Route::post('', 'CommentController@create')->middleware('visitor');
    Route::put('/{id}/vote', 'CommentController@voteComment')->middleware('visitor');
    Route::put('', 'CommentController@updateComment')->middleware('visitor');
    Route::delete('/{id}', 'CommentController@deleteComment')->middleware('visitor');
});
