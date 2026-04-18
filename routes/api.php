<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;

Route::get('/kambing', [KambingController::class, 'index']); //GET /api/kambing 
Route::get('/dashboard/stats', [DashboardController::class, 'stats']); //GET /api/dashboard/stats
Route::get('/ping', function() {
    return response()->json(['status' => 'success', 'message' => 'Pong! Server Kambing Pak Tarno siap melayani!',
    'waktu_Sekarang' => now()
    ]);
});