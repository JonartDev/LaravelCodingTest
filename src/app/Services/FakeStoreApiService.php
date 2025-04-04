<?php

namespace App\Services;

use App\Contracts\ProductInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FakeStoreApiService implements ProductInterface
{
    protected $baseUrl = 'https://fakestoreapi.com';

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
            'category' => $data['category'] ?? 'general',
            'image' => $data['image'] ?? '',
        ]);

        return new Response(
            $response->body(),
            $response->status(),
            $response->headers()
        );
    }
}