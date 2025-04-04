<?php

namespace App\Services;

use App\Contracts\ProductInterface;
use App\Services\FakeStoreApiService;
use App\Services\PlatziApiService;
use Illuminate\Http\Response;

class ExternalProductService
{
    protected $currentApi;
    protected $apis = [];

    public function __construct(FakeStoreApiService $fakeStoreApi, PlatziApiService $platziApi)
    {
        $this->apis = [
            'fakestore' => $fakeStoreApi,
            'platzi' => $platziApi,
        ];
        $this->currentApi = $fakeStoreApi; // Default API
    }

    public function switchApi(string $apiName): void
    {
        if (!array_key_exists($apiName, $this->apis)) {
            throw new \InvalidArgumentException("API {$apiName} not supported");
        }

        $this->currentApi = $this->apis[$apiName];
    }

    public function getProducts(): array
    {
        return $this->currentApi->getProducts();
    }

    public function addProduct(array $data): Response
    {
        return $this->currentApi->addProduct($data);
    }
}