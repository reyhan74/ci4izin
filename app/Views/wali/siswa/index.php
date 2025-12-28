<?= $this->extend('layout/wali') ?> <?= $this->section('content') ?>

<div class="container-fluid p-0">
    
    <div class="row mb-4 align-items-end">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Data Siswa Terdaftar</h4>
            <p class="text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i> Menampilkan seluruh siswa di kelas <?= esc($kelas) ?> <?= esc($jurusan) ?>
            </p>
        </div>
        <div class="col-md-6">
            <div class="row g-2 justify-content-md-end mt-3 mt-md-0">
                <div class="col-6 col-md-4">
                    <div class="bg-white p-2 rounded-3 shadow-sm border-start border-primary border-4">
                        <small class="text-muted d-block" style="font-size: 10px; font-weight: 700;">TOTAL SISWA</small>
                        <span class="fw-bold fs-5"><?= count($siswa) ?></span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="bg-white p-2 rounded-3 shadow-sm border-start border-success border-4">
                        <small class="text-muted d-block" style="font-size: 10px; font-weight: 700;">STATUS AKTIF</small>
                        <span class="fw-bold fs-5 text-success">100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">List Peserta Didik</h6>
            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                <input type="text" id="searchSiswa" class="form-control bg-light border-0" placeholder="Cari nama...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 small fw-bold text-muted" width="80">NO</th>
                            <th class="py-3 border-0 small fw-bold text-muted">NIS</th>
                            <th class="py-3 border-0 small fw-bold text-muted">NAMA LENGKAP</th>
                            <th class="py-3 border-0 small fw-bold text-muted">KELAS</th>
                            <th class="py-3 border-0 small fw-bold text-muted pe-4 text-end">JURUSAN</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTable">
                        <?php if (empty($siswa)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3 d-block mx-auto">
                                    <p class="text-muted small">Belum ada data siswa di kelas ini.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($siswa as $i => $s) : ?>
                                <tr>
                                    <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                    <td><code class="text-primary fw-bold small"><?= esc($s['nis']) ?></code></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xsmall bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px; font-size: 10px;">
                                                <i class="bi bi-person text-secondary"></i>
                                            </div>
                                            <span class="fw-semibold text-dark"><?= esc($s['nama']) ?></span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark fw-medium"><?= esc($s['kelas']) ?></span></td>
                                    <td class="pe-4 text-end text-secondary fw-medium"><?= esc($s['jurusan']) ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Fitur filter sederhana tanpa reload
    document.getElementById('searchSiswa').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#siswaTable tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

<style>
    .fw-800 { font-weight: 800; }
    .table thead th { font-size: 0.65rem; letter-spacing: 0.5px; }
    .avatar-xsmall { border: 1px solid #eee; }
</style>

<?= $this->endSection() ?>