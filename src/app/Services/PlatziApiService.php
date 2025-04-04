<?php

namespace App\Services;

use App\Contracts\ProductInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class PlatziApiService implements ProductInterface
{
    protected $baseUrl = 'https://api.escuelajs.co/api/v1';

    public function getProducts(): array
    {
        $response = Http::get("{$this->baseUrl}/products");
        return $response->json();
    }

    public function addProduct(array $data): Response
    {
        $response = Http::post("{$this->baseUrl}/products", [
            'title' => $data['title'],
            'price' => $data['price'] ?? 0,
            'description' => $data['description'] ?? '',
            'categoryId' => $data['category_id'] ?? 1,
            'images' => $data['images'] ?? ['https://placeimg.com/640/480/any'],
        ]);

        return new Response(
            $response->body(),
            $response->status(),
            $response->headers()
        );
    }
}