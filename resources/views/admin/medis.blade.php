@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid px-4" style="padding-top: 180px; padding-bottom: 100px; background-color: #000; min-height: 100vh;">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5 px-2">
        <div>
            <h2 class="text-white fw-bold">Jadwal Medis & Vaksin</h2>
            <p class="text-secondary mb-0 font-monospace" style="font-size: 0.85rem;">Monitoring kesehatan dan jadwal imunisasi ternak.</p>
        </div>
        <button class="btn btn-info btn-sm rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">+ TAMBAH JADWAL</button>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4 px-2">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Total Catatan</small>
                <h3 class="text-white fw-bold mb-0">-</h3>
                <small class="text-info" style="font-size: 0.65rem;">Seluruh entri log berat.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Berat Terakhir</small>
                <h3 class="text-white fw-bold mb-0">- kg</h3>
                <small class="text-success" style="font-size: 0.65rem;">Data terupdate.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Rata-rata Berat</small>
                <h3 class="text-white fw-bold mb-0">- kg</h3>
                <small class="text-warning" style="font-size: 0.65rem;">Periode ini.</small>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="row g-3 px-2">
        <div class="col-lg-8">
            <div class="card bg-dark border-secondary shadow" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-dark border-secondary py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-info" style="font-size: 0.8rem;">Grafik Monitor Kesehatan</h6>
                    <div class="d-flex align-items-center bg-black px-3 py-1 rounded-pill" style="border: 1px solid #333;">
                        <div style="width: 10px; height: 10px; background: #00fbff; border-radius: 2px; margin-right: 8px;"></div>
                        <span class="text-white" style="font-size: 10px;">BERAT BADAN (KG)</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 350px;">
                        <canvas id="medisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark border-secondary shadow h-100" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary py-3 border-0 text-center">
                    <h6 class="m-0 fw-bold text-white" style="font-size: 0.8rem;">AGENDA VAKSIN MENDATANG</h6>
                </div>
                <div class="card-body p-3">
                    <div class="p-3 mb-3 shadow-sm" style="background: rgba(255,255,255,0.03); border-radius: 12px; border-left: 4px solid #00fbff;">
                        <small class="text-info fw-bold d-block mb-1">20 April 2026</small>
                        <h6 class="text-white fw-bold mb-0" style="font-size: 0.9rem;">Vaksinasi Anthrax - Kandang A</h6>
                    </div>
                    <div class="p-3 shadow-sm" style="background: rgba(255,255,255,0.03); border-radius: 12px; border-left: 4px solid #ffc107;">
                        <small class="text-warning fw-bold d-block mb-1">25 April 2026</small>
                        <h6 class="text-white fw-bold mb-0" style="font-size: 0.9rem;">Cek Nutrisi Kambing Pejantan</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tetap di Bawah --}}
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold">Tambah Jadwal / Log Berat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.medis.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">TANGGAL KEGIATAN</label>
                        <input type="date" name="tanggal" class="form-control bg-black border-secondary text-white shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">BERAT BADAN (KG)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="berat" class="form-control bg-black border-secondary text-white shadow-none" placeholder="25.5" required>
                            <span class="input-group-text bg-secondary border-secondary text-white">kg</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">KETERANGAN AGENDA (OPSIONAL)</label>
                        <textarea name="keterangan" class="form-control bg-black border-secondary text-white shadow-none" rows="2" placeholder="Catatan medis..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-info rounded-pill px-4 fw-bold text-dark">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('medisChart').getContext('2d');
        const medisChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Berat Badan',
                    data: [],
                    borderColor: '#00fbff',
                    backgroundColor: 'rgba(0, 251, 255, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#00fbff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: '#222' }, ticks: { color: '#888' } },
                    x: { grid: { display: false }, ticks: { color: '#888' } }
                }
            }
        });

        fetch('/admin/medis-data')
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    medisChart.data.labels = data.map(item => {
                        const d = new Date(item.tanggal);
                        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
                    });
                    medisChart.data.datasets[0].data = data.map(item => item.berat);
                    medisChart.update();

                    const stats = document.querySelectorAll('.row.g-3.mb-4 h3');
                    stats[0].innerText = data.length;
                    stats[1].innerText = data[data.length - 1].berat + ' kg';
                    const avg = data.reduce((sum, item) => sum + parseFloat(item.berat), 0) / data.length;
                    stats[2].innerText = avg.toFixed(1) + ' kg';
                }
            });
    });
</script>
<style>
    /* Paksa body dan html supaya bisa di-scroll lagi */
    body, html {
        overflow-y: auto !important;
        height: auto !important;
    }
</style>
@endsection