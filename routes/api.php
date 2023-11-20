<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/payment/result', 'App\Http\Controllers\API\PaymentController@result');
Route::group(['namespace' => 'App\Http\Controllers\API\Auth', 'prefix' => '/auth', 'middleware' => ['api-response']], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('me', 'AuthController@me');
});

Route::group(['namespace' => 'App\Http\Controllers\API\Cabinet', 'prefix' => '/cabinet',  'middleware' => ['api-response']], function () {
    Route::resource('post', 'PostController');
    Route::resource('post-category', 'PostCategoryController');
});

