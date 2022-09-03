<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Auth Routes
Route::post('register/submit', [UsersController::class, 'store'])->name('register.agent');
Route::post('/login', [UsersController::class, 'login'])->name('login.agent');

Route::group(['middleware' => ['verified', 'auth']],  function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::any('/game', function () {
        return view('frontend.game');
    });
    Route::any('/game-content', function (Request $request) {
        return view('frontend.game-content');
    });



    // Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'],  function () {
        // Role Management Routes
        Route::resource('roles', RolesController::class, ['name' => 'roles']);
        Route::resource('users', UsersController::class, ['name' => 'users']);

        Route::get('/game-otp', [GameController::class, 'showOTP'])->name('show.otp');
        Route::post('/save-otp', [GameController::class, 'storeOTP'])->name('store.otp');
    });
});
