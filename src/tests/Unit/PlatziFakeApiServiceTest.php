<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PlatziFakeApiService;
use Illuminate\Support\Facades\Http;

class PlatziFakeApiServiceTest extends TestCase
{
    public function test_add_product_to_platzi_api()
    {
        Http::fake([
            'https://api.escuelajs.co/api/v1/products' => Http::response([
                'id' => 123,
                'title' => 'Test Product',
            ], 201),
        ]);

        $service = new PlatziFakeApiService();

        $response = $service->addProduct([
            'title' => 'Test Product',
            'price' => 99.99,
            'description' => 'A test description',
            'categoryId' => 1,
            'images' => ['https://placeimg.com/640/480/any'],
        ]);

        $this->assertEquals(201, $response->status());      // OK
        $this->assertTrue($response->successful());         // OK
        $this->assertEquals('Test Product', $response->json('title'));
        $this->assertEquals(123, $response->json('id'));
    }
}
