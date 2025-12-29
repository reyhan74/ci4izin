<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Izin Siswa</h3>
            <p class="text-muted small mb-0">Memantau riwayat keluar-masuk siswa secara spesifik berdasarkan kriteria.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('admin/laporan-izin/export?' . $_SERVER['QUERY_STRING']) ?>" class="btn btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-file-earmark-excel me-2"></i> Excel
            </a>
            
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm bg-white">
                <i class="bi bi-printer me-2"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="get" id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Tanggal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-calendar3"></i></span>
                        <input type="date" name="tanggal" id="filterTanggal" class="form-control bg-light border-start-0" 
                               value="<?= esc($tanggal) ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Cari Nama / NIS</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-person"></i></span>
                        <input type="text" name="nama" class="form-control bg-light border-start-0" 
                               placeholder="Nama atau NIS..." value="<?= esc($nama_search ?? '') ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Kelas</label>
                    <select name="kelas" class="form-select bg-light">
                        <option value="">Semua Kelas</option>
                        <option value="X" <?= ($kelas_search == 'X') ? 'selected' : '' ?>>X</option>
                        <option value="XI" <?= ($kelas_search == 'XI') ? 'selected' : '' ?>>XI</option>
                        <option value="XII" <?= ($kelas_search == 'XII') ? 'selected' : '' ?>>XII</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Jurusan</label>
                    <select name="jurusan" class="form-select bg-light">
                        <option value="">Semua Jurusan</option>
                        <?php 
                        $list_jurusan = ['TKJ 1', 'TKJ 2', 'TKJ 3', 'RPL 1', 'RPL 2', 'TOI 1', 'TOI 2', 'TITL 1', 'TITL 2'];
                        foreach($list_jurusan as $j): ?>
                            <option value="<?= $j ?>" <?= ($jurusan_search == $j) ? 'selected' : '' ?>><?= $j ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold shadow-sm">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                        <a href="<?= site_url('admin/laporan-izin') ?>" class="btn btn-light rounded-pill border shadow-sm" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted x-small" width="5%">NO</th>
                            <th class="py-3 text-muted x-small">SISWA</th>
                            <th class="py-3 text-muted x-small">KELAS & JURUSAN</th>
                            <th class="py-3 text-muted x-small text-center">STATUS</th>
                            <th class="py-3 text-muted x-small">KETERANGAN</th>
                            <th class="py-3 text-muted x-small">WAKTU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($izin)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="opacity-25 mb-3">
                                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="text-muted fw-bold">Data tidak ditemukan dengan filter tersebut.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($izin as $idx => $row): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $idx + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark mb-0"><?= esc($row['nama']) ?></div>
                                    <div class="text-muted x-small">NIS: <?= esc($row['nis']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark"><?= esc($row['kelas']) ?></div>
                                    <div class="text-muted small"><?= esc($row['jurusan']) ?></div>
                                </td>
                                <td class="text-center">
                                    <?php if($row['status'] == 'keluar'): ?>
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-3">
                                            KELUAR
                                        </span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3">
                                            KEMBALI
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="p-2 bg-light rounded-3 small" style="max-width: 200px;">
                                        <?= esc($row['keterangan']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium small text-dark">
                                        <?= date('H:i', strtotime($row['waktu'])) ?>
                                    </div>
                                    <div class="text-muted x-small"><?= date('d/m/Y', strtotime($row['waktu'])) ?></div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 800; }
    .table thead th { border: none; }
    .table tbody td { border-color: #f8fafc; }
    
    @media print {
        .btn, #filterForm, .header-actions, .input-group-text { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background-color: #fff !important; }
        .container-fluid { padding: 0 !important; }
    }
</style>

<script>
    document.getElementById('filterForm').addEventListener('submit', function() {
        Swal.fire({
            title: 'Memperbarui Data...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
    });
</script>

<?= $this->endSection() ?>