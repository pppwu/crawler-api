<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Crawler\Infrastructure\Http\LaravelHttpClient;
use Modules\Crawler\Domain\Contracts\HttpClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HttpClientInterface::class, LaravelHttpClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
