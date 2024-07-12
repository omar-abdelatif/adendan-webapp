<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TombsController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\MediaRole\MediaRoleController;

Auth::routes();

Route::prefix('media')->group(function () {
    Route::middleware(['auth', 'role:media'])->group(function () {
        //! Home Page Routes
        Route::prefix('dashboard')->group(function () {
            Route::controller(MediaRoleController::class)->group(function () {
                Route::get('main', 'MediaRole')->name('mediaRole.index');
            });
        });
        Route::prefix('news')->group(function () {
            Route::controller(NewsController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.news.all');
                Route::post('store_news', 'storeNews')->name('news.store');
                Route::get('delete_news/{id}', 'destroyNews')->name('news.destroy');
                Route::post('update_news', 'updateNews')->name('news.update');
                Route::get('all_news/all_thumbs/{id}', 'showThumbnails')->name('show.thumbs');
                Route::get('delete_single_thumbs/{id}', 'deleteSingleImage')->name('thumbs.delete');
                Route::get('delete_video/{id}', 'deleteVideo')->name('video.delete');
                Route::post('update_video', 'updateVideo')->name('video.update');
                Route::post('store_video/{id}', 'storeVideo')->name('video.store');
            });
        });
        Route::prefix('workers')->group(function () {
            Route::controller(WorkerController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.workers.all');
                Route::post('store', 'storeWorker')->name('worker.store');
                Route::get('delete/{id}', 'delete')->name('worker.delete');
                Route::post(
                    'update',
                    'update'
                )->name('worker.update');
            });
        });
        Route::prefix('tombs')->group(function () {
            Route::controller(TombsController::class)->group(function () {
                Route::get('all', 'index')->name('mediaRole.tomb.all');
                Route::post('store', 'storeTomb')->name('tomb.store');
                Route::get('delete/{id}', 'deleteTomb')->name('tomb.delete');
                Route::post('update',
                    'updateTomb'
                )->name('tomb.update');
            });
        });
    });
});
