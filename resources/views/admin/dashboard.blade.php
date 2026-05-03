@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #121417; 
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(220, 38, 38, 0.1) 0px, transparent 50%);
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        margin-top: 120px;
        padding-bottom: 60px;
    }

    .header-section h2 {
        color: #ffffff;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .header-section p {
        color: #94a3b8;
    }

    /* Efek Glassmorphism pada Card */
    .card-glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-glass:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-10px);
        border-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .stat-label {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    /* Dekorasi Lingkaran Warna di dalam Card */
    .glow-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 10px currentColor;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        margin-bottom: 20px;
    }
</style>

<div class="container dashboard-container">
    <div class="header-section mb-5">
        <h2>Dashboard Monitoring</h2>
        <p>Ringkasan sistem manajemen peternakan Novagoat.</p>
    </div>

    <div class="row">
        <!-- Total Kambing -->
        <div class="col-md-4 mb-4">
            <div class="card card-glass h-100">
                <div class="card-body p-4">
                    <div class="icon-box text-primary">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <span class="stat-label text-primary">
                        <span class="glow-dot bg-primary"></span>Total Kambing
                    </span>
                    <p id="total-kambing" class="stat-number">0</p>
                </div>
            </div>
        </div>

        <!-- Kambing Sakit -->
        <div class="col-md-4 mb-4">
            <div class="card card-glass h-100">
                <div class="card-body p-4">
                    <div class="icon-box text-danger">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <span class="stat-label text-danger">
                        <span class="glow-dot bg-danger"></span>Kambing Sakit
                    </span>
                    <p id="kambing-sakit" class="stat-number">0</p>
                </div>
            </div>
        </div>

        <!-- Jadwal Suntik -->
        <div class="col-md-4 mb-4">
            <div class="card card-glass h-100">
                <div class="card-body p-4">
                    <div class="icon-box text-success">
                        <i class="bi bi-calendar2-check-fill"></i>
                    </div>
                    <span class="stat-label text-success">
                        <span class="glow-dot bg-success"></span>Jadwal Suntik
                    </span>
                    <p id="jadwal-suntik" class="stat-number">0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('token');
        const userString = localStorage.getItem('user'); // Ambil data user
        
        if (!token || !userString) { //cek login
            alert('Silakan login terlebih dahulu!');
            window.location.href = '/login';
            return;
        }

        const user = JSON.parse(userString);//cek apa admin
        if (user.role !== 'admin') {
            alert('Akses Ditolak! Halaman Dashboard hanya untuk Admin.');
            window.location.href = '/katalog'; //tendang ke katalog
            return;
        }
        fetch('/api/dashboard/stats', { 
            headers: { 
                'Authorization': 'Bearer ' + localStorage.getItem('token'), 
                'Accept': 'application/json' 
            }
        }) 
            .then(response => response.json()) 
            .then(result => {
                if(result.status === 'success' && result.data) { 
                    document.getElementById('total-kambing').innerText = result.data.total_kambing; 
                    document.getElementById('kambing-sakit').innerText = result.data.kambing_sakit; 
                    document.getElementById('jadwal-suntik').innerText = result.data.jadwal_suntik; 
                }
            })
            .catch(error => console.error('Waduh error:', error)); 
    });
</script>
@endsection