<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KambingController;

// /api/kambing
Route::get('/kambing', [KambingController::class, 'index']);