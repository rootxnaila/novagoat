<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogBerat;
use App\Models\Kambing;

class LogBeratController extends Controller
{
    //post timbang
    public function store(Request $request, $id)
    {
        //makesure wedus redi
        $kambing = Kambing::find($id);
        if (!$kambing) {
            return response()->json(['message' => 'Kambing tidak ditemukan'], 404);
        }

        // validasi input
        $request->validate([
            'berat' => 'required|numeric',
            'tanggal' => 'required|date'
        ]);

        // insert log_berat
        $log = LogBerat::create([
            'id_kambing' => $id,
            'berat_sekarang' => $request->berat,
            'tanggal_timbang' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Log berat berhasil ditambahkan!',
            'data' => $log
        ], 201);
    }
}