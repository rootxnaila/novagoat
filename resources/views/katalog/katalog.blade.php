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

        fetch('/api/kambing')
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success') {
                    container.innerHTML = ''; 

                    if (result.data.length === 0) {
                        container.innerHTML = '<div class="col-12"><p class="alert alert-warning">Kandang kosong, belum ada data kambing.</p></div>';
                        return;
                    }

                    result.data.forEach(kambing => {
                        
                        let gambarUrl = (kambing.gambar && typeof kambing.gambar === 'string' && kambing.gambar.startsWith('http')) 
                            ? kambing.gambar 
                            : 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg';

                        let cardHTML = `
                            <div class="col">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="${gambarUrl}" class="card-img-top-equal rounded-top" alt="Foto ${kambing.nama}">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">${kambing.nama}</h5>
                                        <p class="card-text text-muted mb-1">Ras: ${kambing.jenis}</p>
                                        <p class="card-text mb-1"><strong>Berat Awal:</strong> ${kambing.berat_awal} kg</p>
                                        <p class="card-text"><strong>Status:</strong> 
                                            <span class="badge ${kambing.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger'}">
                                                ${kambing.status_kondisi}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="card-footer text-center bg-white border-top-0 pb-3">
                                        <a href="/katalog/detail/${kambing.id_kambing}" class="btn btn-outline-primary btn-sm w-100">Lihat Detail</a>
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
                container.innerHTML = '<div class="col-12"><p class="alert alert-danger">Gagal memuat data API. Cek terminal atau database!</p></div>';
            });
    });
</script>
@endsection