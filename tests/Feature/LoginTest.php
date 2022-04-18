<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function user_login()
    {
        $user = User::first();

        $data = [
            'email' => $user->email,
            'password' => '12345678',
        ];

        $headers = [
            'Accept' => 'Application/json',
        ];

        $response = $this->post("{$this->baseUrl}/login", $data, $headers);

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'token',
                'token_type'
            ]
        ]);
    }

    /**
     * @test
     */
    public function user_login_with_incorrect_credentials()
    {
        $user = User::first();

        $data = [
            'email' => $user->email,
            'password' => '123456789',
        ];

        $headers = [
            'Accept' => 'Application/json',
        ];

        $response = $this->post("{$this->baseUrl}/login", $data, $headers);

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function user_login_with_invalid_email()
    {
        $data = [
            'email' => $this->faker->email(),
            'password' => '12345678',
        ];

        $headers = [
            'Accept' => 'Application/json',
        ];

        $response = $this->post("{$this->baseUrl}/login", $data, $headers);

        $response->assertUnprocessable();
    }
}
