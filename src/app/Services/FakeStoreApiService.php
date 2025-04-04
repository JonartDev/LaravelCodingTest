<?php

namespace App\Services;

use App\Contracts\ProductInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

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
            'body' => $data['body'] ?? '',
            'quantity' => $data['quantity'] ?? '',
            'category' => $data['category'] ?? 'general',
            'image_path' => $data['image_path'] ?? '',
        ]);
        $product = Product::create([
            'title' => $data['title'],
            'price' => $data['price'] ?? 0,
            'body' => $data['body'] ?? '',
            'quantity' => $data['quantity'] ?? '',
            'category' => $data['category'] ?? 'general',
            'image_path' => $data['image_path'] ?? '',
            'user_id' => Auth::id(), // ✅ THIS LINE IS ESSENTIAL
        ]);

        return new Response(
            $response->body(),
            $response->status(),
            $response->headers()
        );
    }
}
