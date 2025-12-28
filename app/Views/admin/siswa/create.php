<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="mb-4 d-flex align-items-center">
                <a href="<?= site_url('admin/siswa') ?>" class="btn btn-dark btn-sm rounded-3 me-3 bg-opacity-10 border-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Tambah Siswa Baru</h3>
                    <p class="text-muted small mb-0">Daftarkan data siswa ke dalam sistem E-Presensi.</p>
                </div>
            </div>

            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: white;">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= site_url('admin/siswa/store') ?>" method="post" id="tambahSiswaForm">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0 border-end">
                                <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25">
                                    <h6 class="text-primary fw-bold mb-2"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                                        Pastikan <strong>NIS</strong> unik. Sistem akan men-generate <strong>QR Code</strong> unik untuk setiap siswa setelah data berhasil disimpan.
                                    </p>
                                </div>
                                <div class="mt-4 text-center d-none d-md-block opacity-25">
                                    <i class="bi bi-person-plus text-primary" style="font-size: 5rem;"></i>
                                </div>
                            </div>

                            <div class="col-md-8 ps-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Nomor Induk Siswa (NIS)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="bi bi-card-text text-primary"></i>
                                        </span>
                                        <input type="text" name="nis" class="form-control modern-input" 
                                               placeholder="Contoh: 222310101" required autofocus>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control modern-input" 
                                           placeholder="Nama lengkap siswa" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small fw-bold text-uppercase">Kelas</label>
                                        <input type="text" name="kelas" class="form-control modern-input" 
                                               placeholder="Contoh: XII" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small fw-bold text-uppercase">Jurusan</label>
                                        <input type="text" name="jurusan" class="form-control modern-input" 
                                               placeholder="Contoh: RPL" required>
                                    </div>
                                </div>

                                <hr class="my-4 opacity-10">

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= site_url('admin/siswa') ?>" class="btn btn-light rounded-pill px-4 border">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling Input Modern */
    .modern-input {
        background: #f8fafc !important;
        border: 2px solid #f1f5f9 !important;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .modern-input:focus {
        background: #fff !important;
        border-color: #4361ee !important;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px !important;
        border: 2px solid #f1f5f9 !important;
        border-right: none !important;
    }

    .input-group .modern-input {
        border-radius: 0 12px 12px 0 !important;
    }

    /* Card Shadow & Radius */
    .card {
        border-radius: 24px;
    }

    /* Button Style */
    .btn-primary {
        background-color: #4361ee;
        border: none;
    }
    .btn-primary:hover {
        background-color: #3751d4;
        transform: translateY(-1px);
    }
</style>

<script>
    // SweetAlert Intergration
    document.getElementById('tambahSiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;

        // Validasi Sederhana
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Siswa?',
            text: "Data akan segera didaftarkan ke sistem.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan Loading (Sangat penting karena generator QR butuh waktu)
                Swal.fire({
                    title: 'Sedang Memproses',
                    text: 'Menyimpan data dan membuat QR Code...',
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