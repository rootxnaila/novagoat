<?php

namespace App\Http\Controllers;
use App\Models\Kambing;
use App\Models\JadwalMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalKambing = Kambing::count();
        $kambingSakit = Kambing::where('status_kondisi', '!=', 'Sehat')->count();
        $hariIni = Carbon::today()->toDateString();
        $jadwalHariIni = JadwalMedis::whereDate('tanggal_rencana', $hariIni)
                                    ->where('status', 'Belum')
                                    ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_kambing' => $totalKambing,
                'kambing_sakit' => $kambingSakit,
                'jadwal_hari_ini' => $jadwalHariIni
            ]
        ]);
    }
}
