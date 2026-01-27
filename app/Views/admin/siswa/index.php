<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
            <p class="text-muted small mb-0">Manajemen data siswa aktif di sistem akademik.</p>
        </div>
        <div class="d-flex" style="gap: 10px;">
            <button type="button" class="btn btn-success shadow-sm px-4 rounded-pill hover-lift" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel mr-2"></i> Import Excel
            </button>
            <a href="/admin/siswa/create" class="btn btn-primary shadow-sm px-4 rounded-pill hover-lift">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Siswa
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4 border-0 rounded-lg">
        <div class="card-body p-3">
            <form action="" method="get" class="row align-items-end">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted">Filter Kelas</label>
                    <select name="filter_kelas" class="form-control form-control-sm rounded-pill">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach($data_kelas as $k): ?>
                            <option value="<?= $k['id_kelas']; ?>" <?= ($filter_kelas == $k['id_kelas']) ? 'selected' : ''; ?>><?= $k['kelas']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted">Filter Jurusan</label>
                    <select name="filter_jurusan" class="form-control form-control-sm rounded-pill">
                        <option value="">-- Semua Jurusan --</option>
                        <?php foreach($data_jurusan as $j): ?>
                            <option value="<?= $j['id']; ?>" <?= ($filter_jurusan == $j['id']) ? 'selected' : ''; ?>><?= $j['jurusan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="/admin/siswa" class="btn btn-sm btn-light px-4 rounded-pill border">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-items-center mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary">
                            <th class="pl-4 py-3 text-xxs font-weight-bold text-uppercase" style="width: 50px;">#</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Profil</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Nama & NIS</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Jenis Kelamin</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Kelas & Jurusan</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Kontak</th>
                            <th class="text-center pr-4 text-xxs font-weight-bold text-uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($siswa)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada data siswa.</td>
                            </tr>
                        <?php endif; ?>

                        <?php $i = 1; foreach ($siswa as $s) : ?>
                            <tr>
                                <td class="pl-4 align-middle font-weight-bold text-muted small"><?= $i++; ?></td>
                                <td class="align-middle">
                                    <div class="avatar-wrapper rounded-circle shadow-sm border d-flex align-items-center justify-content-center overflow-hidden" 
                                        style="width: 45px; height: 45px; background-color: #eaecf4;">
                                        <?php 
                                        $pathFoto = 'uploads/foto-siswa/' . $s['foto'];
                                        if (!empty($s['foto']) && file_exists(FCPATH . $pathFoto)) : ?>
                                            <img src="/<?= $pathFoto; ?>" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else : ?>
                                            <span class="text-primary font-weight-bold" style="font-size: 14px;">
                                                <?= strtoupper(substr($s['nama_siswa'], 0, 1)); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-0"><?= $s['nama_siswa']; ?></span>
                                        <small class="text-muted"><?= $s['nis']; ?></small>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <?php $valJK = strtoupper(substr(trim($s['jenis_kelamin'] ?? ''), 0, 1)); ?>
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
                                </td>
                                <td class="align-middle">
                                    <div class="mb-0 text-dark font-weight-bold"><?= $s['kelas']; ?></div>
                                    <small class="text-primary text-uppercase font-weight-bold" style="font-size: 10px;"><?= $s['jurusan']; ?></small>
                                </td>
                                <td class="align-middle">
                                    <?php if(!empty($s['no_hp'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $s['no_hp']); ?>" target="_blank" class="text-success small font-weight-bold text-decoration-none">
                                            <i class="fab fa-whatsapp mr-1"></i> <?= $s['no_hp']; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pr-4 align-middle">
                                    <div class="d-flex justify-content-center" style="gap: 8px;">
                                        <a href="/admin/siswa/show/<?= $s['id_siswa']; ?>" class="btn-action btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="/admin/siswa/edit/<?= $s['id_siswa']; ?>" class="btn-action btn-edit" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDelete('/admin/siswa/delete/<?= $s['id_siswa']; ?>', '<?= addslashes($s['nama_siswa']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-success text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-excel mr-2"></i> Import Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/siswa/import" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="text-center mb-4 p-3 border rounded bg-light shadow-sm">
                        <p class="small text-muted mb-2">Belum memiliki format file? Silakan download template Excel di bawah ini:</p>
                        <a href="/admin/siswa/downloadTemplate" class="btn btn-outline-success btn-sm rounded-pill px-4">
                            <i class="fas fa-download mr-1"></i> Download Template .xlsx
                        </a>
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Pilih File (.xlsx / .xls)</label>
                        <div class="custom-file">
                            <input type="file" name="file_excel" class="custom-file-input" id="fileExcel" accept=".xlsx, .xls" required onchange="updateFileName()">
                            <label class="custom-file-label" for="fileExcel">Pilih file excel...</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded border-left border-warning small shadow-sm">
                        <p class="mb-1 font-weight-bold text-warning font-italic"><i class="fas fa-info-circle mr-1"></i> Catatan:</p>
                        1. Pastikan kolom <b>ID Kelas</b> diisi dengan angka ID yang benar.<br>
                        2. Gunakan huruf <b>L</b> atau <b>P</b> untuk kolom jenis kelamin.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 font-weight-bold">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-xxs { font-size: 0.7rem; }
    .rounded-lg { border-radius: 12px !important; }
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(78,115,223,0.2) !important; }
    .badge-jk { font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 50px; display: inline-flex; align-items: center; }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.12); }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.12); }
    .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; border: none; cursor: pointer; transition: 0.2s; }
    .btn-view { background: #f0f5ff; color: #4e73df; }
    .btn-edit { background: #fff9e6; color: #f6c23e; }
    .btn-delete { background: #fff5f5; color: #e74a3b; }
    .btn-action:hover { transform: scale(1.1); filter: brightness(0.9); color: #fff !important; }
    .btn-view:hover { background: #4e73df; }
    .btn-edit:hover { background: #f6c23e; }
    .btn-delete:hover { background: #e74a3b; }
</style>

<script>
    function updateFileName() {
        var input = document.getElementById('fileExcel');
        var label = input.nextElementSibling;
        if (input.files.length > 0) {
            label.innerText = input.files[0].name;
        }
    }

    function confirmDelete(url, nama) {
        Swal.fire({
            title: 'Hapus data?',
            html: `Hapus data siswa <b>${nama}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = url;
        });
    }

    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success'); ?>', timer: 2000, showConfirmButton: false });
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({ icon: 'error', title: 'Oops...', text: '<?= session()->getFlashdata('error'); ?>' });
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>