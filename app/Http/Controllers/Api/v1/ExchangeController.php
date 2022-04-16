<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FixerService;
use App\Services\BanxicoService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExchangeController extends Controller
{
    public function __invoke(Request $request)
    {
        return rescue(function () {
            $fixerio = new FixerService;
            $fixerExchange = [];
            $fixerExchange = $fixerio->getLatestExchange();

            $banxico = new BanxicoService;
            $banxicoExchange = $banxico->getLatestExchange();

            return response([
                'message' => 'Exchanges rates from 3 different sources',
                'data' => [
                    'rates' => [
                        'provider_1' => $fixerExchange,
                        'provider_2' => $banxicoExchange,
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
