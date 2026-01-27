<!-- Ganti FORM lama dengan kode ini -->
<div class="card-body p-4">
    <!-- Kita hapus tag <form> dan gunakan event onchange pada dropdown -->
    <div class="row align-items-end">
        <div class="col-md-4 mb-3 mb-md-0">
            <label class="small font-weight-bold text-muted">Filter Kelas</label>
            
            <!-- Menambahkan onchange="location.href=this.value" -->
            <select onchange="location.href=this.value" class="form-control custom-select rounded-pill">
                <option value="/admin/siswa/cetak_qr" <?= ($filter_kelas == '') ? 'selected' : ''; ?>>
                    -- Semua Kelas --
                </option>
                <?php foreach($data_kelas as $k): ?>
                    <!-- Membuat URL dinamis berdasarkan Value Jurusan yang sekarang dipilih -->
                    <?php 
                        $urlJurusan = ($filter_jurusan) ? "?filter_jurusan=$filter_jurusan" : "";
                    ?>
                    <option value="/admin/siswa/cetak_qr?filter_kelas=<?= $k['id_kelas']; ?><?= $urlJurusan ?>" 
                            <?= ($filter_kelas == $k['id_kelas']) ? 'selected' : ''; ?>>
                        <?= $k['kelas']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <label class="small font-weight-bold text-muted">Filter Jurusan</label>
            
            <select onchange="location.href=this.value" class="form-control custom-select rounded-pill">
                <option value="/admin/siswa/cetak_qr" <?= ($filter_jurusan == '') ? 'selected' : ''; ?>>
                    -- Semua Jurusan --
                </option>
                <?php foreach($data_jurusan as $j): ?>
                    <!-- Membuat URL dinamis berdasarkan Value Kelas yang sekarang dipilih -->
                    <?php 
                        $urlKelas = ($filter_kelas) ? "?filter_kelas=$filter_kelas" : "";
                        $tandaTanya = ($urlKelas) ? "&" : "?";
                    ?>
                    <option value="/admin/siswa/cetak_qr<?= $urlKelas ?><?= $tandaTanya ?>filter_jurusan=<?= $j['id']; ?>" 
                            <?= ($filter_jurusan == $j['id']) ? 'selected' : ''; ?>>
                        <?= $j['jurusan']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4 text-md-left mt-3 mt-md-0">
            <!-- Tombol ini hanya untuk Cetak, filter sudah otomatis -->
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill shadow-sm hover-lift">
                <i class="fas fa-print mr-2"></i> Cetak Sekarang
            </button>
        </div>
    </div>
</div>