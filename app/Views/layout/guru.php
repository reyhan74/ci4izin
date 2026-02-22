<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?? 'E-Presensi Guru' ?></title>

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

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-dark);
            position: fixed;
            left: 0; top: 0;
            z-index: 1060;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 2.2rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
        }

        .brand-logo {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-right: 12px;
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.3);
        }

        .nav-custom { padding: 0 1rem; flex-grow: 1; }
        .nav-custom a {
            color: rgba(255,255,255,0.5); padding: 12px 16px;
            display: flex; align-items: center;
            text-decoration: none; border-radius: 12px;
            margin-bottom: 6px; transition: 0.3s;
            font-weight: 600; font-size: 0.9rem;
        }

        .nav-custom a i { margin-right: 12px; font-size: 1.2rem; }
        .nav-custom a:hover { color: #fff; background: rgba(255, 255, 255, 0.05); }
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
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid #eef2f6;
            position: sticky; top: 0; z-index: 1000;
            height: 70px;
        }

        /* --- MOBILE TRANSPARENT STYLE --- */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            z-index: 1050;
            display: none;
        }

        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                background: rgba(15, 23, 42, 0.8) !important; /* Semi-transparent */
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
            }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay.active { display: block; }
            main { margin-left: 0; width: 100%; }
            .top-navbar { padding: 0.8rem 1.2rem; }
        }

        /* --- MODAL --- */
        .modal-content { border-radius: 24px; border: none; }
        .nav-pills .nav-link.active { background-color: var(--accent) !important; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    <aside class="sidebar shadow-lg">
        <div class="sidebar-brand" data-bs-toggle="modal" data-bs-target="#settingsModal">
            <div class="brand-logo">
                <i class="bi bi-qr-code-scan text-white fs-4"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="text-white fw-800 fs-5 lh-1">E-PRESENSI</span>
                <span class="text-white-50 small mt-1" style="font-size: 0.6rem; letter-spacing: 1px;">GURU PANEL</span>
            </div>
        </div>
        
        <nav class="nav-custom">
            <a href="<?= site_url('guru/dashboard') ?>" class="<?= url_is('guru/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= site_url('guru/siswa') ?>" class="<?= url_is('guru/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="<?= site_url('guru/laporan') ?>" class="<?= url_is('guru/laporan*') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text-fill"></i> Laporan
            </a>
            
            <div style="height: 1px; background: rgba(255,255,255,0.08); margin: 1.5rem 1rem;"></div>
            
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-gear-fill"></i> Pengaturan Akun
            </a>

            <a href="javascript:void(0)" class="text-danger-emphasis mt-2" id="logoutBtn">
                <i class="bi bi-power"></i> Keluar Sesi
            </a>
        </nav>
    </aside>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn border-0 d-lg-none shadow-sm me-3" id="sidebarToggle" style="background: #f1f5f9; border-radius:10px;">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="d-none d-md-block">
                    <h6 class="fw-bold mb-0">Halo, Selamat Datang</h6>
                    <small class="text-muted"><?= date('l, d F Y') ?></small>
                </div>
            </div>
            
            <div class="d-flex align-items-center" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <span class="me-2 d-none d-sm-inline fw-semibold small">Admin Guru</span>
                <img src="https://ui-avatars.com/api/?name=guru&background=4361ee&color=fff&bold=true" class="rounded-circle border border-2 border-white shadow-sm" width="38" height="38">
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
                <h5 class="fw-800 mb-0">Pengaturan</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav nav-pills mb-4 bg-light p-1 rounded-4 d-flex" role="tablist">
                    <li class="nav-item flex-fill">
                        <button class="nav-link active rounded-4 w-100 py-2 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button">Profil</button>
                    </li>
                    <li class="nav-item flex-fill">
                        <button class="nav-link rounded-4 w-100 py-2 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-security" type="button">Keamanan</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-profile">
                        <form action="<?= base_url('guru/settings/profile') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control bg-light rounded-3 py-2" value="<?= session()->get('nama') ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold mb-1">Email</label>
                                <input type="email" name="email" class="form-control bg-light rounded-3 py-2" value="<?= session()->get('email') ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">Simpan Perubahan</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="pills-security">
                        <form action="<?= base_url('guru/settings/password') ?>" method="post" id="formPassword">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Password Baru</label>
                                <input type="password" name="password" class="form-control bg-light rounded-3 py-2" id="newPass" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Konfirmasi Password</label>
                                <input type="password" id="confirmPass" class="form-control bg-light rounded-3 py-2" required>
                            </div>
                            <div id="passMsg" class="small fw-bold mb-3 d-none"></div>
                            <button type="submit" id="btnUpdatePass" class="btn btn-danger w-100 rounded-3 py-2 fw-bold shadow-sm" disabled>Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    
    const toggleAction = () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    };

    if(toggleBtn) toggleBtn.addEventListener('click', toggleAction);
    if(overlay) overlay.addEventListener('click', toggleAction);

    // Password Validation
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');
    const passMsg = document.getElementById('passMsg');
    const btnPass = document.getElementById('btnUpdatePass');

    function validatePass() {
        if(confirmPass.value.length > 0) {
            passMsg.classList.remove('d-none');
            if(newPass.value === confirmPass.value) {
                passMsg.innerText = "Password Cocok";
                passMsg.className = "small fw-bold mb-3 text-success";
                btnPass.disabled = false;
            } else {
                passMsg.innerText = "Password Tidak Cocok";
                passMsg.className = "small fw-bold mb-3 text-danger";
                btnPass.disabled = true;
            }
        } else { passMsg.classList.add('d-none'); }
    }
    newPass.addEventListener('keyup', validatePass);
    confirmPass.addEventListener('keyup', validatePass);

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Yakin mau keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => { if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>"; });
    });
</script>
</body>
</html>
