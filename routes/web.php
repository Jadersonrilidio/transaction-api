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

Route::get('/challenge', [App\Http\Controllers\ChallengeController::class, 'index']);

Route::get('/challenge', function () {
    return App\Http\Controllers\ChallengeController::index();
});

Route::get('/about', [App\Http\Controllers\AboutController::class, 'index']);

Route::get('/about', function () {
    return App\Http\Controllers\AboutController::index();
});
