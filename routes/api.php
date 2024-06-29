<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FriendController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\SchoolController;
use Illuminate\Support\Facades\Route;

/**
 * Authentifikasi APIs
 */
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/refresh', [AuthController::class, 'refresh'])->middleware('auth.refresh');
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware(['auth.api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change-password', [AuthController::class, 'updatePassword']);
        Route::delete('logout', [AuthController::class, 'logout']);
    });

    Route::prefix('user')->group(function () {
        Route::post('profile', [AuthController::class, 'update']);
    });

    Route::prefix('friends')->group(function () {
        Route::get('/', [FriendController::class, 'index']);
        Route::get('/{id}', [FriendController::class, 'show']);
    });

    Route::prefix('likes')->group(function () {
        Route::get('/me', [LikeController::class, 'show']);
        Route::post('/', [LikeController::class, 'store']);
    });

    Route::prefix('colek')->group(function () {
        Route::post('/', [NotificationController::class, 'colek']);
    });
});


Route::get('schools', [SchoolController::class, 'index']);
Route::group([
    "prefix" => "dev",
], function () {
    Route::post('notification', [NotificationController::class, 'sendNotificationDevelopment']);
});
