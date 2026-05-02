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
        // Data tidak lagi diambil dari controller, karena frontend blade sudah melakukan 
        // fetch secara asynchronous lewat JavaScript, ini menghindari deadlock di local PHP server
        return view('admin.medis');
    }
}
