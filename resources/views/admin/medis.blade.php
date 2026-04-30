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
            <button class="btn btn-info btn-sm rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">+ TAMBAH JADWAL</button>
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
                    <h6 class="m-0 fw-bold text-info" style="font-size: 0.8rem;">Grafik Monitor Berat Badan Ternak</h6>
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
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold">Input Data Timbangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMedis">
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
                    <button type="submit" class="btn btn-sm btn-info rounded-pill px-4 fw-bold text-dark">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- 1. START FETCHING DATA IMMEDIATELY (PARALLEL WITH CHART.JS DOWNLOAD) ---
    const pKambing = fetch('/api/kambing').then(res => res.json()).catch(() => ({data: []}));
    
    const authHeaders = {
        'Authorization': `Bearer ${localStorage.getItem('token_sakti')}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    };
    
    const pJadwal = fetch('/api/jadwal-medis', { headers: authHeaders })
        .then(res => res.json())
        .catch(() => ({data: []}));

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('medisChart').getContext('2d');
        const kambingSelect = document.getElementById('kambingSelect');
        const formMedis = document.getElementById('formMedis');
        const jadwalList = document.getElementById('jadwalList');

        // --- 2. INITIALIZE CHART ONCE ---
        let medisChart = new Chart(ctx, {
            type: 'line',
            data: { labels: [], datasets: [{ 
                label: 'Berat (Kg)', data: [], borderColor: '#00fbff', tension: 0.4, fill: true, backgroundColor: 'rgba(0, 251, 255, 0.1)' 
            }]},
            options: { responsive: true, maintainAspectRatio: false }
        });

        // --- 3. HELPER FUNCTIONS ---
        const updateChart = (data) => {
            medisChart.data.labels = data.map(i => i.tanggal_timbang);
            medisChart.data.datasets[0].data = data.map(i => i.berat_sekarang);
            medisChart.update();

            document.getElementById('statTotal').innerText = data.length;
            document.getElementById('statTerakhir').innerText = data.length ? data[data.length-1].berat_sekarang + ' kg' : '-';
            const avg = data.length ? (data.reduce((a, b) => a + parseFloat(b.berat_sekarang), 0) / data.length).toFixed(1) : 0;
            document.getElementById('statAvg').innerText = avg + ' kg';
        };

        const loadChartData = (id) => {
            fetch(`/api/grafik-berat/${id}`)
                .then(res => res.json())
                .then(res => updateChart(res.data || []));
        };

        const renderJadwal = (data) => {
            jadwalList.innerHTML = data.length ? '' : '<p class="text-secondary text-center">Tidak ada jadwal</p>';
            data.forEach(item => {
                jadwalList.innerHTML += `
                    <div class="p-3 mb-3 shadow-sm position-relative" style="background: rgba(255,255,255,0.03); border-radius: 12px; border-left: 4px solid ${item.status === 'selesai' ? '#198754' : '#00fbff'};">
                        <small class="text-info fw-bold d-block mb-1">${item.tanggal_rencana || item.tanggal}</small>
                        <h6 class="text-white fw-bold mb-0">${item.jenis_tindakan || item.kegiatan}</h6>
                        ${item.status !== 'selesai' ? `<button onclick="updateStatus(${item.id})" class="btn btn-sm btn-outline-success position-absolute end-0 top-50 translate-middle-y me-2" style="font-size: 10px;">✓</button>` : ''}
                    </div>
                `;
            });
        };

        // --- 4. HANDLE PARALLEL DATA ---
        pKambing.then(res => {
            const list = res.data || [];
            kambingSelect.innerHTML = '<option disabled selected>Pilih Kambing...</option>';
            list.forEach(k => {
                kambingSelect.innerHTML += `<option value="${k.id_kambing}">${k.nama || 'Kambing #'+k.id_kambing}</option>`;
            });
            if(list.length) {
                kambingSelect.value = list[0].id_kambing;
                loadChartData(list[0].id_kambing);
            }
        });

        pJadwal.then(res => renderJadwal(res.data || []));

        // --- 5. EVENT LISTENERS ---
        kambingSelect.addEventListener('change', (e) => loadChartData(e.target.value));

        formMedis.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = kambingSelect.value;
            if(!id) return alert('Pilih kambing!');

            fetch(`/api/kambing/${id}/timbang`, {
                method: 'POST',
                headers: authHeaders,
                body: JSON.stringify({ berat: e.target.berat.value, tanggal: e.target.tanggal.value })
            }).then(() => {
                bootstrap.Modal.getInstance(document.getElementById('modalTambahJadwal')).hide();
                formMedis.reset();
                loadChartData(id);
            });
        });

        window.updateStatus = (id) => {
            fetch(`/api/jadwal-medis/${id}`, { method: 'PATCH', headers: authHeaders })
                .then(() => fetch('/api/jadwal-medis', { headers: authHeaders }))
                .then(res => res.json())
                .then(res => renderJadwal(res.data || []));
        };
    });
</script>
@endsection