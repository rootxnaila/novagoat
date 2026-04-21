@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div id="loading-detail" class="text-center">
        <div class="spinner-border text-primary" role="status"></div>
        <p>Sedang mengambil data medis kambing...</p>
    </div>

    <div class="row d-none" id="content-detail">
        <div class="col-md-5">
            <img id="kambing-foto" src="" class="img-fluid rounded shadow-sm border" alt="Foto Kambing">
        </div>
        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center">
                <h1 id="kambing-nama" class="display-5 fw-bold"></h1>
                <span id="kambing-status" class="badge p-2"></span>
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

            <h5 class="fw-bold mt-5"><i class="bi bi-graph-up"></i> Grafik Perkembangan Berat</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="grafikBerat"></canvas>
            </div>

            <div class="mt-4">
                <button class="btn btn-warning px-4" onclick="window.location.href='/katalog/edit/' + currentId">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
                <button class="btn btn-danger px-4" onclick="deleteKambing()">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentId = window.location.pathname.split('/').pop();
    let chartInstance = null;

    document.addEventListener("DOMContentLoaded", function() {
        fetch(`/api/kambing/${currentId}`)
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success') {
                    const k = result.data;
                    document.getElementById('loading-detail').classList.add('d-none');
                    document.getElementById('content-detail').classList.remove('d-none');

                    document.getElementById('kambing-nama').innerText = k.nama;
                    document.getElementById('kambing-jenis').innerText = k.jenis;
                    document.getElementById('kambing-berat').innerText = k.berat_awal + ' kg';
                    document.getElementById('kambing-foto').src = k.gambar || 'https://via.placeholder.com/500';

                    const statusBadge = document.getElementById('kambing-status');
                    statusBadge.innerText = k.status_kondisi;
                    statusBadge.classList.add(k.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger');

                    // Isi Tabel
                    document.getElementById('kambing-info-tabel').innerHTML = `
                        <tr><td>ID Kambing</td><td>#${k.id_kambing}</td></tr>
                        <tr><td>Catatan Medis</td><td>${k.catatan || 'Belum ada catatan medis.'}</td></tr>
                        <tr><td>Terakhir Update</td><td>${new Date().toLocaleDateString('id-ID')}</td></tr>
                    `;

                    // Muat grafik berat
                    loadGrafikBerat();
                }
            })
            .catch(err => alert('Gagal mengambil data detail: ' + err));
    });

    function loadGrafikBerat() {
        fetch(`/api/grafik-berat/${currentId}`)
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success' && result.data.length > 0) {
                    const data = result.data;

                    // Formatkan data untuk grafik
                    const labels = data.map(d => new Date(d.tanggal_timbang).toLocaleDateString('id-ID'));
                    const weights = data.map(d => parseFloat(d.berat_sekarang));

                    // Inisialisasi Chart.js
                    const ctx = document.getElementById('grafikBerat').getContext('2d');

                    if(chartInstance) {
                        chartInstance.destroy();
                    }

                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Berat Kambing (kg)',
                                data: weights,
                                borderColor: '#0d6efd',
                                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 5,
                                pointBackgroundColor: '#0d6efd',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                title: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'Berat (kg)'
                                    },
                                    min: Math.min(...weights) - 5,
                                    max: Math.max(...weights) + 5
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal Penimbangan'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(err => console.error('Gagal mengambil data grafik:', err));
    }

    function deleteKambing() {
        if(confirm('Yakin ingin menghapus data kambing ini?')) {
            fetch(`/api/kambing/${currentId}`, { method: 'DELETE' })
                .then(res => res.json())
                .then(() => {
                    alert('Data berhasil dihapus!');
                    window.location.href = '/katalog';
                });
        }
    }
</script>
@endsection