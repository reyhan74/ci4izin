<?= $this->extend('layout/admin') ?> 
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= site_url('admin/siswa') ?>" class="btn btn-light rounded-circle shadow-sm me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold text-dark mb-0">Detail Profil Siswa</h3>
            <p class="text-muted small mb-0">Informasi lengkap dan identitas digital siswa.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama']) ?>&background=4361ee&color=fff&size=128" 
                         class="rounded-circle border border-4 border-white shadow-sm" width="120">
                </div>
                <h5 class="fw-bold text-dark mb-1"><?= esc($siswa['nama']) ?></h5>
                <p class="text-primary small fw-bold mb-4">NIS: <?= esc($siswa['nis']) ?></p>
                
                <div class="p-3 bg-light rounded-4 mb-3">
                    <?php if (!empty($siswa['qr_code'])): ?>
                        <img src="<?= base_url('uploads/qr/'.$siswa['qr_code']) ?>" class="img-fluid rounded-3 shadow-sm bg-white p-2" id="qrImage" style="max-width: 180px;">
                    <?php else: ?>
                        <div class="py-4 text-muted small">QR Code tidak tersedia</div>
                    <?php endif ?>
                </div>

                <?php if (!empty($siswa['qr_code'])): ?>
                <button onclick="downloadQR('<?= base_url('uploads/qr/'.$siswa['qr_code']) ?>', 'QR_<?= $siswa['nis'] ?>')" class="btn btn-primary w-100 rounded-pill fw-bold">
                    <i class="bi bi-download me-2"></i> Download QR
                </button>
                <?php endif ?>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Data Akademik</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr>
                                    <th class="ps-4 py-3 text-muted small" width="30%">NOMOR INDUK</th>
                                    <td class="py-3 fw-bold"><?= esc($siswa['nis']) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3 text-muted small">NAMA LENGKAP</th>
                                    <td class="py-3 fw-bold"><?= esc($siswa['nama']) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3 text-muted small">KELAS</th>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill"><?= esc($siswa['kelas']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3 text-muted small">JURUSAN</th>
                                    <td class="py-3 fw-medium text-secondary"><?= esc($siswa['jurusan']) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4 py-3 text-muted small">STATUS AKUN</th>
                                    <td class="py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Aktif</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 rounded-bottom-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small italic">Terdaftar pada: <?= date('d M Y') ?></span>
                        <a href="<?= site_url('admin/siswa/edit/'.$siswa['id']) ?>" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.3s ease; }
    .table th { vertical-align: middle; border-bottom: 1px solid #f8f9fa; }
    .table td { vertical-align: middle; border-bottom: 1px solid #f8f9fa; }
</style>

<script>
    function downloadQR(url, filename) {
        Swal.fire({
            title: 'Download QR Code?',
            text: "File akan disimpan sebagai gambar (.png)",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Download',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Proses Download
                const link = document.createElement('a');
                link.href = url;
                link.download = filename + '.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Notifikasi Sukses
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'QR Code telah diunduh.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>