<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'E-Presensi Admin' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --accent: #4361ee;
            --main-bg: #f8fafc; 
        }

        /* Scrollbar Halus */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR STYLE --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #0f172a; /* Solid di Desktop */
            position: fixed;
            left: 0; top: 0;
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 2.5rem 1.8rem;
            font-weight: 800; color: #fff;
            font-size: 1.3rem; display: flex; align-items: center;
        }

        .brand-icon {
            background: var(--accent);
            width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; margin-right: 12px;
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.3);
        }

        .nav-custom { padding: 0 1.2rem; }
        .nav-custom a {
            color: rgba(255,255,255,0.6); padding: 14px 18px;
            display: flex; align-items: center;
            text-decoration: none; border-radius: 14px;
            margin-bottom: 8px; transition: 0.3s;
            font-weight: 600; font-size: 0.95rem;
        }

        .nav-custom a i { margin-right: 12px; font-size: 1.2rem; }
        .nav-custom a:hover { color: #fff; background: rgba(255, 255, 255, 0.1); }
        .nav-custom a.active {
            background: var(--accent); color: #fff;
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
            padding: 1rem 2.5rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid #eef2f6;
            position: sticky; top: 0; z-index: 1000;
        }

        .content { padding: 2.5rem; }

        /* --- MOBILE FIX (HIGH TRANSPARENCY) --- */
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                /* Sidebar Sangat Transparan */
                background: rgba(15, 23, 42, 0.4) !important; 
                backdrop-filter: blur(25px) saturate(180%);
                -webkit-backdrop-filter: blur(25px) saturate(180%);
                width: 280px;
                border-right: 1px solid rgba(255, 255, 255, 0.1);
            }
            .sidebar.active { transform: translateX(0); }
            
            main { margin-left: 0; width: 100%; }
            
            /* Full Width Mentok Pinggir */
            .content { padding: 1.5rem 0; }
            .top-navbar { padding: 0.8rem 1rem; }

            .sidebar-overlay {
                display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.2); backdrop-filter: blur(4px); z-index: 1040;
            }
            .sidebar.active + .sidebar-overlay { display: block; }
        }

        .btn-toggle {
            background: #fff; border: 1px solid #eef2f6;
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <aside class="sidebar shadow-lg">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-qr-code-scan text-white"></i></div>
            <span class="text-white">E-PRESENSI</span>
        </div>
        
        <nav class="nav-custom">
            <a href="<?= site_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= site_url('admin/siswa') ?>" class="<?= url_is('admin/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="<?= site_url('admin/laporan-izin') ?>" class="<?= url_is('admin/laporan-izin*') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text-fill"></i> Laporan
            </a>
            <a href="<?= site_url('admin/users') ?>" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Data Guru
            </a>
            
            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 2rem 1.2rem;"></div>
            
            <a href="<?= site_url('admin/settings') ?>" class="<?= url_is('admin/settings*') ? 'active' : '' ?>">
                <i class="bi bi-gear-fill"></i> Pengaturan
            </a>
            <a href="javascript:void(0)" class="text-danger mt-3" id="logoutBtn">
                <i class="bi bi-power"></i> Keluar
            </a>
        </nav>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn-toggle d-lg-none me-3 shadow-sm" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="d-none d-md-block">
                    <span class="text-muted fw-medium small"><?= date('l, d F Y') ?></span>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=Admin&background=4361ee&color=fff&bold=true" class="rounded-circle border border-2 border-white shadow-sm" width="35" height="35">
            </div>
        </header>

        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    const toggleAction = () => sidebar.classList.toggle('active');

    if(toggleBtn) toggleBtn.addEventListener('click', toggleAction);
    if(overlay) overlay.addEventListener('click', toggleAction);

    // SweetAlert Flashdata
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success') ?>', showConfirmButton: false, timer: 2000 });
    <?php endif; ?>

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Yakin Keluar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => { if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>"; });
    });
</script>
</body>
</html>