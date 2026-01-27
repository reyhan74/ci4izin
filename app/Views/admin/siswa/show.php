<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>

<!-- CSS Khusus untuk memastikan QR Code muncul dengan benar -->
<style>
    /* Mencegah CSS template merusak ukuran QR Code */
    #qrcode img {
        display: block !important;
        width: 128px !important; /* Paksa lebar 128px */
        height: auto !important;
        margin: 0 auto;
    }
    
    /* Menyalin style dari index untuk konsistensi */
    .text-xxs { font-size: 0.7rem; }
    .rounded-lg { border-radius: 12px !important; }
    .badge-jk { font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 50px; display: inline-flex; align-items: center; }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.12); }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.12); }
</style>

<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <a href="/admin/siswa" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4 border-0 rounded-lg text-center p-4">
                
                <!-- FOTO PROFEL (SAMA SEPERTI INDEX) -->
                <div class="mx-auto mb-3 avatar-wrapper rounded-circle shadow-sm border d-flex align-items-center justify-content-center overflow-hidden" 
                     style="width: 150px; height: 150px; background-color: #eaecf4;">
                    <?php 
                    $pathFoto = 'uploads/foto-siswa/' . $siswa['foto'];
                    if (!empty($siswa['foto']) && file_exists(FCPATH . $pathFoto)) : ?>
                        <img src="/<?= $pathFoto; ?>" class="w-100 h-100" style="object-fit: cover;">
                    <?php else : ?>
                        <span class="text-primary font-weight-bold" style="font-size: 50px;">
                            <?= strtoupper(substr($siswa['nama_siswa'], 0, 1)); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <!-- END FOTO -->

                <h4 class="font-weight-bold text-dark mb-1"><?= $siswa['nama_siswa']; ?></h4>
                
                <div class="mb-3">
                    <!-- NIS Style (Sama seperti Index) -->
                    <small class="text-muted font-weight-bold"><?= $siswa['nis']; ?></small>
                </div>

                <!-- Badge JK Style (Sama seperti Index) -->
                <div class="mb-3">
                    <?php $valJK = strtoupper(substr(trim($siswa['jenis_kelamin'] ?? ''), 0, 1)); ?>
                    <?php if ($valJK === 'L') : ?>
                        <span class="badge-jk bg-soft-primary text-primary">
                            <i class="fas fa-mars mr-2"></i>Laki-laki
                        </span>
                    <?php elseif ($valJK === 'P') : ?>
                        <span class="badge-jk bg-soft-danger text-danger">
                            <i class="fas fa-venus mr-2"></i>Perempuan
                        </span>
                    <?php else : ?>
                        <span class="badge badge-light text-muted small border">Tidak Set</span>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-center mb-4" style="gap: 10px;">
                    <a href="/admin/siswa/edit/<?= $siswa['id_siswa']; ?>" class="btn btn-warning btn-sm px-3 text-white rounded-pill shadow-sm">
                        <i class="fas fa-edit mr-1"></i> Edit Profil
                    </a>
                </div>

                <!-- QR Code Section (Pindah ke bawah Edit Profil) -->
                <div class="d-flex flex-column align-items-center border-top pt-3">
                    <div id="qrcode" class="mb-2 p-2 bg-white border rounded shadow-sm" style="min-width: 128px; min-height: 128px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-small text-muted">Memuat QR...</span>
                    </div>
                    <button onclick="downloadQR()" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="fas fa-download mr-1"></i> Unduh QR
                    </button>
                </div>
                <!-- End QR Code Section -->

            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lengkap Siswa</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 30%;" class="text-muted">NIS</th>
                                <td class="font-weight-bold text-dark">: <?= $siswa['nis']; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Nama Lengkap</th>
                                <td class="text-dark">: <?= $siswa['nama_siswa']; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Jenis Kelamin</th>
                                <td class="text-dark">: <?= ($siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kelas</th>
                                <td class="text-dark">: <?= $siswa['kelas']; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Jurusan</th>
                                <td class="text-dark">: <?= $siswa['jurusan']; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">No. HP / WhatsApp</th>
                                <td class="text-dark">: 
                                    <?php if(!empty($siswa['no_hp'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $siswa['no_hp']); ?>" target="_blank" class="text-success font-weight-bold text-decoration-none">
                                            <i class="fab fa-whatsapp mr-1"></i> <?= $siswa['no_hp']; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Unique Token</th>
                                <td class="text-dark">: <code class="bg-light px-2 py-1 rounded"><?= $siswa['unique_code']; ?></code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light text-right small text-muted">
                    Terdaftar pada sistem: <?= date('d M Y', strtotime($siswa['created_at'] ?? 'now')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Library QRCode dan Logika -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // Tunggu hingga seluruh elemen dimuat (DOMContent)
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen container
        var qrcodeContainer = document.getElementById("qrcode");
        
        // Pastikan Unique Code ada
        var uniqueCode = "<?= $siswa['unique_code']; ?>";

        if (uniqueCode && qrcodeContainer) {
            // Bersihkan teks "Memuat QR..."
            qrcodeContainer.innerHTML = "";

            // Generate QR Code
            try {
                new QRCode(qrcodeContainer, {
                    text: uniqueCode,
                    width: 128,
                    height: 128,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
            } catch (e) {
                console.error("Gagal generate QR:", e);
                qrcodeContainer.innerHTML = "<span class='text-danger'>Error QR</span>";
            }
        }
    });

    function downloadQR() {
        // Coba ambil gambar dari tag img (standar library ini)
        var img = document.querySelector("#qrcode img");
        
        if (img && img.src) {
            var link = document.createElement('a');
            link.href = img.src;
            link.download = "QR-<?= $siswa['unique_code']; ?>.png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            // Fallback jika browser menggunakan canvas
            var canvas = document.querySelector("#qrcode canvas");
            if(canvas) {
                var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                var link = document.createElement('a');
                link.href = image;
                link.download = "QR-<?= $siswa['unique_code']; ?>.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert("QR Code belum siap atau gagal dimuat.");
            }
        }
    }
</script>

<?= $this->endSection(); ?>