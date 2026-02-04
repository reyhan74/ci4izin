<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <div class="d-flex align-items-center mb-3">
                <a href="/admin/kelas" class="btn btn-sm btn-white rounded-circle mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-warning"></i>
                </a>
                <div>
                    <h1 class="h4 mb-0 text-gray-800 font-weight-bold">Edit Kelas</h1>
                    <small class="text-muted">Perbarui informasi tingkat atau jurusan</small>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form action="/admin/kelas/update/<?= $kelas['id_kelas'] ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-4">
                            <label class="form-label small font-weight-bold text-dark text-uppercase">Tingkat Kelas</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-layer-group text-muted"></i></span>
                                </div>
                                <select name="kelas" class="form-control custom-select border-left-0 shadow-none" required>
                                    <option value="X" <?= ($kelas['kelas'] == "X") ? 'selected' : '' ?>>Kelas X</option>
                                    <option value="XI" <?= ($kelas['kelas'] == "XI") ? 'selected' : '' ?>>Kelas XI</option>
                                    <option value="XII" <?= ($kelas['kelas'] == "XII") ? 'selected' : '' ?>>Kelas XII</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label small font-weight-bold text-dark text-uppercase">Jurusan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-graduation-cap text-muted"></i></span>
                                </div>
                                <select name="id_jurusan" class="form-control custom-select border-left-0 shadow-none" required>
                                    <?php foreach($jurusan as $j): ?>
                                        <option value="<?= $j['id'] ?>" <?= ($kelas['id_jurusan'] == $j['id']) ? 'selected' : '' ?>>
                                            <?= $j['jurusan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-warning btn-block btn-lg shadow rounded-pill font-weight-bold text-white" style="font-size: 16px;">
                                <i class="fas fa-sync-alt mr-2"></i> Perbarui Data
                            </button>
                            <a href="/admin/kelas" class="btn btn-link btn-block text-muted small mt-2">
                                Batal, Jangan Ubah
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fc; }
    
    /* Form Styling */
    .form-control, .custom-select {
        height: 50px !important;
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        font-size: 15px;
    }

    .form-control:focus, .custom-select:focus {
        border-color: #f6c23e; /* Warna Kuning/Warning */
        box-shadow: none;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px !important;
        border: 1px solid #d1d3e2;
    }

    .custom-select {
        border-radius: 0 10px 10px 0 !important;
    }

    .btn-white {
        background: #fff;
        border: none;
    }
    
    /* Animasi Hover */
    .btn-warning {
        background-color: #f6c23e;
        border-color: #f6c23e;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background-color: #dda20a;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(246, 194, 62, 0.4) !important;
    }

    /* Responsif untuk HP */
    @media (max-width: 576px) {
        .container-fluid { padding-top: 20px; }
        .card-body { padding: 1.5rem !important; }
        .btn-lg { height: 55px; }
    }
</style>
<?= $this->endSection(); ?>