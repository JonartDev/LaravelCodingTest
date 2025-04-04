<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductInterface;
use App\Services\FakeStoreProductService;
use App\Services\PlatziProductService;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductInterface::class, function ($app) {
            $driver = config('product.driver');

            return match ($driver) {
                'fakestore' => new FakeStoreProductService(),
                'platzi' => new PlatziProductService(),
                default => throw new \Exception("Invalid product driver"),
            };
        });
    }
}
