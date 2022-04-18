<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function create_user()
    {
        $data = [
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email(),
            'password' => '12345678',
        ];

        $headers = [
            'Accept' => 'Application/json'
        ];

        $response = $this->post("{$this->baseUrl}/register", $data, $headers);

        $response->assertCreated();

        $response->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'name',
                    'email',
                    'created_at',
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function create_user_with_same_email()
    {
        $user = User::first();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '12345678',
        ];

        $headers = [
            'Accept' => 'Application/json'
        ];

        $response = $this->post("{$this->baseUrl}/register", $data, $headers);

        $response->assertUnprocessable();
    }

    /**
     * @test
     */
    public function create_user_without_headers_request()
    {
        $user = User::first();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '12345678',
        ];

        $response = $this->post("{$this->baseUrl}/register", $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
