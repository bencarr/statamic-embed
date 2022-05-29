<?php

use BenCarr\Embed\Http\Controllers\FetchController;
use BenCarr\Embed\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('embed-fieldtype')->group(function() {
    Route::get('fetch', [FetchController::class, 'index']);
    Route::get('preview', [PreviewController::class, 'index']);
});