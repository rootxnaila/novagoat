<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMedis;

class JadwalMedisController extends Controller
{
    //get semua jadwal
    public function index(Request $request)
    {
        $query = JadwalMedis::with('kambing');

        //filter wedus
        if ($request->has('id_kambing') && $request->id_kambing != '') {
            $query->where('id_kambing', $request->id_kambing);
        }

        //filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $jadwal = $query->get();
        
        return response()->json([
            'status' => 'success', 
            'message' => 'Berhasil mengambil jadwal medis',
            'data' => $jadwal
        ]);
    }

    //patch jadwal medis update status jd selesai
    public function updateStatus($id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->update([
            'status' => 'Selesai'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status jadwal berhasil diupdate jadi Selesai!',
            'data' => $jadwal
        ]);
    }
    
    //edit isi jadwal mediss
    public function update(Request $request, $id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal medis tidak ditemukan'], 404);
        }

        $request->validate([
            'jenis_tindakan' => 'sometimes|required|string',
            'tanggal_rencana' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:Belum,Selesai'
        ]);

        $jadwal->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal medis berhasil diupdate!',
            'data' => $jadwal
        ]);
    }

    //delete jadwal medis
    public function destroy($id)
    {
        $jadwal = JadwalMedis::find($id);

        if (!$jadwal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal medis tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal medis berhasil dihapus!'
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

        //user milih "Semua Kambing"
        if ($request->id_kambing === 'semua') {
            $semuaKambing = \App\Models\Kambing::all(); 
            $jadwalBaru = [];
            
            foreach ($semuaKambing as $kambing) {
                $jadwalBaru[] = JadwalMedis::create([
                    'id_kambing' => $kambing->id_kambing, 
                    'jenis_tindakan' => $request->jenis_tindakan,
                    'tanggal_rencana' => $request->tanggal_rencana,
                    'status' => 'Belum' 
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal massal berhasil ditambahkan untuk ' . $semuaKambing->count() . ' kambing!',
                'data' => $jadwalBaru
            ], 201);
        } 
        //user milih 1 kambing
        else {
            $jadwal = JadwalMedis::create([
                'id_kambing' => $request->id_kambing,
                'jenis_tindakan' => $request->jenis_tindakan,
                'tanggal_rencana' => $request->tanggal_rencana,
                'status' => 'Belum' 
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal medis berhasil ditambahkan!',
                'data' => $jadwal
            ], 201);
        }
    }
    
}