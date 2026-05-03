@extends('layouts.app')

@section('content')
<style>
    :root {
        --dark-green: #1B4D1E;
        --medium-green: #2E7D32;
        --button-green: #3D7A40;
        --light-green: #A5C8A7;
        --pale-mint: #D6EDD7;
        --page-bg: #E8EDEA;
        --card-white: #FFFFFF;
        --input-bg: #F2F5F2;
        --icon-circle: #C8DAC9;
        --muted-shadow: #B0BEB1;
        --heading-text: #1A2E1A;
        --sub-text: #4A6B4C;
        --placeholder: #9BB09C;
        --border-divider: #D0DDD1;
    }

    body {
        background-color: var(--page-bg) !important;
        color: var(--heading-text) !important;
    }

    .main-content-padded {
        background-color: var(--page-bg) !important;
    }

    @media (max-width: 768px) {
        .chart-wrapper { height: 250px !important; }
    }

    .chart-wrapper canvas {
        width: 100% !important;
    }

    .btn-nature {
        transition: all 0.3s ease;
        border-radius: 50px !important;
        font-weight: bold;
        padding: 0.5rem 1.5rem;
    }

    .btn-nature-primary {
        background-color: var(--medium-green);
        color: white;
        border: 1px solid var(--medium-green);
    }

    .btn-nature-secondary {
        background-color: var(--pale-mint);
        color: var(--dark-green);
        border: 1px solid var(--light-green);
    }

    .btn-nature-primary:hover, .btn-nature-secondary:hover {
        background-color: var(--dark-green) !important;
        border-color: var(--dark-green) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(27, 77, 30, 0.2);
    }

    .card-nature {
        background-color: var(--card-white);
        border: 1px solid var(--border-divider);
        border-radius: 20px !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-up { opacity: 0; animation: fadeInUp 0.6s ease-out forwards; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
</style>

<div class="container" style="padding-top: 40px; padding-bottom: 100px; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-5 px-4">
        <div>
            <h2 class="fw-bold" style="color: var(--heading-text);">Jadwal Medis & Vaksin</h2>
            <p class="mb-0 font-monospace" style="font-size: 0.85rem; color: var(--sub-text);">Monitoring kesehatan dan jadwal imunisasi ternak.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <select id="kambingSelect" class="form-select form-select-sm border-0 shadow-sm" style="width: 220px; background-color: var(--card-white); color: var(--heading-text); border-radius: 10px;">
                <option value="" disabled selected>Pilih Kambing...</option>
            </select>
            <button class="btn btn-nature btn-nature-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalInputBerat">+ INPUT BERAT</button>
        </div>
    </div>

    <div class="row g-3 mb-4 px-4">
        <div class="col-md-4">
            <div class="card card-nature p-3 shadow-sm animate-up delay-1">
                <small class="text-uppercase fw-bold" style="font-size: 0.7rem; color: var(--sub-text);">Total Catatan</small>
                <h3 id="statTotal" class="fw-bold mb-0">-</h3>
                <small style="font-size: 0.65rem; color: var(--medium-green);">Seluruh entri log berat.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-nature p-3 shadow-sm animate-up delay-2">
                <small class="text-uppercase fw-bold" style="font-size: 0.7rem; color: var(--sub-text);">Berat Terakhir</small>
                <h3 id="statTerakhir" class="fw-bold mb-0">- kg</h3>
                <small style="font-size: 0.65rem; color: var(--medium-green);">Data terupdate.</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-nature p-3 shadow-sm animate-up delay-3">
                <small class="text-uppercase fw-bold" style="font-size: 0.7rem; color: var(--sub-text);">Rata-rata Berat</small>
                <h3 id="statAvg" class="fw-bold mb-0">- kg</h3>
                <small style="font-size: 0.65rem; color: var(--medium-green);">Periode ini.</small>
            </div>
        </div>
    </div>

    <div class="row g-3 px-4">
        <div class="col-lg-8">
            <div class="card card-nature shadow-sm animate-up delay-4" style="overflow: hidden;">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: var(--card-white); border-bottom: 1px solid var(--border-divider);">
                    <h6 class="m-0 fw-bold" style="font-size: 0.8rem; color: var(--dark-green);">Grafik Monitor Berat Badan Kambing</h6>
                    <div class="px-3 py-1 rounded-pill" style="border: 1px solid var(--border-divider); background-color: var(--page-bg);">
                        <span class="fw-bold" style="font-size: 10px; color: var(--sub-text);">BERAT BADAN (KG)</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-wrapper" style="position: relative; height: 350px;">
                        <canvas id="medisChart"></canvas>
                        <div id="noDataMessage" class="position-absolute top-50 start-50 translate-middle text-secondary d-none text-center">
                            <p class="mb-0" style="color: var(--muted-shadow);">Belum ada data timbangan untuk kambing ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-nature shadow-sm h-100 animate-up delay-4" style="overflow: hidden;">
                <div class="card-header py-3 border-0 d-flex justify-content-between align-items-center" style="background-color: var(--medium-green);">
                    <h6 class="m-0 fw-bold text-white" style="font-size: 0.8rem;">AGENDA VAKSIN MENDATANG</h6>
                    <button class="btn btn-sm btn-light fw-bold rounded-pill px-3 shadow-sm" style="font-size: 0.7rem; color: var(--dark-green);" data-bs-toggle="modal" data-bs-target="#modalJadwalMedis">+ TAMBAH</button>
                </div>
                <div id="jadwalList" class="card-body p-3 overflow-auto" style="max-height: 450px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInputBerat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">Input Data Timbangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formInputBerat">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">TANGGAL TIMBANG</label>
                        <input type="date" name="tanggal" class="form-control" style="background-color: var(--input-bg);" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">BERAT (KG)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="berat" class="form-control" placeholder="25.5" style="background-color: var(--input-bg);" required>
                            <span class="input-group-text border-0 text-white" style="background-color: var(--medium-green);">kg</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-nature btn-nature-primary shadow-sm">Simpan Berat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalJadwalMedis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">Tambah Jadwal Medis / Vaksin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formJadwalMedis">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">PILIH KAMBING</label>
                        <select name="id_kambing" class="form-select" id="modalKambingSelect" style="background-color: var(--input-bg);" required>
                            <option value="semua">🐑 SEMUA KAMBING (Keseluruhan)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">TANGGAL RENCANA</label>
                        <input type="date" name="tanggal_rencana" class="form-control" style="background-color: var(--input-bg);" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">JENIS TINDAKAN / VAKSIN</label>
                        <input type="text" name="jenis_tindakan" class="form-control" placeholder="Vaksin PMK, Vitamin" style="background-color: var(--input-bg);" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-nature btn-nature-primary shadow-sm">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kambingSelect = document.getElementById('kambingSelect');
    const jadwalList = document.getElementById('jadwalList');
    const stats = {
        total: document.getElementById('statTotal'),
        terakhir: document.getElementById('statTerakhir'),
        avg: document.getElementById('statAvg')
    };

    const headers = {
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    };

    const apiFetch = async (url, opt = {}) => {
        const fullUrl = url.startsWith('http') ? url : `{{ url('/') }}${url.startsWith('/') ? '' : '/'}${url}`;
        const res = await fetch(fullUrl, { ...opt, headers: { ...headers, ...opt.headers } });
        if (!res.ok) throw new Error(await res.text());
        return res.json();
    };

    let medisChart = null;
    let pendingData = null;

    const initChart = () => {
        if (typeof Chart === 'undefined') return setTimeout(initChart, 100);
        medisChart = new Chart(document.getElementById('medisChart').getContext('2d'), {
            type: 'line',
            data: { labels: [], datasets: [{ 
                label: 'Berat (Kg)', 
                data: [], 
                borderColor: '#2E7D32', 
                borderWidth: 3,
                tension: 0.4, 
                fill: true, 
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#2E7D32',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]},
            options: { 
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(27, 77, 30, 0.95)',
                        titleFont: { size: 11, weight: '400' },
                        bodyFont: { size: 12, weight: '600' },
                        padding: 8,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Berat: ${context.parsed.y} kg`;
                            }
                        }
                    }
                },
                scales: {
                    y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#4A6B4C' }, grace: '5%' },
                    x: { grid: { display: false }, ticks: { color: '#4A6B4C' } }
                }
            }
        });
        if (pendingData) updateChart(pendingData);
    };
    initChart();

    const updateChart = (data) => {
        if (!medisChart) return pendingData = data;
        
        const empty = !data || data.length === 0;
        document.getElementById('noDataMessage').classList.toggle('d-none', !empty);
        
        medisChart.data.labels = empty ? [] : data.map(i => i.tanggal_timbang);
        medisChart.data.datasets[0].data = empty ? [] : data.map(i => parseFloat(i.berat_sekarang));
        medisChart.update();

        stats.total.innerText = empty ? '0' : data.length;
        stats.terakhir.innerText = empty ? '-' : `${data[data.length-1].berat_sekarang} kg`;
        stats.avg.innerText = empty ? '0 kg' : `${(data.reduce((a, b) => a + parseFloat(b.berat_sekarang), 0) / data.length).toFixed(1)} kg`;
    };

    const loadData = async (id) => {
        if (!id) return;
        try {
            const res = await apiFetch(`/api/grafik-berat/${id}`);
            updateChart(res.data || []);
        } catch(e) { updateChart([]); }
    };

    const loadJadwal = async (id_kambing) => { 
        try {
            const res = await apiFetch(`/api/jadwal-medis?id_kambing=${id_kambing}`);
            const upcoming = (res.data || []).filter(i => (i.status || '').toLowerCase() !== 'selesai');
            
            jadwalList.innerHTML = upcoming.length ? '' : '<p class="text-secondary text-center mt-4">Tidak ada jadwal medis</p>';
            
            upcoming.forEach(i => {
                const id = i.id_jadwal || i.id; 
                jadwalList.innerHTML += `
                    <div class="p-3 mb-3 shadow-sm d-flex justify-content-between align-items-center" id="jadwal-${id}" style="background: var(--input-bg); border-radius: 12px; border-left: 4px solid var(--medium-green);">
                        <div style="padding-right: 10px; overflow: hidden;">
                            <small class="fw-bold d-block mb-1" style="color: var(--medium-green);">${i.tanggal_rencana || i.tanggal || '-'}</small>
                            <h6 class="fw-bold mb-0" style="color: var(--heading-text); font-size: 0.85rem; line-height: 1.4;">${i.jenis_tindakan || i.kegiatan || '-'}</h6>
                        </div>
                        <button onclick="updateStatus(${id})" class="btn btn-sm btn-outline-success flex-shrink-0" style="width: 30px; height: 30px; border-radius: 8px; font-size: 10px; display: flex; align-items: center; justify-content: center;">✓</button>
                    </div>`;
            });
        } catch(e) {
            console.error("Gagal load jadwal:", e);
        }
    };

    const loadKambing = async () => {
        try {
            const res = await apiFetch('/api/kambing');
            const list = res.data || [];
            kambingSelect.innerHTML = '<option disabled>Pilih Kambing...</option>';
            
            const modalSelect = document.getElementById('modalKambingSelect');
            if(modalSelect) modalSelect.innerHTML = '<option value="semua">🐑 SEMUA KAMBING (Keseluruhan)</option>';

            if (!list.length) {
                kambingSelect.innerHTML = '<option disabled selected>Tidak ada data</option>';
                return updateChart([]);
            }
            list.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id_kambing;
                opt.text = k.nama || `Kambing #${k.id_kambing}`;
                kambingSelect.appendChild(opt);

                if(modalSelect) {
                    const opt2 = document.createElement('option');
                    opt2.value = k.id_kambing;
                    opt2.text = k.nama || `Kambing #${k.id_kambing}`;
                    modalSelect.appendChild(opt2);
                }
            });
            kambingSelect.value = list[0].id_kambing;
            loadData(list[0].id_kambing);
        } catch(e) {}
    };

    const handleForm = (id, url, method, cb) => {
        document.getElementById(id).addEventListener('submit', async function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(e.target).entries());
            
            let targetId = id === 'formJadwalMedis' ? data.id_kambing : kambingSelect.value;
            
            if(!targetId) return alert('Pilih kambing!');
            if (id === 'formJadwalMedis') data.id_kambing = targetId;
            
            const btnSubmit = e.target.querySelector('button[type="submit"]');
            const textAsli = btnSubmit.innerHTML;
            btnSubmit.innerHTML = 'Menyimpan...';
            btnSubmit.disabled = true;

            try {
                await apiFetch(url.replace('{id}', targetId), { method, body: JSON.stringify(data) });
                
                const modalEl = document.getElementById(e.target.closest('.modal').id);
                const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.hide(); 
                
                e.target.reset();
                cb(targetId);
                
                btnSubmit.innerHTML = textAsli;
                btnSubmit.disabled = false;
            } catch(error) {
                console.error("ERROR HERE:", error);
                alert("Gagal disimpen! Coba pencet F12, buka tab Console, dan cek pesan error warna merah.");
                
                btnSubmit.innerHTML = textAsli;
                btnSubmit.disabled = false;
            }
        });
    };

    handleForm('formInputBerat', '/api/kambing/{id}/timbang', 'POST', loadData);
    handleForm('formJadwalMedis', '/api/jadwal-medis', 'POST', loadJadwal);

    kambingSelect.addEventListener('change', (e) => {
    loadData(e.target.value);   //update grafik
    loadJadwal(e.target.value); //update agenda vaksin sesuai kambing
});
    
    window.updateStatus = async (id) => {
        if (!confirm('Sudah dilakukan?')) return;
        try {
            const res = await fetch(`{{ url('/') }}/api/jadwal-medis/${id}`, { method: 'PATCH', headers });
            if (res.ok) document.getElementById(`jadwal-${id}`).remove();
        } catch(e) {}
    };

    loadKambing();
    });
</script>
@endsection