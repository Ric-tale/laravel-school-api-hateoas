<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\JadwalController;

// Auth Routes (PUBLIC - tidak perlu token)
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (memerlukan JWT token)
Route::middleware('jwt.verify')->group(function () {
    // Auth endpoints
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Resource API endpoints (GET/POST/PUT/DELETE)
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/guru', GuruController::class);
    Route::apiResource('/mapel', MapelController::class);
    Route::apiResource('/kelas', KelasController::class);
    Route::apiResource('/siswa', SiswaController::class);
    Route::apiResource('/jadwal', JadwalController::class);
});

