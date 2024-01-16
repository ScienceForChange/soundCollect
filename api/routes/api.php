<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::post('/register', \App\Http\Controllers\Auth\RegisteredUserController::class)
                ->middleware('guest')
                ->name('register');

Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)
                ->middleware('guest')
                ->name('login');

Route::post('/verify-email', \App\Http\Controllers\Auth\VerifyEmailController::class)
                ->middleware(['auth:sanctum', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/reset-password', \App\Http\Controllers\Auth\NewPasswordController::class)
                                ->middleware(['guest'])
                                ->name('password.store');

Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class)
                ->middleware(['auth:sanctum'])
                ->name('logout');

Route::middleware(['auth:sanctum'])
   ->group(function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
});

Route::controller(\App\Http\Controllers\Auth\AuthOtpController::class)
        ->middleware(['auth:sanctum'])
        ->group(function(){
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::post('/otp/apply', 'apply')->name('otp.verify');
});
