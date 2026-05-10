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

    /* ===== RESPONSIVE: Card mode di HP ===== */
    @media (max-width: 768px) {
        .table-nova thead {
            display: none;
        }
        .table-nova tbody tr {
            display: block;
            margin-bottom: 12px;
            border-radius: 12px;
            border: 1px solid var(--border-divider);
            box-shadow: 0 2px 8px rgba(176,190,177,0.3);
            background: var(--card-white);
            padding: 10px;
        }
        .table-nova tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed var(--border-divider);
            padding: 8px 10px;
            text-align: right;
        }
        .table-nova tbody td:last-child {
            border-bottom: none;
        }
        .table-nova tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--dark-green);
            text-align: left;
            flex-shrink: 0;
            margin-right: 10px;
            font-size: 13px;
        }
        .table-nova tbody td.td-foto {
            justify-content: center;
        }
        .table-nova tbody td.td-foto::before {
            display: none;
        }
        .table-nova tbody td.td-aksi {
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
        }
        .table-nova tbody td.td-aksi::before {
            display: none;
        }
    }
</style>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-heading mb-0"><i class="bi bi-book-half" style="color: var(--medium-green);"></i> Katalog Ensiklopedia</h3>
            <small class="text-sub">Manajemen Data Seluruh Kambing di Peternakan</small>
        </div>

        <button id="btn-tambah" class="btn btn-nova-primary px-4 py-2 d-none" data-bs-toggle="modal" data-bs-target="#modalTambahKambing">
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

<div class="modal fade" id="modalTambahKambing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom" style="background-color: var(--page-bg);">
                <h5 class="modal-title fw-bold text-heading">
                    <i class="bi bi-plus-circle-fill me-2" style="color: var(--medium-green);"></i>Tambah Kambing Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahKambing">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-sub">NAMA KAMBING</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Mbek Alpha" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-sub">JENIS / RAS</label>
                        <select name="jenis" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Jenis Kambing --</option>
                            <option value="Boer">Boer</option>
                            <option value="Boerka">Boerka</option>
                            <option value="Etawa">Etawa</option>
                            <option value="PE">PE (Peranakan Etawa)</option>
                            <option value="Kacang">Kambing Kacang</option>
                            <option value="Senduro">Senduro</option>
                            <option value="Lainnya">Lainnya / Campuran</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-sub">BERAT AWAL (KG)</label>
                            <input type="number" step="0.1" name="berat_awal" class="form-control" placeholder="0.0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-sub">STATUS KONDISI</label>
                            <select name="status_kondisi" class="form-select" required>
                                <option value="Sehat">Sehat</option>
                                <option value="Sakit">Sakit / Perawatan</option>
                                <option value="Karantina">Karantina</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-sub">URL GAMBAR (Opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" capture="environment">
                        <small class="text-muted" style="font-size: 11px;">Bisa pilih dari galeri atau langsung foto dari kamera HP.</small>
                        <small class="text-muted" style="font-size: 11px;">Kosongkan jika ingin pakai gambar default.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-nova-primary px-4 rounded-pill shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const userDataStore = JSON.parse(localStorage.getItem('user') || '{}');
    const userRole = userDataStore.role ? userDataStore.role.toLowerCase() : 'guest';

    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('katalog-container');
        const token = localStorage.getItem('token');

        if (!token) {
            container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger"><i class="bi bi-x-circle fs-1"></i><br>Sesi login habis. Silakan login ulang.</td></tr>';
            return;
        }

        if (userRole === 'admin' || userRole === 'anak_kandang') {
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
                    let gambarUrl = '/images/default_kambing.jpg';
                    if (kambing.gambar) {
                        gambarUrl = kambing.gambar.startsWith('http') ? kambing.gambar : `/images/kambing/${kambing.gambar}`;
                    }

                    let statusClass = kambing.status_kondisi === 'Sehat' ? 'bg-success' : 'bg-danger';

                    let actionButtons = `<a href="/katalog/detail/${kambing.id_kambing}" class="btn btn-sm btn-nova-outline fw-bold mx-1"><i class="bi bi-eye"></i> Detail</a>`;

                    if(userRole === 'admin') {
                        actionButtons += `<button class="btn btn-sm btn-danger fw-bold mx-1" onclick="deleteKambing(${kambing.id_kambing})"><i class="bi bi-trash"></i> Hapus</button>`;
                    }

                    let rowHTML = `
                        <tr>
                            <td class="fw-bold" data-label="No">${index + 1}</td>
                            <td class="td-foto"><img src="${gambarUrl}" class="img-kambing" alt="Foto" onerror="this.onerror=null; this.src='/images/default_kambing.jpg';"></td>
                            <td class="text-start fw-bold text-heading fs-6" data-label="Nama">${kambing.nama}</td>
                            <td data-label="Ras/Jenis"><span class="badge" style="background-color: var(--icon-circle); color: var(--dark-green); border: 1px solid var(--border-divider);">${kambing.jenis}</span></td>
                            <td class="fw-bold" data-label="Berat Awal">${kambing.berat_awal} <small class="text-sub">kg</small></td>
                            <td class="fw-bold text-success" data-label="Berat Skrg">${kambing.berat_sekarang ? kambing.berat_sekarang + ' <small class="text-sub">kg</small>' : '-'}</td>
                            <td data-label="Status"><span class="badge ${statusClass} px-3 py-2 rounded-pill">${kambing.status_kondisi}</span></td>
                            <td class="td-aksi">${actionButtons}</td>
                        </tr>`;
                    container.innerHTML += rowHTML;
                });
            } else {
                container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger">Gagal mengambil data.</td></tr>';
            }
        })
        .catch(error => {
            console.error('API Error:', error);
            container.innerHTML = '<tr><td colspan="8" class="py-5 text-center text-danger">Gagal memuat data API.</td></tr>';
        });

        document.getElementById('formTambahKambing')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btnSubmit = this.querySelector('button[type="submit"]');
            const originalText = btnSubmit.innerHTML;

            btnSubmit.innerHTML = 'Mengupload...';
            btnSubmit.disabled = true;

            fetch('/api/kambing', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success') {
                    alert('Kambing & Foto berhasil ditambahkan!');
                    location.reload();
                } else {
                    alert(result.message || 'Cek kembali data form');
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error Save:', error);
                alert('Terjadi kesalahan pada server.');
                btnSubmit.innerHTML = originalText;
                btnSubmit.disabled = false;
            });
        });
    });

    window.deleteKambing = function(id) {
        if(!confirm('Yakin mau hapus kambing ini?')) return;
        const token = localStorage.getItem('token');
        fetch(`/api/kambing/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        })
        .then(() => location.reload());
    }
</script>
@endsection