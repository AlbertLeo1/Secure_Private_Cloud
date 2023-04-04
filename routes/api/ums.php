<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'ums'], function () {
    
    Route::get('/profile', 'UserController@profile')->name('profile.initials');
    Route::post('/password', 'UserController@password')->name('profile.password');
    Route::post('/details', 'UserController@details')->name('user.details');
    Route::get('/roles/initials', 'RoleController@initials')->name('roles.initials');
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::post('/users/roles', 'UserController@roles')->name('users.roles');
    Route::get('/users/search', 'UserController@search')->name('users.search');
    
    Route::apiResources([
        '/bios' => 'BioController',
        '/nok' => 'NOKController',
        '/roles' => 'RoleController',
        '/users' => 'UserController',
        '/branches' => 'BranchController',
        '/departments' => 'DepartmentController',
    ]);
});