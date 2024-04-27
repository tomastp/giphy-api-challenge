<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GifController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/v1/auth/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Gif
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->get('/v1/gif', [ GifController::class, 'get' ]);
Route::middleware('auth:api')->get('/v1/gif/{id}', [ GifController::class, 'find' ]);
Route::middleware('auth:api')->post('/v1/gif', [ GifController::class, 'storeFavorite' ]);
