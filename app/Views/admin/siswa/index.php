<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 animate__animated animate__fadeIn">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
            <p class="text-muted small mb-0">Manajemen data siswa aktif di sistem akademik.</p>
        </div>
        <div class="d-flex" style="gap: 10px;">
            <button type="button" class="btn btn-success shadow-sm px-4 rounded-pill hover-lift" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel mr-2"></i> Import Excel
            </button>
            <a href="<?= base_url('admin/siswa/create'); ?>" class="btn btn-primary shadow-sm px-4 rounded-pill hover-lift">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Siswa
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-lg overflow-hidden animate__animated animate__fadeInUp">
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table class="table table-hover align-items-center mb-0" id="tabelSiswa">
                    <thead class="bg-light">
                        <tr class="text-secondary">
                            <th class="text-xxs font-weight-bold text-uppercase" style="width: 30px;">#</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Profil</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Nama & NIS</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Gender</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Kelas & Jurusan</th>
                            <th class="text-xxs font-weight-bold text-uppercase">Kontak</th>
                            <th class="text-center text-xxs font-weight-bold text-uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($siswa as $s) : ?>
                            <tr>
                                <td class="align-middle font-weight-bold text-muted small"><?= $i++; ?></td>
                                <td class="align-middle">
                                    <div class="avatar-wrapper rounded-circle shadow-sm border d-flex align-items-center justify-content-center overflow-hidden" 
                                        style="width: 42px; height: 42px; background-color: #f8f9fc;">
                                        <?php 
                                        $pathFoto = 'uploads/foto-siswa/' . ($s['foto'] ?? '');
                                        if (!empty($s['foto']) && file_exists(FCPATH . $pathFoto)) : ?>
                                            <img src="<?= base_url($pathFoto); ?>" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else : ?>
                                            <span class="text-primary font-weight-bold small"><?= strtoupper(substr($s['nama_siswa'], 0, 1)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-0" style="font-size: 0.9rem;"><?= esc($s['nama_siswa']); ?></span>
                                        <small class="text-muted"><?= esc($s['nis']); ?></small>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <?php $valJK = strtoupper(substr(trim($s['jenis_kelamin'] ?? ''), 0, 1)); ?>
                                    <span class="badge-jk <?= ($valJK === 'L') ? 'bg-soft-primary text-primary' : 'bg-soft-danger text-danger'; ?>">
                                        <i class="fas <?= ($valJK === 'L') ? 'fa-mars' : 'fa-venus'; ?> mr-1"></i>
                                        <span class="full-text"><?= ($valJK === 'L') ? 'Laki-laki' : 'Perempuan'; ?></span>
                                        <span class="short-text d-none"><?= $valJK; ?></span>
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="mb-0 text-dark font-weight-bold"><?= esc($s['kelas']); ?></div>
                                    <small class="text-primary text-uppercase font-weight-bold" style="font-size: 9px;"><?= esc($s['jurusan'] ?? '-'); ?></small>
                                </td>
                                <td class="align-middle">
                                    <?php if(!empty($s['no_hp'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $s['no_hp']); ?>" target="_blank" class="btn btn-sm btn-outline-success border-0 rounded-pill px-2">
                                            <i class="fab fa-whatsapp"></i> <?= esc($s['no_hp']); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Tidak ada HP</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <a href="<?= base_url('admin/siswa/show/'.$s['id_siswa']); ?>" class="btn-action btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="<?= base_url('admin/siswa/edit/'.$s['id_siswa']); ?>" class="btn-action btn-edit" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDelete('<?= base_url('admin/siswa/delete/'.$s['id_siswa']); ?>', '<?= addslashes($s['nama_siswa']); ?>')">
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
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white py-3" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-excel mr-2"></i> Import Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formImport" action="<?= base_url('admin/siswa/import'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="text-center mb-4 p-3 border rounded bg-light">
                        <p class="small text-muted mb-2">Belum memiliki format file? Download template di bawah ini:</p>
                        <a href="<?= base_url('admin/siswa/downloadTemplate'); ?>" class="btn btn-outline-success btn-sm rounded-pill px-4">
                            <i class="fas fa-download mr-1"></i> Template_Siswa.xlsx
                        </a>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Pilih File Excel</label>
                        <div class="custom-file">
                            <input type="file" name="file_excel" class="custom-file-input" id="fileExcel" accept=".xlsx, .xls" required>
                            <label class="custom-file-label" for="fileExcel">Klik untuk pilih file...</label>
                        </div>
                    </div>

                    <div class="bg-soft-warning p-3 rounded border-left border-warning small">
                        <p class="mb-1 font-weight-bold text-warning"><i class="fas fa-info-circle mr-1"></i> Aturan Import:</p>
                        <ul class="pl-3 mb-0 text-muted">
                            <li>Gunakan format <b>L</b> (Laki-laki) atau <b>P</b> (Perempuan).</li>
                            <li>Pastikan <b>ID Kelas</b> sesuai dengan data di sistem.</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSubmitImport" class="btn btn-success rounded-pill px-4 font-weight-bold">
                        <span id="textImport">Mulai Import</span>
                        <span id="loadingImport" class="d-none"><i class="fas fa-spinner fa-spin mr-1"></i> Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* CSS Styling sesuai permintaan Anda */
    .text-xxs { font-size: 0.75rem; }
    .rounded-lg { border-radius: 15px !important; }
    .hover-lift { transition: all 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; }
    .badge-jk { font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.15); }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.15); }
    .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1); }
    .btn-action { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; border: none; transition: 0.3s; }
    .btn-view { background: #f0f3ff; color: #4e73df; }
    .btn-edit { background: #fff8e6; color: #f6c23e; }
    .btn-delete { background: #fff2f2; color: #e74a3b; }
    .btn-action:hover { transform: scale(1.1); color: #fff !important; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .btn-view:hover { background: #4e73df; }
    .btn-edit:hover { background: #f6c23e; }
    .btn-delete:hover { background: #e74a3b; }
    
    /* DataTable Styling */
    .dataTables_wrapper .dataTables_filter input { border-radius: 20px; border: 1px solid #d1d3e2; padding: 5px 15px; margin-left: 10px; }
    .dataTables_wrapper .dataTables_length select { border-radius: 10px; padding: 2px 5px; }
    .table thead th { border-top: none; }

    /* Responsivitas untuk badge gender */
    @media (max-width: 768px) {
        .full-text { display: none; }  /* Sembunyikan teks penuh di mobile */
        .short-text { display: inline; }  /* Tampilkan singkatan di mobile */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Init DataTable dengan konfigurasi bahasa Indonesia
        $('#tabelSiswa').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Data siswa tidak ditemukan",
                "info": "Menampilkan data _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "paginate": { "previous": "<i class='fas fa-angle-left'></i>", "next": "<i class='fas fa-angle-right'></i>" }
            },
            "columnDefs": [{ "orderable": false, "targets": [1, 6] }]
        });

        // Update Label File Input saat file dipilih
        $('#fileExcel').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Animasi Loading saat Import
        $('#formImport').on('submit', function() {
            $('#textImport').addClass('d-none');
            $('#loadingImport').removeClass('d-none');
            $('#btnSubmitImport').attr('disabled', true);
        });
    });

    // Fungsi Konfirmasi Hapus dengan SweetAlert2
    function confirmDelete(url, nama) {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: `Data "${nama}" akan dihapus secara permanen dari sistem.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // Menampilkan Pesan dari Session (Flashdata)
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success'); ?>', timer: 2500, showConfirmButton: false });
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({ icon: 'error', title: 'Gagal', text: '<?= session()->getFlashdata('error'); ?>' });
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>