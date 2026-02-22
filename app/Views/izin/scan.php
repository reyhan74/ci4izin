<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Scan | E-Izin Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { 
            --primary: #4361ee; 
            --success: #10b981; 
            --danger: #ef4444;
            --bg: #0f172a;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1a2942 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- Nav --- */
        .top-nav { padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .brand-text { color: white; font-weight: 800; font-size: 1.1rem; line-height: 1.2; }
        .btn-glass {
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white; padding: 8px 15px; border-radius: 12px; text-decoration: none;
        }

        /* --- UI Card --- */
        .main-container { flex: 1; display: flex; align-items: center; justify-content: center; padding: 15px; }
        .card-scan { 
            width: 100%; max-width: 450px; background: white; border-radius: 30px; 
            padding: 2rem 1.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); 
        }

        .btn-switch {
            background: linear-gradient(135deg, #64748b 0%, #334155 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 0.9rem;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(51, 65, 85, 0.2);
        }

        .btn-switch:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(51, 65, 85, 0.3);
            background: linear-gradient(135deg, #475569 0%, #1e293b 100%);
        }

        .btn-switch:active {
            transform: translateY(0);
        }

        /* --- SCANNER RESPONSIVE ENGINE --- */
        .scanner-wrapper { 
            position: relative; 
            width: 100%;
            aspect-ratio: 1 / 1; /* Menjaga bentuk kotak sempurna di layar mana pun */
            background: #000; 
            border-radius: 24px; 
            margin: 1.5rem 0; 
            border: 4px solid #f1f5f9;
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }

        /* Memaksa video kamera agar memenuhi kotak (Auto-Crop) */
        #reader { width: 100% !important; height: 100% !important; border: none !important; }
        #reader video { 
            width: 100% !important; height: 100% !important; 
            object-fit: cover !important; /* Kunci utama responsivitas kamera */
        }

        /* Garis Scan Animasi */
        .scan-line {
            position: absolute; width: 100%; height: 3px;
            background: var(--primary); box-shadow: 0 0 15px var(--primary);
            top: 0; z-index: 10; animation: scanning 2.5s infinite linear;
            pointer-events: none;
        }
        @keyframes scanning { 0% { top: 0%; } 100% { top: 100%; } }

        /* Overlay Frame (Target Visual) */
        .scanner-overlay {
            position: absolute; inset: 0;
            border: 40px solid rgba(0,0,0,0.3); /* Bingkai transparan */
            z-index: 5; pointer-events: none;
            display: flex; align-items: center; justify-content: center;
        }
        .scanner-overlay::after {
            content: ""; width: 100%; height: 100%;
            border: 2px solid rgba(255,255,255,0.5); border-radius: 8px;
        }

        /* --- Form Controls --- */
        .status-selector { background: #f1f5f9; padding: 5px; border-radius: 15px; display: flex; gap: 5px; margin-bottom: 1rem; }
        .btn-status { 
            border: none; padding: 10px; border-radius: 10px; flex: 1; 
            font-weight: 700; font-size: 0.85rem; color: #64748b; background: transparent; transition: 0.3s;
        }
        .btn-status.active { background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .btn-status.active[data-status="keluar"] { color: var(--danger); }
        .btn-status.active[data-status="kembali"] { color: var(--success); }

        .form-control-custom {
            border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; font-weight: 600;
        }
        .scanner-btn {
            background: var(--primary); color: white; border: none; padding: 12px; 
            border-radius: 12px; font-weight: 700; width: 100%;
        }

        .camera-loading {
            position: absolute; inset: 0; background: #000; z-index: 20;
            display: flex; flex-direction: column; align-items: center; justify-content: center; color: white;
        }
        /* --- New User-Friendly Nav Buttons --- */
        .btn-nav-user {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-nav-user .icon-box {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .btn-nav-user .nav-label {
            text-align: left;
            line-height: 1.1;
        }

        .btn-nav-user .nav-label .title {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .btn-nav-user .nav-label .desc {
            font-size: 0.65rem;
            opacity: 0.7;
            font-weight: 400;
        }

        /* Hover Effects */
        .btn-nav-user:hover {
            background: white;
            color: var(--primary) !important;
            transform: translateY(-3px);
        }

        .btn-nav-user:hover .icon-box {
            background: var(--primary);
            color: white;
        }

        /* Variant untuk Admin agar berbeda warna saat hover */
        .admin-variant:hover {
            color: #1e293b !important;
        }
        .admin-variant:hover .icon-box {
            background: #1e293b;
        }

        /* Responsivitas Mobile */
        @media (max-width: 991px) {
            .btn-nav-user {
                padding: 8px 15px;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .btn-nav-user .icon-box { display: none; }
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <div class="d-flex align-items-center gap-2">
        <div style="background: var(--primary); width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="bi bi-qr-code-scan"></i>
        </div>
        <div class="brand-text">
            E-IZIN 
            <span class="d-block small opacity-50" style="font-size: 0.6rem;">
                <span class="d-none d-md-inline">SMK CANDA BHIRAWA PARE</span>
                <span class="d-inline d-md-none">SMK CB PARE</span>
            </span>
        </div>
    </div>
    
    <div class="d-flex gap-3">
        <a href="<?= site_url('login-siswa') ?>" class="btn-nav-user shadow-sm">
            <div class="icon-box"><i class="bi bi-person-badge"></i></div>
            <div class="nav-label d-none d-lg-block">
                <span class="title">Siswa</span>
                <span class="desc">Scan Kartu</span>
            </div>
            <span class="d-lg-none d-block">Siswa</span>
        </a>

        <a href="<?= site_url('login') ?>" class="btn-nav-user shadow-sm admin-variant">
            <div class="icon-box"><i class="bi bi-shield-lock"></i></div>
            <div class="nav-label d-none d-lg-block">
                <span class="title">Admin</span>
                <span class="desc">Panel Kontrol</span>
            </div>
            <span class="d-lg-none d-block">Admin</span>
        </a>
    </div>
</nav>

<div class="main-container">
    <div class="card-scan">
        <div class="text-center mb-4">
            <h4 class="fw-bold m-0">Scan Presensi</h4>
            <p class="text-muted small">Pilih status dan arahkan kode QR ke kamera</p>
        </div>

        <form id="scanForm">
            <?= csrf_field() ?>
            <input type="hidden" name="status" id="status" value="keluar">

            <div class="status-selector">
                <button type="button" class="btn-status active" data-status="keluar" onclick="setStatus('keluar', this)">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
                <button type="button" class="btn-status" data-status="kembali" onclick="setStatus('kembali', this)">
                    <i class="bi bi-box-arrow-in-left"></i> Kembali
                </button>
            </div>

            <input type="text" name="keterangan" id="keterangan" class="form-control form-control-custom mb-3" placeholder="Alasan Keluar (Wajib)" required>

            <div class="scanner-wrapper">
                <div class="scan-line" id="scanLine"></div>
                <div class="scanner-overlay"></div>
                
                <div id="reader"></div>
                
                <div class="camera-loading" id="cameraLoading">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <span class="small">Membuka Kamera...</span>
                </div>
            </div>

            <button type="button" id="switchCamera" class="btn-switch mt-2">
                <i class="bi bi-camera-rotate me-1"></i> Ganti Kamera
            </button>
        </form>
    </div>
</div>

<script>
    const html5QrCode = new Html5Qrcode("reader");
    const statusInput = document.getElementById('status');
    const ketInput = document.getElementById('keterangan');
    const scanLine = document.getElementById('scanLine');
    let isProcessing = false;
    let currentCameraId = null;

    function setStatus(val, btn) {
        document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        statusInput.value = val;
        
        const isKeluar = val === 'keluar';
        ketInput.required = isKeluar;
        ketInput.placeholder = isKeluar ? "Alasan Keluar (Wajib)" : "Kembali (Opsional)";
        
        // Ubah warna tema scanner
        const color = isKeluar ? '#ef4444' : '#10b981';
        scanLine.style.background = color;
        scanLine.style.boxShadow = `0 0 15px ${color}`;
    }

    async function initCamera() {
        try {
            const devices = await Html5Qrcode.getCameras();
            if (devices && devices.length > 0) {
                // Utamakan kamera belakang
                const backCam = devices.find(d => d.label.toLowerCase().includes('back'));
                currentCameraId = backCam ? backCam.id : devices[0].id;
                startScanner(currentCameraId);
            }
        } catch (err) {
            Swal.fire('Error', 'Izin kamera ditolak atau tidak ditemukan', 'error');
        }
    }

    function startScanner(cameraId) {
        // Logika QR Box Dinamis (Responsif sesuai layar)
        let qrBoxSize = (viewfinderWidth, viewfinderHeight) => {
            let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
            return { width: minEdge * 0.7, height: minEdge * 0.7 };
        };

        const config = {
            fps: 20,
            qrbox: qrBoxSize,
            aspectRatio: 1.0 // Paksa rasio kotak 1:1
        };

        html5QrCode.start(cameraId, config, (decodedText) => {
            if (isProcessing) return;
            
            if (statusInput.value === 'keluar' && !ketInput.value.trim()) {
                Swal.fire('Perhatian', 'Alasan keluar wajib diisi!', 'warning');
                return;
            }
            
            sendData(decodedText);
        }).then(() => {
            document.getElementById('cameraLoading').style.display = 'none';
        });
    }

    async function sendData(qrCode) {
        isProcessing = true;
        
        // Feedback Getar (hanya Android)
        if ('vibrate' in navigator) navigator.vibrate(100);

        Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        const formData = new FormData(document.getElementById('scanForm'));
        formData.append('qr_code', qrCode);

        try {
            const response = await fetch('<?= site_url('izin/process') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const res = await response.json();

            if (res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                ketInput.value = '';
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        } catch (err) {
            Swal.fire('Error', 'Gagal terhubung ke server', 'error');
        } finally {
            // Delay 3 detik agar tidak scan berkali-kali secara tidak sengaja
            setTimeout(() => { isProcessing = false; }, 3000);
        }
    }

    document.getElementById('switchCamera').addEventListener('click', async () => {
        const devices = await Html5Qrcode.getCameras();
        if (devices.length < 2) return;
        
        const currentIndex = devices.findIndex(d => d.id === currentCameraId);
        const nextIndex = (currentIndex + 1) % devices.length;
        currentCameraId = devices[nextIndex].id;
        
        await html5QrCode.stop();
        startScanner(currentCameraId);
    });

    window.addEventListener('load', initCamera);
</script>

</body>
</html>