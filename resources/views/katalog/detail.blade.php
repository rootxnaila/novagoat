@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body { background-color: #121417; color: white; min-height: 100vh; }
    .dashboard-container { margin-top: 100px; padding-bottom: 60px; }
    .card-glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.05); }
    .table { color: white !important; }
    .table-light { background-color: rgba(255, 255, 255, 0.1) !important; color: white !important; }
</style>

<div class="container dashboard-container">
    <div id="loading-detail" class="text-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="row d-none" id="content-detail"> 
        <div class="col-md-5 mb-4"> 
            <img src="{{ asset('images/foto_kambing.jpg') }}" class="img-fluid rounded-4 shadow" alt="Kambing">
        </div> 

        <div class="col-md-7"> 
            <div class="d-flex justify-content-between align-items-center mb-3"> 
                <div> 
                    <h1 id="kambing-nama" class="display-5 fw-bold mb-1 text-white"></h1> 
                    <span id="kambing-status" class="badge p-2"></span> 
                </div>

                <div class="d-flex gap-2">
                    {{-- EDIT: tampil untuk Admin & Anak_Kandang --}}
                    <button id="btn-edit" class="btn btn-warning btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="window.location.href='/katalog/edit/' + currentId"> 
                        <i class="bi bi-pencil-square"></i> EDIT
                    </button>
                    {{-- HAPUS: hanya untuk Admin --}}
                    <button id="btn-hapus" class="btn btn-danger btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="deleteKambing()"> 
                        <i class="bi bi-trash"></i> HAPUS
                    </button> 
                </div>
            </div>
            <hr class="opacity-25"> 

            <div class="row mb-4"> 
                <div class="col-6"> 
                    <p class="text-muted mb-0 small fw-bold">JENIS/RAS</p>
                    <h5 id="kambing-jenis" class="text-white">-</h5>
                </div>
                <div class="col-6"> 
                    <p class="text-muted mb-0 small fw-bold">BERAT AWAL</p>
                    <h5 id="kambing-berat" class="text-white">-</h5>
                </div>
            </div> 

            <div class="table-responsive card-glass"> 
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Parameter</th><th>Keterangan</th></tr>
                    </thead>
                    <tbody id="kambing-info-tabel"></tbody>
                </table>
            </div> 
        </div> 
    </div> 

    <div class="row mt-5">
        <div class="col-md-7 mb-4">
            <div class="card card-glass h-100 border-0">
                <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 text-white fw-bold">
                    Grafik Pertumbuhan
                </div>
                <div class="card-body"><canvas id="grafikBerat" style="max-height: 250px;"></canvas></div>
            </div>
        </div>
        <div class="col-md-5 mb-4"> 
            <div class="card card-glass h-100 border-0">
                <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 text-white fw-bold d-flex justify-content-between align-items-center"> 
                    <span>Riwayat Timbangan</span> 
                    <button class="btn btn-info btn-sm text-white fw-bold shadow-sm" onclick="alert('Input Berat')">Input Berat</button> 
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>Tanggal</th><th>Berat</th></tr></thead>
                        <tbody id="tabel-riwayat-berat"></tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const currentId  = window.location.pathname.split('/').pop();
    const token      = localStorage.getItem('token_sakti');
    
    // ✅ Ambil role dari object 'user' di localStorage
    const userData   = JSON.parse(localStorage.getItem('user') || '{}');
    const userRole   = userData?.role || ''; // "Admin" atau "Anak_Kandang"

    const apiHeaders = { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' };

    // ✅ Tampilkan tombol sesuai role
    function renderActionButtons() {
        const btnEdit  = document.getElementById('btn-edit');
        const btnHapus = document.getElementById('btn-hapus');

        if (userRole === 'Admin') {
            // Admin: EDIT + HAPUS
            btnEdit.classList.remove('d-none');
            btnHapus.classList.remove('d-none');
        } else if (userRole === 'Anak_Kandang') {
            // Anak kandang: EDIT saja
            btnEdit.classList.remove('d-none');
        }
        // Role lain: semua tombol tetap tersembunyi
    }

    document.addEventListener("DOMContentLoaded", function() {
        // ✅ Render tombol langsung saat halaman siap
        renderActionButtons();

        fetch(`/api/kambing/${currentId}`, { headers: apiHeaders })
            .then(res => res.json())
            .then(result => {
                if(result.status === 'success' && result.data) {
                    const k = result.data;
                    document.getElementById('kambing-nama').innerText = k.nama || 'Kambing B';
                    document.getElementById('kambing-jenis').innerText = k.jenis || 'Etawa';
                    document.getElementById('kambing-berat').innerText = (k.berat_awal || 0) + ' kg';
                    const sb = document.getElementById('kambing-status');
                    sb.innerText = (k.status_kondisi || 'Sehat').toUpperCase();
                    sb.className = 'badge p-2 ' + (k.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger');
                    document.getElementById('kambing-info-tabel').innerHTML = `
                        <tr><td>ID Kambing</td><td>#${k.id_kambing}</td></tr>
                        <tr><td>Kondisi</td><td>${k.status_kondisi}</td></tr>`;
                }
            })
            .finally(() => {
                document.getElementById('loading-detail').classList.add('d-none');
                document.getElementById('content-detail').classList.remove('d-none');
            });

        fetch(`/api/grafik-berat/${currentId}`, { headers: apiHeaders })
            .then(res => res.json())
            .then(result => {
                const tbody = document.getElementById('tabel-riwayat-berat');
                if (result.data && result.data.length > 0) {
                    tbody.innerHTML = '';
                    const labels = [], weights = [];
                    result.data.forEach(item => {
                        labels.push(item.tanggal_timbang); weights.push(item.berat_sekarang);
                        tbody.innerHTML += `<tr><td>${item.tanggal_timbang}</td><td>${item.berat_sekarang} kg</td></tr>`;
                    });
                    new Chart(document.getElementById('grafikBerat').getContext('2d'), {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Berat', data: weights, borderColor: '#0d6efd', fill: true, tension: 0.4 }] },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                }
            });
    });

    function deleteKambing() {
        // ✅ Double-check role sebelum eksekusi hapus
        if (userRole !== 'Admin') {
            alert('Anda tidak memiliki izin untuk menghapus data.');
            return;
        }
        if (confirm('Hapus data ini?')) {
            fetch(`/api/kambing/${currentId}`, { method: 'DELETE', headers: apiHeaders })
                .then(res => res.ok ? window.location.href = '/katalog' : alert('Gagal hapus.'));
        }
    }
</script>
@endsection