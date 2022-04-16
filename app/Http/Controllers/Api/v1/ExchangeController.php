<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Response;
use App\Services\FixerService;
use App\Services\BanxicoService;
use App\Http\Controllers\Controller;
use App\Services\DiarioOficialService;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExchangeController extends Controller
{
    public function __invoke()
    {
        return rescue(function () {
            $fixerio = new FixerService;
            $fixerExchange = $fixerio->getLatestExchange();

            $banxico = new BanxicoService;
            $banxicoExchange = $banxico->getLatestExchange();

            $dof = new DiarioOficialService;
            $dofExchangeRate = $dof->getLatestExchange();

            return response([
                'message' => 'Exchanges rates from 3 different sources',
                'data' => [
                    'rates' => [
                        'provider_1' => $fixerExchange,
                        'provider_2' => $banxicoExchange,
                        'provider_3' => $dofExchangeRate,
                    ]
                ],
            ], Response::HTTP_OK);
        }, function ($e) {
            throw new HttpResponseException(
                response([
                    'errors' => [
                        'message' => $e->getMessage(),
                    ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR)
            );
        });
    }
}
