<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="/admin/siswa" class="text-decoration-none text-muted">Daftar Siswa</a></li>
                    <li class="breadcrumb-item active text-dark font-weight-bold" aria-current="page">Edit Siswa</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <div class="bg-warning-soft p-2 rounded mr-3">
                        <i class="fas fa-user-edit text-warning"></i>
                    </div>
                    <h6 class="m-0 font-weight-bold text-dark">Edit Data Profil Siswa</h6>
                </div>
                
                <div class="card-body p-4">
                    <form action="/admin/siswa/update/<?= $siswa['id_siswa']; ?>" method="post" enctype="multipart/form-data" id="formEditSiswa">
                        <?= csrf_field(); ?>
                        
                        <input type="hidden" name="fotoLama" value="<?= $siswa['foto']; ?>">

                        <div class="row">
                            <!-- Kolom Kiri: Data Form -->
                            <div class="col-md-8 pr-md-4">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Nomor Induk Siswa (NIS)</label>
                                        <input type="text" name="nis" class="form-control <?= (validation_show_error('nis')) ? 'is-invalid' : ''; ?>" 
                                               value="<?= old('nis', $siswa['nis']); ?>" placeholder="Masukkan NIS">
                                        <div class="invalid-feedback"><?= validation_show_error('nis'); ?></div>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold small text-muted">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" 
                                               value="<?= old('nama', $siswa['nama_siswa']); ?>" placeholder="Nama sesuai ijazah">
                                        <div class="invalid-feedback"><?= validation_show_error('nama'); ?></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small text-muted">Kelas & Jurusan</label>
                                        <select name="id_kelas" class="form-control custom-select rounded-pill">
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?= $k['id_kelas']; ?>" <?= ($k['id_kelas'] == $siswa['id_kelas']) ? 'selected' : ''; ?>>
                                                    <?= $k['kelas']; ?> - <?= $k['jurusan']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small text-muted">Jenis Kelamin</label>
                                        <select name="jk" class="form-control custom-select rounded-pill">
                                            <?php 
                                                $valJK = strtoupper(substr(trim($siswa['jenis_kelamin'] ?? 'L'), 0, 1)); 
                                            ?>
                                            <option value="L" <?= ($valJK == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="P" <?= ($valJK == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold small text-muted">Nomor WhatsApp / HP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0 rounded-left-pill"><i class="fab fa-whatsapp text-success"></i></span>
                                        </div>
                                        <input type="text" name="no_hp" class="form-control border-left-0 rounded-right-pill" 
                                               value="<?= old('no_hp', $siswa['no_hp']); ?>" placeholder="62812xxx">
                                    </div>
                                    <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Gunakan kode negara (Contoh: 62812...)</small>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Upload Foto -->
                            <div class="col-md-4 text-center border-left-md pl-md-4">
                                <label class="font-weight-bold small text-muted d-block text-left mb-3">Foto Profil</label>
                                
                                <div class="position-relative d-inline-block mb-3">
                                    <!-- CONTAINER FOTO (SAMA SEPERTI INDEX & SHOW) -->
                                    <div class="img-preview-container avatar-wrapper rounded-circle shadow-sm border d-flex align-items-center justify-content-center overflow-hidden bg-light" 
                                         style="width: 180px; height: 180px; background-color: #eaecf4; position: relative;">
                                        
                                        <!-- LOGIKA TAMPILAN: Jika ada file, tampilkan gambar. Jika tidak, tampilkan Inisial -->
                                        <?php 
                                        $pathFoto = 'uploads/foto-siswa/' . $siswa['foto'];
                                        $fotoAda = !empty($siswa['foto']) && file_exists(FCPATH . $pathFoto);
                                        ?>

                                        <?php if ($fotoAda) : ?>
                                            <!-- Tag Gambar (Default Visible) -->
                                            <img src="/<?= $pathFoto; ?>" id="img-preview" class="w-100 h-100" style="object-fit: cover; z-index: 2;">
                                            <!-- Span Inisial (Hidden) -->
                                            <span id="preview-initial" class="text-primary font-weight-bold d-none" style="font-size: 60px; z-index: 1;">
                                                <?= strtoupper(substr($siswa['nama_siswa'], 0, 1)); ?>
                                            </span>
                                        <?php else : ?>
                                            <!-- Tag Gambar (Hidden/Dummy) -->
                                            <img src="" id="img-preview" class="w-100 h-100 d-none" style="object-fit: cover; z-index: 2;">
                                            <!-- Span Inisial (Visible) -->
                                            <span id="preview-initial" class="text-primary font-weight-bold" style="font-size: 60px; z-index: 1;">
                                                <?= strtoupper(substr($siswa['nama_siswa'], 0, 1)); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- END CONTAINER FOTO -->

                                    <label for="foto" class="btn btn-sm btn-primary position-absolute shadow border-white" 
                                           style="bottom: 10px; right: 10px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="foto" class="d-none" id="foto" onchange="previewImg()" accept="image/*">
                                </div>
                                
                                <div class="text-left bg-light p-2 rounded border small">
                                    <i class="fas fa-info-circle text-warning mr-1"></i> Format: JPG, PNG. Max: 2MB.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <a href="/admin/siswa" class="btn btn-light px-4 mr-2 rounded-pill border font-weight-bold">Batal</a>
                            <button type="submit" class="btn btn-warning px-5 text-white font-weight-bold rounded-pill shadow-sm hover-lift" id="btnSubmit">
                                <i class="fas fa-save mr-2"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-warning-soft { background-color: rgba(246, 194, 62, 0.15); }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; vertical-align: middle; }
    .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #e3e6f0; }
    .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.1); border-color: #f6c23e; }
    
    /* Styling untuk Input Group Rounded */
    .rounded-left-pill { border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important; }
    .rounded-right-pill { border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; }
    
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(246, 194, 62, 0.3) !important; }
    
    @media (max-width: 768px) {
        .border-left-md, .pl-md-4, .pr-md-4 { border-left: none !important; padding-left: 15px !important; padding-right: 15px !important; }
    }
</style>

<script>
    // Preview Gambar saat dipilih
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview');
        const initialPreview = document.querySelector('#preview-initial');

        if (foto.files && foto.files[0]) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(foto.files[0]);

            fileReader.onload = function(e) {
                // Tampilkan gambar baru
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
                
                // Sembunyikan inisial
                initialPreview.classList.add('d-none');
            }
        }
    }

    // Mencegah Double Submit
    document.getElementById('formEditSiswa').addEventListener('submit', function() {
        var btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
    });
</script>
<?= $this->endSection(); ?>