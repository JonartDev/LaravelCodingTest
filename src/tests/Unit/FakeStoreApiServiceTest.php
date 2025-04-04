<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\FakeStoreApiService;
use Illuminate\Http\Respons;

class FakeStoreApiServiceTest extends TestCase
{
    public function testAddProductToFakeStoreApi()
    {
        Http::fake([
            'https://fakestoreapi.com/products' => Http::response(['id' => 101, 'title' => 'Test Product'], 201),
        ]);

        $service = new FakeStoreApiService();

        $response = $service->addProduct([
            'title' => 'Test Product',
            'price' => 99.99,
            'description' => 'Just testing',
            'category' => 'electronics',
            'image' => 'https://i.pravatar.cc',
        ]);

        $response->assertCreated();
        $this->assertEquals('Test Product', $response['title']);
    }
}
