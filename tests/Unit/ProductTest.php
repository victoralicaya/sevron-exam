<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_user_search_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        Product::create([
            'name' => 'iphone',
            'description' => 'apple phone',
            'price' => 200,
            'quantity' => 100
        ]);

        $response = $this->get('/api/products?search=iphone', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_all_products()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        Product::factory()->count(10)->create();

        $response = $this->get('/api/products',  [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_add_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $data = [
            'name' => 'iphone',
            'description' => 'apple phone',
            'price' => 200,
            'quantity' => 100
        ];

        $response = $this->post('/api/products', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity']
        ]);
    }

    /**
     * @test
     */
    public function test_update_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::create([
            'name' => 'iphone',
            'description' => 'apple phone',
            'price' => 200,
            'quantity' => 0
        ]);

        $newData = [
            'name' => 'samsung galaxy',
            'description' => 'samsung phone',
            'price' => 100,
            'quantity' => 60
        ];

        $response = $this->put('/api/products/' . $product->id, $newData,  [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $newData);
    }

    /**
     * @test
     */
    public function test_delete_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::create([
            'name' => 'iphone',
            'description' => 'apple phone',
            'price' => 200,
            'quantity' => 10
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/products/' . $product->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
