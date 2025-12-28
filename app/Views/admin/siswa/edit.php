<?= $this->extend('layout/admin') ?> 
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        
        <div class="mb-4 d-flex align-items-center animate__animated animate__fadeIn">
            <a href="<?= site_url('admin/siswa') ?>" class="btn btn-light btn-sm rounded-3 me-3 border shadow-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Edit Profil Siswa</h3>
                <p class="text-muted small mb-0">Perbarui informasi data diri siswa secara berkala.</p>
            </div>
        </div>

        <div class="card border-0 shadow-lg animate__animated animate__zoomIn" style="border-radius: 24px;">
            <div class="card-body p-4 p-md-5">
                <form action="<?= site_url('admin/siswa/update/'.$siswa['id']) ?>" method="post" id="editSiswaForm">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-4 text-center border-end mb-4 mb-md-0">
                            <div class="mb-3">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama']) ?>&background=4361ee&color=fff&size=128" 
                                     class="rounded-4 shadow border border-4 border-white" 
                                     width="120" alt="avatar">
                            </div>
                            <h6 class="fw-bold text-dark mb-1"><?= esc($siswa['nama']) ?></h6>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill">
                                NIS: <?= esc($siswa['nis']) ?>
                            </span>
                        </div>

                        <div class="col-md-8 ps-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nomor Induk Siswa (NIS)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control bg-light border-0" 
                                           value="<?= esc($siswa['nis']) ?>" readonly style="cursor: not-allowed;">
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">* NIS bersifat unik dan permanen.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nama Lengkap Siswa</label>
                                <input type="text" name="nama" class="form-control modern-input" 
                                       value="<?= esc($siswa['nama']) ?>" required placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Kelas</label>
                                    <input type="text" name="kelas" class="form-control modern-input" 
                                           value="<?= esc($siswa['kelas']) ?>" required placeholder="Contoh: XII">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control modern-input" 
                                           value="<?= esc($siswa['jurusan']) ?>" required placeholder="Contoh: RPL">
                                </div>
                            </div>

                            <hr class="my-4 opacity-10">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= site_url('admin/siswa') ?>" class="btn btn-light rounded-pill px-4 border">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modern-input {
        background: #f8fafc !important;
        border: 2px solid #f1f5f9 !important;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .modern-input:focus {
        background: #fff !important;
        border-color: #4361ee !important;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important;
    }

    .card { border-radius: 24px; }
</style>

<script>
    // SweetAlert Konfirmasi Simpan
    document.getElementById('editSiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan data yang diinput sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan Loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memperbarui data siswa',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
</script>

<?= $this->endSection() ?>