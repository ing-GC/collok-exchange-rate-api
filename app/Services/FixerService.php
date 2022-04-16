<?php

namespace App\Services;

use Ranium\Fixerio\Client;

class FixerService
{
    private $client;

    public function __construct()
    {
        $this->client = Client::create(config('exchange.fixer_access_key'), false);
    }

    /**
     * Return the latest exchenge rate from Fixer.io
     * @return array
     */
    public function getLatestExchangeRate(): array
    {
        $response = $this->client->latest([
            'base' => 'EUR',
            'symbols' => 'MXN',
        ]);

        return [
            'last_updated' => gmdate("Y-m-d\TH:i:s\Z", $response['timestamp']),
            'value' => $response['rates']['MXN'],
        ];
    }
}
