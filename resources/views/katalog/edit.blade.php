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

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 100px 16px 60px;
    }

    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(176,190,177,0.25);
        width: 100%;
        max-width: 520px;
        overflow: hidden;
    }

    .form-card-header {
        background-color: var(--green-button);
        color: var(--green-pale);
        padding: 14px 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .form-card-body {
        padding: 24px 20px;
    }

    .form-label {
        color: var(--text-sub);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
        display: block;
    }

    .form-control, .form-select {
        background-color: var(--bg-input) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-heading) !important;
        border-radius: 8px !important;
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s;
        box-sizing: border-box;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--green-button) !important;
        box-shadow: 0 0 0 3px rgba(61, 122, 64, 0.15) !important;
        background-color: #fff !important;
    }

    .form-control::placeholder {
        color: #9BB09C !important;
    }

    hr {
        border-color: var(--border-color);
        opacity: 1;
        margin: 20px 0;
    }

    .footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-batal {
        background-color: var(--bg-input);
        color: var(--text-sub);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        padding: 8px 18px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.18s;
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
        padding: 8px 18px;
        cursor: pointer;
        transition: background 0.18s;
    }

    .btn-simpan:hover {
        background-color: var(--green-medium);
        color: var(--green-pale);
    }

    .btn-simpan:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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
        margin-bottom: 16px;
    }

    .loading-text {
        color: var(--text-sub);
        font-size: 13px;
        margin-top: 8px;
    }

    /* HP: padding lebih kecil */
    @media (max-width: 480px) {
        .form-card-body {
            padding: 18px 14px;
        }
        .footer-actions {
            flex-direction: column-reverse;
        }
        .btn-batal, .btn-simpan {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="page-wrapper">
    <div class="form-card">
        <div class="form-card-header">
            <i class="bi bi-pencil-square me-1"></i> Edit Data Kambing
        </div>
        <div class="form-card-body">

            <div id="loading-edit" class="text-center py-4">
                <div class="spinner-border" role="status"></div>
                <p class="loading-text">Mengambil data lama...</p>
            </div>

            <div id="error-edit" class="d-none alert-error">
                Gagal mengambil data. Pastikan kamu sudah login.
            </div>

            <form id="form-edit-kambing" class="d-none">
                <div class="mb-3">
                    <label class="form-label">Nama Kambing</label>
                    <input type="text" id="edit-nama" class="form-control" placeholder="Nama kambing" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis/Ras</label>
                    <input type="text" id="edit-jenis" class="form-control" placeholder="Contoh: Etawa" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Kondisi</label>
                    <select id="edit-status" class="form-select">
                        <option value="Sehat">Sehat</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Karantina">Karantina</option>
                    </select>
                </div>
                <hr>
                <div class="footer-actions">
                    <a href="/katalog/detail/{{ $id }}" class="btn-batal">Batal</a>
                    <button type="submit" class="btn-simpan" id="btn-submit">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

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

        document.getElementById('form-edit-kambing').addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

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
            .catch(() => {
                alert('Gagal update data! Cek koneksi atau login ulang.');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Perubahan';
            });
        });
    });
</script>
@endsection