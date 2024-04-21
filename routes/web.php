<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\MsgController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TombsController;
use App\Http\Controllers\DelayController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\DonatorsController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\BoardMembersController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\AssociationCommittesController;
use App\Http\Controllers\CostYearsController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\OuterDonationsController;
use App\Http\Controllers\WithdrawController;

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::view('login', 'auth.login');
    Route::middleware('auth')->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'index')->name('home');
        });
        Route::controller(UserController::class)->group(function () {
            Route::get('profile', 'index')->name('user.profile');
            Route::post('dashboard/update_profile', 'update')->name('user.update');
        });
        Route::controller(NewsController::class)->group(function () {
            Route::get('news/all', 'index')->name('news.all');
            Route::post('news/store_news', 'storeNews')->name('news.store');
            Route::get('news/delete_news/{id}', 'destroyNews')->name('news.destroy');
            Route::post('news/update_news', 'updateNews')->name('news.update');
            Route::get('news/all_news/all_thumbs/{id}', 'showThumbnails')->name('show.thumbs');
            Route::get('news/delete_single_thumbs/{id}', 'deleteSingleImage')->name('thumbs.delete');
            Route::get('news/delete_video/{id}', 'deleteVideo')->name('video.delete');
            Route::post('update_video', 'updateVideo')->name('video.update');
            Route::post('store_video/{id}', 'storeVideo')->name('video.store');
        });
        Route::controller(TombsController::class)->group(function () {
            Route::get('tombs/all', 'index')->name('tomb.all');
            Route::post('tombs/store', 'storeTomb')->name('tomb.store');
            Route::get('tombs/delete/{id}', 'deleteTomb')->name('tomb.delete');
            Route::post('tombs/update', 'updateTomb')->name('tomb.update');
        });
        Route::controller(WorkerController::class)->group(function () {
            Route::get('workers/all', 'index')->name('workers.all');
            Route::post('workers/store', 'storeWorker')->name('worker.store');
            Route::get('worker/delete/{id}', 'delete')->name('worker.delete');
            Route::post('worker/update', 'update')->name('worker.update');
        });
        Route::controller(BoardMembersController::class)->group(function () {
            Route::get('board/all', 'index')->name('board.all');
            Route::post('board/store', 'storeMember')->name('board.store');
            Route::get('board/delete/{id}', 'deleteMember')->name('board.delete');
            Route::post('board/update', 'updateMember')->name('board.update');
        });
        Route::controller(AssociationCommittesController::class)->group(function () {
            Route::get('associations/all', 'index')->name('association.all');
            Route::post('associations/store_association', 'store')->name('association.store');
            Route::get('associations/delete_association/{id}', 'remove')->name('association.delete');
            Route::post('associations/update_association', 'update')->name('association.update');
        });
        Route::controller(ReportController::class)->group(function () {
            Route::get('reports/all', 'index')->name('reports.subscriptions');
            Route::get('reports/jobs', 'jobs')->name('reports.jobs');
            Route::get('reports/age', 'ages')->name('reports.age');
            Route::get('reports/location', 'locations')->name('reports.location');
            Route::get('reports/donations', 'outerdonations')->name('reports.donations');
            Route::get('reports/inner_donations', 'innerDonations')->name('reports.innerDonations');
            Route::get('reports/indebtedness', 'indebtedness')->name('reports.indebtedness');
            Route::get('reports/safe', 'safe')->name('reports.safe');
            Route::get('reports/bank', 'bankTransactions')->name('bankTransactios');
            Route::get('reports/associates', 'associates')->name('reports.associates');
        });
        Route::controller(WeddingController::class)->group(function () {
            Route::get('weddings/all', 'index')->name('weddings.all');
            Route::post('wedding/store', 'weddingStore')->name('weddings.store');
            Route::get('wedding/delete/{id}', 'weddingRemove')->name('wedding.delete');
            Route::post('wedding/update', 'weddingUpdate')->name('weddings.update');
        });
        Route::controller(SubscribersController::class)->group(function () {
            Route::get('subscribers/all', 'index')->name('subscriber.all');
            Route::post('subscribers/store', 'storeSubs')->name('subscribe.store');
            Route::get('subscriber/delete/{id}', 'destroy')->name('subscribe.destroy');
            Route::post('subscriber/update', 'update')->name('subscribe.update');
            Route::get('subscriber/update/{id}', 'subscriberDetails')->name('subscriber.details');
            Route::post('subscriber/bulk_upload', 'bulkUpload')->name('subscriber.bulk');
        });
        Route::controller(SubscriptionsController::class)->group(function () {
            Route::get('subscription/history/{id}', 'index')->name('subscription.history');
            Route::post('subscription/store', 'storeSubscription')->name('subscription.store');
            Route::get('subscription/delete/{id}', 'destroyingSubscription')->name('subscription.destroy');
            Route::post('subscription/updating', 'updatingSubscription')->name('subscription.update');
        });
        Route::controller(DelayController::class)->group(function () {
            Route::post('delays/store', 'storeDelays')->name('delays.store');
            Route::post('delays/upload_delays', 'uploadDelays')->name('delays.costbyyear');
            Route::post('delays/subscriber_delays', 'subscriberDelay')->name('bulk_subscriber_delay');
            Route::post('delays/pay', 'paySubscription')->name('subscription.pay');
            Route::post('delays/old_delays', 'payOldDelay')->name('oldDelays.pay');
        });
        Route::controller(DonatorsController::class)->group(function () {
            Route::get('donators/all', 'index')->name('donators.all');
            Route::post('donators/store', 'storeDonator')->name('donators.store');
            Route::get('donators/remove/{id}', 'removeDonator')->name('donators.remove');
            Route::post('donators/update', 'donatorUpdate')->name('donators.update');
        });
        Route::controller(DonationsController::class)->group(function () {
            Route::get('donations/showAll/{id}', 'index')->name("donations.showAll");
            Route::post('donations/store', 'storeDonations')->name('donations.store');
            Route::get('donations/remove/{id}', 'removeDonation')->name('donation.remove');
            Route::post('donations/update', 'updateDonation')->name('donations.update');
            Route::post('donations/delays/upload_bulk', 'donationsOnSubscribers')->name('delays.uploadDonations');
            Route::post('donation/pay_old_donation', 'payOldDonation')->name('pay.oldDonation');
            Route::post('donations/pay_delay_donation', 'payDelayDonation')->name('pay.delayDonation');
        });
        Route::controller(OuterDonationsController::class)->group(function () {
            Route::get('outer_donations/history/{id}', 'index')->name('outer_donations.history');
            Route::post('outer_donations/history/store', 'storeOuterDonations')->name('outer_donations.store');
            Route::get('outer_donations/history/delete/{id}', 'removeOuterDonations')->name('outer_donations.delete');
            Route::post('outer_donations/history/update', 'updateOuterDonations')->name('outer_donations.update');
        });
        Route::controller(CostYearsController::class)->group(function () {
            Route::get('costyears/all', 'index')->name('costyears.all');
            Route::post('costyears/store', 'storeYears')->name('costyears.store');
            Route::get('costyears/delete/{id}', 'removeYear')->name('costyears.remove');
            Route::post('costyears/update', 'updateYear')->name('costyears.update');
        });
        Route::controller(MiscellaneousController::class)->group(function () {
            Route::get('miscellaneous/all', 'index')->name('miscellaneous.all');
            Route::post('miscellaneous/store', 'storeMiscellaneous')->name('miscellaneous.store');
            Route::get('miscellaneous/delete/{id}', 'deleteMiscellaneous')->name('miscellaneous.delete');
            Route::post('miscellaneous/update', 'updateMiscellaneous')->name('miscellaneous.update');
        });
        Route::controller(WithdrawController::class)->group(function () {
            Route::post('withdraw', 'withdraw')->name('withdraw');
            Route::post('withdraw/bank', 'bankWithdraw')->name('bank.withdraw');
        });
    });
});
