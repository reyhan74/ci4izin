<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h3 class="fw-bold text-dark mb-1">Log Izin Keluar-Masuk</h3>
        <p class="text-muted small mb-0">Riwayat aktivitas presensi siswa secara real-time.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('scan') ?>" target="_blank" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-qr-code-scan me-2"></i> Buka Mode Scanner
        </a>
        <button class="btn btn-white bg-white border rounded-pill px-3 shadow-sm" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 animate__animated animate__fadeInUp">
    <div class="card-body p-3">
        <form action="" method="get" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari nama siswa...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-light border-0 small">
                    <option value="">Semua Status</option>
                    <option value="keluar">Sedang Keluar</option>
                    <option value="kembali">Sudah Kembali</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control bg-light border-0 small" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100 rounded-pill">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted x-small">NAMA SISWA</th>
                        <th class="py-3 text-muted x-small">STATUS</th>
                        <th class="py-3 text-muted x-small">KETERANGAN / ALASAN</th>
                        <th class="py-3 text-muted x-small">WAKTU KELUAR</th>
                        <th class="py-3 text-muted x-small text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($izin)): ?>
                        <?php foreach ($izin as $i): ?>
                        <tr class="activity-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-mini me-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 38px; height: 38px; font-size: 12px;">
                                        <?= strtoupper(substr($i['nama'], 0, 2)) ?>
                                    </div>
                                    <div>
                                        <div class="text-dark fw-bold small mb-0"><?= esc($i['nama']) ?></div>
                                        <div class="text-muted x-small">NIS: <?= esc($i['nis'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if($i['status'] == 'keluar'): ?>
                                    <span class="badge-custom-danger">Keluar</span>
                                <?php else: ?>
                                    <span class="badge-custom-success">Kembali</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-dark small"><?= esc($i['keterangan']) ?></div>
                            </td>
                            <td>
                                <div class="text-dark small fw-bold"><?= date('H:i', strtotime($i['waktu'])) ?></div>
                                <div class="text-muted x-small"><?= date('d M Y', strtotime($i['waktu'])) ?></div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3">
                                    <button class="btn btn-white btn-sm border-end" title="Detail">
                                        <i class="bi bi-eye text-primary"></i>
                                    </button>
                                    <a href="<?= site_url('admin/izin/delete/'.$i['id']) ?>" 
                                       onclick="return confirm('Hapus record ini?')"
                                       class="btn btn-white btn-sm" title="Hapus">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                <p class="text-muted small">Tidak ada data izin ditemukan pada filter ini.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3 border-0">
        <nav class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan <?= count($izin) ?> entri</span>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link rounded-circle me-1 border-0 bg-light" href="#">Prev</a></li>
                <li class="page-item active"><a class="page-link rounded-circle border-0 me-1" href="#">1</a></li>
                <li class="page-item"><a class="page-link rounded-circle border-0" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .x-small { font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 700; text-transform: uppercase; }
    
    /* Tombol Putih ala Dashboard */
    .btn-white { background: white; border: 1px solid #e2e8f0; }
    .btn-white:hover { background: #f8fafc; }

    /* Badges Status */
    .badge-custom-danger {
        background: #fff5f5; color: #e53e3e; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; border: 1px solid #feb2b2;
        display: inline-flex; align-items: center;
    }
    .badge-custom-danger::before {
        content: ""; width: 6px; height: 6px; background: #e53e3e; border-radius: 50%; margin-right: 8px;
        animation: pulse-red 2s infinite;
    }

    .badge-custom-success {
        background: #f0fff4; color: #38a169; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; border: 1px solid #9ae6b4;
    }

    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(229, 62, 62, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(229, 62, 62, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(229, 62, 62, 0); }
    }

    .activity-row:hover { background: #f8fafc; transition: 0.2s; }
</style>

<?= $this->endSection() ?>