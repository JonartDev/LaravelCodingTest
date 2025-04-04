<?php

namespace App\Contracts;

use Illuminate\Http\Response;

interface ProductInterface
{
    public function addProduct(array $data): Response;
    public function getProducts(): array;
}