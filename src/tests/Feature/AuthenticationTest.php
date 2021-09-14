<?php

namespace Tests\Feature;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
class UserTest extends TestCase
{
    use RefreshDatabase;
    // public function testMustEnterEmailAndPassword()
    // {
    //     $this->json('POST', 'api/v1/auth')
    //         ->assertStatus(422)
    //         ->assertJson([
    //             "message" => "The given data was invalid.",
    //             "errors" => [
    //                 'email' => ["The email field is required."],
    //                 'password' => ["The password field is required."],
    //             ]
    //         ]);
    // }

    public function testWithWrongEmailAndPassword()
    {
        $loginData = [
            'email' => '*********@********.com',
            'password' => '******',
        ];
        $this->json('POST', 'api/v1/auth',$loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJsonStructure([
                "error"
            ]);

    }

    public function testSuccessfulAuthentication()
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
    }

}
