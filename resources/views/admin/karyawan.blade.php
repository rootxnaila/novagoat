@extends('layouts.app') 

@section('content')
<style>
    /*palette novagoat */
    :root {
        /* primer */
        --dark-green: #1B4D1E;
        --medium-green: #2E7D32;
        --button-green: #3D7A40;
        --light-green: #A5C8A7;
        --pale-mint: #D6EDD7;
        
        /* netral n bg */
        --card-white: #FFFFFF;
        --page-bg: #E8EDEA;
        --input-bg: #F2F5F2;
        --icon-circle: #C8DAC9;
        --shadow-muted: #B0BEB1;
        
        /* typography */
        --heading-text: #1A2E1A;
        --sub-text: #4A6B4C;
        --placeholder-text: #9BB09C;
        --border-divider: #D0DDD1;
    }

    /* override bg */
    body {
        background-color: var(--page-bg) !important;
    }

    /* typografi */
    .text-heading { color: var(--heading-text) !important; }
    .text-sub { color: var(--sub-text) !important; }

    /* custom button */
    .btn-nova {
        background-color: var(--button-green);
        color: var(--card-white);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-nova:hover {
        background-color: var(--medium-green);
        color: var(--card-white);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px var(--shadow-muted);
    }

    .card-nova {
        background-color: var(--card-white);
        border: 1px solid var(--border-divider);
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(176, 190, 177, 0.4); /*shadow muted*/
    }
    .table-nova thead th {
        background-color: var(--dark-green) !important;
        color: var(--card-white) !important;
        border-bottom: none;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .table-nova tbody td {
        color: var(--sub-text);
        border-bottom: 1px solid var(--border-divider);
        vertical-align: middle;
    }

    .badge-timbang {
        background-color: var(--pale-mint);
        color: var(--dark-green);
        border: 1px solid var(--light-green);
    }
    .badge-medis {
        background-color: var(--icon-circle);
        color: var(--heading-text);
    }

    .form-nova {
        background-color: var(--input-bg);
        border: 1px solid var(--border-divider);
        color: var(--heading-text);
    }
    .form-nova::placeholder {
        color: var(--placeholder-text);
    }
    .form-nova:focus {
        background-color: var(--card-white);
        border-color: var(--medium-green);
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
    }
    .input-group-text-nova {
        background-color: var(--icon-circle);
        border: 1px solid var(--border-divider);
        color: var(--dark-green);
        border-right: none;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-heading mb-0"><i class="bi bi-people-fill" style="color: var(--medium-green);"></i> Kinerja Karyawan</h3>
            <small class="text-sub">Monitoring aktivitas operasional Anak Kandang</small>
        </div>
        <button class="btn btn-nova px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Karyawan
        </button>
    </div>

<div class="card card-nova overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-nova table-hover text-center mb-0">
                    <thead>
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3 text-start">Username</th>
                            <th class="py-3">Kambing Ditimbang</th>
                            <th class="py-3">Medis Diselesaikan</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelKinerja">
                        <tr><td colspan="5" class="py-4 text-sub">Memuat data dari server...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-nova" style="border: none;">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-divider); background-color: var(--page-bg); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title fw-bold text-heading">
                    <i class="bi bi-person-plus-fill me-2" style="color: var(--medium-green);"></i>Tambah Anak Kandang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: var(--card-white); border-radius: 0 0 12px 12px;">
                <form id="formTambahKaryawan">
                    <div class="mb-4">
                        <label for="usernameBaru" class="form-label text-sub small fw-bold text-uppercase tracking-wide">Username</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-nova"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control form-nova border-start-0" id="usernameBaru" placeholder="Ketik username baru..." required>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="passwordBaru" class="form-label text-sub small fw-bold text-uppercase tracking-wide">Password</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-nova"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control form-nova border-start-0" id="passwordBaru" placeholder="Ketik password..." required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-nova w-100 fw-bold py-2 fs-5">
                        <i class="bi bi-save me-2"></i>Simpan Akun Baru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('token');
    if (!token) { window.location.href = '/login'; }

    // FETCH DATA KINERJA KARYAWAN
    fetch('/api/karyawan/kinerja', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(result => {
        const tbody = document.getElementById('tabelKinerja');
        tbody.innerHTML = ''; 

        if (result.data && result.data.length > 0) {
            result.data.forEach((karyawan, index) => {
                let row = `
                    <tr>
                        <td class="py-3">${index + 1}</td>
                        <td class="py-3 text-start fw-bold text-heading"><i class="bi bi-person-circle text-sub me-2"></i>${karyawan.username}</td>
                        <td class="py-3"><span class="badge badge-timbang fs-6 px-3 py-2 rounded-pill">${karyawan.log_berat_count} Kali</span></td>
                        <td class="py-3"><span class="badge badge-medis fs-6 px-3 py-2 rounded-pill">${karyawan.jadwal_medis_count} Tindakan</span></td>
                        <td class="py-3">
                            <button class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="nonaktifkanKaryawan(${karyawan.id_user})">
                                <i class="bi bi-slash-circle me-1"></i>Nonaktifkan
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="py-4 text-sub">Belum ada data Anak Kandang.</td></tr>';
        }
    })
    .catch(error => {
        document.getElementById('tabelKinerja').innerHTML = '<tr><td colspan="5" class="py-4 text-danger">Gagal memuat data.</td></tr>';
    });

    // FUNGSI SIMPAN KARYAWAN
    document.getElementById('formTambahKaryawan').addEventListener('submit', function(e) {
        e.preventDefault(); 
        let username = document.getElementById('usernameBaru').value;
        let password = document.getElementById('passwordBaru').value;

        fetch('/api/register', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify({
                username: username,
                password: password,
                role: 'anak_kandang'
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success' || data.user) {
                alert('Karyawan berhasil ditambahkan!');
                location.reload(); 
            } else {
                alert('Gagal menambahkan karyawan. Username mungkin sudah dipakai!');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // FUNGSI NONAKTIFKAN KARYAWAN
    window.nonaktifkanKaryawan = function(id_user) {
        if (!confirm('Yakin ingin menonaktifkan (menghapus akses) karyawan ini?')) {
            return; 
        }

        fetch(`/api/karyawan/${id_user}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                alert('Akses karyawan berhasil ditutup!');
                location.reload(); // otomaatis refresh biar data di tabel hilang
            } else {
                alert('Gagal: ' + result.message);
            }
        })
        .catch(error => {
            console.error('API Error:', error);
            alert('Terjadi kesalahan pada server saat memproses data.');
        });
    };
</script>
@endsection