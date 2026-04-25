<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMedis;

class JadwalMedisController extends Controller
{
    //get semua jadwal
    public function index()
    {
        //ambil jadwal sm data wedusny
        $jadwal = JadwalMedis::with('kambing')->get();
        
        return response()->json([
            'message' => 'Berhasil mengambil jadwal medis',
            'data' => $jadwal
        ]);
    }

    //patch jadwal medis update status jd selesai
    public function updateStatus($id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->update([
            'status' => 'Selesai'
        ]);

        return response()->json([
            'message' => 'Status jadwal berhasil diupdate jadi Selesai!',
            'data' => $jadwal
        ]);
    }
    public function store(Request $request)
    {
        //validasi inputan
        $request->validate([
            'id_kambing' => 'required', 
            'jenis_tindakan' => 'required|string', 
            'tanggal_rencana' => 'required|date',
        ]);

        //insert ke db
        $jadwal = JadwalMedis::create([
            'id_kambing' => $request->id_kambing,
            'jenis_tindakan' => $request->jenis_tindakan,
            'tanggal_rencana' => $request->tanggal_rencana,
            'status' => 'Belum' 
        ]);

        return response()->json([
            'message' => 'Jadwal medis baru berhasil ditambahkan!',
            'data' => $jadwal
        ], 201);
    }
    //edit isi jadwal mediss
    public function update(Request $request, $id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal medis tidak ditemukan'], 404);
        }

        $request->validate([
            'jenis_tindakan' => 'sometimes|required|string',
            'tanggal_rencana' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:Belum,Selesai'
        ]);

        $jadwal->update($request->all());

        return response()->json([
            'message' => 'Jadwal medis berhasil diupdate!',
            'data' => $jadwal
        ]);
    }

    //delete jadwal medis
    public function destroy($id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal medis tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json([
            'message' => 'Jadwal medis berhasil dihapus!'
        ]);
    }
}