@extends('layouts.app')

@section('content')

<style>
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

    /* ===== Modal Hapus ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.35);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-overlay.show { display: flex; }

    .modal-box {
        background: var(--card-white);
        border-radius: 16px;
        border: 1px solid var(--border-divider);
        padding: 28px 24px;
        max-width: 380px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(27, 77, 30, 0.13);
        animation: slideUp 0.22s ease;
    }

    @keyframes slideUp {
        from { transform: translateY(24px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    .modal-box h5 {
        color: var(--heading-text);
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 16px;
    }
    .modal-box p {
        color: var(--sub-text);
        font-size: 14px;
        margin-bottom: 20px;
    }
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-cancel-modal {
        background: #F2F5F2;
        color: var(--sub-text);
        border: 1px solid var(--border-divider);
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-cancel-modal:hover { background: var(--border-divider); }

    .btn-confirm-delete {
        background: #E24B4A;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-confirm-delete:hover { background: #A32D2D; }
    .btn-confirm-delete:disabled { opacity: 0.6; cursor: not-allowed; }

    /* ===== HP: Card mode ===== */
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

<!-- Modal Konfirmasi Hapus -->
<div class="modal-overlay" id="modal-hapus-katalog">
    <div class="modal-box">
        <h5>
            <i class="bi bi-exclamation-triangle-fill" style="color:#E24B4A; margin-right:6px;"></i>
            Hapus Data Kambing?
        </h5>
        <p>Data yang dihapus tidak dapat dikembalikan. Yakin ingin menghapus kambing ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel-modal" onclick="tutupModalHapusKatalog()">Batal</button>
            <button class="btn-confirm-delete" id="btn-confirm-hapus-katalog" onclick="konfirmasiHapusKatalog()">
                <i class="bi bi-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-heading mb-0">
                <i class="bi bi-book-half" style="color: var(--medium-green);"></i> Katalog Ensiklopedia
            </h3>
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
                        <td colspan="8" class="py-5 text-center text-sub">
                            Memuat data dari server... <br>
                            <small>Pastikan API Sanctum menyala</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kambing -->
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
                        <label class="form-label small fw-bold text-sub">FOTO KAMBING (Opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" capture="environment">
                        <small class="text-muted" style="font-size: 11px;">Bisa pilih dari galeri atau langsung foto dari kamera HP.</small><br>
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

    // ===== Modal Hapus Katalog =====
    let hapusTargetId = null;

    window.deleteKambing = function(id) {
        hapusTargetId = id;
        const btn = document.getElementById('btn-confirm-hapus-katalog');
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-trash"></i> Ya, Hapus';
        document.getElementById('modal-hapus-katalog').classList.add('show');
    }

    function tutupModalHapusKatalog() {
        document.getElementById('modal-hapus-katalog').classList.remove('show');
        hapusTargetId = null;
    }

    function konfirmasiHapusKatalog() {
        if (!hapusTargetId) return;
        const btn = document.getElementById('btn-confirm-hapus-katalog');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menghapus...';

        const token = localStorage.getItem('token');
        fetch(`/api/kambing/${hapusTargetId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => {
            if (res.ok) {
                location.reload();
            } else {
                return res.json().then(data => { throw new Error(data.message || 'Gagal menghapus data.'); });
            }
        })
        .catch(err => {
            tutupModalHapusKatalog();
            alert('Gagal menghapus: ' + err.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash"></i> Ya, Hapus';
        });
    }

    // Klik luar modal = tutup
    document.getElementById('modal-hapus-katalog').addEventListener('click', function(e) {
        if (e.target === this) tutupModalHapusKatalog();
    });

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
            if (result.status === 'success') {
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

                    if (userRole === 'admin') {
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
                if (result.status === 'success') {
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
</script>
@endsection