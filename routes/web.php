<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('update/f1', [\App\Http\Controllers\DashboardController::class, 'f1'])->name('f1');
        Route::post('update/f1/points', [\App\Http\Controllers\DashboardController::class, 'f1Points'])->name('f1.points');
    });

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

//Discord Oauth2 Routes
Route::get('login/discord', [LoginController::class, 'redirectToProvider']);
Route::get('login/discord/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('/unlink/discord', [LoginController::class, 'unlinkDiscord']);
