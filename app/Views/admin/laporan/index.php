<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate__animated animate__fadeIn">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-800 text-dark mb-1">Rekapitulasi Keluar Masuk</h3>
            <p class="text-muted small mb-0">SMK CB - Tahun Ajaran 2025/2026</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                <button onclick="window.print()" class="btn btn-white border-0 px-3 py-2">
                    <i class="bi bi-printer text-primary me-1"></i> Cetak
                </button>
                <a href="<?= base_url('admin/laporan/export') ?>" class="btn btn-white border-0 px-3 py-2">
                    <i class="bi bi-file-earmark-excel text-success me-1"></i> Excel
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px);">
        <div class="card-body p-4">
            <form action="" method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Tanggal Awal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0 shadow-sm"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="tgl_awal" class="form-control border-0 shadow-sm" value="<?= $tgl_awal ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Tanggal Akhir</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0 shadow-sm"><i class="bi bi-calendar-check"></i></span>
                        <input type="date" name="tgl_akhir" class="form-control border-0 shadow-sm" value="<?= $tgl_akhir ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-filter-left me-2"></i> Filter Laporan
                    </button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 24px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">WAKTU</th>
                            <th class="py-3 text-muted small fw-bold">IDENTITAS</th>
                            <th class="py-3 text-muted small fw-bold">KELAS</th>
                            <th class="py-3 text-muted small fw-bold">IZIN</th>
                            <th class="py-3 text-muted small fw-bold">KETERANGAN</th>
                            <th class="py-3 text-muted small fw-bold">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                    <p class="text-muted">Tidak ada data untuk periode ini.</p>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($riwayat as $r) : ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark mb-0"><?= date('H:i', strtotime($r['waktu'])) ?></div>
                                <div class="text-muted" style="font-size: 0.75rem;"><?= date('d M Y', strtotime($r['waktu'])) ?></div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><?= $r['nama_siswa'] ?></div>
                                <div class="text-muted small"><?= $r['nis'] ?></div>
                            </td>
                            <td>
                                <div class="small fw-600"><?= $r['kelas'] ?></div>
                                <div class="text-muted" style="font-size: 0.7rem;"><?= $r['jurusan'] ?></div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 <?= $r['jenis_izin'] == 'Masuk' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25' ?>">
                                    <i class="bi <?= $r['jenis_izin'] == 'Masuk' ? 'bi-box-arrow-in-right' : 'bi-box-arrow-right' ?> me-1"></i>
                                    <?= $r['jenis_izin'] ?>
                                </span>
                            </td>
                            <td class="small text-muted" style="max-width: 200px;"><?= $r['keterangan'] ?></td>
                            <td>
                                <?php if ($r['status'] == 1) : ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 border border-success border-opacity-25"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                <?php else : ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 border border-warning border-opacity-25"><i class="bi bi-clock-history me-1"></i> Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS untuk mempercantik tampilan tabel */
    .table thead th {
        border-bottom: none;
        letter-spacing: 0.5px;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02) !important;
        transform: scale(1.002);
    }
    @media print {
        .btn-group, .card-body form, .sidebar, .navbar {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            backdrop-filter: none !important;
        }
    }
</style>
<?= $this->endSection() ?>