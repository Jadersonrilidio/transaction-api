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

Route::fallback(function () {
    return view('app/about');
});

Route::get('/challenge', [App\Http\Controllers\ChallengeController::class, 'challenge'])->name('app.challenge');

Route::get('/about', [App\Http\Controllers\AboutController::class, 'about']);
