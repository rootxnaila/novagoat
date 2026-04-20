<?php

namespace App\Http\Controllers;

use App\Models\Kambing;
use Illuminate\Http\Request;

class KambingController extends Controller
{
    public function index()
    {
        $data_kambing = Kambing::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data semua kambing berhasil ditarik',
            'data' => $data_kambing
        ]);
    }
    public function show($id)
    {
        $kambing = Kambing::find($id); // fetch detail 1 kambing based on id. 

        if (!$kambing) {
            return response()->json([
                'status' => 'error',
                'message' => 'kambing tidak ditemukan'
            ], 404); // if id invalid atau data tidak ditemukan return 404, jika ada return data json
        }

        return response()->json([
            'status' => 'success',
            'data' => $kambing
        ]);
    }

    // handle insert new data dari form frontend.
    public function store(Request $request)
    {
        // validate request payload-nya, make sure data required pada keisi
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'berat_awal' => 'required|numeric',
            'status_kondisi' => 'required|string',
            'gambar' => 'nullable|string'
        ]);
        // trus create data baru ke db, pake default image fallback usernya ga ngirim url gambar
        $kambingBaru = Kambing::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'berat_awal' => $request->berat_awal,
            'status_kondisi' => $request->status_kondisi,
            'gambar' => $request->gambar ?? 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'data kambing berhasil ditambahkan!',
            'data' => $kambingBaru
        ], 201);
    }
    // fetch riwayat berat buat grafik chart.js di frontend
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

            // Ambil data log berat untuk kambing ini
            $riwayat = \App\Models\LogBerat::where('id_kambing', $id)
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
}
?>