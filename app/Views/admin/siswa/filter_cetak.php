<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-print mr-2"></i> Menu Cetak QR Code Massal</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('admin/siswa/cetak-qr-massal'); ?>" method="GET" target="_blank">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Pilih Jurusan</label>
                            <select name="filter_jurusan" id="filter_jurusan_cetak" class="form-control">
                                <option value="">-- Semua Jurusan --</option>
                                <?php foreach($data_jurusan as $j) : ?>
                                    <option value="<?= $j['id']; ?>"><?= $j['jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Pilih Kelas</label>
                            <select name="filter_kelas" id="filter_kelas_cetak" class="form-control">
                                <option value="">-- Semua Kelas --</option>
                                <?php foreach($data_kelas as $k) : ?>
                                    <option value="<?= $k['id_kelas']; ?>" data-jurusan="<?= $k['id_jurusan']; ?>">
                                        <?= $k['kelas']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted mt-2 d-block">* Kosongkan pilihan jika ingin mencetak semua data.</small>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/siswa" class="btn btn-light border px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                <i class="fas fa-qrcode mr-2"></i> Generate & Cetak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk sinkronisasi dropdown jurusan dan kelas
    const jurusanSelect = document.getElementById('filter_jurusan_cetak');
    const kelasSelect = document.getElementById('filter_kelas_cetak');
    const originalKelasOptions = Array.from(kelasSelect.options);

    jurusanSelect.addEventListener('change', function() {
        const selectedJurusan = this.value;
        
        kelasSelect.innerHTML = '';
        originalKelasOptions.forEach(option => {
            if (selectedJurusan === '' || option.value === '' || option.getAttribute('data-jurusan') === selectedJurusan) {
                kelasSelect.appendChild(option);
            }
        });
    });
</script>
<?= $this->endSection(); ?>