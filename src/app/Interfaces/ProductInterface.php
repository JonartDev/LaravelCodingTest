<?php

namespace App\Interfaces;

use Illuminate\Http\Client\Response;

interface ProductInterface
{
    public function addProduct(array $data): Response;
    
}
