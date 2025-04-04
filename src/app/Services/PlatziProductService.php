<?php

namespace App\Services;

use App\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class PlatziProductService implements ProductInterface
{
    public function addProduct(array $data): Response
    {
        return Http::post('https://api.escuelajs.co/api/v1/products', $data);
    }
}
