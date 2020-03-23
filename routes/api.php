<?php

use App\Models\Heartbeat;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/heartbeat/{test?}', function (Request $request) {
    collect($request->all())
        ->each(function ($hb) {
            $hearbeat = new Heartbeat();
            $hearbeat->fill($hb);
            $hearbeat->created_at = Carbon::createFromTimestamp($hb['time']);
            $hearbeat->save();
        });

    return response()->json();
});
