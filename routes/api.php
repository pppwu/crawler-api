<?php

use Illuminate\Support\Facades\Route;
use Modules\Crawler\Presentation\Controllers\CrawlController;


Route::prefix('crawl')->group(function () {
    Route::post('/', [CrawlController::class, 'store']);
    Route::get('/{id}', [CrawlController::class, 'show']);
    Route::put('/{id}', [CrawlController::class, 'update']);
    Route::delete('/{id}', [CrawlController::class, 'destroy']);
});