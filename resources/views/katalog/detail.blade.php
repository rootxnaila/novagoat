@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --green-dark:    #1B4D1E;
        --green-medium:  #2E7D32;
        --green-button:  #3D7A40;
        --green-light:   #A5C8A7;
        --green-pale:    #D6EDD7;
        --bg-page:       #E8EDEA;
        --bg-card:       #FFFFFF;
        --bg-input:      #F2F5F2;
        --icon-circle:   #C8DAC9;
        --shadow-muted:  #B0BEB1;
        --text-heading:  #1A2E1A;
        --text-sub:      #4A6B4C;
        --text-placeholder: #9BB09C;
        --border-color:  #D0DDD1;
    }

    body {
        background-color: var(--bg-page);
        color: var(--text-heading);
        min-height: 100vh;
    }

    .dashboard-container {
        margin-top: 100px;
        padding-bottom: 60px;
    }

    .card-custom {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(176, 190, 177, 0.2);
    }

    .table {
        color: var(--text-heading) !important;
    }

    .table-light th {
        background-color: var(--bg-input) !important;
        color: var(--text-sub) !important;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 600;
    }

    .table tbody td {
        border-color: var(--border-color);
    }

    .display-5 {
        color: var(--text-heading) !important;
    }

    .badge-sehat {
        background-color: #EAF3DE !important;
        color: #27500A !important;
        border: 1px solid #A5C8A7;
    }

    .badge-sakit {
        background-color: #FCEBEB !important;
        color: #791F1F !important;
        border: 1px solid #F09595;
    }

    .btn-green {
        background-color: var(--green-button) !important;
        border-color: var(--green-button) !important;
        color: white !important;
    }

    .btn-green:hover {
        background-color: var(--green-medium) !important;
    }

    .btn-outline-danger-custom {
        background-color: #FCEBEB !important;
        border-color: #F09595 !important;
        color: #791F1F !important;
    }

    .btn-outline-danger-custom:hover {
        background-color: #F7C1C1 !important;
    }

    .card-header {
        background-color: var(--bg-input) !important;
        color: var(--text-heading) !important;
        border-bottom: 1px solid var(--border-color) !important;
        font-weight: 600;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 28px 32px;
        max-width: 380px;
        width: 90%;
    }

    .modal-box h5 {
        color: var(--text-heading);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .modal-box p {
        color: var(--text-sub);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel-modal {
        background: var(--bg-input);
        color: var(--text-sub);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-cancel-modal:hover {
        background: var(--border-color);
    }

    .btn-confirm-delete {
        background: #E24B4A;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-confirm-delete:hover {
        background: #A32D2D;
    }

    .btn-confirm-delete:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<!-- Modal Konfirmasi Hapus -->
<div class="modal-overlay" id="modal-hapus">
    <div class="modal-box">
        <h5><i class="bi bi-exclamation-triangle-fill" style="color:#E24B4A; margin-right:6px;"></i>Hapus Data Kambing?</h5>
        <p>Data yang dihapus tidak dapat dikembalikan. Yakin ingin menghapus kambing ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel-modal" onclick="tutupModal()">Batal</button>
            <button class="btn-confirm-delete" id="btn-confirm-hapus" onclick="konfirmasiHapus()">
                <i class="bi bi-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<div class="container dashboard-container">
    <div id="loading-detail" class="text-center">
        <div class="spinner-border" role="status" style="color: var(--green-button);"></div>
        <p class="mt-2" style="color: var(--text-sub);">Memuat data...</p>
    </div>

    <div class="row d-none" id="content-detail">
        <div class="col-md-5 mb-4">
            <img src="{{ asset('images/foto_kambing.jpg') }}" class="img-fluid rounded-4 shadow-sm border w-100" alt="Kambing" style="border-color: var(--border-color) !important;">
        </div>

        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 id="kambing-nama" class="display-5 fw-bold mb-1"></h1>
                    <span id="kambing-status" class="badge p-2 shadow-sm"></span>
                </div>
                <div class="d-flex gap-2">
                    <button id="btn-edit" class="btn btn-green btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="window.location.href='/katalog/edit/' + currentId">
                        <i class="bi bi-pencil-square"></i> EDIT
                    </button>
                    <button id="btn-hapus" class="btn btn-outline-danger-custom btn-sm fw-bold px-3 shadow-sm d-none"
                            onclick="bukaModal()">
                        <i class="bi bi-trash"></i> HAPUS
                    </button>
                </div>
            </div>
            <hr style="border-color: var(--border-color); opacity: 1;">

            <div class="row mb-4">
                <div class="col-6">
                    <p class="mb-0 small fw-bold" style="color: var(--text-sub);">JENIS/RAS</p>
                    <h5 id="kambing-jenis" class="fw-bold">-</h5>
                </div>
                <div class="col-6">
                    <p class="mb-0 small fw-bold" style="color: var(--text-sub);">BERAT AWAL</p>
                    <h5 id="kambing-berat" class="fw-bold">-</h5>
                </div>
            </div>

            <div class="table-responsive card-custom">
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
            <div class="card card-custom h-100 border-0">
                <div class="card-header border-0">Grafik Pertumbuhan</div>
                <div class="card-body"><canvas id="grafikBerat" style="max-height: 250px;"></canvas></div>
            </div>
        </div>
        <div class="col-md-5 mb-4">
            <div class="card card-custom h-100 border-0">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <span>Riwayat Timbangan</span>
                    <button class="btn btn-green btn-sm fw-bold shadow-sm" onclick="alert('Fitur Input Berat')">Input Berat</button>
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
    const userData   = JSON.parse(localStorage.getItem('user') || '{}');
    const userRole   = userData?.role || '';
    const apiHeaders = { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' };

    function renderActionButtons() {
        const btnEdit  = document.getElementById('btn-edit');
        const btnHapus = document.getElementById('btn-hapus');
        if (userRole === 'Admin') {
            btnEdit?.classList.remove('d-none');
            btnHapus?.classList.remove('d-none');
        } else if (userRole === 'Anak_Kandang') {
            btnEdit?.classList.remove('d-none');
        }
    }

    function bukaModal() {
        document.getElementById('modal-hapus').classList.add('show');
    }

    function tutupModal() {
        document.getElementById('modal-hapus').classList.remove('show');
    }

    function konfirmasiHapus() {
        const btn = document.getElementById('btn-confirm-hapus');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

        fetch(`/api/kambing/${currentId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => {
            if (res.ok) {
                window.location.href = '/katalog';
            } else {
                return res.json().then(data => {
                    throw new Error(data.message || 'Gagal menghapus data.');
                });
            }
        })
        .catch(err => {
            tutupModal();
            alert('Gagal menghapus: ' + err.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash"></i> Ya, Hapus';
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        renderActionButtons();

        fetch(`/api/kambing/${currentId}`, { headers: apiHeaders })
            .then(res => res.json())
            .then(result => {
                if(result.status === 'success' && result.data) {
                    const k = result.data;
                    document.getElementById('kambing-nama').innerText = k.nama || 'Kambing #';
                    document.getElementById('kambing-jenis').innerText = k.jenis || '-';
                    document.getElementById('kambing-berat').innerText = (k.berat_awal || 0) + ' kg';

                    const sb = document.getElementById('kambing-status');
                    const kondisi = (k.status_kondisi || 'Sehat').toUpperCase();
                    sb.innerText = kondisi;
                    sb.className = 'badge p-2 ' + (kondisi === 'SEHAT' ? 'badge-sehat' : 'badge-sakit');

                    document.getElementById('kambing-info-tabel').innerHTML = `
                        <tr><td>ID Kambing</td><td>#${k.id_kambing}</td></tr>
                        <tr><td>Kondisi</td><td>${k.status_kondisi}</td></tr>`;
                }
            })
            .catch(err => console.error("Fetch Error:", err))
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
                        labels.push(item.tanggal_timbang);
                        weights.push(item.berat_sekarang);
                        tbody.innerHTML += `<tr><td>${item.tanggal_timbang}</td><td>${item.berat_sekarang} kg</td></tr>`;
                    });

                    new Chart(document.getElementById('grafikBerat').getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Berat (kg)',
                                data: weights,
                                borderColor: '#3D7A40',
                                backgroundColor: 'rgba(165, 200, 167, 0.2)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#2E7D32',
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { ticks: { color: '#4A6B4C' }, grid: { color: '#D0DDD1' } },
                                y: { ticks: { color: '#4A6B4C' }, grid: { color: '#D0DDD1' } }
                            }
                        }
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="2" class="text-center py-3" style="color: var(--text-sub);">Tidak ada data riwayat</td></tr>';
                }
            });
    });
</script>
@endsection