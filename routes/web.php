<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\AssociationCommittesController;
use App\Http\Controllers\BoardMembersController;
use App\Http\Controllers\DelayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MsgController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TombsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\WorkerController;

Route::view('/','welcome');

Auth::routes();
Route::prefix('admin')->group(function () {
    Route::view('login', 'auth.login');
    Route::middleware('auth')->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'index')->name('home');
        });
        Route::controller(UserController::class)->group(function () {
            Route::get('profile', 'index')->name('user.profile');
            Route::post('update_profile', 'update')->name( 'user.update' );
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
        Route::controller(SubscribersController::class)->group(function(){});
        Route::controller(TombsController::class)->group(function(){});
        Route::controller(WorkerController::class)->group(function(){});
        Route::controller(WeddingController::class)->group(function(){});
        Route::controller(SubscriptionsController::class)->group(function(){});
        Route::controller(DelayController::class)->group(function(){});
        Route::controller(BoardMembersController::class)->group(function(){});
        Route::controller(ReportController::class)->group(function(){});
        Route::controller(AssociationCommittesController::class)->group(function () {
            Route::get('all', 'index')->name('association.all');
            Route::post('store_association', 'store')->name('association.store');
            Route::get('delete_association/{id}', 'remove')->name('association.delete');
            Route::post('update_association', 'update')->name('association.update');
        });
        Route::controller(AdsController::class)->group(function(){});
        Route::controller(MsgController::class)->group(function(){});
    });
});
