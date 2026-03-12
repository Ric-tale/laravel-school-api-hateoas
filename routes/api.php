<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\JadwalController;

Route::apiResource('/user', App\Http\Controllers\Api\UserController::class);
Route::apiResource('/guru', App\Http\Controllers\Api\GuruController::class);
Route::apiResource('/mapel', App\Http\Controllers\Api\MapelController::class);
Route::apiResource('/kelas', App\Http\Controllers\Api\KelasController::class);
Route::apiResource('/siswa', App\Http\Controllers\Api\SiswaController::class);
Route::apiResource('/jadwal', App\Http\Controllers\Api\JadwalController::class);
