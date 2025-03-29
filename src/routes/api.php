<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Middleware\Owner;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::prefix('hotel')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::get('/{hotelId}/room', [HotelController::class, 'rooms']);
    Route::get('/{hotelId}/room/{roomNumber}', [HotelController::class, 'room']);
});

Route::prefix('room')->group(function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/{id}', [RoomController::class, 'show']);
});

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::prefix('hotel')->middleware(Owner::class)->group(function () {
        Route::post('/create', [HotelController::class, 'create']);
        Route::post('/update', [HotelController::class, 'update']);
        Route::post('/delete', [HotelController::class, 'delete']);
    });

    Route::prefix('room')->group(function () {
        Route::post('/create', [RoomController::class, 'create']);
        Route::post('/update', [RoomController::class, 'update']);
        Route::post('/delete', [RoomController::class, 'delete']);
    });
});
