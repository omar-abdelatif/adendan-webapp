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
        });
        Route::controller(WeddingController::class)->group(function () {
            Route::get('weddings/all', 'index')->name('weddings.all');
            Route::post('wedding/store', 'weddingStore')->name('weddings.store');
            Route::get('wedding/delete/{id}', 'weddingRemove')->name('wedding.delete');
            Route::post('wedding/update', 'weddingUpdate')->name('weddings.update');
        });
        Route::controller(SubscribersController::class)->group(function(){});
        Route::controller(SubscriptionsController::class)->group(function(){});
        Route::controller(DelayController::class)->group(function(){});
        Route::controller(DonatorsController::class)->group(function(){});
        Route::controller(DonationsController::class)->group(function(){});
        Route::controller(AdsController::class)->group(function(){});
        Route::controller(MsgController::class)->group(function(){});
    });
});
