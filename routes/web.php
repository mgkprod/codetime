<?php

use App\Http\Controllers\HomeController;
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

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::group(['middleware' => 'auth'], function () {
    Route::redirect('/', '/dashboard')->name('index');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/data', [HomeController::class, 'data'])->name('dashboard.data');

    Route::get('/wakacfg', [HomeController::class, 'wakacfg'])->name('wakacfg');
});

// Route::get('/', function () {
//     return inertia('index');
// });
