<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function test_user_add_to_cart()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::factory()->create();

        $data = [
            'user_id' => $user->id,
            'product_id' => [$product->id],
        ];

        $response = $this->post('/api/cart', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('carts', [
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
        ]);
    }

    /**
     * @test
     *
     */
    public function test_checkout_order()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/checkout');

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function test_all_orders()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/orders');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_change_order_status()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'total' => $product->price * $product->quantity,
            'status' => 'paid',
        ]);

        $newData = [
            'status' => 'shipped',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('/api/orders/' . $order->id, $newData);

        $response->assertStatus(200);
    }

}
