<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;
use App\Http\Controllers\DashboardController;

/**
 * ====================================
 * AUTENTIKASI - Sanctum
 * ====================================
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * ====================================
 * ENDPOINT KAMBING
 * ====================================
 */

// Ambil daftar semua kambing yang terdaftar
Route::get('/kambing', [KambingController::class, 'index']);

// Ambil detail kambing berdasarkan ID
Route::get('/kambing/{id}', [KambingController::class, 'show']);

// Tambah kambing baru ke sistem
Route::post('/kambing', [KambingController::class, 'store']);

/**
 * ====================================
 * ENDPOINT LOG BERAT
 * ====================================
 */

// Ambil semua data log berat (untuk halaman medis)
Route::get('/log-berat', [KambingController::class, 'logBeratAll']);

// Ambil riwayat berat kambing berdasarkan ID untuk grafik
Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']);

/**
 * ====================================
 * ENDPOINT DASHBOARD
 * ====================================
 */

// Ambil data statistik untuk dashboard
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

/**
 * ====================================
 * HEALTH CHECK
 * ====================================
 */

// Endpoint untuk testing/verifikasi server berjalan
Route::get('/ping', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Pong! Server Kambing Pak Tarno siap melayani!',
        'waktu_sekarang' => now()
    ]);
});