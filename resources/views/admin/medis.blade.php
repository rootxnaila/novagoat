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
        const kambingSelect = document.getElementById('kambingSelect');
        const jadwalList = document.getElementById('jadwalList');
        const stats = {
            total: document.getElementById('statTotal'),
            terakhir: document.getElementById('statTerakhir'),
            avg: document.getElementById('statAvg')
        };

        const authHeaders = {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };

        // Helper untuk Fetch API
        const apiFetch = async (url, options = {}) => {
            const res = await fetch(url, { ...options, headers: { ...authHeaders, ...options.headers } });
            if (!res.ok) throw new Error(await res.text());
            return res.json();
        };

        // UI Loading States
        const spinner = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
        Object.values(stats).forEach(el => el.innerHTML = spinner);
        jadwalList.innerHTML = `<p class="text-secondary text-center mt-4">${spinner} Memuat jadwal...</p>`;
        kambingSelect.innerHTML = '<option disabled selected>Memuat data kambing...</option>';

        let medisChart = null;
        let pendingChartData = null;

        const tryInitChart = () => {
            if (typeof Chart === 'undefined') return setTimeout(tryInitChart, 100);
            medisChart = new Chart(document.getElementById('medisChart').getContext('2d'), {
                type: 'line',
                data: { labels: [], datasets: [{ 
                    label: 'Berat (Kg)', data: [], borderColor: '#00fbff', tension: 0.4, fill: true, backgroundColor: 'rgba(0, 251, 255, 0.1)' 
                }]},
                options: { responsive: true, maintainAspectRatio: false }
            });
            if (pendingChartData) updateChart(pendingChartData);
        };
        tryInitChart();

        const updateChart = (data) => {
            if (!medisChart) return pendingChartData = data;
            
            medisChart.data.labels = data.map(i => i.tanggal_timbang);
            medisChart.data.datasets[0].data = data.map(i => i.berat_sekarang);
            medisChart.update();

            stats.total.innerText = data.length;
            stats.terakhir.innerText = data.length ? data[data.length-1].berat_sekarang + ' kg' : '-';
            const avg = data.length ? (data.reduce((a, b) => a + parseFloat(b.berat_sekarang), 0) / data.length).toFixed(1) : 0;
            stats.avg.innerText = avg + ' kg';
        };

        const loadChartData = async (id) => {
            try {
                const res = await apiFetch(`/api/grafik-berat/${id}`);
                updateChart(res.data || []);
            } catch(e) { console.error("Gagal load grafik:", e); }
        };

        const loadJadwal = async () => {
            try {
                const res = await apiFetch('/api/jadwal-medis');
                const upcoming = (res.data || []).filter(item => (item.status || '').toLowerCase() !== 'selesai');
                jadwalList.innerHTML = upcoming.length ? '' : '<p class="text-secondary text-center mt-4">Tidak ada jadwal medis</p>';
                upcoming.forEach(item => {
                    const id = item.id_jadwal || item.id; 
                    jadwalList.innerHTML += `
                        <div class="p-3 mb-3 shadow-sm position-relative" id="jadwal-${id}" style="background: rgba(255,255,255,0.03); border-radius: 12px; border-left: 4px solid #00fbff;">
                            <small class="text-info fw-bold d-block mb-1">${item.tanggal_rencana || item.tanggal || '-'}</small>
                            <h6 class="text-white fw-bold mb-0">${item.jenis_tindakan || item.kegiatan || '-'}</h6>
                            <button onclick="updateStatus(${id})" class="btn btn-sm btn-outline-success position-absolute end-0 top-50 translate-middle-y me-2" style="font-size: 10px;" title="Tandai Selesai">✓</button>
                        </div>
                    `;
                });
            } catch(e) { console.error("Gagal load jadwal:", e); }
        };

        const loadKambing = async () => {
            try {
                const res = await apiFetch('/api/kambing');
                const list = res.data || [];
                kambingSelect.innerHTML = '<option disabled selected>Pilih Kambing...</option>';
                list.forEach(k => {
                    kambingSelect.innerHTML += `<option value="${k.id_kambing}">${k.nama || 'Kambing #'+k.id_kambing}</option>`;
                });
                if(list.length) {
                    kambingSelect.value = list[0].id_kambing;
                    loadChartData(list[0].id_kambing);
                } else {
                    updateChart([]);
                }
            } catch(e) { console.error("Gagal load kambing:", e); }
        };

        // Form Handlers
        const handleForm = (formId, url, method, onSuccess) => {
            document.getElementById(formId).addEventListener('submit', async function(e) {
                e.preventDefault();
                const id = kambingSelect.value;
                if(!id) return alert('Pilih kambing terlebih dahulu!');
                
                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());
                if (formId === 'formJadwalMedis') data.id_kambing = id;

                try {
                    await apiFetch(url.replace('{id}', id), {
                        method: method,
                        body: JSON.stringify(data)
                    });
                    bootstrap.Modal.getInstance(document.getElementById(e.target.closest('.modal').id)).hide();
                    e.target.reset();
                    onSuccess(id);
                } catch(e) { console.error(`Gagal simpan ${formId}:`, e); }
            });
        };

        handleForm('formInputBerat', '/api/kambing/{id}/timbang', 'POST', loadChartData);
        handleForm('formJadwalMedis', '/api/jadwal-medis', 'POST', loadJadwal);

        kambingSelect.addEventListener('change', (e) => loadChartData(e.target.value));

        window.updateStatus = async (id) => {
            if (!confirm('Apakah vaksin / tindakan medis ini sudah dilakukan?')) return;
            try {
                const res = await fetch(`/api/jadwal-medis/${id}`, { method: 'PATCH', headers: authHeaders });
                if (res.ok) {
                    const el = document.getElementById(`jadwal-${id}`);
                    if (el) {
                        el.style.opacity = "0";
                        el.style.transform = "translateX(20px)";
                        setTimeout(() => {
                            el.remove();
                            if (!jadwalList.children.length) jadwalList.innerHTML = '<p class="text-secondary text-center mt-4">Tidak ada jadwal medis</p>';
                        }, 300);
                    }
                }
            } catch(e) { console.error("Gagal update status:", e); }
        };

        loadKambing();
        loadJadwal();
    });
</script>
@endsection