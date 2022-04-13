<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ExchangeController;
use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', RegisterController::class)->name('register');
Route::post('login', LoginController::class)->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('exchange', ExchangeController::class)->name('exchange');
});
