<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Menampilkan daftar semua kambing yang terdaftar
Route::get('/kambing', [KambingController::class, 'index']);

// Menampilkan detail informasi satu kambing berdasarkan ID
Route::get('/kambing/{id}', [KambingController::class, 'show']);

// Menambahkan kambing baru ke dalam sistem
Route::post('/kambing', [KambingController::class, 'store']);

// Mengambil data statistik untuk ditampilkan di dashboard
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

// Menampilkan grafik perkembangan berat badan kambing
Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']); 

Route::get('/ping', function() {
    return response()->json([
        'status' => 'success', 
        'message' => 'Pong! Server Kambing Pak Tarno siap melayani!',
        'waktu_Sekarang' => now()
    ]);
});