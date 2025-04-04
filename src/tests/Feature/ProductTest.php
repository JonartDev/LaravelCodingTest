<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_not_deleted_by_default()
    {
        $user = User::factory()->create();

        // Create a deleted product
        Product::create([
            'title' => 'Deleted Product',
            'body' => 'This product is deleted',
            'user_id' => $user->id,
            'del_flag' => 1, // deleted flag
            'quantity' => 10,
            'image_path' => 'images/deleted_product.jpg',
        ]);

        // Create a non-deleted product
        $product = Product::create([
            'title' => 'Available Product',
            'body' => 'This product is available',
            'user_id' => $user->id,
            'del_flag' => 0, // active flag
            'quantity' => 10,
            'image_path' => 'images/available_product.jpg',
        ]);

        $products = Product::all();

        // Assert that only the non-deleted product is returned
        $this->assertCount(1, $products);
        $this->assertEquals('Available Product', $products->first()->title);
    }

    public function test_available_scope()
    {
        $user = User::factory()->create();

        // Create products with different quantities
        $productInStock = Product::create([
            'title' => 'In Stock Product',
            'body' => 'This product is in stock',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 5,
            'image_path' => 'images/in_stock.jpg',
        ]);

        $productOutOfStock = Product::create([
            'title' => 'Out of Stock Product',
            'body' => 'This product is out of stock',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 0,
            'image_path' => 'images/out_of_stock.jpg',
        ]);

        $products = Product::available()->get();

        // Assert only in-stock product is returned
        $this->assertCount(1, $products);
        $this->assertEquals('In Stock Product', $products->first()->title);
    }

    public function test_image_url_accessor()
    {
        Storage::fake('public'); // Fake storage for testing

        $user = User::factory()->create();

        // Create a product with an image path
        $product = Product::create([
            'title' => 'Product with Image',
            'body' => 'This product has an image',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 10,
            'image_path' => 'products/sample_image.jpg',
        ]);

        // Assert that the image URL accessor returns the correct URL
        $this->assertEquals(Storage::url('products/sample_image.jpg'), $product->image_url);
    }

    public function test_is_in_stock()
    {
        $user = User::factory()->create();

        // Create a product with stock
        $product = Product::create([
            'title' => 'Product with Stock',
            'body' => 'This product is in stock',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 5,
            'image_path' => 'images/product_in_stock.jpg',
        ]);

        // Assert the product is in stock
        $this->assertTrue($product->isInStock());

        // Create a product with no stock
        $productOutOfStock = Product::create([
            'title' => 'Out of Stock Product',
            'body' => 'This product is out of stock',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 0,
            'image_path' => 'images/product_out_of_stock.jpg',
        ]);

        // Assert the product is not in stock
        $this->assertFalse($productOutOfStock->isInStock());
    }

    public function test_update_stock()
    {
        $user = User::factory()->create();

        // Create a product with initial stock
        $product = Product::create([
            'title' => 'Product to Update Stock',
            'body' => 'This product will have its stock updated',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 5,
            'image_path' => 'images/product_to_update_stock.jpg',
        ]);

        // Update stock by adding 5
        $product->updateStock(5);

        // Assert the quantity is updated
        $this->assertEquals(10, $product->quantity);
    }
}
