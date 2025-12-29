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
                                    <select name="kelas" class="form-select modern-input" required>
                                        <option value="" disabled>Pilih Kelas</option>
                                        <option value="X" <?= ($siswa['kelas'] == 'X') ? 'selected' : '' ?>>X (Sepuluh)</option>
                                        <option value="XI" <?= ($siswa['kelas'] == 'XI') ? 'selected' : '' ?>>XI (Sebelas)</option>
                                        <option value="XII" <?= ($siswa['kelas'] == 'XII') ? 'selected' : '' ?>>XII (Duabelas)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Jurusan</label>
                                    <select name="jurusan" class="form-select modern-input" required>
                                        <option value="" disabled>Pilih Jurusan</option>
                                        
                                        <optgroup label="Teknik Komputer & Jaringan">
                                            <?php for($i=1; $i<=3; $i++): ?>
                                                <option value="TKJ <?= $i ?>" <?= ($siswa['jurusan'] == "TKJ $i") ? 'selected' : '' ?>>TKJ <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>

                                        <optgroup label="Teknik Otomasi Industri">
                                            <?php for($i=1; $i<=2; $i++): ?>
                                                <option value="TOI <?= $i ?>" <?= ($siswa['jurusan'] == "TOI $i") ? 'selected' : '' ?>>TOI <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>

                                        <optgroup label="Teknik Pemesinan">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <option value="TPM <?= $i ?>" <?= ($siswa['jurusan'] == "TPM $i") ? 'selected' : '' ?>>TPM <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>

                                        <optgroup label="Teknik Kendaraan Ringan">
                                            <?php for($i=1; $i<=3; $i++): ?>
                                                <option value="TKR <?= $i ?>" <?= ($siswa['jurusan'] == "TKR $i") ? 'selected' : '' ?>>TKR <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>

                                        <optgroup label="Teknik Instalasi Tenaga Listrik">
                                            <?php for($i=1; $i<=3; $i++): ?>
                                                <option value="TITL <?= $i ?>" <?= ($siswa['jurusan'] == "TITL $i") ? 'selected' : '' ?>>TITL <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>

                                        <optgroup label="Desain Pemodelan & Informasi Bangunan">
                                            <?php for($i=1; $i<=2; $i++): ?>
                                                <option value="DPIB <?= $i ?>" <?= ($siswa['jurusan'] == "DPIB $i") ? 'selected' : '' ?>>DPIB <?= $i ?></option>
                                            <?php endfor; ?>
                                        </optgroup>
                                    </select>
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
        color: #334155;
    }

    .modern-input:focus {
        background: #fff !important;
        border-color: #4361ee !important;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important;
    }

    /* Styling khusus Select agar arrow seragam */
    select.modern-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 1rem center !important;
        background-size: 16px 12px !important;
    }

    optgroup {
        font-weight: 700;
        color: #4361ee;
        font-style: normal;
        background: #fff;
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