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
        :root { --primary: #4f46e5; --success: #10b981; --danger: #ef4444; --bg: #0f172a; }
        
        body {
            background-color: var(--bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* FIX: Header untuk tombol Admin agar tidak menumpuk */
        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end; /* Memindahkan tombol ke kanan */
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .btn-admin {
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white; 
            padding: 8px 16px; 
            border-radius: 12px; 
            font-weight: 600; 
            font-size: 0.8rem; 
            text-decoration: none;
            display: flex; 
            align-items: center; 
            gap: 8px; 
            transition: 0.3s;
        }
        .btn-admin:hover { background: rgba(255, 255, 255, 0.2); color: #fff; }

        /* Container utama agar card tetap di tengah */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: 40px; /* Memberi ruang agar tidak menabrak tombol admin di atas */
        }

        .card-scan {
            width: 100%; 
            max-width: 400px; 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(20px);
            border-radius: 32px; 
            padding: 2rem 1.5rem; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .status-selector { 
            background: #f1f5f9; padding: 6px; border-radius: 18px; 
            display: flex; gap: 6px; margin-bottom: 1.5rem; 
        }

        .btn-status { 
            border: none; padding: 12px; border-radius: 14px; 
            font-weight: 700; font-size: 0.85rem; flex: 1; 
            color: #64748b; background: transparent; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .btn-status.active { background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-status.active[data-status="keluar"] { color: var(--danger); }
        .btn-status.active[data-status="kembali"] { color: var(--success); }

        .form-control-custom {
            background: #f8fafc; border: 2px solid #e2e8f0;
            padding: 12px 16px; border-radius: 14px; font-weight: 500;
            transition: 0.3s;
        }
        .form-control-custom:focus {
            background: #fff; border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); outline: none;
        }

        .scanner-wrapper { 
            position: relative; border-radius: 24px; overflow: hidden; 
            background: #000; aspect-ratio: 1/1; margin-top: 1.5rem; 
            border: 5px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .laser { 
            position: absolute; left: 5%; right: 5%; height: 3px; 
            background: var(--danger); box-shadow: 0 0 15px var(--danger); 
            z-index: 20; animation: move 2.5s infinite ease-in-out; 
        }

        @keyframes move { 
            0%, 100% { top: 15%; opacity: 0.3; } 
            50% { top: 85%; opacity: 1; } 
        }

        @media (max-width: 480px) {
            .card-scan { border-radius: 24px; padding: 1.5rem 1.25rem; }
            .top-nav { padding: 10px 15px; }
            .main-container { padding: 15px; }
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <a href="<?= site_url('login') ?>" class="btn-admin">
        <i class="bi bi-shield-lock-fill"></i> Panel Admin
    </a>
</nav>

<div class="main-container">
    <div class="card-scan animate__animated animate__zoomIn">
        <div class="text-center mb-4">
            <div class="mb-2">
                <i class="bi bi-qr-code-scan fs-1" style="color: var(--primary);"></i>
            </div>
            <h4 class="fw-800 mb-1" style="letter-spacing: -0.5px;">E-Presensi Siswa</h4>
            <p class="text-muted small">Pilih status, isi alasan, lalu scan QR</p>
        </div>

        <form id="scanForm">
            <?= csrf_field() ?>
            <input type="hidden" name="status" id="status" value="keluar">

            <div class="status-selector">
                <button type="button" class="btn-status active" data-status="keluar" onclick="setStatus('keluar', this)">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </button>
                <button type="button" class="btn-status" data-status="kembali" onclick="setStatus('kembali', this)">
                    <i class="bi bi-box-arrow-in-left me-1"></i> Kembali
                </button>
            </div>

            <div class="mb-3">
                <input type="text" name="keterangan" id="keterangan" 
                       class="form-control form-control-custom" 
                       placeholder="Alasan (Contoh: Sakit, Izin Pulang)" required>
            </div>

            <div class="scanner-wrapper">
                <div class="laser" id="laser"></div>
                <div id="reader" style="width: 100%;"></div>
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <p class="text-muted" style="font-size: 0.7rem;">&copy; <?= date('Y') ?> Smart School System</p>
        </div>
    </div>
</div>

<script>
    const html5QrCode = new Html5Qrcode("reader");
    const ketInput = document.getElementById('keterangan');
    let isProcessing = false;

    function setStatus(val, btn) {
        document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('status').value = val;
        
        const color = val === 'kembali' ? '#10b981' : '#ef4444';
        const laser = document.getElementById('laser');
        laser.style.background = color;
        laser.style.boxShadow = `0 0 15px ${color}`;
    }

    function startScanner() {
        html5QrCode.start(
            { facingMode: "environment" },
            { 
                fps: 25, 
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0 
            },
            (decodedText) => {
                if (isProcessing) return;
                
                if (!ketInput.value.trim()) {
                    isProcessing = true;
                    Swal.fire({ 
                        icon: 'warning', 
                        title: 'Alasan Kosong', 
                        text: 'Tuliskan alasan izin terlebih dahulu!',
                        confirmButtonColor: '#4f46e5'
                    }).then(() => { 
                        isProcessing = false; 
                        ketInput.focus(); 
                    });
                    return;
                }
                processScan(decodedText);
            }
        ).catch(err => {
            console.error("Kamera error:", err);
        });
    }

    function processScan(qrCode) {
        isProcessing = true;
        
        const audio = new Audio('https://www.soundjay.com/buttons/beep-07a.mp3');
        audio.play().catch(() => {});

        Swal.fire({ 
            title: 'Memvalidasi...', 
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false, 
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new FormData(document.getElementById('scanForm'));
        formData.append('qr_code', qrCode);

        fetch('<?= site_url('izin/process') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: data.message, 
                    timer: 2500, 
                    showConfirmButton: false
                });
                ketInput.value = ''; 
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Gagal', 
                    text: data.message,
                    confirmButtonColor: '#4f46e5'
                });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Koneksi ke server terputus.' });
        })
        .finally(() => { 
            setTimeout(() => { isProcessing = false; }, 1500);
        });
    }

    startScanner();
</script>
</body>
</html>