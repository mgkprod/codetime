<?php

use App\Models\Heartbeat;
use App\Models\User;
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

Route::any('/users/current/heartbeats.bulk', function (Request $request) {
    // Autenticate
    try {
        $token = $request->header('Authorization');
        $api_key = base64_decode(str_replace('Basic ', '', $token));
        $user = User::where('api_key', $api_key)->firstOrFail();
    } catch (\Throwable $th) {
        return abort(403);
    }

    // Collect heartbeats
    collect($request->all())
        ->each(function ($payload) use ($user) {
            $hearbeat = Heartbeat::firstOrCreate(
                array_merge(
                    collect($payload)->only([
                        'entity',
                        'type',
                        'category',
                        'is_write',
                        'project',
                        'branch',
                        'language',
                        'user_agent',
                    ])->toArray(),
                    [
                        'created_at' => Carbon::createFromTimestamp($payload['time'])->setSecond(0),
                        'user_id' => $user->id,
                    ]
                )
            );
            $hearbeat->save();
        });

    return response()->json([], 202);
})->name('api.heartbeats.bulk');
