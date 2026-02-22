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
            --accent-light: rgba(67, 97, 238, 0.1);
            --main-bg: #f8fafc; 
            --sidebar-dark: #0f172a;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        body { 
            background-color: var(--main-bg);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        /* --- SIDEBAR GURU (Lebih Simpel) --- */
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
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent), #3f37c9);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-right: 12px;
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .nav-custom { padding: 0.5rem 1rem; flex-grow: 1; }
        
        .nav-label {
            color: rgba(255,255,255,0.25);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 1.5rem 0 0.8rem 1rem;
        }

        .nav-custom a {
            color: rgba(255,255,255,0.5); 
            padding: 12px 16px;
            display: flex; align-items: center;
            text-decoration: none; border-radius: 12px;
            margin-bottom: 5px; transition: 0.3s;
            font-weight: 600;
        }

        .nav-custom a i { margin-right: 12px; font-size: 1.2rem; }
        .nav-custom a:hover { color: #fff; background: rgba(255, 255, 255, 0.05); }
        .nav-custom a.active {
            background: var(--accent) !important;
            color: #fff !important;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        /* --- TOPBAR --- */
        main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.4s;
        }

        .top-navbar {
            padding: 0 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 1000;
            height: 75px;
        }

        .user-profile-btn {
            background: #f1f5f9;
            padding: 6px 6px 6px 15px;
            border-radius: 30px;
            display: flex; align-items: center;
            gap: 10px; transition: 0.3s;
            border: 1px solid transparent;
        }
        .user-profile-btn:hover { background: #e2e8f0; border-color: #cbd5e1; }

        /* --- MOBILE --- */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            main { margin-left: 0; width: 100%; }
            .top-navbar { padding: 0 1.2rem; }
        }

        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px); z-index: 1050; display: none;
        }
        .sidebar-overlay.active { display: block; }

        .card-custom {
            border: none; border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="d-flex">
    <aside class="sidebar">
        <a href="<?= site_url('guru/dashboard') ?>" class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-person-workspace fs-4"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="text-white fw-800 fs-5 lh-1">E-PRESENSI</span>
                <span class="text-white-50 small mt-1" style="font-size: 0.65rem; letter-spacing: 1px;">GURU PORTAL</span>
            </div>
        </a>
        
        <nav class="nav-custom">
            <div class="nav-label">Menu Utama</div>
            <a href="<?= site_url('guru/dashboard') ?>" class="<?= url_is('guru/dashboard*') ? 'active' : '' ?>">
                <i class="bi bi-house-door-fill"></i> Beranda
            </a>
            
            <div class="nav-label">Aktivitas</div>
            <a href="<?= site_url('guru/presensi') ?>" class="<?= url_is('guru/presensi*') ? 'active' : '' ?>">
                <i class="bi bi-qr-code-scan"></i> Scan Presensi
            </a>
            <a href="<?= site_url('guru/siswa') ?>" class="<?= url_is('guru/siswa*') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="<?= site_url('guru/laporan') ?>" class="<?= url_is('guru/laporan*') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-check-fill"></i> Rekap Kehadiran
            </a>

            <div class="nav-label">Lainnya</div>
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-person-gear"></i> Akun Saya
            </a>
            <a href="javascript:void(0)" class="text-danger-emphasis mt-3" id="logoutBtn">
                <i class="bi bi-box-arrow-right"></i> Keluar Sesi
            </a>
        </nav>
        
        <div class="p-3 mt-auto">
            <div class="bg-white bg-opacity-10 rounded-4 p-3 text-center">
                <small class="text-white-50 d-block mb-1" style="font-size: 0.6rem;">VERSI APLIKASI</small>
                <span class="text-white fw-bold" style="font-size: 0.75rem;">v2.0.4-Stable</span>
            </div>
        </div>
    </aside>

    <main>
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn border-0 d-lg-none bg-light rounded-3 me-3" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div>
                    <h6 class="fw-800 mb-0">Halo, Pak/Bu <?= explode(' ', session()->get('nama'))[0] ?>!</h6>
                    <small class="text-muted d-none d-md-block" style="font-size: 0.75rem;">
                        <i class="bi bi-calendar3 me-1"></i> <?= date('l, d F Y') ?>
                    </small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="user-profile-btn" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold small lh-1"><?= session()->get('nama') ?></div>
                        <small class="text-muted" style="font-size: 0.65rem;">Tenaga Pengajar</small>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?= session()->get('nama') ?>&background=4361ee&color=fff&bold=true" class="rounded-circle shadow-sm" width="38" height="38">
                </div>
            </div>
        </header>

        <div class="content p-4 animate__animated animate__fadeIn">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Pengaturan Akun</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav nav-pills mb-4 bg-light p-1 rounded-4" role="tablist">
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link active rounded-4 w-100 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button">Profil</button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link rounded-4 w-100 fw-bold" data-bs-toggle="pill" data-bs-target="#pills-security" type="button">Keamanan</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-profile">
                        <form action="<?= base_url('guru/settings/profile') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control border-0 bg-light rounded-3 py-2" value="<?= session()->get('nama') ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold mb-1">Email</label>
                                <input type="email" name="email" class="form-control border-0 bg-light rounded-3 py-2" value="<?= session()->get('email') ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">Simpan</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-security">
                        <form action="<?= base_url('guru/settings/password') ?>" method="post" id="formPassword">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Password Baru</label>
                                <input type="password" name="password" class="form-control border-0 bg-light rounded-3 py-2" id="newPass" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold mb-1">Ulangi Password</label>
                                <input type="password" id="confirmPass" class="form-control border-0 bg-light rounded-3 py-2" required>
                            </div>
                            <div id="passMsg" class="small fw-bold mb-3 d-none"></div>
                            <button type="submit" id="btnUpdatePass" class="btn btn-danger w-100 rounded-3 py-2 fw-bold" disabled>Ganti Password</button>
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

    // Password Match
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');
    const passMsg = document.getElementById('passMsg');
    const btnPass = document.getElementById('btnUpdatePass');

    const checkPass = () => {
        if(confirmPass.value.length > 0) {
            passMsg.classList.remove('d-none');
            if(newPass.value === confirmPass.value) {
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
    newPass.addEventListener('keyup', checkPass);
    confirmPass.addEventListener('keyup', checkPass);

    // Logout Swal
    document.getElementById('logoutBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Selesai Mengajar?',
            text: "Pastikan semua data presensi hari ini sudah tersimpan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4361ee',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => { if (result.isConfirmed) window.location.href = "<?= site_url('logout') ?>"; });
    });
</script>
</body>
</html>
