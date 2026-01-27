<?= $this->extend('layout/guru'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-4">
                    <li class="breadcrumb-item"><a href="/guru/siswa">Daftar Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Siswa</li>
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
                    <form action="/guru/siswa/update/<?= $siswa['id_siswa']; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <input type="hidden" name="fotoLama" value="<?= $siswa['foto']; ?>">

                        <div class="row">
                            <div class="col-md-8 border-right">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold small text-uppercase">Nomor Induk Siswa (NIS)</label>
                                        <input type="text" name="nis" class="form-control <?= (validation_show_error('nis')) ? 'is-invalid' : ''; ?>" 
                                               value="<?= old('nis', $siswa['nis']); ?>" placeholder="Masukkan NIS">
                                        <div class="invalid-feedback"><?= validation_show_error('nis'); ?></div>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold small text-uppercase">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" 
                                               value="<?= old('nama', $siswa['nama_siswa']); ?>" placeholder="Nama sesuai ijazah">
                                        <div class="invalid-feedback"><?= validation_show_error('nama'); ?></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small text-uppercase">Kelas & Jurusan</label>
                                        <select name="id_kelas" class="form-control custom-select">
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?= $k['id_kelas']; ?>" <?= ($k['id_kelas'] == $siswa['id_kelas']) ? 'selected' : ''; ?>>
                                                    <?= $k['kelas']; ?> - <?= $k['jurusan']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold small text-uppercase">Jenis Kelamin</label>
                                        <select name="jk" class="form-control custom-select">
                                            <?php 
                                                // Proteksi error offset string: ambil inisial L/P
                                                $valJK = strtoupper(substr(trim($siswa['jenis_kelamin'] ?? 'L'), 0, 1)); 
                                            ?>
                                            <option value="L" <?= ($valJK == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="P" <?= ($valJK == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold small text-uppercase">Nomor WhatsApp / HP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fab fa-whatsapp"></i></span>
                                        </div>
                                        <input type="text" name="no_hp" class="form-control" 
                                               value="<?= old('no_hp', $siswa['no_hp']); ?>" placeholder="62812xxx">
                                    </div>
                                    <small class="text-muted italic">Gunakan kode negara (Contoh: 62812...)</small>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <label class="font-weight-bold small text-uppercase d-block text-left mb-3">Foto Profil</label>
                                
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="img-preview-container shadow-sm border rounded-circle overflow-hidden bg-light" style="width: 180px; height: 180px;">
                                        <img src="/uploads/foto-siswa/<?= $siswa['foto'] ?: 'default.png'; ?>" 
                                             id="img-preview" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <label for="foto" class="btn btn-sm btn-primary position-absolute shadow" 
                                           style="bottom: 10px; right: 10px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="foto" class="d-none" id="foto" onchange="previewImg()">
                                </div>
                                
                                <div class="text-left bg-light p-2 rounded border small">
                                    <i class="fas fa-info-circle text-primary mr-1"></i> Format: JPG, PNG. Max: 2MB.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <a href="/guru/siswa" class="btn btn-light px-4 mr-2 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-warning px-5 text-white font-weight-bold rounded-pill shadow-sm">
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
    .img-preview-container { border: 4px solid #fff; }
</style>

<script>
function previewImg() {
    const foto = document.querySelector('#foto');
    const imgPreview = document.querySelector('#img-preview');

    const fileReader = new FileReader();
    fileReader.readAsDataURL(foto.files[0]);

    fileReader.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}
</script>
<?= $this->endSection(); ?>