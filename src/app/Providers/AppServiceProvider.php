<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExternalProductService;
use App\Services\FakeStoreApiService;
use App\Services\PlatziApiService;
use App\Models\Product;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExternalProductService::class, function ($app) {
            return new ExternalProductService(
                $app->make(FakeStoreApiService::class),
                $app->make(PlatziApiService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }
}
