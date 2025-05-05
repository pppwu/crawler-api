<?php

use Illuminate\Support\Facades\Route;
use Modules\Crawler\Presentation\Controllers\CrawlController;


Route::prefix('crawl')->group(function () {
    Route::post('/', [CrawlController::class, 'store'])->name('crawl.store');
    Route::get('/{id}', [CrawlController::class, 'show'])->name('crawl.show');
    Route::put('/{id}', [CrawlController::class, 'update'])->name('crawl.update');  
    Route::delete('/{id}', [CrawlController::class, 'destroy'])->name('crawl.destroy');
});