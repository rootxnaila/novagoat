@extends('layouts.app')

@section('content')
<div class="container mt-5 text-white"> 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Katalog Ensiklopedia Kambing</h2> 
        @if(Auth::user() && Auth::user()->role === 'admin') 
            <button class="btn btn-primary" onclick="window.location.href='/katalog/tambah'">+ Tambah Kambing</button> 
        @endif
    </div>
    
    <div class="table-responsive bg-dark p-3 rounded shadow" style="border: 1px solid #333;">
        <table class="table table-dark table-hover align-middle mb-0"> 
            <thead> 
                <tr>
                    <th>No</th> 
                    <th>Foto</th> 
                    <th>Nama</th> 
                    <th>Ras/Jenis</th> 
                    <th>Berat Awal</th> 
                    <th>Status</th> 
                    <th class="text-center">Aksi</th> 
                </tr>
            </thead>
            <tbody id="katalog-container"> 
                <tr>
                    <td colspan="7" class="text-center text-muted">Sedang memuat data kambing...</td> 
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const userRole = "{{ Auth::user() ? Auth::user()->role : 'guest' }}"; 

    document.addEventListener("DOMContentLoaded", function() { // wait page beres
        const container = document.getElementById('katalog-container'); 

        fetch('/api/kambing', {
            headers: { 
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json' 
            }
        })
            .then(response => response.json()) 
            .then(result => { 
                if(result.status === 'success') { 
                    container.innerHTML = ''; //clear loading

                    if (result.data.length === 0) { //kalo data kosong stop
                        container.innerHTML = '<tr><td colspan="7" class="text-center text-warning">Kandang kosong.</td></tr>'; //pesankosong
                        return; 
                    }

                    result.data.forEach((kambing, index) => { //looping data wedus
                        
                        let gambarUrl = (kambing.gambar && typeof kambing.gambar === 'string' && kambing.gambar.startsWith('http')) ? kambing.gambar : 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg'; //setgambarfallback

                        let statusClass = kambing.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger'; //warnabadge

                        let actionButtons = `<a href="/katalog/detail/${kambing.id_kambing}" class="btn btn-sm btn-info text-white">Detail</a>`; //tombolwajibsemuarole

                        if(userRole === 'admin') { //cek if admin
                            actionButtons += `
                                <button class="btn btn-sm btn-warning text-dark mx-1" onclick="window.location.href='/katalog/edit/${kambing.id_kambing}'">Edit</button> 
                                <button class="btn btn-sm btn-danger" onclick="deleteKambing(${kambing.id_kambing})">Hapus</button> 
                            `; //add button danger
                        }

                        let rowHTML = `
                            <tr>
                                <td>${index + 1}</td> 
                                <td><img src="${gambarUrl}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"></td> 
                                <td class="fw-bold">${kambing.nama}</td>
                                <td>${kambing.jenis}</td> 
                                <td>${kambing.berat_awal} kg</td> 
                                <td><span class="badge ${statusClass}">${kambing.status_kondisi}</span></td> 
                                <td class="text-center">${actionButtons}</td> 
                            </tr>
                        `; 
                        container.innerHTML += rowHTML; 
                    });
                }
            })
            .catch(error => { //catch error
                console.error('Waduh, ada error:', error); //log error diconsole
                container.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Gagal memuat data API.</td></tr>'; //tampilkanpesanerror
            });
    });
</script>
@endsection