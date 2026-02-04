<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid py-3 py-md-4">
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
        <div class="mb-3 mb-sm-0">
            <h1 class="h4 mb-0 text-gray-800 font-weight-bold">Data Kelas</h1>
            <p class="text-muted small mb-0 d-none d-sm-block">Daftar tingkat kelas dan jurusan yang terdaftar.</p>
        </div>
        <a href="/admin/kelas/create" class="btn btn-primary shadow-sm px-4 rounded-pill hover-lift btn-sm">
            <i class="fas fa-plus-circle mr-1"></i> Tambah Kelas
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="card-body p-2 p-md-3">
            <div class="table-responsive">
                <table class="table table-hover nowrap align-items-center w-100" id="tabelKelas">
                    <thead class="bg-light">
                        <tr class="text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">
                            <th class="border-0" style="width: 50px;">NO</th>
                            <th class="border-0">TINGKAT</th>
                            <th class="border-0">JURUSAN</th>
                            <th class="border-0 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <?php $no=1; foreach($kelas as $k): ?>
                        <tr>
                            <td class="align-middle text-muted font-weight-bold"><?= $no++ ?></td>
                            <td class="align-middle">
                                <span class="badge badge-light px-3 py-2 text-dark border" style="border-radius: 8px;">
                                    <b><?= $k['kelas'] ?></b>
                                </span>
                            </td>
                            <td class="align-middle font-weight-bold text-primary">
                                <?= $k['jurusan'] ?>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group shadow-sm border rounded">
                                    <a href="/admin/kelas/edit/<?= $k['id_kelas'] ?>" class="btn btn-sm btn-white text-warning py-2 px-3" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-white text-danger py-2 px-3" 
                                            onclick="confirmDelete('/admin/kelas/delete/<?= $k['id_kelas'] ?>', 'Kelas <?= $k['kelas'] ?> <?= $k['jurusan'] ?>')" title="Hapus">
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

<style>
    /* Styling Dasar */
    .hover-lift { transition: transform 0.2s; }
    .hover-lift:hover { transform: translateY(-2px); }
    .btn-white { background: #fff; border: none; }
    .btn-white:hover { background: #f8f9fc; }
    
    /* DataTable Mobile Fix */
    @media (max-width: 576px) {
        .dataTables_filter input { 
            width: 100% !important; 
            margin-left: 0 !important; 
            border-radius: 10px !important;
            margin-top: 10px;
        }
        .dataTables_length { display: none; }
        .table td, .table th { padding: 12px 10px; }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelKelas').DataTable({
            "language": {
                "search": "",
                "searchPlaceholder": "Cari kelas...",
                "paginate": { "previous": "<", "next": ">" }
            },
            "pageLength": 10,
            "columnDefs": [{ "orderable": false, "targets": [3] }]
        });
    });

    // SweetAlert2 Hapus
    function confirmDelete(url, nama) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: `Anda akan menghapus "${nama}". Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // Flashdata Success
    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>

<?= $this->endSection(); ?>