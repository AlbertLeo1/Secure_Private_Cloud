<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'som'], function () {
    Route::apiResources([
        '/nominations' => 'NominationController',
        '/votes'       => 'VoteController',
        '/winners'     => 'WinnerController',
    ]);
});