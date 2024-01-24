<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObservationController;
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
                ->name('register');

Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)
                ->middleware('guest')
                ->name('login');

Route::post('/verify-email', \App\Http\Controllers\Auth\VerifyEmailController::class)
                ->middleware(['guest', 'throttle:6,1'])
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

Route::middleware(['auth:sanctum', 'verified'])
   ->group(function() {
        Route::get('/user/profile', function () {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'email_verified' => 'true',
                ],
            ]);
        })->name('profile');
});

Route::controller(\App\Http\Controllers\Auth\AuthOtpController::class)
        ->middleware(['guest', 'throttle:3,1'])
        ->group(function(){
    Route::post('/otp/generate', 'generate')->name('otp.generate');
});

Route::name('observations.')
    ->prefix('observations')
    ->group(function () {
    Route::get('/', [ObservationController::class, 'index'])->name('index');
    Route::get('/{observation}', [ObservationController::class, 'show'])->name('show');
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/', [ObservationController::class, 'store'])->name('store');
        Route::put('/{observation}', [ObservationController::class, 'update'])->name('update');
        Route::delete('/{observation}', [ObservationController::class, 'destroy'])->name('destroy');
    });
});
