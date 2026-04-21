<?php

namespace App\Http\Controllers;

use App\Models\Kambing;
use App\Models\LogBerat;
use Illuminate\Http\Request;

class KambingController extends Controller
{
    /**
     * Ambil data semua kambing yang terdaftar
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $dataKambing = Kambing::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data semua kambing berhasil ditarik',
            'data' => $dataKambing
        ]);
    }

    /**
     * Ambil detail kambing berdasarkan ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $kambing = Kambing::find($id);

        if (!$kambing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kambing tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $kambing
        ]);
    }

    /**
     * Tambah kambing baru ke sistem
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data input dari request
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'berat_awal' => 'required|numeric',
            'status_kondisi' => 'required|string',
            'gambar' => 'nullable|string'
        ]);

        // Buat kambing baru dengan gambar default jika tidak dikirim
        $kambingBaru = Kambing::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'berat_awal' => $request->berat_awal,
            'status_kondisi' => $request->status_kondisi,
            'gambar' => $request->gambar ?? 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kambing berhasil ditambahkan!',
            'data' => $kambingBaru
        ], 201);
    }

    /**
     * Ambil riwayat berat kambing untuk grafik
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function grafikBerat($id)
    {
        try {
            // Cek apakah kambing dengan ID ini ada
            $kambing = Kambing::find($id);
            if (!$kambing) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kambing tidak ditemukan',
                    'data' => []
                ], 404);
            }

            // Ambil riwayat berat kambing ini, urutkan dari tanggal paling lama
            $riwayat = LogBerat::where('id_kambing', $id)
                ->orderBy('tanggal_timbang', 'asc')
                ->get(['berat_sekarang', 'tanggal_timbang']);

            return response()->json([
                'status' => 'success',
                'data' => $riwayat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Ambil semua data log berat untuk halaman medis
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logBeratAll()
    {
        try {
            // Ambil data log berat dengan informasi kambing, urutkan dari paling baru
            $logBerat = LogBerat::with('kambing')
                ->orderBy('tanggal_timbang', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $logBerat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}