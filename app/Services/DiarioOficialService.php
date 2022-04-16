<?php

namespace App\Services;

use Carbon\Carbon;
use Goutte\Client;

class DiarioOficialService
{
    private $client;
    private $url;
    private $startWeek;
    private $today;

    public function __construct()
    {
        $this->client = new Client();

        $this->startWeek = Carbon::now()->startOfWeek()->format('d/m/Y');
        $this->today = Carbon::now()->format('d/m/Y');

        $this->url = "http://www.dof.gob.mx/indicadores_detalle.php?cod_tipo_indicador=158&dfecha={$this->startWeek}&hfecha={$this->today}";
    }

    public function getLatestExchange()
    {
        $crawler = $this->client->request('GET', $this->url);
        $rates = $crawler->filter('.Celda')->each(function ($rates) {
            $tdDate = $rates->filter("[width='48%']")->first();
            $tdRate = $rates->filter("[width='52%']")->first();

            $arrayRates = [
                'last_updated' => Carbon::createFromFormat('d-m-Y', $tdDate->html()),
                'value' => (double) $tdRate->html(),
            ];

            return $arrayRates;
        });

        $latestExchangeRate = end($rates);

        return $latestExchangeRate;
    }
}
