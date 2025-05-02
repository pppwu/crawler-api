<?php

use Illuminate\Support\Facades\Route;
use Modules\Crawler\Presentation\Controllers\CrawlController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/crawl', CrawlController::class);