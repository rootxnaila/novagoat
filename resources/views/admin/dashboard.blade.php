@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
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

    .dashboard-wrapper {
        padding: 80px 16px 60px;
    }

    /* ===== Metric Cards ===== */
    .metric-card {
        background: var(--card-white);
        border-radius: 16px;
        border-left: 6px solid var(--medium-green);
        box-shadow: 0 4px 12px rgba(176, 190, 177, 0.4);
        transition: transform 0.3s ease;
        padding: 20px;
        height: 100%;
    }
    .metric-card:hover { transform: translateY(-4px); }

    .card-title-nova {
        color: var(--sub-text);
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-value-nova {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        font-weight: 800;
        color: var(--heading-text);
        line-height: 1.1;
        margin-top: 6px;
    }

    .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    /* ===== Chart Cards ===== */
    .chart-container {
        background: var(--card-white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(176, 190, 177, 0.4);
        border: 1px solid var(--border-divider);
        height: 100%;
    }

    .chart-title {
        color: var(--heading-text);
        font-weight: 700;
        font-size: clamp(0.85rem, 2.5vw, 1rem);
        margin-bottom: 0;
    }

    /* ===== Greeting ===== */
    .greeting-title {
        font-size: clamp(1.3rem, 4vw, 1.8rem);
        font-weight: 800;
        color: var(--heading-text);
        margin-bottom: 4px;
    }

    .greeting-sub {
        font-size: clamp(0.8rem, 2.5vw, 0.95rem);
        color: var(--dark-green);
        opacity: 0.75;
        font-weight: 500;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 80px 12px 60px;
        }

        /* 2 kolom di HP untuk metric cards */
        .metric-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Chart full width di HP */
        .chart-col {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Chart height lebih kecil di HP */
        .chart-inner {
            height: 200px !important;
        }

        /* Legend chart di bawah di HP */
        .chart-legend-bottom canvas {
            max-height: 180px;
        }
    }

    @media (min-width: 769px) {
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-wrapper">

    <!-- Header Greeting -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="greeting-title">Halo Bos, <span id="namaBos">Admin</span>!</h2>
            <p class="greeting-sub mb-0">Ini ringkasan kondisi Peternakan Pak Tarno hari ini.</p>
        </div>
    </div>

    <!-- Metric Cards -->
    <div class="metric-grid mb-4">
        <div>
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova">Total Kambing</div>
                    <div class="icon-box" style="background-color: var(--pale-mint); color: var(--dark-green);">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-kambing">0</div>
            </div>
        </div>
        <div>
            <div class="metric-card" style="border-left-color: #e74c3c;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova text-danger">Sakit/Rawat</div>
                    <div class="icon-box" style="background-color: #fdeaea; color: #e74c3c;">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-sakit">0</div>
            </div>
        </div>
        <div>
            <div class="metric-card" style="border-left-color: #f39c12;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="card-title-nova text-warning">Jadwal Hari Ini</div>
                    <div class="icon-box" style="background-color: #fef5e7; color: #f39c12;">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-jadwal">0</div>
            </div>
        </div>
        <div>
            <div class="metric-card" style="border-left-color: #3498db;">
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

    <!-- Chart Row -->
    <div class="row g-3">
        <div class="col-12 col-md-6 chart-col">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart-fill me-2" style="color: var(--medium-green);"></i>
                        Distribusi Ras Kambing
                    </h5>
                </div>
                <div class="chart-inner" style="position: relative; height: 250px;">
                    <canvas id="chartRas"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 chart-col">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="chart-title">
                        <i class="bi bi-heart-pulse-fill me-2" style="color: #e74c3c;"></i>
                        Status Kesehatan Kandang
                    </h5>
                </div>
                <div class="chart-inner" style="position: relative; height: 250px;">
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

        if (!token || !userString) {
            window.location.href = '/login';
            return;
        }

        const user = JSON.parse(userString);
        if (user.role !== 'admin') {
            window.location.href = '/katalog';
            return;
        }

        const namaBosEl = document.getElementById('namaBos');
        if (namaBosEl) namaBosEl.innerText = user.username;

        // Fetch Anak Kandang
        fetch('/api/karyawan/kinerja', {
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                document.getElementById('val-pekerja').innerText = result.data.length;
            }
        })
        .catch(err => console.error('Error Kinerja:', err));

        // Fetch Dashboard Stats
        fetch('/api/dashboard/stats', {
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                const data = result.data;
                document.getElementById('val-kambing').innerText = data.total_kambing;
                document.getElementById('val-sakit').innerText   = data.kambing_sakit;
                document.getElementById('val-jadwal').innerText  = data.jadwal_hari_ini;
                renderChartRas(data.sebaran_ras);
                renderChartKesehatan(data.status_kesehatan);
            }
        })
        .catch(err => console.error('Error Dashboard Stats:', err));

        function renderChartRas(data) {
            if (!data || data.length === 0) return;
            const isMobile = window.innerWidth <= 768;
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
                        legend: {
                            position: isMobile ? 'bottom' : 'right',
                            labels: { boxWidth: 12, font: { size: 11 }, padding: 10 }
                        }
                    }
                }
            });
        }

        function renderChartKesehatan(data) {
            if (!data || data.length === 0) return;
            const ctx = document.getElementById('chartKesehatan').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.label),
                    datasets: [{
                        label: 'Jumlah Ekor',
                        data: data.map(item => item.total),
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
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endsection