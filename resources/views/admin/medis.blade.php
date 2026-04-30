@extends('layouts.app')

@section('content')
<div class="container-fluid px-4" style="padding-top: 20px; padding-bottom: 100px; background-color: #000; min-height: 100vh;">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5 px-2">
        <div>
            <h2 class="text-white fw-bold">Jadwal Medis & Vaksin</h2>
            <p class="text-secondary mb-0 font-monospace" style="font-size: 0.85rem;">Monitoring kesehatan dan jadwal imunisasi ternak.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <select id="kambingSelect" class="form-select form-select-sm bg-black text-white border-secondary" style="width: 220px; min-width: 180px;">
                <option value="" disabled selected>Pilih Kambing...</option>
            </select>
            <button class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow" data-bs-toggle="modal" data-bs-target="#modalJadwalMedis">+ JADWAL MEDIS</button>
            <button class="btn btn-info btn-sm rounded-pill px-3 fw-bold text-dark shadow" data-bs-toggle="modal" data-bs-target="#modalInputBerat">+ INPUT BERAT</button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4 px-2">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Total Catatan</small>
                <h3 id="statTotal" class="text-white fw-bold mb-0">-</h3>
                <small class="text-info" style="font-size: 0.65rem;">Seluruh entri log berat.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Berat Terakhir</small>
                <h3 id="statTerakhir" class="text-white fw-bold mb-0">- kg</h3>
                <small class="text-success" style="font-size: 0.65rem;">Data terupdate.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 shadow" style="border-radius: 15px;">
                <small class="text-secondary text-uppercase" style="font-size: 0.7rem;">Rata-rata Berat</small>
                <h3 id="statAvg" class="text-white fw-bold mb-0">- kg</h3>
                <small class="text-warning" style="font-size: 0.65rem;">Periode ini.</small>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="row g-3 px-2">
        <div class="col-lg-8">
            <div class="card bg-dark border-secondary shadow" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-dark border-secondary py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-info" style="font-size: 0.8rem;">Grafik Monitor Berat Badan Kambing</h6>
                    <div class="d-flex align-items-center bg-black px-3 py-1 rounded-pill" style="border: 1px solid #333;">
                        <div style="width: 10px; height: 10px; background: #00fbff; border-radius: 2px; margin-right: 8px;"></div>
                        <span class="text-white" style="font-size: 10px;">BERAT BADAN (KG)</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 350px;">
                        <canvas id="medisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark border-secondary shadow h-100" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary py-3 border-0 text-center">
                    <h6 class="m-0 fw-bold text-white" style="font-size: 0.8rem;">AGENDA VAKSIN MENDATANG</h6>
                </div>
                <div id="jadwalList" class="card-body p-3 overflow-auto" style="max-height: 450px;">
                    </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
{{-- Modal Input Berat --}}
<div class="modal fade" id="modalInputBerat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold">Input Data Timbangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formInputBerat">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">TANGGAL TIMBANG</label>
                        <input type="date" name="tanggal" class="form-control bg-black border-secondary text-white shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">BERAT (KG)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="berat" class="form-control bg-black border-secondary text-white shadow-none" placeholder="25.5" required>
                            <span class="input-group-text bg-secondary border-secondary text-white">kg</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-info rounded-pill px-4 fw-bold text-dark">Simpan Berat</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah Jadwal Medis --}}
<div class="modal fade" id="modalJadwalMedis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold">Tambah Jadwal Medis / Vaksin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJadwalMedis">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">TANGGAL RENCANA</label>
                        <input type="date" name="tanggal_rencana" class="form-control bg-black border-secondary text-white shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">JENIS TINDAKAN / VAKSIN</label>
                        <input type="text" name="jenis_tindakan" class="form-control bg-black border-secondary text-white shadow-none" placeholder="Contoh: Vaksin PMK, Pemberian Vitamin" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-warning rounded-pill px-4 fw-bold text-dark">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js" async></script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const ctx = document.getElementById('medisChart').getContext('2d');
        const kambingSelect = document.getElementById('kambingSelect');
        const formInputBerat = document.getElementById('formInputBerat');
        const formJadwalMedis = document.getElementById('formJadwalMedis');
        const jadwalList = document.getElementById('jadwalList');

        const authHeaders = {
            'Authorization': `Bearer ${localStorage.getItem('token_sakti')}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };

        // UI Loading States
        document.getElementById('statTotal').innerHTML = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
        document.getElementById('statTerakhir').innerHTML = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
        document.getElementById('statAvg').innerHTML = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
        jadwalList.innerHTML = '<p class="text-secondary text-center mt-4"><span class="spinner-border spinner-border-sm"></span> Memuat jadwal...</p>';
        kambingSelect.innerHTML = '<option disabled selected>Memuat data kambing...</option>';

        let medisChart = null;
        let pendingChartData = null;

        const tryInitChart = () => {
            // Tunggu sampai Chart.js selesai didownload (karena pakai async)
            if (typeof Chart === 'undefined') {
                setTimeout(tryInitChart, 100);
                return;
            }
            try {
                medisChart = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [{ 
                        label: 'Berat (Kg)', data: [], borderColor: '#00fbff', tension: 0.4, fill: true, backgroundColor: 'rgba(0, 251, 255, 0.1)' 
                    }]},
                    options: { responsive: true, maintainAspectRatio: false }
                });
                
                // Jika data sudah tiba lebih dulu daripada Chart.js, langsung gambar
                if (pendingChartData) {
                    updateChart(pendingChartData);
                }
            } catch(e) {
                console.error("Gagal memuat Chart.js:", e);
            }
        };
        tryInitChart();

        const updateChart = (data) => {
            if (!medisChart) {
                // Simpan data sementara jika Chart.js masih proses download
                pendingChartData = data;
                return;
            }
            medisChart.data.labels = data.map(i => i.tanggal_timbang);
            medisChart.data.datasets[0].data = data.map(i => i.berat_sekarang);
            medisChart.update();

            document.getElementById('statTotal').innerText = data.length;
            document.getElementById('statTerakhir').innerText = data.length ? data[data.length-1].berat_sekarang + ' kg' : '-';
            const avg = data.length ? (data.reduce((a, b) => a + parseFloat(b.berat_sekarang), 0) / data.length).toFixed(1) : 0;
            document.getElementById('statAvg').innerText = avg + ' kg';
        };

        const loadChartData = async (id) => {
            try {
                let res = await fetch(`/api/grafik-berat/${id}`);
                res = await res.json();
                updateChart(res.data || []);
            } catch(e) { console.error("Gagal load grafik:", e); }
        };

        const renderJadwal = (data) => {
            // Filter jadwal yang belum selesai saja
            const upcoming = data.filter(item => (item.status || '').toLowerCase() !== 'selesai');

            jadwalList.innerHTML = upcoming.length ? '' : '<p class="text-secondary text-center mt-4">Tidak ada jadwal medis</p>';
            upcoming.forEach(item => {
                // Gunakan id_jadwal karena itu primary key di database Anda
                const id = item.id_jadwal || item.id; 
                jadwalList.innerHTML += `
                    <div class="p-3 mb-3 shadow-sm position-relative" id="jadwal-${id}" style="background: rgba(255,255,255,0.03); border-radius: 12px; border-left: 4px solid #00fbff;">
                        <small class="text-info fw-bold d-block mb-1">${item.tanggal_rencana || item.tanggal || '-'}</small>
                        <h6 class="text-white fw-bold mb-0">${item.jenis_tindakan || item.kegiatan || '-'}</h6>
                        <button onclick="updateStatus(${id})" class="btn btn-sm btn-outline-success position-absolute end-0 top-50 translate-middle-y me-2" style="font-size: 10px;" title="Tandai Selesai">✓</button>
                    </div>
                `;
            });
        };

        const loadJadwal = async () => {
            try {
                let res = await fetch('/api/jadwal-medis', { headers: authHeaders });
                res = await res.json();
                renderJadwal(res.data || []);
            } catch(e) { console.error("Gagal load jadwal:", e); }
        };

        const loadKambing = async () => {
            try {
                let res = await fetch('/api/kambing');
                res = await res.json();
                const list = res.data || [];
                kambingSelect.innerHTML = '<option disabled selected>Pilih Kambing...</option>';
                list.forEach(k => {
                    kambingSelect.innerHTML += `<option value="${k.id_kambing}">${k.nama || 'Kambing #'+k.id_kambing}</option>`;
                });
                if(list.length) {
                    kambingSelect.value = list[0].id_kambing;
                    loadChartData(list[0].id_kambing);
                } else {
                    updateChart([]); // Kosongkan chart jika tidak ada kambing
                }
            } catch(e) { console.error("Gagal load kambing:", e); }
        };

        // Listeners
        kambingSelect.addEventListener('change', (e) => loadChartData(e.target.value));

        formInputBerat.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = kambingSelect.value;
            if(!id) return alert('Pilih kambing terlebih dahulu!');

            try {
                await fetch(`/api/kambing/${id}/timbang`, {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify({ berat: e.target.berat.value, tanggal: e.target.tanggal.value })
                });
                bootstrap.Modal.getInstance(document.getElementById('modalInputBerat')).hide();
                formInputBerat.reset();
                loadChartData(id);
            } catch(e) { console.error("Gagal simpan berat:", e); }
        });

        formJadwalMedis.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = kambingSelect.value;
            if(!id) return alert('Pilih kambing terlebih dahulu!');

            try {
                await fetch('/api/jadwal-medis', {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify({ 
                        id_kambing: id,
                        jenis_tindakan: e.target.jenis_tindakan.value, 
                        tanggal_rencana: e.target.tanggal_rencana.value 
                    })
                });
                bootstrap.Modal.getInstance(document.getElementById('modalJadwalMedis')).hide();
                formJadwalMedis.reset();
                loadJadwal();
            } catch(e) { console.error("Gagal simpan jadwal:", e); }
        });

        window.updateStatus = async (id) => {
            if (confirm('Apakah vaksin / tindakan medis ini sudah dilakukan? Jika iya, jadwal ini akan dihapus dari daftar.')) {
                try {
                    // 1. Kirim perintah hapus ke database
                    const response = await fetch(`/api/jadwal-medis/${id}`, { 
                        method: 'DELETE', 
                        headers: authHeaders 
                    });
                    
                    if (response.ok) {
                        // 2. Langsung hapus elemen dari layar secara instan (UI feedback)
                        const element = document.getElementById(`jadwal-${id}`);
                        if (element) {
                            element.style.transition = "all 0.3s ease";
                            element.style.opacity = "0";
                            element.style.transform = "translateX(20px)";
                            setTimeout(() => {
                                element.remove();
                                // Cek jika sudah kosong tampilkan pesan "Tidak ada jadwal"
                                if (jadwalList.children.length === 0) {
                                    jadwalList.innerHTML = '<p class="text-secondary text-center mt-4">Tidak ada jadwal medis</p>';
                                }
                            }, 300);
                        }
                    } else {
                        const errData = await response.json();
                        alert('Gagal menghapus: ' + (errData.message || 'Error tidak dikenal'));
                    }
                } catch(e) { 
                    console.error("Gagal update status:", e);
                    alert('Terjadi kesalahan koneksi saat mencoba menghapus.');
                }
            }
        };

        // Start Fetching Data
        loadKambing();
        loadJadwal();
    });
</script>
@endsection