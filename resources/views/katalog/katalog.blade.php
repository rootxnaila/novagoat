@extends('layouts.app')

@section('content')

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

    .text-heading { color: var(--heading-text) !important; }
    .text-sub { color: var(--sub-text) !important; }

    .btn-nova-primary {
        background-color: var(--button-green);
        color: var(--card-white);
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-nova-primary:hover {
        background-color: var(--medium-green);
        color: var(--card-white);
        transform: translateY(-2px);
    }
    .btn-nova-outline {
        border: 1px solid var(--medium-green);
        color: var(--medium-green);
        background: transparent;
    }
    .btn-nova-outline:hover {
        background: var(--pale-mint);
        color: var(--dark-green);
    }

    .card-katalog {
        background-color: var(--card-white);
        border: 1px solid var(--border-divider);
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(176, 190, 177, 0.4);
        overflow: hidden;
    }
    .table-nova thead th {
        background-color: var(--dark-green) !important;
        color: var(--card-white) !important;
        border-bottom: none;
        padding: 15px 10px;
    }
    .table-nova tbody td {
        color: var(--sub-text);
        border-bottom: 1px solid var(--border-divider);
        vertical-align: middle;
        padding: 12px 10px;
    }

    .img-kambing {
        width: 60px; 
        height: 60px; 
        object-fit: cover; 
        border-radius: 12px;
        border: 2px solid var(--icon-circle);
        box-shadow: 0 2px 4px var(--shadow-muted);
    }
</style>

<div class="container mt-5 mb-5"> 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-heading mb-0"><i class="bi bi-book-half" style="color: var(--medium-green);"></i> Katalog Ensiklopedia</h3>
            <small class="text-sub">Manajemen Data Seluruh Kambing di Peternakan</small>
        </div>
        
        <button id="btn-tambah" class="btn btn-nova-primary px-4 py-2 d-none" onclick="window.location.href='/katalog/tambah'">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kambing
        </button> 
        
    </div>
    
    <div class="card card-katalog p-0">
        <div class="table-responsive">
            <table class="table table-nova table-hover text-center align-middle mb-0"> 
                <thead> 
                    <tr>
                        <th>No</th> 
                        <th>Foto</th> 
                        <th class="text-start">Nama Kambing</th> 
                        <th>Ras/Jenis</th> 
                        <th>Berat Awal</th> 
                        <th>Berat Sekarang</th> 
                        <th>Status</th> 
                        <th>Aksi</th> 
                    </tr>
                </thead>
                <tbody id="katalog-container"> 
                    <tr>
                        <td colspan="8" class="py-5 text-center text-sub">Memuat data dari server... <br> <small>Pastikan API Sanctum menyala</small></td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    //role dr localstorage, kebal uppercase
    const userDataStore = JSON.parse(localStorage.getItem('user') || '{}');
    const userRole = userDataStore.role ? userDataStore.role.toLowerCase() : 'guest'; 

    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('katalog-container'); 
        const token = localStorage.getItem('token');

        if (!token) {
            container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger"><i class="bi bi-x-circle fs-1"></i><br>Sesi login habis. Silakan login ulang.</td></tr>';
            return;
        }

        // role admin, munculin button tambah kambing
        if (userRole === 'admin') {
            document.getElementById('btn-tambah')?.classList.remove('d-none');
        }

        fetch('/api/kambing', {
            headers: { 
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json' 
            }
        })
        .then(response => response.json()) 
        .then(result => { 
            if(result.status === 'success') { 
                container.innerHTML = ''; 

                if (result.data.length === 0) { 
                    container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-sub"><i class="bi bi-inbox fs-1"></i><br>Kandang masih kosong.</td></tr>'; 
                    return; 
                }

                result.data.forEach((kambing, index) => { 
                    
                    let gambarUrl = '/images/default_kambing.jpg'; //fallback default
                    if (kambing.gambar) {
                        if (kambing.gambar.startsWith('http')) {
                            gambarUrl = kambing.gambar; 
                        } else {
                            gambarUrl = `/images/kambing/${kambing.gambar}`; 
                        }
                    }

                    let statusClass = kambing.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-warning text-dark'; 

                    let actionButtons = `<a href="/katalog/detail/${kambing.id_kambing}" class="btn btn-sm btn-nova-outline fw-bold mx-1"><i class="bi bi-eye"></i> Detail</a>`; 

                    if(userRole === 'admin') { 
                        actionButtons += `
                            <button class="btn btn-sm btn-danger fw-bold mx-1" onclick="deleteKambing(${kambing.id_kambing})"><i class="bi bi-trash"></i> Hapus</button> 
                        `; 
                    }

                    // render row table w kolom berat skrg
                    let rowHTML = `
                        <tr>
                            <td class="fw-bold">${index + 1}</td> 
                            <td><img src="${gambarUrl}" class="img-kambing" alt="Foto Kambing" onerror="this.onerror=null; this.src='/images/default_kambing.jpg';"></td> 
                            <td class="text-start fw-bold text-heading fs-6">${kambing.nama}</td>
                            <td><span class="badge" style="background-color: var(--icon-circle); color: var(--dark-green); border: 1px solid var(--border-divider);">${kambing.jenis}</span></td> 
                            <td class="fw-bold">${kambing.berat_awal} <small class="text-sub fw-normal">kg</small></td> 
                            
                            <td class="fw-bold text-success">${kambing.berat_sekarang ? kambing.berat_sekarang + ' <small class="text-sub fw-normal">kg</small>' : '-'}</td> 

                            <td><span class="badge ${statusClass} px-3 py-2 rounded-pill">${kambing.status_kondisi}</span></td> 
                            <td>${actionButtons}</td> 
                        </tr>
                    `; 
                    container.innerHTML += rowHTML; 
                });
            } else {
                container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger">Gagal mengambil data. Status: Bukan Success.</td></tr>'; 
            }
        })
        .catch(error => { 
            console.error('API Error:', error); 
            container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger"><i class="bi bi-exclamation-triangle fs-1"></i><br>Gagal memuat data API. Coba refresh halaman.</td></tr>'; 
        });
    });
</script>
@endsection