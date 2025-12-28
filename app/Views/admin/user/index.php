<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 tracking-tight">Manajemen <span class="text-primary">User</span></h3>
            <p class="text-muted small mb-0">Kelola hak akses dan akun administrator sistem.</p>
        </div>
        <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah User
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted x-small">USER</th>
                            <th class="py-3 text-muted x-small">EMAIL / USERNAME</th>
                            <th class="py-3 text-muted x-small">ROLE</th>
                            <th class="py-3 text-muted x-small text-end pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach($users as $u): ?>
                            <tr class="user-row border-bottom border-light">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box me-3">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($u['nama']) ?>&background=4361ee&color=fff&bold=true" 
                                                 class="rounded-circle shadow-sm" width="38" height="38" alt="Avatar">
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small mb-0"><?= esc($u['nama']) ?></div>
                                            <div class="text-muted x-small">ID: #USR-<?= $u['id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark small fw-medium"><?= esc($u['email']) ?></span>
                                        <span class="text-muted x-small">Last Login: Just now</span>
                                    </div>
                                </td>
                                <td>
                                    <?php if($u['role'] == 'admin'): ?>
                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3">
                                            <i class="bi bi-shield-check me-1"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 px-3">
                                            <i class="bi bi-person me-1"></i> Staff
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="action-buttons">
                                        <a href="<?= site_url('admin/users/edit/'.$u['id']) ?>" 
                                           class="btn btn-icon btn-light-warning" title="Edit User">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" 
                                                onclick="confirmDelete('<?= site_url('admin/users/delete/'.$u['id']) ?>', '<?= esc($u['nama']) ?>')" 
                                                class="btn btn-icon btn-light-danger" title="Hapus User">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                    <p class="text-muted mb-0">Belum ada data user terdaftar.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 800; }
    .tracking-tight { letter-spacing: -0.5px; }
    
    .user-row { transition: all 0.2s; }
    .user-row:hover { background-color: #f8faff; }

    /* Action Buttons Styling */
    .action-buttons { display: flex; justify-content: flex-end; gap: 8px; }
    .btn-icon {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 8px; border: none; transition: 0.3s;
    }
    .btn-light-warning { background: #fffbeb; color: #d97706; }
    .btn-light-warning:hover { background: #fef3c7; color: #92400e; transform: translateY(-2px); }
    
    .btn-light-danger { background: #fef2f2; color: #dc2626; }
    .btn-light-danger:hover { background: #fee2e2; color: #991b1b; transform: translateY(-2px); }

    .badge { font-weight: 600; font-size: 0.75rem; }
</style>



<script>
    // 1. Fungsi Konfirmasi Hapus dengan SweetAlert2
    function confirmDelete(url, name) {
        Swal.fire({
            title: 'Hapus User?',
            html: `Apakah Anda yakin ingin menghapus <b>${name}</b>?<br>Aksi ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                title: 'fw-bold text-dark'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan Loading Overlay
                Swal.fire({
                    title: 'Menghapus User...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = url;
            }
        })
    }

    // 2. Auto-notifikasi Flashdata (Success/Error)
    document.addEventListener('DOMContentLoaded', function() {
        const toastConfig = {
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'rounded-3 shadow-sm' }
        };

        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                ...toastConfig,
                icon: 'success',
                title: '<?= session()->getFlashdata('success') ?>'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>',
                customClass: { popup: 'rounded-4' }
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>