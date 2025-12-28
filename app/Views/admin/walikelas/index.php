<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-800 text-dark mb-1">Pengaturan Wali Kelas</h4>
            <p class="text-muted small">Kelola penugasan guru untuk wali kelas dan jurusan</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                            <i class="bi bi-person-plus-fill fs-5"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Tambah Penugasan</h6>
                    </div>
                    
                    <form method="post" action="<?= site_url('admin/walikelas/store') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Pilih Guru</label>
                            <select name="user_id" class="form-select border-0 bg-light py-2 rounded-3" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php foreach($guru as $g): ?>
                                    <option value="<?= $g['id'] ?>"><?= esc($g['nama']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tingkat Kelas</label>
                            <input type="text" name="kelas" class="form-control border-0 bg-light py-2 rounded-3" placeholder="Contoh: XII" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control border-0 bg-light py-2 rounded-3" placeholder="Contoh: RPL" required>
                        </div>

                        <button class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm border-0" style="background-color: var(--accent);">
                            <i class="bi bi-save2 me-2"></i>Simpan Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Daftar Wali Kelas</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small fw-bold text-uppercase border-0">Guru</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Kelas</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Jurusan</th>
                                    <th class="pe-4 py-3 text-muted small fw-bold text-uppercase border-0 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($wali as $w): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="fw-semibold"><?= esc($w['nama']) ?></span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3"><?= esc($w['kelas']) ?></span></td>
                                    <td class="fw-medium text-secondary"><?= esc($w['jurusan']) ?></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-light btn-sm rounded-3 border-0"><i class="bi bi-pencil-square text-primary"></i></button>
                                        <button class="btn btn-light btn-sm rounded-3 border-0 ms-1"><i class="bi bi-trash text-danger"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php if(empty($wali)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted small">Belum ada data wali kelas tersedia</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .card { transition: all 0.3s ease; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid var(--accent) !important;
        box-shadow: none;
    }
    .table thead th { font-size: 0.7rem; letter-spacing: 0.5px; }
</style>
<?= $this->endSection() ?>