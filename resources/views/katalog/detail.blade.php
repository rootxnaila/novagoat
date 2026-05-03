@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Menggunakan Palet dari WhatsApp Image 2026-05-03 at 16.35.28.jpeg */
    body { 
        background-color: #E8EDEA; /* Page BG */
        color: #4A6B4C; /* Sub Text */
        min-height: 100vh; 
    }
    
    .dashboard-container { margin-top: 100px; padding-bottom: 60px; }
    
    /* Card Styling */
    .card-custom { 
        background: #FFFFFF; /* Card White */
        border-radius: 20px; 
        border: 1px solid #D0DDD1; /* Border / Divider */
        box-shadow: 0 4px 15px rgba(176, 190, 177, 0.2); /* Shadow Muted */
    }

    /* Typography */
    h1, h2, h5, .text-heading { 
        color: #1A2E1A !important; /* Heading Text */
    }

    .text-muted-custom { color: #9BB09C !important; } /* Placeholder / Muted */

    /* Table Styling */
    .table { color: #4A6B4C !important; }
    .table-light-custom { 
        background-color: #D6EDD7 !important; /* Pale Mint */
        color: #1A2E1A !important; 
    }

    /* Buttons */
    .btn-primary-custom { 
        background-color: #3D7A40; /* Button Green */
        border: none;
        color: white;
    }
    .btn-primary-custom:hover { background-color: #2E7D32; }

    .badge-sehat { background-color: #2E7D32; color: white; } /* Medium Green */
    .badge-sakit { background-color: #d9534f; color: white; }

    hr { border-top: 1px solid #D0DDD1; opacity: 1; }
</style>

<div class="container dashboard-container">
    <div id="loading-detail" class="text-center">
        <div class="spinner-border text-success" role="status"></div>
    </div>

    <div class="row d-none" id="content-detail"> 
        <div class="col-md-5 mb-4"> 
            <img src="{{ asset('images/foto_kambing.jpg') }}" class="img-fluid rounded-4 shadow-sm border" alt="Kambing" style="border-color: #D0DDD1 !important;">
        </div> 

        <div class="col-md-7"> 
            <div class="d-flex justify-content-between align-items-center mb-3"> 
                <div> 
                    <h1 id="kambing-nama" class="display-5 fw-bold mb-1"></h1> 
                    <span id="kambing-status" class="badge p-2 shadow-sm"></span> 
                </div>

                <div class="d-flex gap-2">
                    <button id="btn-edit" class="btn btn-warning btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="window.location.href='/katalog/edit/' + currentId"> 
                        <i class="bi bi-pencil-square"></i> EDIT
                    </button>
                    <button id="btn-hapus" class="btn btn-danger btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="deleteKambing()"> 
                        <i class="bi bi-trash"></i> HAPUS
                    </button> 
                </div>
            </div>
            <hr> 

            <div class="row mb-4"> 
                <div class="col-6"> 
                    <p class="text-muted-custom mb-0 small fw-bold">JENIS/RAS</p>
                    <h5 id="kambing-jenis" class="fw-bold">-</h5>
                </div>
                <div class="col-6"> 
                    <p class="text-muted-custom mb-0 small fw-bold">BERAT AWAL</p>
                    <h5 id="kambing-berat" class="fw-bold">-</h5>
                </div>
            </div> 

            <div class="table-responsive card-custom"> 
                <table class="table table-hover mb-0">
                    <thead class="table-light-custom">
                        <tr><th>Parameter</th><th>Keterangan</th></tr>
                    </thead>
                    <tbody id="kambing-info-tabel"></tbody>
                </table>
            </div> 
        </div> 
    </div> 

    <div class="row mt-5">
        <div class="col-md-7 mb-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-transparent border-bottom text-heading fw-bold">
                    Grafik Pertumbuhan
                </div>
                <div class="card-body"><canvas id="grafikBerat" style="max-height: 250px;"></canvas></div>
            </div>
        </div>
        <div class="col-md-5 mb-4"> 
            <div class="card card-custom h-100">
                <div class="card-header bg-transparent border-bottom text-heading fw-bold d-flex justify-content-between align-items-center"> 
                    <span>Riwayat Timbangan</span> 
                    <button class="btn btn-primary-custom btn-sm fw-bold shadow-sm" onclick="alert('Input Berat')">Input Berat</button> 
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light-custom"><tr><th>Tanggal</th><th>Berat</th></tr></thead>
                        <tbody id="tabel-riwayat-berat"></tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ... (Logika JS kamu tetap sama, cukup update bagian warna grafik di bawah) ...
    
    // Di dalam fetch grafik, update warna Chart.js agar matching:
    // borderColor: '#2E7D32', // Medium Green
    // backgroundColor: 'rgba(165, 200, 167, 0.2)', // Light Green Transparan
</script>
@endsection