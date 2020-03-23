<?php

use App\Models\User;
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

Route::any('/heartbeat/', function (Request $request) {
    // Autenticate
    $token = $request->header('Authorization');
    $api_key = base64_decode(str_replace('Basic ', '', $token));
    $user = User::where('api_key', $api_key)->firstOrFail();

    // Collect heartbeats
    collect($request->all())
        ->each(function ($payload) use ($user) {
            $hearbeat = new Heartbeat;
            $hearbeat->fill($payload);
            $hearbeat->created_at = Carbon::createFromTimestamp($payload['time']);
            $hearbeat->user_id = $user->id;
            $hearbeat->save();
        });

    return response()->json([], 202);
});
