<?php

use App\Http\Controllers\Api\Categorie;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GoogleAuth;
use App\Http\Controllers\Api\Order\ContractOrders;
use App\Http\Controllers\Api\Order\HourlyOrders;
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
    Route::get('/auth/google/redirect', [GoogleAuth::class, 'redirect'])->name('GoogleRedirect');
    Route::get('/auth/google/callback', [GoogleAuth::class, 'callback'])->name('GoogleCallback');
    //company///

    Route::get('/company/{id}', [CompanyController::class, 'Company']);
    Route::get('/company/get/AllCompanies/', [CompanyController::class, 'AllCompanies']);
    Route::get('/categorie/AllCategories', [categorie::class, 'AllCategories']);
    Route::get('/company/get/Hourly/AllCompanies/', [CompanyController::class, 'HAllCompanies']);
    Route::get('/company/get/Contract/AllCompanies/', [CompanyController::class, 'CAllCompanies']);

    //admin////
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

        ///order//
        Route::post('/ContractOrder/store', [ContractOrders::class, 'store']);
        Route::post('/HourlyOrder/store', [HourlyOrders::class, 'store']);

        //get all user orders
        Route::get('/HourlyOrder', [HourlyOrders::class, 'HourlyOrder']);
        Route::get('/ContractOrder', [ContractOrders::class, 'ContractOrder']);
        Route::get('/AllOrders', [ContractOrders::class, 'AllOrders']);

        //get  user order details
        Route::get('/HourlyOrderDetails/{id}', [HourlyOrders::class, 'HourlyOrderDetails']);
        Route::get('/ContractOrderDetails/{id}', [ContractOrders::class, 'ContractOrderDetails']);

        //company
        Route::post('/company/store', [CompanyController::class, 'store']);

        Route::post('/update-password', [UserAuth::class, 'updatePassword']);
        Route::post('/logout', [UserAuth::class, 'logout']);

        Route::get('/profile', [UserAuth::class, 'userProfile']);

        Route::post('/update-profile', [UserAuth::class, 'updateProfile']);
        Route::post('/contact', [ContactController::class, 'contact']);

    });
});
