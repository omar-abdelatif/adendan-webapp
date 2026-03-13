<?php

use App\Http\Controllers\Api\OcrController;
use Illuminate\Support\Facades\Route;

Route::post('/ocr-data', [OcrController::class, 'store']);
