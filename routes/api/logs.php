<?php

use App\Http\Controllers\Api\Blogs\LikeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'logs'], function () {
    Route::apiResources([
        'activities'  => 'LogController',
    ]);
});

