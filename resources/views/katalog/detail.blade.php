@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div id="loading-detail" class="text-center">
        <div class="spinner-border text-primary" role="status"></div>
        <p>Sedang mengambil data medis kambing...</p>
    </div>

    <div class="row d-none" id="content-detail"> 
        <div class="col-md-5"> 
            <img src="{{ asset('images/foto_kambing.jpg') }}" class="img-fluid rounded shadow-sm border" alt="Foto Kambing">
        </div> 

        <div class="col-md-7"> 
            <div class="d-flex justify-content-between align-items-start"> 
                <div> 
                    <h1 id="kambing-nama" class="display-5 fw-bold mb-2"></h1> 
                    <span id="kambing-status" class="badge p-2"></span> 
                </div>
                @if(Auth::user() && Auth::user()->role === 'admin') 
                <div> /
                    <button class="btn btn-warning btn-sm me-2" onclick="window.location.href='/katalog/edit/' + currentId"> 
                        <i class="bi bi-pencil-square"></i> Edit
                    </button> 
                    <button class="btn btn-danger btn-sm" onclick="deleteKambing()"> 
                        <i class="bi bi-trash"></i> Hapus
                    </button> 
                </div>
                @endif 
            </div>
            <hr> 

            <div class="row mb-4"> 
                <div class="col-6"> 
                    <p class="text-muted mb-0">Jenis/Ras</p>
                    <h5 id="kambing-jenis">-</h5>
                </div>
                <div class="col-6"> 
                    <p class="text-muted mb-0">Berat Awal</p>
                    <h5 id="kambing-berat">-</h5>
                </div>
            </div> 

            <h5 class="fw-bold"><i class="bi bi-clipboard2-pulse"></i> Riwayat & Catatan Medis</h5>
            <div class="table-responsive"> 
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>Parameter</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="kambing-info-tabel">
                    </tbody>
                </table>
            </div> 
        </div> 
    </div> 
            <div class="mt-4">
                <button class="btn btn-warning px-4" onclick="window.location.href='/katalog/edit/' + currentId">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
                <button class="btn btn-danger px-4 d-none" id="btnHapusKambing" onclick="deleteKambing()">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-graph-up"></i> Grafik Pertumbuhan Berat
                    </div>
                    <div class="card-body">
                        <canvas id="grafikBerat" style="max-height: 300px;"></canvas>
                    </div>
>>>>>>> 0a471a3252ea1e6764c2b56fd411faab2f5db6c3
                </div>
            </div>
        </div> 

        <div class="col-md-5"> 
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center"> 
                    <span><i class="bi bi-list-ul"></i> Riwayat Timbangan</span> 
                    <button class="btn btn-info btn-sm text-white" onclick="alert('Ini nanti buka modal Naufal!')"> 
                    </button> 
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Berat</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-riwayat-berat">
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const currentId = window.location.pathname.split('/').pop();

    document.addEventListener("DOMContentLoaded", function() {

        // Security Role: tombol Hapus hanya muncul untuk Admin
        const _u = localStorage.getItem('user');
        if (_u) {
            const _uObj = JSON.parse(_u);
            if (_uObj.role === 'Admin') {
                const btnDel = document.getElementById('btnHapusKambing');
                if (btnDel) btnDel.classList.remove('d-none');
            }
        }
        
        //fetch detail utama
        fetch(`/api/kambing/${currentId}`)
            .then(res => res.json())
            .then(result => {
                if(result.status === 'success' && result.data) {
                    const k = result.data;
                    document.getElementById('kambing-nama').innerText = k.nama || 'Kambing';
                    document.getElementById('kambing-jenis').innerText = k.jenis || '-';
                    document.getElementById('kambing-berat').innerText = (k.berat_awal || 0) + ' kg';
                    
                    const statusBadge = document.getElementById('kambing-status');
                    statusBadge.innerText = k.status_kondisi || 'Sehat';
                    statusBadge.className = 'badge p-2 ' + (k.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger');

                    document.getElementById('kambing-info-tabel').innerHTML = `
                        <tr><td>ID Kambing</td><td>#${k.id_kambing}</td></tr>
                        <tr><td>Status Medis</td><td>${k.status_kondisi || '-'}</td></tr>
                        <tr><td>Catatan</td><td>Belum ada catatan medis.</td></tr>
                    `;
                }
            })
            .catch(err => console.error("Error Detail:", err))
            .finally(() => {
                document.getElementById('loading-detail').classList.add('d-none');
                document.getElementById('content-detail').classList.remove('d-none');
            });

        //fetch riwayat berat
        fetch(`/api/grafik-berat/${currentId}`)
            .then(res => res.json())
            .then(result => {
                const tbody = document.getElementById('tabel-riwayat-berat');
                const dataArr = result.data;

                if (Array.isArray(dataArr) && dataArr.length > 0) {
                    tbody.innerHTML = ''; 
                    const tgls = [];
                    const brts = [];

                    dataArr.forEach(item => {
                    
                        let t = item.tanggal_timbang || '-'; 
                        let b = item.berat_sekarang || 0;
                        
                        tgls.push(t);
                        brts.push(b);

                        tbody.innerHTML += `<tr><td>${t}</td><td><strong>${b} kg</strong></td></tr>`;
                    });

                    const ctx = document.getElementById('grafikBerat').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: tgls,
                            datasets: [{
                                label: 'Berat (kg)',
                                data: brts,
                                borderColor: '#0d6efd',
                                tension: 0.3,
                                fill: true,
                                backgroundColor: 'rgba(13, 110, 253, 0.1)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { y: { beginAtZero: false } }
                        }
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="2" class="text-center">Riwayat belum tersedia.</td></tr>';
                }
            })
            .catch(err => console.error("Error Riwayat:", err));
    }); 

    function deleteKambing() {
        if(confirm('Yakin hapus data kambing ini? Tindakan tidak bisa dibatalkan!')) {
            const token = localStorage.getItem('token_sakti');
            fetch(`/api/kambing/${currentId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.ok) {
                    alert('Berhasil dihapus!');
                    window.location.href = '/katalog';
                } else {
                    res.json().then(err => alert('Gagal: ' + (err.message || 'Tidak memiliki izin.')));
                }
            })
            .catch(() => alert('Kesalahan jaringan.'));
        }
    }
</script>
@endsection