<?php

use BenCarr\Embed\Http\Controllers\RefreshController;
use BenCarr\Embed\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('embed-fieldtype')->group(function() {
    Route::post('refresh', [RefreshController::class, 'index']);
    Route::get('preview', [PreviewController::class, 'index']);
});