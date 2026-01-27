<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
                <p class="text-muted small mb-0">Silakan isi formulir di bawah ini dengan data yang benar.</p>
            </div>
            <a href="/admin/siswa" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm border-0">
                <div style="height: 5px; background: #4e73df; border-radius: 5px 5px 0 0;"></div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="/admin/siswa/saveSiswa" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-lg-8 border-right-lg">
                                <h5 class="text-primary font-weight-bold mb-4">Informasi Pribadi</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 form-group mb-4">
                                        <label class="text-dark font-weight-bold">Nomor Induk Siswa (NIS)</label>
                                        <input type="text" class="form-control form-control-user <?= (validation_show_error('nis')) ? 'is-invalid' : ''; ?>" 
                                               name="nis" value="<?= old('nis'); ?>" placeholder="Masukkan NIS">
                                        <div class="invalid-feedback"><?= validation_show_error('nis'); ?></div>
                                    </div>

                                    <div class="col-md-6 form-group mb-4">
                                        <label class="text-dark font-weight-bold">Nama Lengkap</label>
                                        <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" 
                                               name="nama" value="<?= old('nama'); ?>" placeholder="Nama sesuai ijazah">
                                        <div class="invalid-feedback"><?= validation_show_error('nama'); ?></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-4">
                                        <label class="text-dark font-weight-bold">Kelas & Jurusan</label>
                                        <select class="custom-select <?= (validation_show_error('id_kelas')) ? 'is-invalid' : ''; ?>" name="id_kelas">
                                            <option value="" selected disabled>-- Pilih Kelas --</option>
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?= $k['id_kelas']; ?>" <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : ''; ?>>
                                                    <?= $k['kelas']; ?> - <?= $k['jurusan']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"><?= validation_show_error('id_kelas'); ?></div>
                                    </div>

                                    <div class="col-md-6">
                           <label for="jk">Jenis Kelamin</label>
                           <?php
                           if (old('jk')) {
                              $l = (old('jk') ?? $oldInput['jk']) == '1' ? 'checked' : '';
                              $p = (old('jk') ?? $oldInput['jk']) == '2' ? 'checked' : '';
                           }
                           ?>
                           <div class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>" id="jk">
                              <div class="row">
                                 <div class="col-auto">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jk" id="laki" value="1" <?= $l ?? ''; ?>>
                                       </div>
                                       <div class="col">
                                          <label class="form-check-label pl-0 pt-1" for="laki">
                                             <h6 class="text-dark">Laki-laki</h6>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jk" id="perempuan" value="2" <?= $p ?? ''; ?>>
                                       </div>
                                       <div class="col">
                                          <label class="form-check-label pl-0 pt-1" for="perempuan">
                                             <h6 class="text-dark">Perempuan</h6>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="invalid-feedback">
                              <?= $validation->getError('jk'); ?>
                           </div>
                        </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-dark font-weight-bold">Nomor WhatsApp/HP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">+62</span>
                                        </div>
                                        <input type="text" class="form-control" name="no_hp" value="<?= old('no_hp'); ?>" placeholder="8123456789">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-4 mt-lg-0">
                                <h5 class="text-primary font-weight-bold mb-4 text-center text-lg-left">Foto Profil</h5>
                                
                                <div class="text-center bg-light p-4 rounded border">
                                    <div class="mb-3">
                                        <div class="mx-auto shadow-sm border bg-white" 
                                             style="width: 160px; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 8px;">
                                            <img src="" id="img-preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                            <span id="placeholder-text" class="text-muted small px-2">Preview Foto</span>
                                        </div>
                                    </div>

                                    <div class="custom-file mt-2">
                                        <input type="file" class="custom-file-input <?= (validation_show_error('foto')) ? 'is-invalid' : ''; ?>" 
                                               id="foto-siswa" name="foto" onchange="previewImage()">
                                        <label class="custom-file-label text-left overflow-hidden" for="foto-siswa">Pilih File</label>
                                        <div class="invalid-feedback text-left"><?= validation_show_error('foto'); ?></div>
                                    </div>
                                    <ul class="text-left mt-3 text-muted small pl-3">
                                        <li>Format: JPG, JPEG, PNG</li>
                                        <li>Ukuran Maks: 2 MB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light px-4 mr-2">Reset</button>
                            <button type="submit" class="btn btn-primary px-5 font-weight-bold">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const foto = document.querySelector('#foto-siswa');
        const imgPreview = document.querySelector('#img-preview');
        const placeholder = document.querySelector('#placeholder-text');
        const fileLabel = document.querySelector('.custom-file-label');

        fileLabel.textContent = foto.files[0].name;

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.style.display = 'block';
            placeholder.style.display = 'none';
            imgPreview.src = e.target.result;
        }
    }
</script>

<style>
    /* Tambahan CSS untuk responsivitas */
    @media (min-width: 992px) {
        .border-right-lg {
            border-right: 1px solid #e3e6f0;
            padding-right: 2rem;
        }
    }
    .custom-file-label::after {
        content: "Cari";
    }
    .form-control:focus, .custom-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
    }
</style>
<?= $this->endSection(); ?>