<!DOCTYPE html>
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
            --sidebar-bg: #0f172a;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR MODERN --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0; top: 0;
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .brand-icon {
            background: var(--accent);
            width: 42px; height: 42px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; margin-right: 12px;
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.3);
            color: white;
            font-size: 1.4rem;
        }

        /* Nav Custom Styling */
        .nav-custom { padding: 1.5rem 1rem; flex-grow: 1; overflow-y: auto; }
        
        .nav-label {
            color: rgba(255,255,255,0.3);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 1.5rem 0 0.5rem 1rem;
        }

        .nav-custom a {
            color: rgba(255,255,255,0.5);
            padding: 12px 16px;
            display: flex; align-items: center;
            text-decoration: none; border-radius: 12px;
            margin-bottom: 4px; transition: all 0.3s ease;
            font-weight: 600; font-size: 0.9rem;
        }

        .nav-custom a i { margin-right: 12px; font-size: 1.1rem; }
        
        .nav-custom a:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
            transform: translateX(5px);
        }

        .nav-custom a.active {
            background: var(--accent) !important;
            color: #fff !important;
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4);
        }

        /* --- MAIN CONTENT --- */
        main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.4s;
        }

        .top-navbar {
            padding: 0.8rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 1000;
            height: 70px;
        }

        .user-profile-btn {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 5px 12px 5px 6px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .user-profile-btn:hover { border-color: var(--accent); background: #f8fafc; }

        .qr-download-btn {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            border: none; color: white; padding: 10px 20px;
            border-radius: 12px; font-size: 0.85rem; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center;
            gap: 8px; transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .qr-download-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3); color: white; }

        .content { padding: 2rem; }

        /* --- MODAL SETTINGS --- */
        .modal-content { border-radius: 24px; border: none; }
        .nav-pills .nav-link { color: #64748b; font-weight: 700; border-radius: 12px; padding: 10px 20px; }
        .nav-pills .nav-link.active { background-color: var(--accent) !important; color: white !important; }
        
        /* Mobile View Toggle */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1040;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            main { margin-left: 0; width: 100%; }
            .top-navbar { padding: 0.8rem 1rem; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar shadow-lg">
        <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-envelope-paper-fill"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="text-white lh-1 fw-800 fs-5">E-IZIN</span>
                <span class="text-white-50 small" style="font-size: 0.6rem; letter-spacing: 1px;">MANAGEMENT SYSTEM</span>
            </div>
        </a>
        
        <nav class="nav-custom">
            <div class="nav-label">Main Menu</div>
            <a href="<?= site_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="nav-label">Data Siswa</div>
            <a href="<?= site_url('admin/siswa') ?>" class="<?= url_is('admin/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Semua Siswa
            </a>
            <a href="<?= site_url('admin/jurusan') ?>" class="<?= url_is('admin/jurusan*') ? 'active' : '' ?>">
                <i class="bi bi-layers-fill"></i> Jurusan
            </a>
            <a href="<?= site_url('admin/kelas') ?>" class="<?= url_is('admin/kelas*') ? 'active' : '' ?>">
                <i class="bi bi-door-closed-fill"></i> Kelas
            </a>

            <div class="nav-label">Log Izin</div>
            <a href="<?= site_url('admin/qr-siswa') ?>" class="<?= url_is('admin/qr-siswa*') ? 'active' : '' ?>">
                <i class="bi bi-qr-code-scan"></i> Cetak Kartu Izin
            </a>
            <a href="<?= site_url('admin/laporan') ?>" class="<?= url_is('admin/laporan*') ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i> Riwayat Izin
            </a>
            <a href="<?= site_url('admin/users') ?>" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Petugas Piket
            </a>
            
            <div class="mt-5 px-3">
                <a href="javascript:void(0)" class="text-danger py-2" id="logoutBtn" style="background: rgba(239, 68, 68, 0.1);">
                    <i class="bi bi-power"></i> Keluar Sistem
                </a>
            </div>
        </nav>
    </aside>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn border-0 d-lg-none me-3" id="sidebarToggle" style="background: #f1f5f9; border-radius:10px;">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="d-none d-md-block">
                    <h6 class="fw-800 mb-0">Halaman <?= $title ?? 'Admin' ?></h6>
                    <small class="text-muted"><?= date('l, d F Y') ?></small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= site_url('admin/qr-siswa/') ?>" class="qr-download-btn d-none d-sm-inline-flex">
                    <i class="bi bi-printer-fill"></i> Cetak QR
                </a>
                
                <div class="user-profile-btn shadow-sm" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4361ee&color=fff&bold=true" class="rounded-circle" width="30" height="30">
                    <span class="fw-bold small d-none d-lg-block">Administrator</span>
                    <i class="bi bi-chevron-down small opacity-50"></i>
                </div>
            </div>
        </header>

        <div class="content animate__animated animate__fadeIn">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0"><i class="bi bi-gear-fill me-2 text-primary"></i>Pengaturan Akun</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <ul class="nav nav-pills mb-4 bg-light p-1 rounded-4 d-flex" role="tablist">
                    <li class="nav-item flex-fill">
                        <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#pills-profile">Profil</button>
                    </li>
                    <li class="nav-item flex-fill">
                        <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#pills-security">Keamanan</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-profile">
                        <form action="<?= base_url('admin/settings/profile') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Nama Lengkap</label>
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
    // Sidebar Toggle Logic
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    const handleToggle = () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    };

    if(toggleBtn) toggleBtn.addEventListener('click', handleToggle);
    if(overlay) overlay.addEventListener('click', handleToggle);

    // Password Validation
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');
    const passMsg = document.getElementById('passMsg');
    const btnPass = document.getElementById('btnUpdatePass');

    const validate = () => {
        if (confirmPass.value.length > 0) {
            passMsg.classList.remove('d-none');
            if (newPass.value === confirmPass.value) {
                passMsg.innerHTML = '<i class="bi bi-check-circle-fill"></i> Password Cocok';
                passMsg.className = "small fw-bold mb-3 text-success";
                btnPass.disabled = false;
            } else {
                passMsg.innerHTML = '<i class="bi bi-x-circle-fill"></i> Password Tidak Cocok';
                passMsg.className = "small fw-bold mb-3 text-danger";
                btnPass.disabled = true;
            }
        } else {
            passMsg.classList.add('d-none');
        }
    };

    newPass.addEventListener('keyup', validate);
    confirmPass.addEventListener('keyup', validate);

    // Logout Action
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Yakin mau keluar?',
            text: "Sesi admin akan dihentikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>";
        });
    });

    // Flash Data Alerts
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2000, showConfirmButton: false });
    <?php endif; ?>
</script>
</body>
</html>
