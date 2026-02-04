<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <div class="d-flex align-items-center mb-3">
                <a href="/admin/jurusan" class="btn btn-sm btn-white rounded-circle mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-warning"></i>
                </a>
                <div>
                    <h1 class="h4 mb-0 text-gray-800 font-weight-bold">Edit Jurusan</h1>
                    <small class="text-muted">ID Jurusan: #<?= $jurusan['id'] ?></small>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form action="/admin/jurusan/update/<?= $jurusan['id'] ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-4">
                            <label class="form-label small font-weight-bold text-dark text-uppercase">Nama Jurusan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-edit text-muted"></i></span>
                                </div>
                                <input type="text" name="jurusan" 
                                       class="form-control border-left-0 shadow-none" 
                                       value="<?= esc($jurusan['jurusan']) ?>" 
                                       placeholder="Masukkan nama jurusan..." 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-warning btn-block btn-lg shadow rounded-pill font-weight-bold text-white">
                                <i class="fas fa-sync-alt mr-2"></i> Update Jurusan
                            </button>
                            <a href="/admin/jurusan" class="btn btn-link btn-block text-muted small mt-2">
                                Batal, Kembali ke Daftar
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
    .form-control {
        height: 50px !important;
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #f6c23e;
        box-shadow: none;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px !important;
        border: 1px solid #d1d3e2;
        padding-left: 18px;
        padding-right: 18px;
    }

    /* Fix radius untuk input sebelah kanan ikon */
    input.form-control {
        border-radius: 0 10px 10px 0 !important;
    }

    .btn-white {
        background: #fff;
        border: none;
    }

    /* Animasi Tombol Update */
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

    /* Mobile View Adjustments */
    @media (max-width: 576px) {
        .card-body { padding: 1.5rem !important; }
        .btn-lg { height: 55px; font-size: 16px; }
    }
</style>
<?= $this->endSection(); ?>