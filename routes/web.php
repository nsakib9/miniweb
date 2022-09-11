<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayGameController;
use Illuminate\Support\Facades\Artisan;
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
    return view('frontend.welcome');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Auth::routes(['verify' => true]);

// Auth Routes
Route::post('register/submit', [UsersController::class, 'store'])->name('register.agent');
Route::post('/login', [UsersController::class, 'login'])->name('login.agent');

//Game
Route::group(['prefix' => 'game'],  function () {

    Route::get('/', [PlayGameController::class, 'page1'])->name('game.page1');
    Route::get('/page2', [PlayGameController::class, 'page2'])->name('game.page2');
    Route::get('/page3', [PlayGameController::class, 'page3'])->name('game.page3');
    Route::get('/page4', [PlayGameController::class, 'page4'])->name('game.page4');
    Route::get('/page5', [PlayGameController::class, 'page5'])->name('game.page5');
    Route::get('/page6', [PlayGameController::class, 'page6'])->name('game.page6');
});

Route::group(['middleware' => ['verified', 'auth']],  function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/point-log/{user_id}', [HomeController::class, 'pointlog'])->name('point.log');
    Route::get('/log', [HomeController::class, 'log'])->name('ticket.log');
    Route::post('/ticket/exchange', [HomeController::class, 'exchangeTicket'])->name('ticket.exchange');

    // Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'],  function () {
        // Role Management Routes
        Route::resource('roles', RolesController::class, ['name' => 'roles']);
        Route::resource('users', UsersController::class, ['name' => 'users']);

        // OTP
        Route::get('/game/otp', [GameController::class, 'showOTP'])->name('show.otp');
        Route::post('/save-otp', [GameController::class, 'storeOTP'])->name('store.otp');
        Route::get('/edit-otp/{id}', [GameController::class, 'editOTP'])->name('otp.edit');
        Route::put('/update-otp/{id}', [GameController::class, 'updateOTP'])->name('update.otp');
        Route::delete('/delete-otp/{id}', [GameController::class, 'destroyOTP'])->name('otp.destroy');

        // Game Settings
        Route::get('/game/settings', [GameController::class, 'showSettings'])->name('show.settings');
        Route::post('/save-settings', [GameController::class, 'storeSettings'])->name('store.settings');
        Route::post('/save-probability', [GameController::class, 'storeProbability'])->name('store.probability');

        // Point Log
        Route::get('/point-log', [GameController::class, 'pointLog'])->name('pointLog');
        Route::get('/user-log/mw-uid={id}', [GameController::class, 'singleUserLog'])->name('singleUserLog');

        // All Users Log
        Route::get('/users-log', [GameController::class, 'usersLog'])->name('usersLog');
    });
});
