<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'inventory'], function () {

    Route::get('/devices/status', 'DeviceController@status')->name('devices.status');
    
    Route::apiResources([
        '/dashboard'    => 'DashboardController',
        '/devices'      => 'DeviceController',
    ]);
    
});