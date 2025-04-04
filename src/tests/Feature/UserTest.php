<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_relationship()
    {
        // Create a user role
        $role = UserRole::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        // Create a user with that role
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
        ]);

        // Assert that the user's role is correctly associated
        $this->assertEquals($role->id, $user->role->id);
        $this->assertEquals('Admin', $user->role->name);
    }

    public function test_is_admin_method()
    {
        // Create a user with the ADMIN role
        $role = UserRole::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
        ]);

        // Debugging output
        dd($adminUser->role_id, UserRole::ADMIN);

        // Create a user without the ADMIN role
        $roleUser = UserRole::create([
            'name' => 'User',
            'slug' => 'user',
        ]);

        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $roleUser->id,
        ]);

        // Assert that isAdmin() returns true for admin
        $this->assertTrue($adminUser->isAdmin());
        // Assert that isAdmin() returns false for non-admin
        $this->assertFalse($normalUser->isAdmin());
    }


    public function test_user_has_many_products()
    {
        // Create a user
        $user = User::create([
            'name' => 'User with Products',
            'email' => 'userproducts@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 1,  // Assuming this is the admin role
        ]);

        // Create products associated with the user
        $product1 = Product::create([
            'title' => 'Product 1',
            'body' => 'Product 1 description',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 10,
            'image_path' => 'images/product1.jpg',
        ]);

        $product2 = Product::create([
            'title' => 'Product 2',
            'body' => 'Product 2 description',
            'user_id' => $user->id,
            'del_flag' => 0,
            'quantity' => 5,
            'image_path' => 'images/product2.jpg',
        ]);

        // Assert the user has 2 products
        $this->assertCount(2, $user->products);
        $this->assertEquals('Product 1', $user->products->first()->title);
    }
}
