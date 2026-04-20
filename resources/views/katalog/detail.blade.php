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

<script>
    let currentId = window.location.pathname.split('/').pop();

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
                }
            })
            .catch(err => alert('Gagal mengambil data detail: ' + err));
    });

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