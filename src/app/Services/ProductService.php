<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function createProduct(array $data, $image = null): Product
    {
        $imagePath = $this->storeImage($image);

        return Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'image_path' => $imagePath,
            'user_id' => auth()->id()
        ]);
    }

    public function updateProduct(Product $product, array $data, $image = null): Product
    {
        if ($image) {
            $this->deleteImage($product->image_path);
            $data['image_path'] = $this->storeImage($image);
        }

        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): bool
    {
        $this->deleteImage($product->image_path);
        return $product->delete();
    }

    protected function storeImage($image): ?string
    {
        if (!$image) return null;
        return $image->store('products', 'public');
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
