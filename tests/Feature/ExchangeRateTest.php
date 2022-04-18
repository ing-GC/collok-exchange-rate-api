<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ExchangeRateTest extends TestCase
{
    /**
     * @test
     */
    public function get_exchange_rates()
    {
        $user = User::first();

        $data = [
            'email' => $user->email,
            'password' => '12345678',
        ];

        $headers = [
            'Accept' => 'Application/json'
        ];

        $response = $this->post("{$this->baseUrl}/login", $data, $headers);

        $headers['Authorization'] = "Bearer {$response['data']['token']}";

        $response = $this->get("{$this->baseUrl}/exchange", $headers);

        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'data' => [
                'rates' => [
                    'provider_1' => [
                        'last_updated',
                        'value',
                    ],
                    'provider_2' => [
                        'last_updated',
                        'value',
                    ],
                    'provider_3' => [
                        'last_updated',
                        'value',
                    ],
                ]
            ]
        ]);
    }
}
