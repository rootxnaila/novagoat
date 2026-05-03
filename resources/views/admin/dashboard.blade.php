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

    <!-- 4 Kotak Metrik Utama -->
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
                    <div class="card-title-nova text-warning">Jadwal Medis</div>
                    <div class="icon-box" style="background-color: #fef5e7; color: #f39c12;">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                </div>
                <div class="card-value-nova" id="val-jadwal">...</div> <!-- Angka dummy medis sementara -->
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

    <!-- grafik karyawan -->
    <div class="row">
        <div class="col-md-12">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: var(--heading-text);"><i class="bi bi-bar-chart-line-fill me-2" style="color: var(--medium-green);"></i> Grafik Kinerja Anak Kandang</h5>
                </div>
                <canvas id="kinerjaChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('token');
        const userString = localStorage.getItem('user');
        
        //security script
        if (!token || !userString) {
            window.location.href = '/login';
            return;
        }

        const user = JSON.parse(userString);
        if (user.role !== 'admin') {
            window.location.href = '/katalog';
            return;
        }

        document.getElementById('namaBos').innerText = user.username;

        fetch('/api/kambing', { headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }})
        .then(res => res.json())
        .then(result => {
            if(result.status === 'success') {
                document.getElementById('val-kambing').innerText = result.data.length;
                const sakit = result.data.filter(k => k.status_kondisi !== 'Sehat').length;
                document.getElementById('val-sakit').innerText = sakit;
            }
        });

        fetch('/api/karyawan/kinerja', { headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }})//fetch data utk grafik 
        .then(res => res.json())
        .then(result => {
            if(result.status === 'success') {
                const pekerja = result.data;
                document.getElementById('val-pekerja').innerText = pekerja.length;

                //ekstrak data chart
                const labels = pekerja.map(p => p.username);
                const dataTimbang = pekerja.map(p => p.log_berat_count);
                const dataMedis = pekerja.map(p => p.jadwal_medis_count);

                const ctx = document.getElementById('kinerjaChart').getContext('2d'); //render grafik bar
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Input Berat Kambing',
                                data: dataTimbang,
                                backgroundColor: '#A5C8A7',
                                borderRadius: 6
                            },
                            {
                                label: 'Tindakan Medis',
                                data: dataMedis,
                                backgroundColor: '#2E7D32', 
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: { 
                            legend: { position: 'top' } 
                        },
                        scales: { 
                            y: { 
                                beginAtZero: true, 
                                ticks: { precision: 0 } 
                            } 
                        }
                    }
                });
            }
        });
        fetch('/api/jadwal-medis', { 
            headers: { 
                'Authorization': 'Bearer ' + token, 
                'Accept': 'application/json' 
            }
        })
        .then(res => res.json())
        .then(result => {
            if(result.status === 'success') {
                // Hitung total jadwal medis dari database dan masukkan ke kotak
                document.getElementById('val-jadwal').innerText = result.data.length;
            } else {
                document.getElementById('val-jadwal').innerText = '0';
            }
        })
        .catch(error => {
            console.error('API Error (Jadwal):', error);
            document.getElementById('val-jadwal').innerText = '0';
        });
    });
</script>
@endsection