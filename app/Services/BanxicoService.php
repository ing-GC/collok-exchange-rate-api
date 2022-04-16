<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class BanxicoService
{
    private $client;
    private $startWeek;
    private $endWeek;
    private $url;

    public function __construct()
    {
        $token = config('exchange.bmx_token');

        $this->client = Http::withHeaders([
            'Bmx-Token' => $token,
            'Accept' => 'application/xml',
        ]);

        $this->startWeek = Carbon::now()->startOfWeek()->toDateString();
        $this->endWeek = Carbon::now()->endOfWeek()->toDateString();

        $this->url = "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/{$this->startWeek}/{$this->endWeek}";
    }

    /**
     * Get the latest exchange rate from Banxico API
     * @return array|string
     */
    public function getLatestExchange(): mixed
    {
        $exchanges = [];
        $response = $this->client->get($this->url)->throw();

        $jsonResponse = json_encode(simplexml_load_string($response->body()));
        $arrayData = json_decode($jsonResponse, true);

        foreach ($arrayData['serie'] as $key => $value) {
            if ($key == 'Obs') {
                $exchanges += $value;
            }
        }

        $latestExchange = end($exchanges);

        $latestExchange['last_updated'] = Carbon::createFromFormat('d/m/Y', $latestExchange['fecha']);
        $latestExchange['value'] = (double) $latestExchange['dato'];

        unset($latestExchange['fecha'], $latestExchange['dato']);

        return $latestExchange;
    }
}
