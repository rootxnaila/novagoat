@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white fw-bold">
                    <i class="bi bi-pencil-square"></i> Edit Data Kambing
                </div>
                <div class="card-body">
                    <div id="loading-edit" class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p>Mengambil data lama...</p>
                    </div>

                    <form id="form-edit-kambing" class="d-none">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kambing</label>
                            <input type="text" id="edit-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis/Ras</label>
                            <input type="text" id="edit-jenis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Kondisi</label>
                            <select id="edit-status" class="form-select">
                                <option value="Sehat">Sehat</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="/katalog/detail/{{ $id }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const currentId = "{{ $id }}"; // Mengambil ID dari rute Laravel

    document.addEventListener("DOMContentLoaded", function() {
        // 1. Ambil data lama dulu biar form-nya nggak kosong
        fetch(`/api/kambing/${currentId}`)
            .then(res => res.json())
            .then(result => {
                if(result.status === 'success' && result.data) {
                    const k = result.data;
                    document.getElementById('edit-nama').value = k.nama;
                    document.getElementById('edit-jenis').value = k.jenis;
                    document.getElementById('edit-status').value = k.status_kondisi;
                    
                    // Sembunyikan loading, munculkan form
                    document.getElementById('loading-edit').classList.add('d-none');
                    document.getElementById('form-edit-kambing').classList.remove('d-none');
                }
            })
            .catch(err => console.error("Error ambil data:", err));

        // 2. Proses Simpan (PUT)
        const form = document.getElementById('form-edit-kambing');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const updatedData = {
                nama: document.getElementById('edit-nama').value,
                jenis: document.getElementById('edit-jenis').value,
                status_kondisi: document.getElementById('edit-status').value
            };

            fetch(`/api/kambing/${currentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': 'Bearer ' + localStorage.getItem('token') // Aktifkan kalau butuh login
                },
                body: JSON.stringify(updatedData)
            })
            .then(res => res.json())
            .then(result => {
                alert('Data berhasil diperbarui!');
                window.location.href = `/katalog/detail/${currentId}`;
            })
            .catch(err => alert('Gagal update data!'));
        });
    });
</script>
@endsection