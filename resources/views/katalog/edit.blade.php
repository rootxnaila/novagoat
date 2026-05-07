@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --green-dark:    #1B4D1E;
        --green-medium:  #2E7D32;
        --green-button:  #3D7A40;
        --green-light:   #A5C8A7;
        --green-pale:    #D6EDD7;
        --bg-page:       #E8EDEA;
        --bg-card:       #FFFFFF;
        --bg-input:      #F2F5F2;
        --text-heading:  #1A2E1A;
        --text-sub:      #4A6B4C;
        --border-color:  #D0DDD1;
    }

    body {
        background-color: var(--bg-page) !important;
        color: var(--text-heading);
        min-height: 100vh;
    }

    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color) !important;
        border-radius: 16px !important;
    }

    .card-header {
        background-color: var(--green-button) !important;
        color: var(--green-pale) !important;
        border-bottom: 1px solid var(--border-color) !important;
        border-radius: 16px 16px 0 0 !important;
        font-size: 14px;
        font-weight: 500;
    }

    .form-label {
        color: var(--text-sub);
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .form-control, .form-select {
        background-color: var(--bg-input) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-heading) !important;
        border-radius: 8px !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--green-button) !important;
        box-shadow: 0 0 0 3px rgba(61, 122, 64, 0.15) !important;
    }

    .form-control::placeholder {
        color: #9BB09C !important;
    }

    hr {
        border-color: var(--border-color);
        opacity: 1;
    }

    .btn-batal {
        background-color: var(--bg-input);
        color: var(--text-sub);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        text-decoration: none;
    }

    .btn-batal:hover {
        background-color: var(--border-color);
        color: var(--text-heading);
    }

    .btn-simpan {
        background-color: var(--green-button);
        color: var(--green-pale);
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
    }

    .btn-simpan:hover {
        background-color: var(--green-medium);
        color: var(--green-pale);
    }

    .spinner-border {
        color: var(--green-button) !important;
    }

    .alert-error {
        background-color: #FCEBEB;
        color: #791F1F;
        border: 1px solid #F09595;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
    }

    p.loading-text {
        color: var(--text-sub);
        font-size: 13px;
        margin-top: 8px;
    }
</style>

<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> Edit Data Kambing
                </div>
                <div class="card-body">

                    <div id="loading-edit" class="text-center py-4">
                        <div class="spinner-border" role="status"></div>
                        <p class="loading-text">Mengambil data lama...</p>
                    </div>

                    <div id="error-edit" class="d-none alert-error mb-3">
                        Gagal mengambil data. Pastikan kamu sudah login.
                    </div>

                    <form id="form-edit-kambing" class="d-none">
                        <div class="mb-3">
                            <label class="form-label">Nama Kambing</label>
                            <input type="text" id="edit-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis/Ras</label>
                            <input type="text" id="edit-jenis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kondisi</label>
                            <select id="edit-status" class="form-select">
                                <option value="Sehat">Sehat</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="/katalog/detail/{{ $id }}" class="btn-batal">Batal</a>
                            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const currentId  = "{{ $id }}";
    const token      = localStorage.getItem('token');
    const apiHeaders = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
    };

    document.addEventListener("DOMContentLoaded", function() {

        fetch(`/api/kambing/${currentId}`, { headers: apiHeaders })
            .then(res => {
                if (!res.ok) throw new Error('Unauthorized atau data tidak ditemukan');
                return res.json();
            })
            .then(result => {
                if (result.status === 'success' && result.data) {
                    const k = result.data;
                    document.getElementById('edit-nama').value   = k.nama;
                    document.getElementById('edit-jenis').value  = k.jenis;
                    document.getElementById('edit-status').value = k.status_kondisi;

                    document.getElementById('loading-edit').classList.add('d-none');
                    document.getElementById('form-edit-kambing').classList.remove('d-none');
                }
            })
            .catch(err => {
                document.getElementById('loading-edit').classList.add('d-none');
                document.getElementById('error-edit').classList.remove('d-none');
                console.error("Error ambil data:", err);
            });

        const form = document.getElementById('form-edit-kambing');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const updatedData = {
                nama:           document.getElementById('edit-nama').value,
                jenis:          document.getElementById('edit-jenis').value,
                status_kondisi: document.getElementById('edit-status').value
            };

            fetch(`/api/kambing/${currentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(updatedData)
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal update');
                return res.json();
            })
            .then(() => {
                alert('Data berhasil diperbarui!');
                window.location.href = `/katalog/detail/${currentId}`;
            })
            .catch(() => alert('Gagal update data! Cek koneksi atau login ulang.'));
        });
    });
</script>
@endsection