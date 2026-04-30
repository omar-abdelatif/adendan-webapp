<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\OcrController;
use App\Http\Controllers\Api\SubscriberFinanceController;
use App\Http\Controllers\Api\TombController;
use App\Http\Controllers\Api\WeddingsController;
use App\Http\Controllers\Api\WorkersController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/ocr-data', [OcrController::class, 'store']);
    Route::post('/member/login', [AuthController::class, 'login']);
    Route::controller(NewsController::class)->group(function () {
        Route::get('/all_news', 'allNews');
        Route::get('/news/{id}', 'show');
    });
    Route::controller(TombController::class)->group(function () {
        Route::get('/all_tombs', 'index');
    });
    Route::controller(WorkersController::class)->group(function () {
        Route::get('/all_workers', 'index');
    });
    Route::controller(WeddingsController::class)->group(function () {
        Route::get('/all_weddings', 'index');
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/user/logout', 'logout');
        Route::get('/user/me', 'user');
    });
    Route::prefix('/subscriber')->controller(SubscriberFinanceController::class)->group(function () {
        Route::get('/subscription-payments-history', 'getUserSubscriptionPaymentHistory');
        Route::get('/donations-payments-history', 'getUserDonationPaymentHistory');
        Route::get('/subscription-dues', 'getsubscriptionDues');
        Route::get('/donation-dues', 'getUserDonationDues');
    });
});
