@extends('layouts.app')

@section('content')
<style>
    .card-img-top-equal {
        height: 250px; 
        object-fit: cover; 
    }
</style>

<div class="container mt-5">
    <h2 class="mb-4">Ensiklopedia Kambing</h2>
    
    <div class="row row-cols-1 row-cols-md-3 g-4" id="katalog-container">
        <div class="col-12" id="loading-text">
            <p class="text-muted">Sedang memuat data kambing dari kandang...</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('katalog-container');
        const loading = document.getElementById('loading-text');

        fetch('/api/kambing')
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success') {
                    if(loading) loading.remove();
                    
                    container.innerHTML = '';

                    result.data.forEach(kambing => {
                        
                        let gambarUrl = kambing.gambar.startsWith('http') 
                            ? kambing.gambar 
                            : 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg';

                        let cardHTML = `
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <img src="${gambarUrl}" class="card-img-top-equal" alt="Foto ${kambing.nama}">
                                    <div class="card-body">
                                        <h5 class="card-title">${kambing.nama}</h5>
                                        <p class="card-text text-muted mb-1">Ras: ${kambing.jenis}</p>
                                        <p class="card-text mb-1"><strong>Berat Awal:</strong> ${kambing.berat_awal} kg</p>
                                        <p class="card-text"><strong>Status:</strong> ${kambing.status_kondisi}</p>
                                    </div>
                                    <div class="card-footer text-center bg-white border-top-0 pb-3">
                                        <button class="btn btn-outline-primary btn-sm" onclick="alert('Nanti ini buka detail ID: ${kambing.id_kambing}')">Detail</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        container.innerHTML += cardHTML;
                    });
                }
            })
            .catch(error => {
                console.error('Waduh, ada error ambil data:', error);
                container.innerHTML = '<p class="text-danger">Gagal memuat data kambing. Cek koneksi API.</p>';
            });
    });
</script>
@endsection