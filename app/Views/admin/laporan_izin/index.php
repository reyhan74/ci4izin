<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Izin Siswa</h3>
            <p class="text-muted small mb-0">Memantau riwayat keluar-masuk siswa dalam satu periode.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm bg-white">
                <i class="bi bi-printer me-2"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="get" id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Pilih Tanggal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-primary"><i class="bi bi-calendar3"></i></span>
                        <input type="date" name="tanggal" id="filterTanggal" class="form-control bg-light border-start-0" 
                               value="<?= esc($tanggal) ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold shadow-sm">
                        <i class="bi bi-filter me-2"></i> Filter
                    </button>
                </div>
                <?php if ($tanggal): ?>
                <div class="col-md-2">
                    <a href="<?= site_url('admin/laporan-izin') ?>" class="btn btn-light rounded-pill w-100 border shadow-sm">
                        Reset
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted x-small" width="5%">NO</th>
                            <th class="py-3 text-muted x-small">SISWA</th>
                            <th class="py-3 text-muted x-small">KELAS</th>
                            <th class="py-3 text-muted x-small text-center">STATUS</th>
                            <th class="py-3 text-muted x-small">KETERANGAN</th>
                            <th class="py-3 text-muted x-small">WAKTU PERISTIWA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($izin)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="opacity-25 mb-3">
                                        <i class="bi bi-folder-x" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="text-muted fw-bold">Tidak ada data izin pada tanggal ini.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($izin as $idx => $row): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $idx + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark mb-0"><?= esc($row['nama']) ?></div>
                                    <div class="text-muted x-small">NIS: <?= esc($row['nis']) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 rounded-pill"><?= esc($row['kelas']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if($row['status'] == 'keluar'): ?>
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-3">
                                            <i class="bi bi-box-arrow-right me-1"></i> KELUAR
                                        </span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3">
                                            <i class="bi bi-box-arrow-in-left me-1"></i> KEMBALI
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="p-2 bg-light rounded-3 small" style="max-width: 250px;">
                                        <?= esc($row['keterangan']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium small text-dark">
                                        <i class="bi bi-clock me-1 text-primary"></i> <?= date('H:i', strtotime($row['waktu'])) ?>
                                    </div>
                                    <div class="text-muted x-small"><?= date('d M Y', strtotime($row['waktu'])) ?></div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tipografi Label Kecil */
    .x-small { 
        font-size: 0.65rem; 
        text-transform: uppercase; 
        letter-spacing: 0.8px; 
        font-weight: 800; 
    }

    /* Gaya Tabel Minimalis */
    .table thead th { 
        border: none; 
    }
    .table tbody td { 
        border-color: #f8fafc; 
    }

    /* Animasi Card */
    .card { 
        transition: all 0.3s ease; 
    }

    /* Form Input */
    .input-group-text { 
        border-color: #dee2e6; 
    }
    
    /* Optimasi Cetak (Print) */
    @media print {
        /* Sembunyikan elemen interaktif yang tidak diperlukan saat diprint */
        .btn, .card-body form, .header-actions { 
            display: none !important; 
        }

        /* Pastikan card terlihat bersih (tanpa shadow, border tipis) */
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        /* Opsional: Memastikan latar belakang putih bersih */
        body {
            background-color: #fff !important;
        }
    }
</style>


<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const tanggal = document.getElementById('filterTanggal').value;
        
        if (!tanggal) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Tanggal Belum Dipilih',
                text: 'Silakan pilih tanggal terlebih dahulu untuk memfilter data.',
                confirmButtonColor: '#4361ee',
                customClass: { popup: 'rounded-4' }
            });
            return;
        }

        // Tampilkan loading saat memproses filter
        Swal.fire({
            title: 'Memuat Data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Notifikasi jika ada flashdata (misal dari controller)
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 2000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-4' }
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>