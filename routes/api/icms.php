<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'icms'], function () {
    
    Route::get('/checked/{id}',  'CheckController@checked')->name('checked');
    
    Route::apiResources([
        '/checks' => 'CheckController',
    ]);
    
});