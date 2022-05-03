<?php

use Illuminate\Http\Request;
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

Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index']);
Route::get('/transactions/{uuid}', [App\Http\Controllers\TransactionController::class, 'show']);
Route::put('/transactions/{uuid}', [App\Http\Controllers\TransactionController::class, 'update']);
Route::patch('/transactions/{uuid}', [App\Http\Controllers\TransactionController::class, 'update']);
Route::delete('/transactions/{uuid}', [App\Http\Controllers\TransactionController::class, 'destroy']);
Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store']);
