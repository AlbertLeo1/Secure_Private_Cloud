<?php

use App\Http\Controllers\Api\Blogs\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('posts/initials', 'PostController@initials')->name('initials');
Route::get('posts/mine', 'PostController@mine')->name('post.mine');
Route::get('posts/{id}/comments', 'CommentController@initial')->name('post.comments.initials');
Route::post('posts/{id}/comments', 'CommentController@stored')->name('post.comments');
Route::post('posts/{id}/likes', 'LikeController@likeOrUnlike')->name('post.likes');

Route::apiResources([
    'comments'  => 'CommentController',
    'posts'     => 'PostController',
    'tags'      => 'TagController',
    'likes'     => 'LikeController',
]);

