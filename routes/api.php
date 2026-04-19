<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes - NovaGoat Project
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/kambing', [KambingController::class, 'index']);           // Ambil semua data kambing
Route::get('/kambing/{id}', [KambingController::class, 'show']);       // Detail satu kambing
Route::post('/kambing', [KambingController::class, 'store']);          // Tambah kambing baru
Route::get('/dashboard/stats', [DashboardController::class, 'stats']); // Data statistik dashboard

Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']); 

Route::get('/ping', function() {
    return response()->json([
        'status' => 'success', 
        'message' => 'Pong! Server Kambing Pak Tarno siap melayani!',
        'waktu_Sekarang' => now()
    ]);
});