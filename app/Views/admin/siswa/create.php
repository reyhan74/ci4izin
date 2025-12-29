<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="mb-4 d-flex align-items-center">
                <a href="<?= site_url('admin/siswa') ?>" class="btn btn-dark btn-sm rounded-3 me-3 bg-opacity-10 border-secondary">
                    <i class="bi bi-arrow-left text-dark"></i>
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
                                        <select name="kelas" class="form-select modern-input" required>
                                            <option value="" selected disabled>Pilih Kelas</option>
                                            <option value="X">X (Sepuluh)</option>
                                            <option value="XI">XI (Sebelas)</option>
                                            <option value="XII">XII (Duabelas)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small fw-bold text-uppercase">Jurusan</label>
                                        <select name="jurusan" class="form-select modern-input" required>
                                            <option value="" selected disabled>Pilih Jurusan</option>
                                            
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
    /* Styling Input & Select Modern */
    .modern-input {
        background: #f8fafc !important;
        border: 2px solid #f1f5f9 !important;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        color: #334155;
    }

    .modern-input:focus {
        background: #fff !important;
        border-color: #4361ee !important;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important;
    }

    /* Khusus untuk Dropdown Select agar tampil seragam */
    select.modern-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 1rem center !important;
        background-size: 16px 12px !important;
    }

    optgroup {
        font-size: 0.85rem;
        color: #4361ee;
        font-weight: 700;
        background: #fff;
    }

    option {
        color: #334155;
        font-weight: normal;
        padding: 10px;
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
    .card { border-radius: 24px; }

    /* Button Style */
    .btn-primary { background-color: #4361ee; border: none; }
    .btn-primary:hover { background-color: #3751d4; transform: translateY(-1px); }
</style>

<script>
    document.getElementById('tambahSiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;

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