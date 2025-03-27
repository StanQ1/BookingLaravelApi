<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Middleware\Owner;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::prefix('hotel')->group(function () {
    Route::get('/all', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
});

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::prefix('hotel')->middleware(Owner::class)->group(function () {
        Route::post('/create', [HotelController::class, 'create']);
        Route::post('/update', [HotelController::class, 'update']);
        Route::post('/delete', [HotelController::class, 'delete']);
    });
});
