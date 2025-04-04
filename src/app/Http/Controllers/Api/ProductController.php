<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products', 3600, function () {
            return Product::with('user')->get();
        });

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:products|max:255',
            // 'body' => 'required',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'ftp');
        }

        $product = Product::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'quantity' => $request->quantity,
            'image_path' => $imagePath,
        ]);

        // Dispatch event for email notification
        event(new \App\Events\ProductCreated($product));

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'title' => 'required|max:255|unique:products,title,' . $product->id,
            'body' => 'required',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('ftp')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'ftp');
        }

        $product->update([
            'title' => $request->title,
            'body' => $request->body,
            'quantity' => $request->quantity,
            'image_path' => $imagePath,
        ]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->user()->exists()) {
            return response()->json(['message' => 'Cannot delete product assigned to a user'], 403);
        }

        if ($product->image_path) {
            Storage::disk('ftp')->delete($product->image_path);
        }

        $product->update(['del_flag' => true]);

        return response()->json(null, 204);
    }
}