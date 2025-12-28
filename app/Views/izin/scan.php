<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Scan | Izin Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --bg: #0f172a;
        }

        body {
            background-color: var(--bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        /* Tombol Admin di Pojok Kanan Atas */
        .admin-login-wrapper {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-admin {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-admin:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        .card-scan {
            max-width: 400px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 2rem;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .icon-box i {
            font-size: 2rem;
            color: var(--primary);
        }

        .status-selector {
            background: #f1f5f9;
            padding: 6px;
            border-radius: 16px;
            display: flex;
            gap: 4px;
            margin-bottom: 1.5rem;
        }

        .btn-status {
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            flex: 1;
            color: #64748b;
            background: transparent;
        }

        .btn-status.active[data-status="keluar"] {
            background: white;
            color: var(--danger);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        .btn-status.active[data-status="kembali"] {
            background: white;
            color: var(--success);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-left: 4px;
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            font-weight: 500;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .scanner-wrapper {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            background: #000;
            aspect-ratio: 1/1;
            margin-top: 1.5rem;
            border: 4px solid #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        #reader {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
        }

        #reader video {
            object-fit: cover !important;
        }

        .laser {
            position: absolute;
            left: 10%;
            right: 10%;
            height: 2px;
            background: var(--danger);
            box-shadow: 0 0 15px var(--danger);
            z-index: 20;
            animation: move 3s infinite linear;
            border-radius: 100%;
        }

        @keyframes move {
            0%, 100% { top: 15%; opacity: 0.3; }
            50% { top: 85%; opacity: 1; }
        }
    </style>
</head>
<body>

<div class="admin-login-wrapper">
    <a href="<?= site_url('login') ?>" class="btn-admin">
        <i class="bi bi-person-fill-lock"></i>
        Admin Login
    </a>
</div>

<div class="card-scan">
    <div class="text-center">
        <div class="icon-box">
            <i class="bi bi-qr-code-scan"></i>
        </div>
        <h4 class="fw-800 mb-1">Presensi QR</h4>
        <p class="text-muted small mb-4">Arahkan kamera ke kode QR siswa</p>
    </div>

    <form action="<?= site_url('izin/process') ?>" method="post" id="scanForm">
        <?= csrf_field() ?>
        <input type="hidden" name="qr_code" id="qr_code">
        <input type="hidden" name="status" id="status" value="keluar">

        <div class="status-selector">
            <button type="button" class="btn-status active" data-status="keluar" onclick="setStatus('keluar', this)">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
            </button>
            <button type="button" class="btn-status" data-status="kembali" onclick="setStatus('kembali', this)">
                <i class="bi bi-box-arrow-in-left me-1"></i> Kembali
            </button>
        </div>

        <div class="mb-2">
            <label class="form-label">Alasan / Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Contoh: Sakit, Izin Bank..." required>
        </div>

        <div class="scanner-wrapper">
            <div class="laser" id="laser"></div>
            <div id="reader"></div>
        </div>
    </form>

    <?php if (session('error')): ?>
        <div class="alert alert-danger border-0 rounded-4 mt-3 py-2 small">
            <i class="bi bi-exclamation-circle me-2"></i> <?= session('error') ?>
        </div>
    <?php endif; ?>
</div>

<script>
    const qrInput = document.getElementById('qr_code');
    const form = document.getElementById('scanForm');
    const statusInput = document.getElementById('status');
    const ketInput = document.getElementById('keterangan');
    const laser = document.getElementById('laser');

    function setStatus(val, btn) {
        document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        statusInput.value = val;
        
        if(val === 'kembali') {
            laser.style.background = '#10b981';
            laser.style.boxShadow = '0 0 15px #10b981';
        } else {
            laser.style.background = '#ef4444';
            laser.style.boxShadow = '0 0 15px #ef4444';
        }
    }

    const html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { 
            fps: 25, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        (decodedText) => {
            if (!ketInput.value.trim()) {
                ketInput.focus();
                if(navigator.vibrate) navigator.vibrate(100);
                return;
            }

            qrInput.value = decodedText;
            document.querySelector('.scanner-wrapper').style.borderColor = "#10b981";

            html5QrCode.stop().then(() => {
                form.submit();
            });
        }
    ).catch(err => {
        console.error("Gagal kamera: ", err);
    });
</script>

</body>
</html>