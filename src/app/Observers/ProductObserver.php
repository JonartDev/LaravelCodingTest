<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    public function created(Product $product)
    {
        Log::info('Product created: ' . $product->title);
    }

    public function updated(Product $product)
    {
        Log::info('Product updated: ' . $product->title);
    }

    public function deleted(Product $product)
    {
        Log::warning('Product deleted: ' . $product->title);
    }

    public function restored(Product $product)
    {
        Log::info('Product restored: ' . $product->title);
    }

    public function forceDeleted(Product $product)
    {
        Log::error('Product permanently deleted: ' . $product->title);
    }
}
