<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?? 'E-Presensi guru' ?></title>

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
            background: #0f172a;
            position: fixed;
            left: 0; top: 0;
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 2.5rem 1.8rem;
            font-weight: 800; color: #fff;
            font-size: 1.3rem; display: flex; align-items: center;
            cursor: pointer;
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
        .nav-custom a:hover, .nav-custom a.active { color: #fff; background: rgba(255, 255, 255, 0.1); }
        .nav-custom a.active {
            background: var(--accent) !important;
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
            border-bottom: 1px solid #eef2f6;
            position: sticky; top: 0; z-index: 1000;
        }

        .content { padding: 2.5rem; }

        /* --- MODAL STYLE --- */
        .modal-content { border-radius: 30px; border: none; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); }
        .nav-pills .nav-link { color: #64748b; font-weight: 600; transition: 0.3s; }
        .nav-pills .nav-link.active { background-color: #fff !important; color: var(--accent) !important; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        
        .form-control { border: 1px solid transparent; transition: 0.3s; }
        .form-control:focus { background: #fff !important; border-color: var(--accent) !important; box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1) !important; }
        
        .hover-up { transition: 0.3s; }
        .hover-up:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3) !important; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); background: rgba(15, 23, 42, 0.4) !important; backdrop-filter: blur(25px); }
            .sidebar.active { transform: translateX(0); }
            main { margin-left: 0; width: 100%; }
            .content { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <aside class="sidebar shadow-lg">
        <div class="sidebar-brand" data-bs-toggle="modal" data-bs-target="#settingsModal">
            <div class="brand-icon"><i class="bi bi-qr-code-scan text-white"></i></div>
            <span class="text-white">E-PRESENSI</span>
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
            <!-- <a href="<?= site_url('guru/users') ?>" class="<?= url_is('guru/users*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Data Guru
            </a> -->

            <!-- <a href="<?= site_url('guru/walikelas') ?>" class="<?= url_is('guru/walikelas*') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Data Wali Kelas
            </a> -->
            
            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 2rem 1.2rem;"></div>
            
            <a href="javascript:void(0)"
            data-bs-toggle="modal"
            data-bs-target="#settingsModal"
            class="<?= url_is('guru/settings*') ? 'active' : '' ?>">
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
            <button class="btn border-0 d-lg-none shadow-sm" id="sidebarToggle" style="background: #fff; width:40px; height:40px; border-radius:10px;">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="d-none d-md-block">
                <span class="text-muted fw-medium small"><?= date('l, d F Y') ?></span>
            </div>
            <img src="https://ui-avatars.com/api/?name=guru&background=4361ee&color=fff&bold=true" class="rounded-circle border border-2 border-white shadow-sm" width="35" height="35" data-bs-toggle="modal" data-bs-target="#settingsModal" style="cursor:pointer">
        </header>

        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content shadow-lg border-0 overflow-hidden">
            <div class="modal-header border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-gear-wide-connected text-primary fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-800 mb-0">Settings</h4>
                        <p class="text-muted small mb-0">Kelola akun Anda</p>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <div class="form-floating mb-3">
                                <input type="text" name="nama" class="form-control bg-light rounded-4" id="floatName" placeholder="Nama" value="<?= session()->get('nama') ?>" required>
                                <label for="floatName" class="text-muted small fw-bold"><i class="bi bi-person me-1"></i> Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="email" name="email" class="form-control bg-light rounded-4" id="floatEmail" placeholder="Email" value="<?= session()->get('email') ?>" required>
                                <label for="floatEmail" class="text-muted small fw-bold"><i class="bi bi-envelope me-1"></i> Email</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-4 fw-bold py-3 shadow-sm hover-up">
                                Simpan Perubahan <i class="bi bi-check2-all ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="pills-security">
                        <form action="<?= base_url('guru/settings/password') ?>" method="post" id="formPassword">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control bg-light rounded-4" id="newPass" placeholder="Password Baru" required minlength="6">
                                <label for="newPass" class="text-muted small fw-bold"><i class="bi bi-key me-1"></i> Password Baru</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" id="confirmPass" class="form-control bg-light rounded-4" placeholder="Ulangi Password" required>
                                <label for="confirmPass" class="text-muted small fw-bold"><i class="bi bi-shield-check me-1"></i> Verifikasi Password</label>
                            </div>
                            <div id="passMsg" class="small fw-bold mb-4 ms-2 d-none"></div>

                            <button type="submit" id="btnUpdatePass" class="btn btn-danger w-100 rounded-4 fw-bold py-3 shadow-sm hover-up" disabled>
                                Update Password <i class="bi bi-shield-lock ms-2"></i>
                            </button>
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
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleAction = () => sidebar.classList.toggle('active');
    if(toggleBtn) toggleBtn.addEventListener('click', toggleAction);
    if(overlay) overlay.addEventListener('click', toggleAction);

    // SweetAlert Flashdata
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2500, showConfirmButton: false });
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({ icon: 'error', title: 'Oops...', text: '<?= session()->getFlashdata('error') ?>' });
    <?php endif; ?>

    // Password Verification Logic
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');
    const passMsg = document.getElementById('passMsg');
    const btnPass = document.getElementById('btnUpdatePass');

    function validatePass() {
        const p1 = newPass.value;
        const p2 = confirmPass.value;

        if(p2.length > 0) {
            passMsg.classList.remove('d-none');
            if(p1 === p2) {
                passMsg.innerHTML = '<i class="bi bi-check-circle-fill"></i> Password Cocok';
                passMsg.className = "small fw-bold mb-4 ms-2 text-success animate__animated animate__fadeIn";
                confirmPass.style.borderColor = "#2ecc71";
                btnPass.disabled = false;
            } else {
                passMsg.innerHTML = '<i class="bi bi-x-circle-fill"></i> Password Tidak Cocok';
                passMsg.className = "small fw-bold mb-4 ms-2 text-danger animate__animated animate__shakeX";
                confirmPass.style.borderColor = "#e74c3c";
                btnPass.disabled = true;
            }
        } else {
            passMsg.classList.add('d-none');
            btnPass.disabled = true;
        }
    }
    newPass.addEventListener('keyup', validatePass);
    confirmPass.addEventListener('keyup', validatePass);

    // Logout SweetAlert
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Yakin Keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => { if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>"; });
    });
</script>
</body>
</html>