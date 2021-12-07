<?php

use App\Http\Controllers\Api\WakatimeController;
use Illuminate\Support\Facades\Route;

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

Route::post('/heartbeat', [WakatimeController::class, 'heartbeat'])->name('api.heartbeat');
Route::post('/heartbeats', [WakatimeController::class, 'heartbeat'])->name('api.heartbeats');

Route::post('/users/{user}/heartbeats', [WakatimeController::class, 'heartbeat']);
Route::post('/users/{user}/heartbeats.bulk', [WakatimeController::class, 'heartbeat']);
Route::post('/v1/users/{user}/heartbeats', [WakatimeController::class, 'heartbeat']);
Route::post('/v1/users/{user}/heartbeats.bulk', [WakatimeController::class, 'heartbeat']);
