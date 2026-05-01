<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MedisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/katalog', function () {
    return view('katalog.katalog');
});

Route::get('/katalog/detail/{id}', function ($id) {
    return view('katalog.detail');
});

// Tambahkan rute untuk halaman edit
Route::get('/katalog/edit/{id}', function ($id) {
    return view('katalog.edit', ['id' => $id]);
});

// Route untuk nampilin halaman (View)
Route::get('/admin/medis', [MedisController::class, 'index'])->name('admin.medis');

// Route untuk ambil data grafik (API/JSON)
Route::get('/admin/medis-data', function () {
    return DB::table('log_berat')
        ->select('tanggal_timbang as tanggal', 'berat_sekarang as berat')
        ->orderBy('tanggal_timbang', 'asc')
        ->get();
});


// Pintu masuk ke halaman login
Route::get('/login', function () {
    return view('auth.login');
});
// pintu masuk halaman daftar
Route::get('/register', function () {
    return view('auth.register');
});