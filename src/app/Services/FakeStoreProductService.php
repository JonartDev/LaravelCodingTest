<?php

namespace App\Services;

use App\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class FakeStoreProductService implements ProductInterface
{
    public function addProduct(array $data): Response
    {
        return Http::post('https://fakestoreapi.com/products', $data);
    }
}
