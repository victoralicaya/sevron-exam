<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_user_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function test_register_user()
    {
        $data = [
            'name' => 'John Doe',
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin'
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => $data['role']
        ]);
    }

    /**
     * @test
     */
    public function test_user_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout');

        $response->assertStatus(200);
    }
}
