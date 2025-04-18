<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalProductService;
use App\Contracts\ProductInterface;

class ExternalProductController extends Controller
{
    protected $externalProductService;

    public function __construct(ExternalProductService $externalProductService)
    {
        $this->externalProductService = $externalProductService;
    }

    public function index()
    {
        $products = $this->externalProductService->getProducts();
        return response()->json($products);
    }

    public function addProduct(Request $request)
    {
        $product = $this->externalProductService->addProduct($request->all());
        return response()->json($product, 201);
    }
    // public function addProduct(Request $request)
    // {
    //     $data = $request->all();

    //     // Handle image upload if present
    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('product_images', 'public');
    //         $data['image'] = asset('storage/' . $path);
    //     }

    //     $product = $this->externalProductService->addProduct($data);
    //     return response()->json($product, 201);
    // }

    public function switchApi(Request $request)
    {
        $api = $request->input('api');
        $this->externalProductService->switchApi($api);
        return response()->json(['message' => 'API switched successfully']);
    }
}
