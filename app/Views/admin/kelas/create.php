<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <div class="d-flex align-items-center mb-3">
                <a href="/admin/kelas" class="btn btn-sm btn-light rounded-circle mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-primary"></i>
                </a>
                <h1 class="h4 mb-0 text-gray-800 font-weight-bold">Tambah Kelas</h1>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form action="/admin/kelas/store" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-4">
                            <label class="form-label small font-weight-bold text-dark text-uppercase">Tingkat Kelas</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-layer-group text-muted"></i></span>
                                </div>
                                <select name="kelas" class="form-control custom-select border-left-0 shadow-none" required>
                                    <option value="" disabled selected>Pilih Tingkat...</option>
                                    <option value="X">Kelas X</option>
                                    <option value="XI">Kelas XI</option>
                                    <option value="XII">Kelas XII</option>
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
                                    <option value="" disabled selected>Pilih Jurusan...</option>
                                    <?php foreach($jurusan as $j): ?>
                                        <option value="<?= $j['id'] ?>"><?= $j['jurusan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow rounded-pill font-weight-bold" style="font-size: 16px;">
                                <i class="fas fa-save mr-2"></i> Simpan Data
                            </button>
                            <a href="/admin/kelas" class="btn btn-link btn-block text-muted small mt-2">
                                Batal dan Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert bg-soft-info border-0 rounded-lg mt-4 p-3 d-flex align-items-start">
                <i class="fas fa-info-circle text-info mt-1 mr-3"></i>
                <small class="text-info">
                    Pastikan kombinasi Tingkat dan Jurusan belum ada sebelumnya untuk menghindari duplikasi data kelas.
                </small>
            </div>

        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fc; }
    
    /* Styling Form Control */
    .form-control, .custom-select {
        height: 50px !important;
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        font-size: 15px;
    }

    .form-control:focus, .custom-select:focus {
        border-color: #4e73df;
        box-shadow: none;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px !important;
        border: 1px solid #d1d3e2;
    }

    .custom-select {
        border-radius: 0 10px 10px 0 !important;
    }

    /* Custom Color */
    .bg-soft-info { background-color: rgba(54, 185, 204, 0.1); }
    
    /* Tombol Hover Effect */
    .btn-primary { transition: all 0.3s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4) !important; }

    /* Responsif Mobile */
    @media (max-width: 576px) {
        .card-body { padding: 1.5rem !important; }
        .h4 { font-size: 1.2rem; }
        .btn-lg { height: 55px; }
    }
</style>
<?= $this->endSection(); ?>