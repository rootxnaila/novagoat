<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LogBerat; // Pastikan Model ini sudah ada

class MedisController extends Controller
{
    public function index()
    {
        return view('admin.medis');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'berat' => 'required|numeric',
        ]);

        // 2. Simpan ke database (tabel log_berat)
        // Kita pakai DB facade biar aman dan simpel dulu
        DB::table('log_berat')->insert([
            'tanggal_timbang' => $request->tanggal,
            'berat_sekarang' => $request->berat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Balik ke halaman medis dengan notifikasi
        return redirect()->back()->with('success', 'Data berat kambing berhasil disimpan!');
    }
}
