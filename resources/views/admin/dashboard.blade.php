@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* palette novagoat */
    :root {
        --dark-green: #1B4D1E;
        --medium-green: #2E7D32;
        --button-green: #3D7A40;
        --light-green: #A5C8A7;
        --pale-mint: #D6EDD7;
        --card-white: #FFFFFF;
        --page-bg: #E8EDEA;
        --icon-circle: #C8DAC9;
        --shadow-muted: #B0BEB1;
        --heading-text: #1A2E1A;
        --sub-text: #4A6B4C;
        --border-divider: #D0DDD1;
    }

    body { background-color: var(--page-bg) !important; }

    .metric-card {
        background: var(--card-white);
        border-radius: 16px;
        border-left: 6px solid var(--medium-green);
        box-shadow: 0 4px 12px rgba(176, 190, 177, 0.4);
        transition: transform 0.3s ease;
    }
    .metric-card:hover { transform: translateY(-5px); }
    
    .card-title-nova { color: var(--sub-text); font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;}
    .card-value-nova { font-size: 2.5rem; font-weight: 800; color: var(--heading-text); }
    
    .chart-container {
        background: var(--card-white);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(176, 190, 177, 0.4);
        border: 1px solid var(--border-divider);
    }
    
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: var(--heading-text);">Halo Bos, <span id="namaBos">Admin</span>!</h2>
            <p class="fw-medium" style="color: var(--dark-green); opacity: 0.75;">Ini ringkasan kondisi Peternakan Pak Tarno hari ini.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="metric-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova">Total Kambing</div>
                    <div class="icon-box" style="background-color: var(--pale-mint); color: var(--dark-green);">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-kambing">0</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card p-4" style="border-left-color: #e74c3c;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova text-danger">Sakit/Rawat</div>
                    <div class="icon-box" style="background-color: #fdeaea; color: #e74c3c;">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-sakit">0</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card p-4" style="border-left-color: #f39c12;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova text-warning">Jadwal Hari Ini</div>
                    <div class="icon-box" style="background-color: #fef5e7; color: #f39c12;">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-jadwal">0</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card p-4" style="border-left-color: #3498db;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova text-info">Anak Kandang</div>
                    <div class="icon-box" style="background-color: #ebf5fb; color: #3498db;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-pekerja">0</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="chart-container h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: var(--heading-text);"><i class="bi bi-pie-chart-fill me-2" style="color: var(--medium-green);"></i> Distribusi Ras Kambing</h5>
                </div>
                <div style="position: relative; height: 250px;">
                    <canvas id="chartRas"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="chart-container h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: var(--heading-text);"><i class="bi bi-heart-pulse-fill me-2" style="color: #e74c3c;"></i> Status Kesehatan Kandang</h5>
                </div>
                <div style="position: relative; height: 250px;">
                    <canvas id="chartKesehatan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('token');
        const userString = localStorage.getItem('user');
        
        // 🛡️ SCRIPT SATPAM: Cek Login & Role Admin
        if (!token || !userString) {
            window.location.href = '/login';
            return;
        }

        const user = JSON.parse(userString);
        if (user.role !== 'admin') {
            window.location.href = '/katalog';
            return;
        }

        // Tampilkan nama admin
        const namaBosEl = document.getElementById('namaBos');
        if(namaBosEl) namaBosEl.innerText = user.username;

        // 1. Fetch Jumlah Anak Kandang (Pekerja)
        fetch('/api/karyawan/kinerja', { headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }})
        .then(res => res.json())
        .then(result => {
            if(result.status === 'success') {
                document.getElementById('val-pekerja').innerText = result.data.length;
            }
        }).catch(err => console.error('Error Kinerja:', err));

        // 2. Fetch Statistik Utama & Data Grafik dari Controller Baru
        fetch('/api/dashboard/stats', { headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }})
        .then(res => res.json())
        .then(result => {
            if(result.status === 'success') {
                const data = result.data;
                
                // Update Angka Metrik
                document.getElementById('val-kambing').innerText = data.total_kambing;
                document.getElementById('val-sakit').innerText = data.kambing_sakit;
                document.getElementById('val-jadwal').innerText = data.jadwal_hari_ini;

                // Render 2 Grafik Baru
                renderChartRas(data.sebaran_ras);
                renderChartKesehatan(data.status_kesehatan);
            }
        })
        .catch(err => console.error('Error Dashboard Stats:', err));

        // Fungsi Render Chart Ras (Donat)
        function renderChartRas(data) {
            if(!data || data.length === 0) return; // Skip kalo kosong
            const ctx = document.getElementById('chartRas').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.map(item => item.label),
                    datasets: [{
                        data: data.map(item => item.total),
                        backgroundColor: ['#1B4D1E', '#2E7D32', '#A5C8A7', '#D6EDD7', '#C8DAC9'],
                        borderWidth: 2,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 15, font: { size: 12 } } }
                    }
                }
            });
        }

        // Fungsi Render Chart Kesehatan (Batang)
        function renderChartKesehatan(data) {
            if(!data || data.length === 0) return; // Skip kalo kosong
            const ctx = document.getElementById('chartKesehatan').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.label),
                    datasets: [{
                        label: 'Jumlah Ekor',
                        data: data.map(item => item.total),
                        // Kalo statusnya 'Sehat' warnanya ijo, selain itu (Sakit/Karantina) warnanya merah/orange
                        backgroundColor: data.map(item => item.label === 'Sehat' ? '#2E7D32' : '#e74c3c'),
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } } // Sembunyin legend karena udah jelas di label X
                }
            });
        }
    });
</script>
@endsection