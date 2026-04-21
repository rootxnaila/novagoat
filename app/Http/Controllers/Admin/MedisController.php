<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MedisController extends Controller
{
    /**
     * Menampilkan halaman medis dengan data log berat dari API
     * 
     * @return \Illuminate\View\View
    */
    public function index()
    {
        try {
            // Ambil data log berat dari endpoint API internal
            $response = Http::get(url('/api/log-berat'));
            $data = $response->json();
            
            // Extract data dari response, default ke array kosong jika gagal
            $logBerat = $data['data'] ?? [];
        } catch (\Exception $e) {
            // Jika API error, tampilkan halaman dengan data kosong
            $logBerat = [];
        }
        
        return view('admin.medis', compact('logBerat'));
    }

    /**
     * Simpan data log berat baru ke database
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input yang dikirim dari form
        $request->validate([
            'tanggal' => 'required|date',
            'berat' => 'required|numeric',
        ]);

        // Simpan ke database tabel log_berat
        \Illuminate\Support\Facades\DB::table('log_berat')->insert([
            'tanggal_timbang' => $request->tanggal,
            'berat_sekarang' => $request->berat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect kembali dengan notifikasi sukses
        return redirect()->back()->with('success', 'Data berat kambing berhasil disimpan!');
    }
}
