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
                    
                    <form method="post" action="<?= site_url('admin/walikelas/store') ?>" id="formTambah">
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
                            <select name="kelas" class="form-select border-0 bg-light py-2 rounded-3" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jurusan</label>
                            <select name="jurusan" class="form-select border-0 bg-light py-2 rounded-3" required>
                                <option value="">Pilih Jurusan</option>
                                <optgroup label="Teknik Komputer & Jaringan">
                                    <option value="TKJ 1">TKJ 1</option>
                                    <option value="TKJ 2">TKJ 2</option>
                                    <option value="TKJ 3">TKJ 3</option>
                                </optgroup>
                                <optgroup label="Teknik Otomasi Industri">
                                    <option value="TOI 1">TOI 1</option>
                                    <option value="TOI 2">TOI 2</option>
                                </optgroup>
                                <optgroup label="Teknik Pemesinan">
                                    <option value="TPM 1">TPM 1</option>
                                    <option value="TPM 2">TPM 2</option>
                                    <option value="TPM 3">TPM 3</option>
                                    <option value="TPM 4">TPM 4</option>
                                    <option value="TPM 5">TPM 5</option>
                                </optgroup>
                                <optgroup label="Teknik Kendaraan Ringan">
                                    <option value="TKR 1">TKR 1</option>
                                    <option value="TKR 2">TKR 2</option>
                                    <option value="TKR 3">TKR 3</option>
                                </optgroup>
                                <optgroup label="Teknik Instalasi Tenaga Listrik">
                                    <option value="TITL 1">TITL 1</option>
                                    <option value="TITL 2">TITL 2</option>
                                    <option value="TITL 3">TITL 3</option>
                                </optgroup>
                                <optgroup label="Desain Pemodelan & Informasi Bangunan">
                                    <option value="DPIB 1">DPIB 1</option>
                                    <option value="DPIB 2">DPIB 2</option>
                                </optgroup>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm border-0">
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
                                            <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="fw-semibold"><?= esc($w['nama']) ?></span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3"><?= esc($w['kelas']) ?></span></td>
                                    <td class="fw-medium text-secondary"><?= esc($w['jurusan']) ?></td>
                                    <td class="pe-4 text-end">
                                        <button onclick="editWali(<?= htmlspecialchars(json_encode($w)) ?>)" class="btn btn-light btn-sm rounded-3 border-0">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <a href="<?= site_url('admin/walikelas/delete/'.$w['id']) ?>" class="btn btn-light btn-sm rounded-3 border-0 ms-1 btn-hapus">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">Edit Penugasan Wali Kelas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Guru</label>
                        <select name="user_id" id="edit_user_id" class="form-select border-0 bg-light py-2 rounded-3" required>
                            <?php foreach($guru as $g): ?>
                                <option value="<?= $g['id'] ?>"><?= esc($g['nama']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kelas</label>
                        <select name="kelas" id="edit_kelas" class="form-select border-0 bg-light py-2 rounded-3" required>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jurusan</label>
                        <select name="jurusan" id="edit_jurusan" class="form-select border-0 bg-light py-2 rounded-3" required>
                             <option value="TKJ 1">TKJ 1</option>
                             <option value="TKJ 2">TKJ 2</option>
                             <option value="TKJ 3">TKJ 3</option>
                             <option value="TOI 1">TOI 1</option>
                             <option value="TOI 2">TOI 2</option>
                             <option value="TPM 1">TPM 1</option>
                             <option value="TPM 2">TPM 2</option>
                             <option value="TPM 3">TPM 3</option>
                             <option value="TPM 4">TPM 4</option>
                             <option value="TPM 5">TPM 5</option>
                             <option value="TKR 1">TKR 1</option>
                             <option value="TKR 2">TKR 2</option>
                             <option value="TKR 3">TKR 3</option>
                             <option value="TITL 1">TITL 1</option>
                             <option value="TITL 2">TITL 2</option>
                             <option value="TITL 3">TITL 3</option>
                             <option value="DPIB 1">DPIB 1</option>
                             <option value="DPIB 2">DPIB 2</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi Edit Modal
    function editWali(data) {
        document.getElementById('formEdit').action = "<?= site_url('admin/walikelas/update/') ?>" + data.id;
        document.getElementById('edit_user_id').value = data.user_id;
        document.getElementById('edit_kelas').value = data.kelas;
        document.getElementById('edit_jurusan').value = data.jurusan;
        
        var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }

    // Konfirmasi Hapus
    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data penugasan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });

    // Notifikasi Sukses
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success') ?>', timer: 2000, showConfirmButton: false });
    <?php endif; ?>
</script>

<style>
    .fw-800 { font-weight: 800; }
    .card { transition: all 0.3s ease; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid var(--accent) !important;
        box-shadow: none;
    }
    .table thead th { font-size: 0.7rem; letter-spacing: 0.5px; }
    .avatar-sm { flex-shrink: 0; }
</style>
<?= $this->endSection() ?>