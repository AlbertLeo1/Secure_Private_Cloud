<?php 
use Illuminate\Support\Facades\Route;

Route::get('/products/search', 'ProductController@search')->name('products.search');
    
Route::apiResources([
    '/products'         => 'ProductController',
]);
