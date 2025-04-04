<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DelayController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DonatorsController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\CostYearsController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\OuterDonationsController;
use App\Http\Controllers\SubscriptionRole\SubscriptionRoleController;

Auth::routes();

Route::prefix('admin/subscriptions')->group(function () {
    Route::middleware(['auth', 'role:subscriptions'])->group(function () {
        //! Home Page Routes
        Route::controller(SubscriptionRoleController::class)->group(function () {
            Route::get('dashboard', 'RoleIndex')->name('subscriptionRole.index');
        });
        //! Reports Routes
        Route::prefix('reports')->group(function () {
            Route::controller(ReportController::class)->group(function () {
                Route::get('age', 'ages')->name('subscriptionRole.reports.age');
                Route::get('safe', 'safe')->name('subscriptionRole.reports.safe');
                Route::get('jobs', 'jobs')->name('subscriptionRole.reports.jobs');
                Route::get('search', 'search')->name('subscriptionRole.reports.search');
                Route::get('all', 'index')->name('subscriptionRole.reports.subscriptions');
                Route::get('location', 'locations')->name('subscriptionRole.reports.location');
                Route::get('bank', 'bankTransactions')->name('subscriptionRole.bankTransactios');
                Route::get('incomplete', 'incomplete')->name('subscriptionRole.reports.incompete');
                Route::get('associates', 'associates')->name('subscriptionRole.reports.associates');
                Route::get('donations', 'outerdonations')->name('subscriptionRole.reports.donations');
                Route::get('indebtedness', 'indebtedness')->name('subscriptionRole.reports.indebtedness');
                Route::get('inner_donations', 'innerDonations')->name('subscriptionRole.reports.innerDonations');
                Route::get('subscriptions_old_delays', 'subOldDelay')->name('subscriptionRole.reports.subOlddelay');
            });
        });
        //! Subscribers Routes
        Route::controller(SubscribersController::class)->group(function () {
            Route::get('subscribers/all', 'index')->name('subscriptionRole.subscriber.all');
            Route::post('subscribers/store', 'storeSubs')->name('subscriptionRole.subscribe.store');
            Route::get('subscriber/delete/{id}', 'destroy')->name('subscriptionRole.subscribe.destroy');
            Route::post('subscriber/update', 'update')->name('subscriptionRole.subscribe.update');
            Route::get('subscriber/update/{id}', 'subscriberDetails')->name('subscriptionRole.subscriber.details');
            Route::post('subscriber/bulk_upload', 'bulkUpload')->name('subscriptionRole.subscriber.bulk');
            Route::get('subscribers/ajax/data/subscribers', 'getSubscribersData')->name('subscriptionRole.ajax.subscribers');
            Route::get('subscribers/get-year-cost/{year}', 'getYearlyCostByAjax');
        });
        //! Subscriptions Routes
        Route::controller(SubscriptionsController::class)->group(function () {
            Route::get('subscription/history/{id}', 'index')->name('subscriptionRole.subscription.history');
            Route::post('subscription/store', 'storeSubscription')->name('subscriptionRole.subscription.store');
            Route::get('subscription/delete/{id}', 'destroyingSubscription')->name('subscriptionRole.subscription.destroy');
            Route::post('subscription/updating', 'updatingSubscription')->name('subscriptionRole.subscription.update');
        });
        //! Delay Routes
        Route::controller(DelayController::class)->group(function () {
            Route::post('delays/upload_delays', 'uploadDelays')->name('subscriptionRole.delays.costbyyear');
            Route::post('delays/subscriber_delays', 'subscriberDelay')->name('subscriptionRole.bulk_subscriber_delay');
            Route::post('delays/pay', 'paySubscription')->name('subscriptionRole.subscription.pay');
            Route::post('delays/old_delays', 'payOldDelay')->name('subscriptionRole.oldDelays.pay');
        });
        //! Donators Routes
        Route::controller(DonatorsController::class)->group(function () {
            Route::get('donators/all', 'index')->name('subscriptionRole.donators.all');
            Route::post('donators/store', 'storeDonator')->name('subscriptionRole.donators.store');
            Route::get('donators/remove/{id}', 'removeDonator')->name('subscriptionRole.donators.remove');
            Route::post('donators/update', 'donatorUpdate')->name('subscriptionRole.donators.update');
        });
        //! Donations Routes
        Route::controller(DonationsController::class)->group(function () {
            Route::get('donations/showAll/{id}', 'index')->name("subscriptionRole.donations.showAll");
            Route::post('donations/store', 'storeDonations')->name('subscriptionRole.donations.store');
            Route::get('donations/remove/{id}', 'removeDonation')->name('subscriptionRole.donation.remove');
            Route::post('donations/update', 'updateDonation')->name('subscriptionRole.donations.update');
            Route::post('donations/delays/upload_bulk', 'donationsOnSubscribers')->name('subscriptionRole.delays.uploadDonations');
            Route::post('donation/pay_old_donation', 'payOldDonation')->name('subscriptionRole.pay.oldDonation');
            Route::post('donations/pay_delay_donation', 'payDelayDonation')->name('subscriptionRole.pay.delayDonation');
        });
        //! Outter Donations Routes
        Route::controller(OuterDonationsController::class)->group(function () {
            Route::get('outer_donations/history/{id}', 'index')->name('subscriptionRole.outer_donations.history');
            Route::post('outer_donations/history/store', 'storeOuterDonations')->name('subscriptionRole.outer_donations.store');
            Route::get('outer_donations/history/delete/{id}', 'removeOuterDonations')->name('subscriptionRole.outer_donations.delete');
            Route::post('outer_donations/history/update', 'updateOuterDonations')->name('subscriptionRole.outer_donations.update');
        });
        //! Cost Years Routes
        Route::controller(CostYearsController::class)->group(function () {
            Route::get('costyears/all', 'index')->name('subscriptionRole.costyears.all');
            Route::post('costyears/store', 'storeYears')->name('subscriptionRole.costyears.store');
            Route::get('costyears/delete/{id}', 'removeYear')->name('subscriptionRole.costyears.remove');
            Route::post('costyears/update', 'updateYear')->name('subscriptionRole.costyears.update');
        });
        //! Miscellaneous Routes
        Route::controller(MiscellaneousController::class)->group(function () {
            Route::get('miscellaneous/all', 'index')->name('subscriptionRole.miscellaneous.all');
            Route::post('miscellaneous/store', 'storeMiscellaneous')->name('subscriptionRole.miscellaneous.store');
            Route::get('miscellaneous/delete/{id}', 'deleteMiscellaneous')->name('subscriptionRole.miscellaneous.delete');
            Route::post('miscellaneous/update', 'updateMiscellaneous')->name('subscriptionRole.miscellaneous.update');
        });
        //! Withdraw Routes
        Route::controller(WithdrawController::class)->group(function () {
            Route::post('withdraw', 'withdraw')->name('subscriptionRole.withdraw');
            Route::post('withdraw/bank', 'bankWithdraw')->name('subscriptionRole.bank.withdraw');
        });
    });
});
