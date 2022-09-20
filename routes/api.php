<?php

use App\Http\Controllers\PlayGameController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/score', [PlayGameController::class, 'getScore']);
Route::get('/score/{id}', [PlayGameController::class, 'getScore']); // LS SH
Route::post('/auth/register', [UsersController::class, 'registerApi']);
Route::post('/auth/token', [UsersController::class, 'loginApi']);
Route::get('/user', function () {
    return Auth::user();
})->middleware('auth:api')->name('authCheck');
