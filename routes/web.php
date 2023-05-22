<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',                     [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/admin',                [App\Http\Controllers\ModulesController::class, 'admin'])->name('admin');
Route::get('/admin/{any}',          [App\Http\Controllers\ModulesController::class, 'admin'])->where('any', '.*');

Route::get('/home',                 [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/hr',                   [App\Http\Controllers\ModulesController::class, 'human_resources'])->name('human_resources');
Route::get('/hr/{any}',             [App\Http\Controllers\ModulesController::class, 'human_resources'])->where('any', '.*');
Route::get('/inventory',            [App\Http\Controllers\ModulesController::class, 'inventory'])->name('inventory');
Route::get('/inventory/{any}',      [App\Http\Controllers\ModulesController::class, 'inventory'])->where('any', '.*');
    
Route::get('/clear-cache', function() {
    //$exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('cache:clear');
    
    return "All done boss, anything else";
    // return what you want
});

Route::get('2fa', [App\Http\Controllers\DoubleAuthenticationController::class, 'index'])->name('2fa.index');
Route::post('2fa', [App\Http\Controllers\DoubleAuthenticationController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [App\Http\Controllers\DoubleAuthenticationController::class, 'resend'])->name('2fa.resend');
