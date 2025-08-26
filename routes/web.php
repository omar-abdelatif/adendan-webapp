<?php

use App\Models\SearchedData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DelayController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TombsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DonatorsController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\CostYearsController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\BoardMembersController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\OuterDonationsController;
use App\Http\Controllers\SubscriberDataController;
use App\Http\Controllers\AssociationCommittesController;

Auth::routes();

Route::view('login', 'auth.login');
Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('dashboard')->controller(HomeController::class)->group(function () {
            Route::get('main', 'index')->name('home');
        });
        Route::prefix('users')->controller(UserController::class)->group(function () {
            Route::get('profile', 'index')->name('user.profile');
            Route::post('user/store', 'store')->name('user.store');
            Route::get('users/all', 'AllUsers')->name('user.index');
            Route::post('update_profile', 'update')->name('user.update');
            Route::get('user/delete/{id}', 'destroy')->name('user.delete');
            Route::post('user/update', 'updateUser')->name('newuser.update');
        });
        Route::prefix('news')->controller(NewsController::class)->group(function () {
            Route::get('all', 'index')->name('news.all');
            Route::post('store_news', 'storeNews')->name('news.store');
            Route::post('update_news', 'updateNews')->name('news.update');
            Route::post('update_video', 'updateVideo')->name('video.update');
            Route::post('store_video/{id}', 'storeVideo')->name('video.store');
            Route::get('delete_news/{id}', 'destroyNews')->name('news.destroy');
            Route::get('delete_video/{id}', 'deleteVideo')->name('video.delete');
            Route::get('all_news/all_thumbs/{id}', 'showThumbnails')->name('show.thumbs');
            Route::get('delete_single_thumbs/{id}', 'deleteSingleImage')->name('thumbs.delete');
        });
        Route::prefix('tomb')->controller(TombsController::class)->group(function () {
            Route::get('tombs/all', 'index')->name('tomb.all');
            Route::post('tombs/store', 'storeTomb')->name('tomb.store');
            Route::post('tombs/update', 'updateTomb')->name('tomb.update');
            Route::get('tombs/delete/{id}', 'deleteTomb')->name('tomb.delete');
        });
        Route::prefix('workers')->controller(WorkerController::class)->group(function () {
            Route::get('workers/all', 'index')->name('workers.all');
            Route::post('worker/update', 'update')->name('worker.update');
            Route::post('workers/store', 'storeWorker')->name('worker.store');
            Route::get('worker/delete/{id}', 'delete')->name('worker.delete');
        });
        Route::prefix('board')->controller(BoardMembersController::class)->group(function () {
            Route::get('board/all', 'index')->name('board.all');
            Route::post('board/store', 'storeMember')->name('board.store');
            Route::post('board/update', 'updateMember')->name('board.update');
            Route::get('board/delete/{id}', 'deleteMember')->name('board.delete');
        });
        Route::prefix('association')->controller(AssociationCommittesController::class)->group(function () {
            Route::get('associations/all', 'index')->name('association.all');
            Route::post('associations/store_association', 'store')->name('association.store');
            Route::post('associations/update_association', 'update')->name('association.update');
            Route::get('associations/delete_association/{id}', 'remove')->name('association.delete');
        });
        Route::prefix('reports')->controller(ReportController::class)->group(function () {
            Route::get('age', 'ages')->name('reports.age');
            Route::get('jobs', 'jobs')->name('reports.jobs');
            Route::get('safe', 'safe')->name('reports.safe');
            Route::get('search', 'search')->name('reports.search');
            Route::get('all', 'index')->name('reports.subscriptions');
            Route::get('location', 'locations')->name('reports.location');
            Route::get('bank', 'bankTransactions')->name('bankTransactios');
            Route::get('incomplete', 'incomplete')->name('reports.incompete');
            Route::get('associates', 'associates')->name('reports.associates');
            Route::get('donations', 'outerdonations')->name('reports.donations');
            Route::get('indebtedness', 'indebtedness')->name('reports.indebtedness');
            Route::get('inner_donations', 'innerDonations')->name('reports.innerDonations');
            Route::get('subscribers_data', 'searchedData')->name('reports.subscribersData');
            Route::get('subscriptions_old_delays', 'subOldDelay')->name('reports.subOlddelay');
        });
        Route::prefix('weddings')->controller(WeddingController::class)->group(function () {
            Route::get('weddings/all', 'index')->name('weddings.all');
            Route::post('wedding/store', 'weddingStore')->name('weddings.store');
            Route::post('wedding/update', 'weddingUpdate')->name('weddings.update');
            Route::get('wedding/delete/{id}', 'weddingRemove')->name('wedding.delete');
            Route::post('wedding/bulk/upload', 'uploadBulkWedding')->name('weddings.bulk');
        });
        Route::prefix('subscriber')->controller(SubscribersController::class)->group(function () {
            Route::get('subscribers/all', 'index')->name('subscriber.all');
            Route::post('subscriber/update', 'update')->name('subscribe.update');
            Route::post('subscribers/store', 'storeSubs')->name('subscribe.store');
            Route::get('subscriber/delete/{id}', 'destroy')->name('subscribe.destroy');
            Route::post('subscriber/bulk_upload', 'bulkUpload')->name('subscriber.bulk');
            Route::get('subscriber/update/{id}', 'subscriberDetails')->name('subscriber.details');
            Route::get('subscribers/get-year-cost/{year}', 'getYearlyCostByAjax')->name('get.year.cost');
            Route::get('subscribers/ajax/data/subscribers', 'getSubscribersData')->name('ajax.subscribers');
        });
        Route::prefix('subscription')->controller(SubscriptionsController::class)->group(function () {
            Route::get('subscription/history/{id}', 'index')->name('subscription.history');
            Route::post('subscription/store', 'storeSubscription')->name('subscription.store');
            Route::post('subscription/updating', 'updatingSubscription')->name('subscription.update');
            Route::get('subscription/delete/{id}', 'destroyingSubscription')->name('subscription.destroy');
        });
        Route::prefix('subscription')->controller(DelayController::class)->group(function () {
            Route::post('delays/pay', 'paySubscription')->name('subscription.pay');
            Route::post('delays/old_delays', 'payOldDelay')->name('oldDelays.pay');
            Route::post('delays/upload_delays', 'uploadDelays')->name('delays.costbyyear');
            Route::post('delays/subscriber_delays', 'subscriberDelay')->name('bulk_subscriber_delay');
        });
        Route::prefix('donators')->controller(DonatorsController::class)->group(function () {
            Route::get('donators/all', 'index')->name('donators.all');
            Route::post('donators/store', 'storeDonator')->name('donators.store');
            Route::post('donators/update', 'donatorUpdate')->name('donators.update');
            Route::get('donators/remove/{id}', 'removeDonator')->name('donators.remove');
        });
        Route::prefix('donations')->controller(DonationsController::class)->group(function () {
            Route::get('donations/showAll/{id}', 'index')->name("donations.showAll");
            Route::post('donations/store', 'storeDonations')->name('donations.store');
            Route::post('donations/update', 'updateDonation')->name('donations.update');
            Route::get('donations/remove/{id}', 'removeDonation')->name('donation.remove');
            Route::post('donation/pay_old_donation', 'payOldDonation')->name('pay.oldDonation');
            Route::post('donations/pay_delay_donation', 'payDelayDonation')->name('pay.delayDonation');
            Route::post('donations/delays/upload_bulk', 'donationsOnSubscribers')->name('delays.uploadDonations');
        });
        Route::prefix('outer_donations')->controller(OuterDonationsController::class)->group(function () {
            Route::get('outer_donations/history/{id}', 'index')->name('outer_donations.history');
            Route::post('outer_donations/history/store', 'storeOuterDonations')->name('outer_donations.store');
            Route::post('outer_donations/history/update', 'updateOuterDonations')->name('outer_donations.update');
            Route::get('outer_donations/history/delete/{id}', 'removeOuterDonations')->name('outer_donations.delete');
        });
        Route::prefix('costyears')->controller(CostYearsController::class)->group(function () {
            Route::get('costyears/all', 'index')->name('costyears.all');
            Route::post('costyears/store', 'storeYears')->name('costyears.store');
            Route::post('costyears/update', 'updateYear')->name('costyears.update');
            Route::get('costyears/delete/{id}', 'removeYear')->name('costyears.remove');
        });
        Route::prefix('miscellaneous')->controller(MiscellaneousController::class)->group(function () {
            Route::get('miscellaneous/all', 'index')->name('miscellaneous.all');
            Route::post('miscellaneous/store', 'storeMiscellaneous')->name('miscellaneous.store');
            Route::post('miscellaneous/update', 'updateMiscellaneous')->name('miscellaneous.update');
            Route::get('miscellaneous/delete/{id}', 'deleteMiscellaneous')->name('miscellaneous.delete');
        });
        Route::prefix('withdraw')->controller(WithdrawController::class)->group(function () {
            Route::post('withdraw', 'withdraw')->name('withdraw');
            Route::post('withdraw/bank', 'bankWithdraw')->name('bank.withdraw');
        });
        Route::prefix('activiy')->controller(ActivityController::class)->name('activity.')->group(function () {
            Route::get('activity', 'index')->name('index');
        });
        Route::prefix('roles')->controller(RolesController::class)->name('roles.')->group(function () {
            Route::get('roles', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::post('update', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('destroy');
        });
        Route::prefix('permissions')->controller(PermissionsController::class)->name('permissions.')->group(function () {
                Route::post('store', 'store')->name('store');
                Route::post('update', 'update')->name('update');
                Route::get('permissions', 'index')->name('index');
                Route::get('delete/{id}', 'destroy')->name('destroy');
        });
        Route::prefix('searched_data')->controller(SubscriberDataController::class)->name('search.')->group(function () {
            Route::post('approve', 'approve')->name('approve');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('create_new', 'insert')->name('insert');
        });
    });
});