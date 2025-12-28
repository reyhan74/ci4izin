<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Dashboard <span class="text-primary">Sistem Izin</span></h3>
            <p class="text-muted small mb-0">Status operasional hari ini, <?= date('d M Y') ?>.</p>
        </div>
        <button onclick="window.location.reload()" class="btn btn-white shadow-sm border rounded-pill px-3">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-4 p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted x-small fw-bold uppercase">TOTAL SISWA</div>
                        <h3 class="fw-bold mb-0"><?= number_format($totalSiswa) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 border-start border-4 border-warning">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-4 p-3 me-3">
                        <i class="bi bi-journal-text fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted x-small fw-bold">TOTAL IZIN</div>
                        <h3 class="fw-bold mb-0"><?= number_format($izinHariIni) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 border-start border-4 border-danger">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-4 p-3 me-3">
                        <i class="bi bi-box-arrow-right fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted x-small fw-bold">SEDANG KELUAR</div>
                        <h3 class="fw-bold mb-0"><?= number_format($izinKeluar) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 border-start border-4 border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-4 p-3 me-3">
                        <i class="bi bi-check-all fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted x-small fw-bold">SUDAH KEMBALI</div>
                        <h3 class="fw-bold mb-0"><?= number_format($izinKembali) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 ps-4">
                    <h5 class="fw-bold text-dark mb-0">Tren Izin Mingguan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartIzin" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 ps-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Aktivitas Terbaru</h5>
                    <a href="<?= site_url('admin/laporan-izin') ?>" class="text-primary x-small text-decoration-none fw-bold">SEMUA</a>
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="list-group list-group-flush">
                        <?php if(empty($izinTerbaru)): ?>
                            <div class="text-center py-5">
                                <p class="text-muted small">Tidak ada aktivitas izin hari ini.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($izinTerbaru as $izin): ?>
                            <div class="list-group-item border-0 py-3 px-4 activity-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($izin['nama']) ?>&background=random&size=32" class="rounded-circle me-3 shadow-sm">
                                        <div>
                                            <div class="fw-bold text-dark small"><?= esc($izin['nama']) ?></div>
                                            <span class="badge <?= $izin['status'] == 'keluar' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?> rounded-pill x-small">
                                                <?= strtoupper($izin['status']) ?>
                                            </span>
                                            
                                            <?php if($izin['status'] == 'keluar'): 
                                                $durasi = (time() - strtotime($izin['waktu'])) / 3600;
                                                if($durasi > 1): ?>
                                                <span class="text-danger x-small ms-1 fw-bold pulse-anim">
                                                    <i class="bi bi-exclamation-circle"></i> > 1 Jam
                                                </span>
                                            <?php endif; endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-muted small"><?= date('H:i', strtotime($izin['waktu'])) ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .activity-item:hover { background-color: #f8fafc; transition: 0.3s; }
    .bg-danger-subtle { background-color: #fee2e2; }
    .bg-success-subtle { background-color: #dcfce7; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
    .pulse-anim { animation: pulse 1s infinite; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartIzin').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= $grafikLabels ?>,
                datasets: [{
                    label: 'Siswa Izin',
                    data: <?= $grafikData ?>,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>