<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Crawler\Infrastructure\Http\LaravelHttpClient;
use Modules\Crawler\Domain\Contracts\HttpClientInterface;
use Modules\Crawler\Domain\Contracts\UuidGeneratorInterface;
use Modules\Crawler\Infrastructure\Utils\UuidGenerator;
use Modules\Crawler\Domain\Contracts\CrawlRepositoryInterface;
use Modules\Crawler\Domain\Contracts\CrawlServiceInterface;
use Modules\Crawler\Infrastructure\Repositories\CrawlRepository;
use Modules\Crawler\Application\Services\CrawlService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HttpClientInterface::class, LaravelHttpClient::class);
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->bind(CrawlRepositoryInterface::class, CrawlRepository::class);
        $this->app->bind(CrawlServiceInterface::class, CrawlService::class);    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
