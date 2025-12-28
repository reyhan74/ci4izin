<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center animate__animated animate__fadeIn">
    <div class="col-md-8">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="fw-bold text-dark mb-1">Edit Pengguna</h3>
                <p class="text-muted small mb-0">Perbarui informasi akun dan hak akses user.</p>
            </div>
            <a href="<?= site_url('admin/users') ?>" class="btn btn-light rounded-pill px-3 border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form action="<?= site_url('admin/users/update/'.$user['id']) ?>" method="post" id="formEditUser">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-12 text-center mb-5">
                            <div class="position-relative d-inline-block">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama']) ?>&background=4361ee&color=fff&size=128" 
                                     class="rounded-circle shadow border border-4 border-white mb-2" width="100" alt="Avatar">
                                <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2" title="User Aktif"></span>
                            </div>
                            <h5 class="fw-bold mb-0 mt-2 text-dark"><?= esc($user['nama']) ?></h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mt-1 border border-primary border-opacity-10">
                                <i class="bi bi-shield-check me-1"></i> <?= ucfirst($user['role']) ?>
                            </span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" name="nama" class="form-control bg-light border-start-0 ps-0" 
                                       value="<?= esc($user['nama']) ?>" required placeholder="Masukkan nama lengkap">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Email (Username)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0 ps-0" 
                                       value="<?= esc($user['email']) ?>" required placeholder="nama@sekolah.id">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Role / Hak Akses</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock text-primary"></i></span>
                                <select name="role" class="form-select bg-light border-start-0 ps-0" required>
                                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin (Full Access)</option>
                                    <option value="guru" <?= $user['role']=='guru'?'selected':'' ?>>Guru (Operator)</option>
                                    <option value="wali" <?= $user['role']=='wali'?'selected':'' ?>>Wali Kelas</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-primary"></i></span>
                                <input type="password" name="password" id="passwordInput" class="form-control bg-light border-start-0 border-end-0 ps-0" 
                                       placeholder="Kosongkan jika tidak diubah">
                                <button class="btn btn-light border-start-0 border text-muted" type="button" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text x-small mt-2 text-warning fw-medium">
                                <i class="bi bi-info-circle-fill"></i> Biarkan kosong jika password tetap sama.
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 fw-bold shadow-sm">
                                <i class="bi bi-cloud-arrow-up me-2"></i> Update Informasi Pengguna
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        border-color: #4361ee;
        background-color: white !important;
    }
    .input-group-text { border-color: #dee2e6; color: #94a3b8; }
    .x-small { font-size: 0.72rem; }
</style>

<script>
    // 1. Toggle Password Visibility
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('passwordIcon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // 2. SweetAlert Konfirmasi Update
    document.getElementById('formEditUser').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Informasi pengguna akan diperbarui dalam sistem.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan Loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memperbarui data user',
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