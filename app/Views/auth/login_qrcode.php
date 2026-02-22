<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Siswa | SMK CANDA BHIRAWA PARE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { 
            --primary: #4361ee; 
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

        /* --- Header --- */
        .top-nav {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-text { color: white; font-weight: 800; font-size: 1.1rem; line-height: 1.2; }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white; padding: 8px 16px; border-radius: 12px; 
            font-size: 0.85rem; text-decoration: none;
        }

        /* --- Card & Scanner --- */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .card-login {
            width: 100%; 
            max-width: 400px; 
            background: white; 
            border-radius: 28px; 
            padding: 2rem 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* PERBAIKAN SCANNER MOBILE */
        .scanner-wrapper { 
            position: relative; 
            border-radius: 20px; 
            overflow: hidden; 
            background: #000; 
            width: 100%;
            aspect-ratio: 1/1; /* Memaksa kotak sempurna */
            margin: 1.5rem auto; 
            border: 5px solid #f8fafc;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        /* Memaksa video kamera memenuhi area kotak */
        #reader {
            width: 100% !important;
            height: 100% !important;
            border: none !important;
        }

        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important; /* Mencegah video gepeng di HP */
        }

        /* Garis Scan Animasi */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: #4361ee;
            box-shadow: 0 0 15px #4361ee;
            top: 0;
            z-index: 10;
            animation: scanning 2s infinite linear;
            pointer-events: none;
        }

        @keyframes scanning {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        .btn-camera {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .footer { font-size: 0.75rem; color: #94a3b8; margin-top: 1.5rem; }

/* --- Modern Switch Camera Button --- */
.btn-switch {
    background: linear-gradient(135deg, #475569 0%, #1e293b 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 18px;
    width: 100%;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-align: left;
}

.btn-switch .icon-circle {
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.btn-switch .btn-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.btn-switch .main-text {
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.3px;
}

.btn-switch .sub-text {
    font-size: 0.7rem;
    opacity: 0.7;
    font-weight: 400;
}

/* Hover & Active States */
.btn-switch:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(30, 41, 59, 0.3);
    background: linear-gradient(135deg, #334155 0%, #0f172a 100%);
}

.btn-switch:hover .icon-circle {
    background: var(--primary); /* Berubah biru saat hover */
    transform: rotate(180deg);
}

.btn-switch:active {
    transform: translateY(-1px);
}

/* Penyesuaian Mobile */
@media (max-width: 576px) {
    .btn-switch .sub-text {
        display: none; /* Sembunyikan sub-teks di layar sangat kecil agar ringkas */
    }
    .btn-switch {
        justify-content: center;
        padding: 12px;
    }
}

        /* --- User-Friendly Nav Buttons (Berlaku untuk Login & Kembali) --- */
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

/* Hover Effect Khusus Tombol Kembali */
.back-variant:hover {
    background: white;
    color: #1e293b !important;
    transform: translateX(-5px); /* Efek bergeser ke kiri sedikit saat hover */
}

.back-variant:hover .icon-box {
    background: #f1f5f9;
    color: #1e293b;
}

/* Adaptasi Mobile */
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
    
    <a href="<?= site_url('/') ?>" class="btn-nav-user shadow-sm back-variant">
        <div class="icon-box"><i class="bi bi-arrow-left"></i></div>
        <div class="nav-label d-none d-lg-block">
            <span class="title">Kembali</span>
            <span class="desc">Halaman Utama</span>
        </div>
        <span class="d-lg-none d-block">Kembali</span>
    </a>
</nav>
<div class="main-container">
    <div class="card-login">
        <h5 class="fw-bold mb-1">Login Siswa</h5>
        <p class="text-muted small">Posisikan QR Code di dalam kotak</p>

        <div class="scanner-wrapper">
            <div class="scan-line"></div>
            <div id="reader"></div>
        </div>

        <div id="result">
            <span class="badge bg-light text-secondary rounded-pill px-3 py-2 border small">
                <i class="bi bi-camera me-1"></i> Mencari Kamera...
            </span>
        </div>

        <div class="mt-4">
            <button type="button" class="btn-switch shadow-sm" id="btnSwitchCamera">
                <div class="icon-circle">
                    <i class="bi bi-camera-rotate"></i>
                </div>
                <div class="btn-text">
                    <span class="main-text">Ganti Kamera</span>
                    <span class="sub-text">Gunakan kamera depan/belakang</span>
                </div>
            </button>
        </div>

        <div class="footer">
            &copy; <?= date('Y') ?> SMK CANDA BHIRAWA PARE
        </div>
    </div>
</div>

<script>
    let currentFacingMode = "environment"; 
    const html5QrCode = new Html5Qrcode("reader");
    
    function onScanSuccess(decodedText) {
        // Hentikan scanner segera setelah terdeteksi
        html5QrCode.stop().then(() => {
            // Feedback Suara
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.play().catch(() => {});

            Swal.fire({
                title: 'Verifikasi...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: "<?= site_url('loginsiswa/cekLogin') ?>",
                type: "POST",
                data: { 
                    qr_code: decodedText,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
                dataType: "json",
                success: function(res) {
                    if(res.status == 'success') {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Halo, ' + res.nama, timer: 1500, showConfirmButton: false })
                        .then(() => { window.location.href = "<?= site_url('siswa/dashboard') ?>"; });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message }).then(() => { startScanner(currentFacingMode); });
                    }
                },
                error: () => { location.reload(); }
            });
        });
    }

    function startScanner(facingMode) {
        currentFacingMode = facingMode;
        
        // Ukuran Kotak Scan (QR Box) Dinamis agar pas di HP
        let qrBoxSize = (viewfinderWidth, viewfinderHeight) => {
            let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
            return { width: minEdge * 0.7, height: minEdge * 0.7 };
        }

        const config = { 
            fps: 20, 
            qrbox: qrBoxSize,
            aspectRatio: 1.0 // Penting agar video 1:1 di mobile
        };

        html5QrCode.start({ facingMode: facingMode }, config, onScanSuccess)
        .catch(err => {
            console.error(err);
            // Fallback jika kamera belakang tidak ditemukan
            if(facingMode === "environment") startScanner("user");
        });
    }

    // Jalankan awal
    startScanner("environment");

    // Tombol Ganti Kamera
    document.getElementById('btnSwitchCamera').addEventListener('click', function() {
        const btn = this;
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras.length > 1) {
                const newMode = currentFacingMode === "environment" ? "user" : "environment";
                btn.disabled = true;
                html5QrCode.stop().then(() => {
                    startScanner(newMode);
                    btn.disabled = false;
                });
            } else {
                Swal.fire({ icon: 'info', text: 'Hanya satu kamera terdeteksi.', timer: 2000, showConfirmButton: false });
            }
        });
    });
</script>

</body>
</html>