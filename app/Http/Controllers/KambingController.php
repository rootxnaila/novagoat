<?php

namespace App\Http\Controllers;

use App\Models\Kambing;
use Illuminate\Http\Request;

class KambingController extends Controller
{
    public function index()
    {
        $data_kambing = Kambing::all();

        foreach ($data_kambing as $kambing) {
            
            $log_terbaru = \DB::table('log_berat')
                ->where('id_kambing', $kambing->id_kambing)
                ->orderBy('tanggal_timbang', 'desc')
                ->orderBy('id_log', 'desc')
                ->first();

            $kambing->berat_sekarang = $log_terbaru ? $log_terbaru->berat_sekarang : null;
        }

        // balikin ke fe
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

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'berat_awal' => 'required|numeric',
            'status_kondisi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' 
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // Bikin nama file unik pake timestamp biar ga bentrok
            $namaGambar = time() . '_' . $file->getClientOriginalName(); 
            // Pindahin file langsung ke folder public/images/kambing
            $file->move(public_path('images/kambing'), $namaGambar);
        }

        $kambingBaru = Kambing::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'berat_awal' => $request->berat_awal,
            'status_kondisi' => $request->status_kondisi,
            'gambar' => $namaGambar 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kambing dan foto berhasil ditambahkan!',
            'data' => $kambingBaru
        ], 201);
    }
    // fetch riwayat berat buat grafik chart.js di frontend
    public function grafikBerat($id)
    {
        $riwayat = \App\Models\LogBerat::where('id_kambing', $id)
            ->orderBy('tanggal_timbang', 'asc') 
            ->get(['berat_sekarang', 'tanggal_timbang']); // ambil berat_sekarang dan tanggalnya aja

        return response()->json([
            'status' => 'success',
            'data' => $riwayat
        ]);
    }
    public function update(Request $request, $id) //update wedus
    {
        $kambing = \App\Models\Kambing::find($id);
        
        if (!$kambing) {
            return response()->json(['message' => 'Data kambing tidak ditemukan'], 404);
        }

        $kambing->update($request->all());

        return response()->json([
            'message' => 'Data kambing berhasil diupdate!',
            'data' => $kambing
        ]);
    }

    public function destroy($id) //delete wedus
    {
        $kambing = \App\Models\Kambing::find($id);

        if (!$kambing) {
            return response()->json(['message' => 'Data kambing tidak ditemukan'], 404);
        }

        $kambing->delete();

        return response()->json(['message' => 'Data kambing berhasil dihapus!']);
    }
}
?>