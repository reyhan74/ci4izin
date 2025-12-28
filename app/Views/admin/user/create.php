<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center animate__animated animate__fadeIn">
    <div class="col-md-8">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="fw-bold text-dark mb-1">Tambah Pengguna Baru</h3>
                <p class="text-muted small mb-0">Daftarkan akun administrator atau operator baru ke dalam sistem.</p>
            </div>
            <a href="<?= site_url('admin/users') ?>" class="btn btn-light rounded-pill px-3 border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form action="<?= site_url('admin/users/store') ?>" method="post" id="formCreateUser">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Nama Lengkap</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge text-primary"></i></span>
                                <input type="text" name="nama" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="Masukkan nama lengkap user" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Email (Username)</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="nama@email.com" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Hak Akses / Role</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-primary"></i></span>
                                <select name="role" class="form-select bg-light border-start-0 ps-0" required>
                                    <option value="" disabled selected>Pilih Role...</option>
                                    <option value="admin">Admin (Akses Penuh)</option>
                                    <option value="guru">Guru (Operator Scan)</option>
                                    <option value="wali">Wali Kelas (Laporan)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Kata Sandi</label>
                            <div class="input-group input-group-modern">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-primary"></i></span>
                                <input type="password" name="password" id="passwordInput" class="form-control bg-light border-start-0 border-end-0 ps-0" 
                                       placeholder="Minimal 6 karakter" required minlength="6">
                                <button class="btn btn-light border-start-0 border border-light-subtle text-muted" type="button" id="btnTogglePassword">
                                    <i class="bi bi-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text x-small mt-2 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2 text-primary"></i> 
                                Pastikan password kuat dan mudah diingat oleh user.
                            </div>
                        </div>

                        <hr class="my-3 opacity-25">

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light rounded-pill px-4 border shadow-sm">Reset</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                <i class="bi bi-check-circle me-2"></i> Simpan User Baru
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling modern untuk input */
    .input-group-modern .form-control, 
    .input-group-modern .form-select,
    .input-group-modern .input-group-text,
    .input-group-modern .btn {
        padding: 0.75rem 1rem;
        border-color: #f1f5f9;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important;
        border-color: #4361ee !important;
        background-color: #fff !important;
    }

    .tracking-wider { letter-spacing: 0.05em; }
    .x-small { font-size: 0.75rem; color: #64748b; }
</style>

<script>
    // 1. Toggle Password Visibility
    const btnToggle = document.getElementById('btnTogglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const passwordIcon = document.getElementById('passwordIcon');

    btnToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        passwordIcon.classList.toggle('bi-eye');
        passwordIcon.classList.toggle('bi-eye-slash');
    });

    // 2. SweetAlert2 Confirmation & Validation
    document.getElementById('formCreateUser').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;

        // Validasi HTML5 dasar
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Daftarkan User Baru?',
            text: "Pastikan alamat email sudah benar untuk login.",
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
                // Loading state saat proses simpan
                Swal.fire({
                    title: 'Sedang Menyimpan...',
                    text: 'Mohon tunggu sebentar',
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