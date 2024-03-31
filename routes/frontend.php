<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MasterController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\News\NewsController;
use App\Http\Controllers\Frontend\BoardMembersController;
use App\Http\Controllers\Frontend\AssociationsCommittesController;
use App\Http\Controllers\Frontend\WorkerController;

Auth::routes();

Route::view('about', 'frontend.pages.about')->name('site.about');
Route::get('/', [MasterController::class, 'index'])->name('site.index');
Route::view('contact_us', 'frontend.pages.contact')->name('site.contact');
Route::get('all_news', [NewsController::class, 'index'])->name('site.news');
Route::get('search', [SearchController::class, 'index'])->name('site.search');
Route::post('result', [SearchController::class, 'result'])->name('site.result');
Route::get('workers/all', [WorkerController::class, 'index'])->name('workers.index');
Route::get('board_members', [BoardMembersController::class, 'index'])->name('site.borders');
Route::get('all_news/single_news/{id}', [NewsController::class, 'newsDetails'])->name('site.single_news');
Route::get('search/wedding_details/{id}', [SearchController::class, 'weddingDetails'])->name('site.weddingDetails');
Route::get('assossiation_committees', [AssociationsCommittesController::class, 'index'])->name('site.assossiation');
Route::get('assossiation_committees/assossiation_details/{id}', [AssociationsCommittesController::class, 'associationDetails'])->name('site.assossiation_details');
