<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\User;

class UserProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserProductCreation()
    {
        $user = factory(User::class)->create([
            'email' => 'example@domain.com',
            'password' => 'secret',
        ]);

        $loginData = [
            'email' => 'example@domain.com',
            'password' => 'secret',
        ];

        $this->json('POST', 'api/v1/auth', $loginData, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in",
            "user"
        ]);

        $this->assertAuthenticated();


        $formData = [
            'product_sku'=>'Test'
        ];


        $response = $this->json('POST', '/api/v1/user/products',  $formData );

        $response->assertStatus(403);
    }

}
