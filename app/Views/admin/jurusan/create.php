<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <div class="d-flex align-items-center mb-3">
                <a href="/admin/jurusan" class="btn btn-sm btn-light rounded-circle mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-primary"></i>
                </a>
                <h1 class="h4 mb-0 text-gray-800 font-weight-bold">Tambah Jurusan</h1>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <form action="/admin/jurusan/store" method="post">
                        <?= csrf_field(); ?>

                        <div class="form-group mb-4">
                            <label class="form-label small font-weight-bold text-dark text-uppercase">Nama Jurusan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-microchip text-muted"></i></span>
                                </div>
                                <input type="text" name="jurusan" 
                                       class="form-control border-left-0 shadow-none" 
                                       placeholder="Contoh: Rekayasa Perangkat Lunak" 
                                       required autofocus>
                            </div>
                            <small class="form-text text-muted mt-2">
                                Tuliskan nama lengkap jurusan tanpa singkatan jika memungkinkan.
                            </small>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow rounded-pill font-weight-bold">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Jurusan
                            </button>
                            <a href="/admin/jurusan" class="btn btn-link btn-block text-muted small mt-2">
                                Batal dan Kembali
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
    
    /* Styling Input */
    .form-control {
        height: 50px !important;
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: none;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px !important;
        border: 1px solid #d1d3e2;
        padding-left: 20px;
        padding-right: 20px;
    }

    /* Input text radius adjustment */
    input.form-control {
        border-radius: 0 10px 10px 0 !important;
    }

    /* Tombol Effect */
    .btn-primary { transition: all 0.3s; }
    .btn-primary:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4) !important; 
    }

    /* Responsive Mobile */
    @media (max-width: 576px) {
        .card-body { padding: 1.5rem !important; }
        .btn-lg { height: 55px; font-size: 16px; }
    }
</style>
<?= $this->endSection(); ?>