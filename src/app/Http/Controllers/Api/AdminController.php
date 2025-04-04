<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Get all users with their products
     */
    public function usersWithProducts()
    {
        $users = User::with('products')
            ->whereHas('products')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name,
                    'products_count' => $user->products->count(),
                    'products' => $user->products->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'title' => $product->title,
                            'quantity' => $product->quantity,
                            'created_at' => $product->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Get all products in the system
     */
    public function allProducts(Request $request)
    {
        $products = Product::with('user')
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('body', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'body' => $product->body,
                    'quantity' => $product->quantity,
                    'user' => $product->user ? [
                        'id' => $product->user->id,
                        'name' => $product->user->name,
                        'email' => $product->user->email,
                    ] : null,
                    'created_at' => $product->created_at->format('Y-m-d H:i:s'),
                    'can_delete' => !$product->user()->exists(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Admin delete a product
     */
    public function deleteProduct(Product $product)
    {
        if ($product->user()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product assigned to a user',
            ], 403);
        }

        if ($product->image_path) {
            Storage::disk('ftp')->delete($product->image_path);
        }

        $product->update(['del_flag' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Product marked as deleted',
        ]);
    }
}