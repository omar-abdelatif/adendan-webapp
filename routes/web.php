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
        Route::controller(NewsController::class)->group(function(){});
        Route::controller(SubscribersController::class)->group(function(){});
        Route::controller(TombsController::class)->group(function(){});
        Route::controller(WorkerController::class)->group(function(){});
        Route::controller(WeddingController::class)->group(function(){});
        Route::controller(SubscriptionsController::class)->group(function(){});
        Route::controller(DelayController::class)->group(function(){});
        Route::controller(BoardMembersController::class)->group(function(){});
        Route::controller(ReportController::class)->group(function(){});
        Route::controller(AssociationCommittesController::class)->group(function(){});
        Route::controller(AdsController::class)->group(function(){});
        Route::controller(MsgController::class)->group(function(){});
    });
});
