<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IssueController;

// ورود کاربر و دریافت JWT
Route::post('/login', [AuthController::class, 'login']);

// مسیرهای محافظت‌شده با توکن JWT
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/projects',[ProjectController::class,'getAll']);
    Route::post('/project', [ProjectController::class,'store']);

    Route::get('issues', [IssueController::class,'index']);
    Route::post('issue', [IssueController::class,'store']);
});
