<?= $this->extend('layout/wali') ?> <?= $this->section('content') ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-800 text-dark mb-1">Statistik & Monitoring</h4>
                <p class="text-muted small">Kelas <?= esc($wali['kelas']) ?> <?= esc($wali['jurusan']) ?></p>
            </div>
            <div class="dropdown">
                <button class="btn btn-white bg-white border rounded-3 dropdown-toggle shadow-sm small fw-bold" data-bs-toggle="dropdown">
                    <i class="bi bi-filter me-2"></i>Filter Waktu
                </button>
                <ul class="dropdown-menu border-0 shadow-lg">
                    <li><a class="dropdown-item small" href="#">7 Hari Terakhir</a></li>
                    <li><a class="dropdown-item small" href="#">Bulan Ini</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-4">
                <p class="text-muted small fw-bold mb-1 text-uppercase">Total Siswa</p>
                <h3 class="fw-800 mb-0"><?= $totalSiswa ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-danger border-4">
                <p class="text-danger small fw-bold mb-1 text-uppercase">Keluar Aktif</p>
                <h3 class="fw-800 mb-0 text-danger"><?= $izinKeluar ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-4">
                <p class="text-success small fw-bold mb-1 text-uppercase">Selesai Izin</p>
                <h3 class="fw-800 mb-0 text-success"><?= $izinKembali ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-4">
                <p class="text-warning small fw-bold mb-1 text-uppercase">Rata-rata/Hari</p>
                <h3 class="fw-800 mb-0"><?= round($izinKeluar / 1, 1) ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">Tren Izin Keluar (7 Hari Terakhir)</h6>
                    <i class="bi bi-graph-up text-primary"></i>
                </div>
                <canvas id="chartIzin" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0 text-danger">Sedang di Luar</h6>
                    <p class="text-muted extra-small mb-0">Siswa yang belum melakukan scan masuk</p>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(empty($siswaDiLuar)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-check2-all text-success fs-1"></i>
                                <p class="text-muted small mt-2">Semua siswa berada di kelas</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($siswaDiLuar as $sdl): ?>
                                <li class="list-group-item border-0 px-4 py-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-person text-secondary small"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small text-dark"><?= esc($sdl['nama']) ?></p>
                                            <span class="extra-small text-muted">Sejak <?= date('H:i', strtotime($sdl['waktu_keluar'])) ?></span>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger rounded-pill px-2" style="font-size: 10px;">Belum Kembali</span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
    const ctx = document.getElementById('chartIzin').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Jumlah Siswa Izin',
                data: [12, 19, 3, 5, 2, 3, 0], // Ganti dengan data dinamis dari Controller
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#4361ee'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<style>
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 11px; }
    .list-group-item { transition: background 0.2s; cursor: default; }
    .list-group-item:hover { background-color: #f8fafc; }
</style>

<?= $this->endSection() ?>