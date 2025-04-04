<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class PlatziFakeApiService
{
    public function addProduct(array $data): Response
    {
        return Http::post('https://api.escuelajs.co/api/v1/products', $data);
    }
}
