<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'E-Presensi Admin' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a; 
            --accent: #4361ee;
            --main-bg: #f8fafc; 
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0; top: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header { padding: 2.5rem 1.5rem; }

        .sidebar-brand {
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .brand-icon {
            background: var(--accent);
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px;
            margin-right: 12px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
        }

        .nav-custom { padding: 0 1rem; }

        .nav-custom a {
            color: #94a3b8;
            padding: 12px 16px;
            display: flex; align-items: center;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 6px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-custom a i { margin-right: 12px; font-size: 1.1rem; }

        .nav-custom a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-custom a.active {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        /* MAIN CONTENT AREA */
        main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
        }

        .top-navbar {
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 999;
        }

        .content { padding: 2.5rem; }

        /* Custom SweetAlert Style agar matching dengan dashboard */
        .swal2-popup {
            border-radius: 20px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .swal2-styled.swal2-confirm {
            background-color: var(--accent) !important;
            border-radius: 10px !important;
            padding: 10px 25px !important;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            main { margin-left: 0; width: 100%; }
            .sidebar.active { transform: translateX(0); }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <aside class="sidebar shadow-lg">
        <div class="sidebar-header">
            <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-brand">
                <div class="brand-icon">
                    <i class="bi bi-qr-code-scan"></i>
                </div>
                <span>E-PRESENSI</span>
            </a>
        </div>
        
        <nav class="nav-custom mt-2">
            <a href="<?= site_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= site_url('admin/siswa') ?>" class="<?= url_is('admin/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="<?= site_url('admin/users') ?>" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Data User
            </a>
            <a href="<?= site_url('admin/laporan-izin') ?>" class="<?= url_is('admin/laporan-izin*') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-check-fill"></i> Laporan
            </a>
            <a href="<?= site_url('admin/walikelas') ?>" class="<?= url_is('admin/walikelas*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Wali Kelas
            </a>
            
            <div class="text-white-50 small fw-bold text-uppercase px-3 mt-4 mb-2" style="font-size: 0.65rem; letter-spacing: 1.5px; opacity: 0.5;">Sistem</div>
            
            <a href="<?= site_url('admin/settings') ?>" class="<?= url_is('admin/settings*') ? 'active' : '' ?>">
                <i class="bi bi-gear-wide-connected"></i> Pengaturan
            </a>
            <a href="javascript:void(0)" class="text-danger mt-4" id="logoutBtn">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </nav>
    </aside>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <button class="btn btn-light d-lg-none rounded-3 border" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            
            <div class="d-none d-md-block">
                <span class="text-muted small fw-medium">Panel Administrasi &bull; <?= date('d M Y') ?></span>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="mb-0 small fw-bold text-dark">Administrator</p>
                    <p class="mb-0 text-muted" style="font-size: 0.7rem;">Superuser Access</p>
                </div>
                <div class="avatar-box">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4361ee&color=fff&bold=true" class="rounded-circle border border-2 border-white shadow-sm" width="40" height="40" alt="Avatar">
                </div>
            </div>
        </header>

        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // 1. Sidebar Mobile Toggle
    const btnToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    if(btnToggle) {
        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // 2. SweetAlert Otomatis untuk Flashdata Success
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    <?php endif; ?>

    // 3. SweetAlert Otomatis untuk Flashdata Error
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonText: 'Tutup'
        });
    <?php endif; ?>

    // 4. Konfirmasi Logout dengan SweetAlert
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Sesi Anda akan segera diakhiri!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= site_url('logout') ?>";
            }
        })
    });
</script>
</body>
</html>