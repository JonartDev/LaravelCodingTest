<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Use the test database
        config(['database.default' => 'mysql_test']);
    }

    public function test_can_create_product()
    {
        $user = User::factory()->create(['role_id' => UserRole::USER]);
        
        $response = $this->actingAs($user)->postJson('/api/products', [
            'title' => 'Test Product',
            'body' => 'Test Description',
            'quantity' => 10,
        ]);

        $response->assertStatus(201)
                ->assertJson(['title' => 'Test Product']);
    }

    public function test_cannot_create_duplicate_product()
    {
        $user = User::factory()->create(['role_id' => UserRole::USER]);
        
        Product::factory()->create(['title' => 'Existing Product', 'user_id' => $user->id]);
        
        $response = $this->actingAs($user)->postJson('/api/products', [
            'title' => 'Existing Product',
            'body' => 'Test Description',
            'quantity' => 10,
        ]);

        $response->assertStatus(422);
    }

    // Add more test cases for update, delete, etc.
}