<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | Smart School</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root { --primary: #4f46e5; --success: #10b981; --warning: #f59e0b; --bg: #0f172a; }
        
        body {
            background-color: var(--bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.12) 0px, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.08) 0px, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #f8fafc;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .card-custom {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            transition: 0.3s;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary), #6366f1);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::after {
            content: "";
            position: absolute;
            right: -50px;
            top: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .table {
            color: #cbd5e1;
            vertical-align: middle;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
            padding: 1.2rem;
        }

        .table td {
            padding: 1.2rem;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: white;
        }

        .status-icon {
            font-size: 1.1rem;
            margin-right: 6px;
        }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <span class="navbar-brand fw-800 d-flex align-items-center text-white">
            <i class="bi bi-grid-fill text-primary me-2"></i>
            SISTEM Izin Keluar Masuk Siswa
        </span>
        <a href="<?= site_url('siswa/logout') ?>" class="btn-logout text-decoration-none">
            <i class="bi bi-box-arrow-right me-2"></i>Keluar
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="welcome-section animate__animated animate__fadeIn">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-800 mb-1">Halo, <?= $nama_siswa ?>! 👋</h2>
                        <p class="mb-0 opacity-75">Pantau histori riwayat izin masuk dan keluar Anda hari ini.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="badge bg-white text-dark p-2 rounded-pill px-3 fw-bold">
                            <i class="bi bi-calendar3 me-2"></i><?= date('d M Y') ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FILTER & DOWNLOAD -->
<form method="get" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="mulai" class="form-control" value="<?= $_GET['mulai'] ?? '' ?>">
    </div>
    <div class="col-md-3">
        <input type="date" name="selesai" class="form-control" value="<?= $_GET['selesai'] ?? '' ?>">
    </div>
    <div class="col-md-3">
        <select name="hari" class="form-select">
            <option value="">Semua Hari</option>
            <?php
            $hariList = [
                'Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu',
                'Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'
            ];
            foreach($hariList as $k=>$v):
            ?>
            <option value="<?= $k ?>" <?= (@$_GET['hari']==$k)?'selected':'' ?>><?= $v ?></option>
            <?php endforeach ?>
        </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">Filter</button>
                <a href="<?= current_url() ?>" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <?php if($izin_terakhir && $izin_terakhir['jenis_izin']=='Keluar'): ?>
                    <span class="badge bg-warning">Sedang di luar</span>
                <?php else: ?>
                    <span class="badge bg-success">Di sekolah</span>
                <?php endif ?>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('siswa/izin/excel?'.$_SERVER['QUERY_STRING']) ?>" class="btn btn-success btn-sm">
                    Excel
                </a>
                <a href="<?= site_url('siswa/izin/pdf?'.$_SERVER['QUERY_STRING']) ?>" class="btn btn-danger btn-sm">
                    PDF
                </a>
            </div>
        </div>

            <div class="card card-custom animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-header border-0 bg-transparent p-4 pb-0 d-flex align-items-center justify-content-between">
                    <h5 class="fw-700 mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Histori Izin
                    </h5>
                    <button class="btn btn-sm btn-outline-light border-0 opacity-50" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Jenis Izin</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($histori)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                            <span class="text-muted">Belum ada riwayat izin tercatat.</span>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($histori as $h): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-600"><?= date('H:i', strtotime($h['waktu'])) ?></div>
                                            <div class="small text-muted"><?= date('d M Y', strtotime($h['waktu'])) ?></div>
                                        </td>
                                        <td>
                                            <?php if($h['jenis_izin'] == 'Keluar'): ?>
                                                <span class="badge bg-warning-subtle text-warning badge-status">
                                                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success-subtle text-success badge-status">
                                                    <i class="bi bi-box-arrow-in-left me-1"></i> Kembali
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                                <?= $h['keterangan'] ?: '-' ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <?php if($h['status'] == 1): ?>
                                                <span class="text-success fw-bold">
                                                    <i class="bi bi-check-circle-fill status-icon"></i>Berhasil
                                                </span>
                                            <?php else: ?>
                                                <span class="text-danger fw-bold">
                                                    <i class="bi bi-x-circle-fill status-icon"></i>Gagal
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center opacity-50">
                <p class="small">&copy; <?= date('Y') ?> Smart Izin Siswa • E-Presensi v1.0 • By rhn</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>