<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ExchangeController extends Controller
{
    public function __invoke(Request $request)
    {
        return response(['desde invoke'], Response::HTTP_OK);
    }
}
