<?php

use App\Http\Controllers\Api\Categorie ;
use App\Http\Controllers\Api\GoogleAuth;
use App\Http\Controllers\Api\PhoneVerify;
use App\Http\Controllers\Api\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'user/auth'
], function ($router) {
    Route::post('register', [UserAuth::class, 'register']);
    Route::post('/login', [UserAuth::class, 'login']);
    Route::get('/auth/google/redirect', [GoogleAuth::class,'redirect'])->name('GoogleRedirect');
    Route::get('/auth/google/callback', [GoogleAuth::class,'callback'])->name('GoogleCallback');


    Route::post('/categorie/store', [categorie::class, 'store']);
    Route::get('/categorie/edit/{id}', [categorie::class, 'edit']);
    Route::post('/categorie/update/{id}', [categorie::class, 'update']);
    Route::delete('/categorie/delete/{id}', [categorie::class, 'delete']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group([
        'prefix' => 'user/auth'
    ], function ($router) {
        Route::post('/start-verification', [PhoneVerify::class, 'startVerification']);
        Route::post('/cancel-verification', [PhoneVerify::class, 'cancelVerification']);
        Route::post('/check-verification', [PhoneVerify::class, 'checkVerification']);

        Route::post('/update-password', [UserAuth::class, 'updatePassword']);
        Route::post('/logout', [UserAuth::class, 'logout']);

        Route::get('/profile', [UserAuth::class, 'userProfile']);
    });
});