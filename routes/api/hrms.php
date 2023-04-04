<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'hrms'], function () {
    
    Route::get('/profile', 'UserController@profile')->name('profile.initials');
    Route::post('/password', 'UserController@password')->name('profile.password');
    Route::get('/salaries/initials', 'SalaryController@initials')->name('salaries.initials');
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::get('/users/search', 'UserController@search')->name('users.search');
    Route::get('/contacts',     'UserController@contacts')->name('contacts');
    
    Route::apiResources([
        '/applications' => 'ApplicationController',
        '/bios'         => 'BioController',
        '/bonuses'      => 'BonusController',
        '/deductions'   => 'DeductionController',
        '/employees'    => 'EmployeeController',
        '/jobs'         => 'JobController',
        '/leaves'       => 'LeaveController',
        '/leave_types'  => 'LeaveTypeController',
        '/nok'          => 'NOKController',
        '/salaries'     => 'SalaryController',
        '/users'        => 'UserController',

        //'/profile' => 'ProfileController',
    ]);
});