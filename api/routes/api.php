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

Route::middleware(['auth:sanctum'])->get('/user', [App\Http\Controllers\Api\V1\AuthUserController::class, 'show'])->name('auth.show');

Route::middleware(['auth:sanctum'])->get('/users/{uuid}', [App\Http\Controllers\Api\V1\UserController::class, 'show'])->name('users.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/verified', [App\Http\Controllers\Api\V1\AuthUserController::class, 'verified'])->name('users.verified');

Route::fallback(function () {
    return response()->json([
        'message' => 'URL Not Found'
    ], 404);
});
