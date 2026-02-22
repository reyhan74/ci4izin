
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?? 'E-IZIN Admin | SMK CB PARE' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --accent: #4361ee;
            --main-bg: #f8fafc; 
            --sidebar-dark: #0f172a;
        }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-dark);
            position: fixed;
            left: 0; top: 0;
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-custom { padding: 1rem; flex-grow: 1; overflow-y: auto; }
        
        .nav-label {
            color: rgba(255,255,255,0.3);
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1.2rem 0 0.5rem 0.8rem;
        }

        .nav-custom a {
            color: rgba(255,255,255,0.5);
            padding: 10px 14px;
            display: flex; align-items: center;
            text-decoration: none; border-radius: 10px;
            margin-bottom: 4px; transition: 0.3s;
            font-weight: 600; font-size: 0.85rem;
        }

        .nav-custom a i { margin-right: 10px; font-size: 1.1rem; }
        .nav-custom a:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .nav-custom a.active { background: var(--accent) !important; color: #fff !important; box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2); }

        /* --- TOPBAR --- */
        main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.4s;
        }

        .top-navbar {
            padding: 0 1.5rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 1000;
            height: 65px;
        }

        .btn-header-action {
            background: var(--accent);
            color: white; padding: 8px 16px;
            border-radius: 10px; font-size: 0.8rem; font-weight: 700;
            text-decoration: none; display: flex; align-items: center; gap: 8px;
            transition: 0.3s; border: none;
        }
        .btn-header-action:hover { background: #3751d7; color: white; transform: translateY(-1px); }

        /* --- MOBILE OPTIMIZATION --- */
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                background: var(--sidebar-dark) !important;
            }
            .sidebar.active { transform: translateX(0); }
            main { margin-left: 0; width: 100%; }
            .sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); z-index: 1040;
            }
            .sidebar-overlay.active { display: block; }
        }

        .user-pill {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 5px 5px 5px 12px;
            border-radius: 30px;
            display: flex; align-items: center;
            gap: 10px; transition: 0.3s;
        }
        .user-pill:hover { background: #f1f5f9; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar">
        <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-brand text-decoration-none">
            <div class="brand-logo-container me-2">
                <img src="<?= base_url('/img/logo.png') ?>" alt="Logo" class="img-fluid" style="height: 30px; width: auto;">
            </div>
            <div class="d-flex flex-column">
                <span class="text-white lh-1 fw-800 fs-5">E-IZIN</span>
                <span class="text-white-50 small" style="font-size: 0.55rem; letter-spacing: 1px;">ADMIN PANEL</span>
            </div>
        </a>
        
        <nav class="nav-custom">
            <div class="nav-label">Main Menu</div>
            <a href="<?= site_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="nav-label">Master Data</div>
            <a href="<?= site_url('admin/siswa') ?>" class="<?= url_is('admin/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="<?= site_url('admin/jurusan') ?>" class="<?= url_is('admin/jurusan*') ? 'active' : '' ?>">
                <i class="bi bi-layers-fill"></i> Jurusan
            </a>
            <a href="<?= site_url('admin/kelas') ?>" class="<?= url_is('admin/kelas*') ? 'active' : '' ?>">
                <i class="bi bi-door-closed-fill"></i> Kelas
            </a>

            <div class="nav-label">Laporan & Pengguna</div>
            <a href="<?= site_url('admin/qr-siswa') ?>" class="<?= url_is('admin/qr-siswa*') ? 'active' : '' ?>">
                <i class="bi bi-qr-code-scan"></i> Cetak Kartu
            </a>
            <a href="<?= site_url('admin/laporan') ?>" class="<?= url_is('admin/laporan*') ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i> Riwayat Izin
            </a>
            <a href="<?= site_url('admin/users') ?>" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Data Guru
            </a>
            
            <div class="mt-4 px-2 pt-4 border-top border-secondary border-opacity-10">
                <a href="javascript:void(0)" class="text-danger py-2" id="logoutBtn">
                    <i class="bi bi-power"></i> Keluar
                </a>
            </div>
        </nav>
    </aside>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn border-0 d-lg-none me-3 bg-light rounded-3" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="d-none d-md-block">
                    <h6 class="fw-800 mb-0"><?= $title ?? 'Administrator' ?></h6>
                    <small class="text-muted" style="font-size: 0.7rem; font-weight: 500;">
                        <i class="bi bi-calendar-event me-1"></i> <?= date('l, d F Y') ?>
                    </small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= site_url('admin/qr-siswa') ?>" class="btn-header-action d-none d-sm-flex shadow-sm">
                    <i class="bi bi-printer"></i> Cetak QR
                </a>

                <div class="user-pill shadow-sm" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <div class="d-none d-lg-block text-end me-1">
                        <div class="fw-800 mb-0 lh-1" style="font-size: 0.75rem;"><?= session()->get('nama') ?></div>
                        <small class="text-muted" style="font-size: 0.65rem;">Super Admin</small>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama')) ?>&background=4361ee&color=fff&bold=true" 
                         class="rounded-circle shadow-sm" width="32" height="32">
                </div>
            </div>
        </header>

        <div class="content p-3 p-lg-4 animate__animated animate__fadeIn">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Manajemen Akun</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav nav-pills mb-4 bg-light p-1 rounded-3 d-flex" role="tablist">
                    <li class="nav-item flex-fill">
                        <button class="nav-link active w-100 py-2 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-profile">Profil</button>
                    </li>
                    <li class="nav-item flex-fill">
                        <button class="nav-link w-100 py-2 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-security">Keamanan</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-profile">
                        <form action="<?= base_url('admin/settings/profile') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Nama Admin</label>
                                <input type="text" name="nama" class="form-control bg-light border-0 py-2 rounded-3" value="<?= session()->get('nama') ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold mb-1">Email</label>
                                <input type="email" name="email" class="form-control bg-light border-0 py-2 rounded-3" value="<?= session()->get('email') ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-security">
                        <form action="<?= base_url('admin/settings/password') ?>" method="post" id="formPassword">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Password Baru</label>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2 rounded-3" id="newPass" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Konfirmasi Password</label>
                                <input type="password" class="form-control bg-light border-0 py-2 rounded-3" id="confirmPass" required>
                            </div>
                            <div id="passMsg" class="small fw-bold mb-3 d-none"></div>
                            <button type="submit" id="btnUpdatePass" class="btn btn-danger w-100 py-2 fw-bold rounded-3" disabled>Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar logic
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    const handleToggle = () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    };

    if(toggleBtn) toggleBtn.addEventListener('click', handleToggle);
    if(overlay) overlay.addEventListener('click', handleToggle);

    // Password Match logic
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');
    const passMsg = document.getElementById('passMsg');
    const btnPass = document.getElementById('btnUpdatePass');

    const validate = () => {
        if (confirmPass.value.length > 0) {
            passMsg.classList.remove('d-none');
            if (newPass.value === confirmPass.value) {
                passMsg.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Cocok';
                passMsg.className = "small fw-bold mb-3 text-success";
                btnPass.disabled = false;
            } else {
                passMsg.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Tidak Cocok';
                passMsg.className = "small fw-bold mb-3 text-danger";
                btnPass.disabled = true;
            }
        } else { passMsg.classList.add('d-none'); }
    };

    newPass.addEventListener('keyup', validate);
    confirmPass.addEventListener('keyup', validate);

    // Logout logic
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Keluar dari Sistem?',
            text: "Anda perlu login kembali untuk mengelola data.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => { if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>"; });
    });

    // Alert Flashdata
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success') ?>', timer: 2000, showConfirmButton: false });
    <?php endif; ?>
</script>
</body>
</html>
