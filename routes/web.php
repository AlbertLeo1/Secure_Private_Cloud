<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',                     [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home',                 [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/domiciliary',          [App\Http\Controllers\ModulesController::class, 'domiciliary'])->name('domiciliary');
//Route::get('/domiciliary/{any}',    [App\Http\Controllers\ModulesController::class, 'domiciliary'])->where('any', '.*');
//Route::get('/hims',                 [App\Http\Controllers\ModulesController::class, 'hims'])->name('hims');
//Route::get('/hims/{any}',           [App\Http\Controllers\ModulesController::class, 'hims'])->where('any', '.*');
Route::get('/hr',                   [App\Http\Controllers\ModulesController::class, 'human_resources'])->name('human_resources');
Route::get('/hr/{any}',             [App\Http\Controllers\ModulesController::class, 'human_resources'])->where('any', '.*');
//Route::get('/learn',                [App\Http\Controllers\ModulesController::class, 'learn'])->name('learn');
//Route::get('/learn/{any}',          [App\Http\Controllers\ModulesController::class, 'learn'])->where('any', '.*');
//Route::get('/nursing',              [App\Http\Controllers\ModulesController::class, 'nursing'])->name('nursing');
//Route::get('/nursing/{any}',        [App\Http\Controllers\ModulesController::class, 'nursing'])->where('any', '.*');
//Route::get('/policies',             [App\Http\Controllers\ModulesController::class, 'policies'])->name('policies');
//Route::get('/policies/{any}',       [App\Http\Controllers\ModulesController::class, 'policies'])->where('any', '.*');
    
Route::get('/clear-cache', function() {
    //$exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('cache:clear');
    
    return "All done boss, anything else";
    // return what you want
});
