<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'inventory'], function () {
    
    Route::apiResources([
        '/devices' => 'DeviceController',
    ]);
    
});