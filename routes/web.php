<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/', 'HomeController@index')->name('home');
});


Route::get('test', function () {
    $from = now()->subDays(7)->startOfDay();
    $to = now();
    $userId = auth()->user()->id;

    $res = DB::query()
        ->selectRaw('project, created_at')
        ->selectRaw('created_at - lag(created_at, 1) over (partition by project, to_char(created_at, \'yyyy-mm-dd\') order by created_at) as diff')
        ->from('heartbeats')
        ->whereBetween('created_at', [$from, $to])
        // ->where('user_id', $userId)
        ->orderBy('project')
        ->orderBy('created_at', 'ASC');

    dump(
        $res
            ->get()
            ->where('project', 'actual')
            ->toArray()
    );
});
