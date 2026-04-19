<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;
use App\Http\Controllers\DashboardController;

Route::get('/kambing', [KambingController::class, 'index']); 
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);