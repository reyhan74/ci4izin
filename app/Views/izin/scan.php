<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Scan | Izin Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { 
            --primary: #4361ee; 
            --primary-dark: #3556e6;
            --success: #10b981; 
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg: #0f172a;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1a2942 50%, #0d1f3c 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- Navigation --- */
        .top-nav {
            width: 100%;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .brand-header { display: flex; align-items: center; gap: 12px; }
        .brand-logo {
            width: 45px; height: 45px;
            background: rgba(67, 97, 238, 0.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: white;
        }
        .brand-text { color: white; font-weight: 800; font-size: 1.1rem; }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white; padding: 10px 18px; border-radius: 12px; 
            font-weight: 600; font-size: 0.9rem; text-decoration: none;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
        }
        .btn-glass:hover { 
            background: rgba(255, 255, 255, 0.2); color: #fff; 
            transform: translateY(-2px);
        }

        /* --- Main UI --- */
        .main-container {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 20px 15px; width: 100%;
        }

        .card-scan { 
            width: 100%; max-width: 480px;
            background: white; border-radius: 24px;
            padding: 2rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .header-section h4 { font-weight: 800; color: #0f172a; }
        .header-section p { color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem; }

        /* --- Scanner Area --- */
        .scanner-wrapper { 
            position: relative; border-radius: 16px; overflow: hidden; 
            background: #000; aspect-ratio: 1/1; margin: 1.2rem 0; 
            border: 3px solid #f1f5f9;
        }

        #reader { border: none !important; width: 100%; height: 100%; }
        
        .scan-line {
            position: absolute; width: 100%; height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            box-shadow: 0 0 15px var(--primary);
            top: 0; z-index: 10; animation: scanning 2.5s infinite linear;
        }

        @keyframes scanning { 0% { top: 0%; } 100% { top: 100%; } }

        /* --- Controls --- */
        .status-selector { 
            background: #f1f5f9; padding: 6px; border-radius: 16px; 
            display: flex; gap: 8px; margin-bottom: 1.2rem; 
        }

        .btn-status { 
            border: none; padding: 10px; border-radius: 12px; 
            font-weight: 700; font-size: 0.85rem; flex: 1; 
            color: #64748b; background: transparent; transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .btn-status.active { background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-status.active[data-status="keluar"] { color: var(--danger); }
        .btn-status.active[data-status="kembali"] { color: var(--success); }

        .form-control-custom {
            border-radius: 12px; padding: 12px 16px; border: 2px solid #f1f5f9;
            font-weight: 500; transition: all 0.3s ease;
        }
        .form-control-custom:focus {
            border-color: var(--primary); box-shadow: none; background: #f8faff;
        }

        .scanner-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white; border: none; padding: 12px 24px; border-radius: 12px;
            font-weight: 700; width: 100%; transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        /* --- Notifications --- */
        .notification {
            position: fixed; top: -100px; left: 50%; transform: translateX(-50%);
            padding: 16px 24px; border-radius: 16px; background: white;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2); display: flex;
            align-items: center; gap: 12px; z-index: 9999;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 300px; font-weight: 600;
        }
        .notification.show { top: 30px; }
        .notification.success { border-bottom: 4px solid var(--success); color: var(--success); }
        .notification.error { border-bottom: 4px solid var(--danger); color: var(--danger); }
        .notification.warning { border-bottom: 4px solid var(--warning); color: var(--warning); }

        /* --- Camera Overlay --- */
        .camera-loading, .camera-error {
            position: absolute; inset: 0; background: rgba(0,0,0,0.8);
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; color: white; z-index: 100; padding: 20px;
        }
        
        .camera-error button {
            margin-top: 15px; background: white; border: none;
            padding: 8px 16px; border-radius: 8px; font-weight: 600;
        }

        @media (max-width: 576px) {
            .btn-glass span { display: none; }
            .top-nav { padding: 15px; }
            .card-scan { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <div class="brand-header">
        <div class="brand-logo"><i class="bi bi-buildings"></i></div>
        <div>
            <div class="brand-text">E-IZIN</div>
            <div style="color: rgba(255,255,255,0.7); font-size: 0.7rem; font-weight: 600;">SMK CB PARE</div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('login-siswa') ?>" class="btn-glass"><i class="bi bi-person"></i> <span>Siswa</span></a>
        <a href="<?= site_url('login') ?>" class="btn-glass"><i class="bi bi-shield-lock"></i> <span>Admin</span></a>
    </div>
</nav>

<div class="main-container">
    <div class="card-scan animate__animated animate__zoomIn">
        <div class="header-section">
            <h4>E-Izin QR Scan</h4>
            <p>Pilih status lalu scan kartu siswa</p>
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

            <div class="mb-3">
                <input type="text" name="keterangan" id="keterangan" 
                       class="form-control form-control-custom" 
                       placeholder="Alasan Keluar (Wajib)" required>
            </div>

            <div class="scanner-wrapper">
                <div class="scan-line" id="scanLine"></div>
                <div id="reader"></div>
                
                <div class="camera-loading" id="cameraLoading" style="display: none;">
                    <div class="spinner-border text-primary mb-2"></div>
                    <span>Menyiapkan Kamera...</span>
                </div>

                <div class="camera-error" id="cameraError" style="display: none;">
                    <i class="bi bi-camera-video-off fs-1 mb-2"></i>
                    <span>Akses Kamera Ditolak</span>
                    <button type="button" id="retryCamera">Coba Lagi</button>
                </div>
            </div>

            <button type="button" id="switchCamera" class="scanner-btn mt-2">
                <i class="bi bi-camera-rotate"></i> Ganti Kamera
            </button>
        </form>
    </div>
</div>

<p class="text-center pb-4 text-white-50 small">
    &copy; <?= date('Y') ?> SMK Canda Bhirawa Pare &bull; rhn.dev
</p>

<div class="notification" id="notification">
    <i id="notificationIcon" class="bi"></i>
    <span id="notificationText"></span>
</div>

<script>
    const html5QrCode = new Html5Qrcode("reader");
    const ketInput = document.getElementById('keterangan');
    const statusInput = document.getElementById('status');
    const cameraLoading = document.getElementById('cameraLoading');
    const cameraError = document.getElementById('cameraError');
    
    let isProcessing = false;
    let currentCameraId = null;
    let cameras = [];

    function showNotification(message, type = 'success') {
        const notif = document.getElementById('notification');
        const text = document.getElementById('notificationText');
        const icon = document.getElementById('notificationIcon');
        
        text.textContent = message;
        notif.className = `notification ${type} show`;
        
        const icons = {
            success: 'bi-check-circle-fill',
            error: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill'
        };
        icon.className = `bi ${icons[type]}`;
        
        setTimeout(() => notif.classList.remove('show'), 3000);
    }

    function setStatus(val, btn) {
        document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        statusInput.value = val;
        
        const isKeluar = val === 'keluar';
        ketInput.required = isKeluar;
        ketInput.placeholder = isKeluar ? "Alasan Keluar (Wajib)" : "Kembali (Opsional)";
        
        const scanLine = document.getElementById('scanLine');
        scanLine.style.background = isKeluar ? 'var(--danger)' : 'var(--success)';
        scanLine.style.boxShadow = `0 0 15px ${isKeluar ? 'var(--danger)' : 'var(--success)'}`;
    }

    async function initCamera() {
        cameraLoading.style.display = 'flex';
        cameraError.style.display = 'none';
        
        try {
            const devices = await Html5Qrcode.getCameras();
            if (devices && devices.length > 0) {
                cameras = devices;
                // Cari kamera belakang secara otomatis jika ada
                const backCam = devices.find(d => d.label.toLowerCase().includes('back'));
                currentCameraId = backCam ? backCam.id : devices[0].id;
                startScanner(currentCameraId);
            } else {
                throw new Error("Kamera tidak ditemukan");
            }
        } catch (err) {
            cameraError.style.display = 'flex';
            showNotification("Gagal akses kamera", "error");
        } finally {
            cameraLoading.style.display = 'none';
        }
    }

    function startScanner(cameraId) {
        const config = {
            fps: 15,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        html5QrCode.start(cameraId, config, (decodedText) => {
            if (isProcessing) return;
            
            if (statusInput.value === 'keluar' && !ketInput.value.trim()) {
                showNotification("Alasan wajib diisi!", "warning");
                ketInput.focus();
                return;
            }
            
            handleScanSuccess(decodedText);
        }).catch(err => {
            console.error(err);
            cameraError.style.display = 'flex';
        });
    }

    async function handleScanSuccess(qrCode) {
        isProcessing = true;
        if ('vibrate' in navigator) navigator.vibrate(100);

        Swal.fire({
            title: 'Memproses...',
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(document.getElementById('scanForm'));
        formData.append('qr_code', qrCode);

        try {
            const response = await fetch('<?= site_url('izin/process') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();

            if (data.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                ketInput.value = '';
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kegagalan sistem' });
        } finally {
            setTimeout(() => { isProcessing = false; }, 3000);
        }
    }

    document.getElementById('switchCamera').addEventListener('click', async () => {
        if (cameras.length < 2) return showNotification("Hanya 1 kamera tersedia", "warning");
        
        const currentIndex = cameras.findIndex(c => c.id === currentCameraId);
        const nextIndex = (currentIndex + 1) % cameras.length;
        currentCameraId = cameras[nextIndex].id;
        
        await html5QrCode.stop();
        startScanner(currentCameraId);
    });

    document.getElementById('retryCamera').addEventListener('click', initCamera);

    window.addEventListener('load', initCamera);
    
    // Matikan kamera saat pindah tab untuk hemat baterai
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            html5QrCode.stop();
        } else {
            if (currentCameraId) startScanner(currentCameraId);
        }
    });
</script>

</body>
</html>