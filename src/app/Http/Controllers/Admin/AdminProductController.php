<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products with pagination
     */
    public function index()
    {
        $products = Product::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product with image upload
     */
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        
        $productData = $this->prepareProductData($validated, $request);
        
        Product::create($productData);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * Show the form for editing the product
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product with image handling
     */
    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);
        
        $productData = $this->prepareProductData($validated, $request, $product);
        
        $product->update($productData);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product with image cleanup
     */
    public function destroy(Product $product)
    {
        $this->deleteProductImage($product);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Validate product data
     */
    protected function validateProduct(Request $request, $productId = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255|unique:products,title,'.$productId,
            'body' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    /**
     * Prepare product data with image handling
     */
    protected function prepareProductData(array $validated, Request $request, Product $product = null)
    {
        $data = [
            'title' => $validated['title'],
            'body' => $validated['body'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'user_id' => auth()->id(),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($product && $product->image_path) {
                $this->deleteProductImage($product);
            }
            
            $data['image_path'] = $this->storeProductImage($request->file('image'));
        }

        return $data;
    }

    /**
     * Store product image and return path
     */
    protected function storeProductImage($image)
    {
        return $image->store('products', 'public');
    }

    /**
     * Delete product image from storage
     */
    protected function deleteProductImage(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
    }
}