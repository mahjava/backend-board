<?php
use App\Http\Controllers\AuthController;

// ورود کاربر و دریافت JWT
Route::post('/login', [AuthController::class, 'login']);

// مسیرهای محافظت‌شده با توکن JWT
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
