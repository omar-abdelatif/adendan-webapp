<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsCommentsController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\OcrController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SMSController;
use App\Http\Controllers\Api\SubscriberFinanceController;
use App\Http\Controllers\Api\TombController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WeddingsController;
use App\Http\Controllers\Api\WorkersController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/ocr-data', [OcrController::class, 'store']);
    Route::post('/member/login', [AuthController::class, 'login']);
    Route::prefix('/news')->controller(NewsController::class)->group(function () {
        Route::get('/all', 'allNews');
        Route::get('/limited_news', 'latestNews');
        Route::get('/{id}', 'show');
        Route::controller(NewsCommentsController::class)->group(function () {
            Route::get('/{newsId}/comments', 'getComments');
            Route::post('/{newsId}/comments', 'store');
            Route::put('/{newsId}/comments/{commentId}', 'update');
            Route::delete('/{newsId}/comments/{commentId}', 'destroy');
        });
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
    Route::prefix('paymob')->controller(PaymentController::class)->group(function () {
        Route::match(['get', 'post'], 'callback', 'callback');
    });
    Route::prefix('notify')->controller(NotificationsController::class)->group(function(){
        Route::post('send-notification', 'sendToSubscribers');
    });
    Route::prefix('pay')->controller(PaymentController::class)->group(function () {
        Route::match(['get', 'post'], 'callback', 'callback');
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::put('/update', 'updateUser');
            Route::get('is_pending', 'isPending');
        });
        Route::controller(AuthController::class)->group(function () {
            Route::post('logout', 'logout');
            Route::get('me', 'user');
        });
    });
    Route::prefix('/subscriber')->controller(SubscriberFinanceController::class)->group(function () {
        Route::get('/subscription-payments-history', 'getUserSubscriptionPaymentHistory');
        Route::get('/donations-payments-history', 'getUserDonationPaymentHistory');
        Route::get('/subscription-dues', 'getsubscriptionDues');
        Route::get('/donation-dues', 'getUserDonationDues');
    });
    Route::prefix('sms')->controller(SMSController::class)->group(function () {
        Route::get('payment_history', 'getUserSmsPaymentHistory');
        Route::post('pay_subscription', 'paySmsSubscription');
        Route::get('sms_status', 'getSmsStatus');
        Route::post('renew_subscription', 'renewSms');
        Route::get('fees', 'getSmsFees');
    });
    Route::prefix('fcm/notify')->controller(NotificationsController::class)->group(function () {
        Route::post('fcm-token', 'updateFcmToken');
    });
});
