<?= $this->extend('layout/wali') ?>
<?= $this->section('content') ?>

<div class="container-fluid p-0">

    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Riwayat Izin Siswa</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                    Kelas <?= esc($kelas) ?> <?= esc($jurusan) ?>
                </span>
            </p>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <form action="" method="get" class="d-flex gap-2 justify-content-md-end">
                <div class="input-group input-group-sm w-auto shadow-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                    <input type="date" name="tanggal" class="form-control border-start-0 ps-0" value="<?= $_GET['tanggal'] ?? date('Y-m-d') ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm px-3 rounded-3 shadow-sm">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Log Aktivitas Izin</h6>
            <button class="btn btn-light btn-sm rounded-circle" title="Refresh Data" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise text-primary"></i>
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 small fw-bold text-muted" width="50">NO</th>
                            <th class="py-3 border-0 small fw-bold text-muted">IDENTITAS SISWA</th>
                            <th class="py-3 border-0 small fw-bold text-muted text-center">STATUS</th>
                            <th class="py-3 border-0 small fw-bold text-muted">KETERANGAN</th>
                            <th class="py-3 border-0 small fw-bold text-muted pe-4">WAKTU & TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($izin)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-50 mb-3">
                                        <i class="bi bi-clipboard-x fs-1"></i>
                                    </div>
                                    <p class="text-muted small">Belum ada aktivitas izin terekam untuk periode ini.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($izin as $i => $row) : ?>
                                <tr>
                                    <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark small mb-0"><?= esc($row['nama']) ?></div>
                                                <div class="text-muted extra-small">NIS: <?= esc($row['nis']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'keluar') : ?>
                                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-bold" style="font-size: 11px;">
                                                <i class="bi bi-box-arrow-right me-1"></i> KELUAR
                                            </span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-bold" style="font-size: 11px;">
                                                <i class="bi bi-box-arrow-in-left me-1"></i> KEMBALI
                                            </span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <div class="bg-light p-2 rounded-3 small text-secondary" style="font-size: 12px; border-left: 3px solid #dee2e6;">
                                            "<?= esc($row['keterangan']) ?>"
                                        </div>
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-primary">
                                                <i class="bi bi-clock"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark small mb-0"><?= date('H:i', strtotime($row['waktu'])) ?></div>
                                                <div class="text-muted extra-small"><?= date('d M Y', strtotime($row['waktu'])) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 text-center">
             <p class="text-muted extra-small mb-0 italic">* Data diperbarui secara otomatis melalui sistem QR-Scan</p>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 11px; }
    .italic { font-style: italic; }
    .table thead th { font-size: 0.65rem; letter-spacing: 1px; }
</style>

<?= $this->endSection() ?>