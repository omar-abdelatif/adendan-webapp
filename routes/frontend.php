<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MasterController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\WorkerController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\News\NewsController;
use App\Http\Controllers\Frontend\BoardMembersController;
use App\Http\Controllers\Frontend\FrontDonationController;
use App\Http\Controllers\Frontend\AssociationsCommittesController;

Auth::routes();

Route::name('site.')->group(function () {
    Route::view('about', 'frontend.pages.about')->name('about');
    Route::view('contact_us', 'frontend.pages.contact')->name('contact');
    Route::get('/', [MasterController::class, 'index'])->name('index');
    Route::controller(NewsController::class)->group(function () {
        Route::get('all_news', 'index')->name('news');
        Route::get('all_news/single_news/{id}', 'newsDetails')->name('single_news');
    });
    Route::controller(SearchController::class)->group(function () {
        Route::get('search', 'index')->name('search');
        Route::post('result', 'result')->name('result');
        Route::get('search-details/{name}', 'searechDetails')->name('searchDetails');
        Route::post('store-member-main-data', 'storeMainMemberData')->name('storeMemberMainData');
    });
    Route::controller(AssociationsCommittesController::class)->group(function () {
        Route::get('assossiation_committees', 'index')->name('assossiation');
        Route::get('assossiation_committees/assossiation_details/{id}', 'associationDetails')->name('assossiation_details');
    });
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/paymob/callback', 'callback')->name('payment.callback');
        Route::post('paymob/send-payment', 'sendPayment')->name('payment.send');
    });
    Route::controller(FrontDonationController::class)->group(function () {
        Route::get('donate_page', 'index')->name('donate');
        Route::post('make_donation', 'store')->name('store');
    });
    Route::get('board_members', [BoardMembersController::class, 'index'])->name('borders');
    Route::post('checkout', [CheckoutController::class, 'checkingOut'])->name('paymentCheckout');
    Route::get('workers/all', [WorkerController::class, 'index'])->name('workers');
});