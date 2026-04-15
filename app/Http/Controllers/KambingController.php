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
}
?>