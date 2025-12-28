<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="row g-4 mb-4 align-items-center">
        <div class="col-lg-6">
            <h2 class="fw-bold text-dark mb-1 tracking-tight">Database <span class="text-primary">Siswa</span></h2>
            <p class="text-muted small mb-0">Manajemen identitas siswa dan sistem integrasi QR Code.</p>
        </div>
        <div class="col-lg-6 d-flex justify-content-lg-end align-items-center gap-2">
            <div class="search-box-modern">
                <i class="bi bi-search text-muted"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama, NIS, atau Kelas...">
            </div>
            
            <button type="button" class="btn-tool-header bg-success text-white" data-bs-toggle="modal" data-bs-target="#importExcelModal" title="Import Excel">
                <i class="bi bi-file-earmark-excel"></i>
            </button>

            <a href="<?= site_url('admin/siswa/create') ?>" class="btn-tool-header bg-primary text-white" title="Tambah Siswa">
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate__animated animate__headShake">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="main-table-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 py-4 text-muted small fw-bold">PROFIL SISWA</th>
                        <th class="text-center py-4 text-muted small fw-bold">AKADEMIK</th>
                        <th class="text-center py-4 text-muted small fw-bold">QR CODE</th>
                        <th class="text-end pe-4 py-4 text-muted small fw-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody id="siswaTableBody">
                    <?php if (!empty($siswa)): foreach ($siswa as $s): ?>
                        <tr class="siswa-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($s['nama']) ?>&background=random&color=fff&bold=true" alt="avatar">
                                    </div>
                                    <div>
                                        <div class="text-dark fw-bold mb-0 fs-6"><?= esc($s['nama']) ?></div>
                                        <div class="text-primary x-small fw-bold">NIS: <?= esc($s['nis']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="academic-chip">
                                    <span class="badge-class"><?= esc($s['kelas']) ?></span>
                                    <span class="badge-major"><?= esc($s['jurusan']) ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="qr-preview-box" data-bs-toggle="modal" data-bs-target="#qrModal<?= $s['id'] ?>">
                                    <img src="<?= base_url('uploads/qr/'.$s['qr_code']) ?>" onerror="this.src='https://placehold.co/100x100?text=QR'">
                                    <div class="qr-overlay"><i class="bi bi-zoom-in"></i></div>
                                </div>

                                <div class="modal fade" id="qrModal<?= $s['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content border-0 shadow-lg rounded-4 text-center p-4">
                                            <h6 class="fw-bold mb-1"><?= esc($s['nama']) ?></h6>
                                            <p class="text-muted x-small mb-3">ID Kartu: <?= esc($s['nis']) ?></p>
                                            <div class="p-2 border rounded-3 mb-3 bg-white">
                                                <img src="<?= base_url('uploads/qr/'.$s['qr_code']) ?>" class="img-fluid rounded">
                                            </div>
                                            <button type="button" class="btn btn-light btn-sm w-100 rounded-pill border" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="action-dock">
                                    <a href="<?= site_url('admin/siswa/edit/'.$s['id']) ?>" class="btn-tool edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <button onclick="confirmDelete('<?= site_url('admin/siswa/delete/'.$s['id']) ?>')" class="btn-tool delete" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted small">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Import Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin/siswa/import') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Upload File Excel (.xlsx / .xls)</label>
                        <input type="file" name="file_excel" class="form-control rounded-3" accept=".xls,.xlsx" required>
                    </div>
                    
                    <div class="bg-light p-3 rounded-4 border-start border-4 border-primary">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cloud-arrow-down-fill text-primary me-2"></i>
                            <span class="small fw-bold">Download Template</span>
                        </div>
                        <p class="x-small text-muted mb-3">Gunakan format Excel standar kami agar data dapat terbaca dengan benar.</p>
                        <a href="<?= site_url('admin/siswa/download-template') ?>" class="btn btn-white btn-sm rounded-pill px-3 shadow-sm border border-primary text-primary fw-bold">
                            <i class="bi bi-download me-1"></i> Format_Siswa.xlsx
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.7rem; }
    .tracking-tight { letter-spacing: -1px; }
    
    .search-box-modern {
        background: white; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 8px 16px; display: flex; align-items: center; width: 100%; max-width: 250px;
    }
    .search-box-modern input { border: none; outline: none; margin-left: 10px; width: 100%; font-size: 0.85rem; }

    .btn-tool-header {
        width: 42px; height: 42px; border: none; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; transition: 0.3s;
    }
    .btn-tool-header:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    .main-table-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; }
    .siswa-row:hover { background-color: #f8fafc; }
    
    .avatar-wrapper img { width: 40px; height: 40px; border-radius: 10px; }
    
    .academic-chip { display: inline-flex; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
    .badge-class { background: #f1f5f9; color: #4361ee; padding: 4px 10px; font-weight: bold; font-size: 0.7rem; border-right: 1px solid #e2e8f0; }
    .badge-major { background: white; padding: 4px 10px; color: #64748b; font-size: 0.7rem; }

    .qr-preview-box {
        width: 45px; height: 45px; margin: auto; border: 1px solid #e2e8f0; 
        border-radius: 8px; padding: 3px; position: relative; cursor: pointer;
    }
    .qr-preview-box img { width: 100%; height: 100%; border-radius: 4px; }
    .qr-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(67, 97, 238, 0.8); color: white; border-radius: 7px;
        display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.3s;
    }
    .qr-preview-box:hover .qr-overlay { opacity: 1; }

    .action-dock { display: inline-flex; gap: 4px; background: #f8fafc; padding: 4px; border-radius: 10px; }
    .btn-tool {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: 0.2s; color: #64748b; border: none; background: transparent;
    }
    .btn-tool:hover { background: white; color: #4361ee; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .btn-tool.delete:hover { color: #ef4444; }
</style>

<script>
    // Live Search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('.siswa-row');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });

    // Delete confirmation with SweetAlert2 (if available)
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
            window.location.href = url;
        }
    }
</script>

<?= $this->endSection() ?>