<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Siswa | SMK CANDA BHIRAWA PARE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { 
            --primary: #4361ee; 
            --success: #10b981; 
            --bg: #0f172a;
            --light-bg: #f8fafc;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1a2942 50%, #0d1f3c 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1e293b;
        }

        /* --- Header --- */
        .top-nav {
            width: 100%;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1000;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 45px;
            height: 45px;
            background: rgba(67, 97, 238, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .brand-text {
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white; 
            padding: 10px 18px; 
            border-radius: 12px; 
            font-weight: 600; 
            font-size: 0.9rem; 
            text-decoration: none;
            display: flex; 
            align-items: center; 
            gap: 8px; 
            transition: all 0.3s ease;
        }
        .btn-glass:hover { 
            background: rgba(255, 255, 255, 0.2); 
            color: #fff; 
            transform: translateY(-2px);
        }

        /* --- Main Content --- */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .card-login {
            width: 100%; 
            max-width: 450px; 
            background: white; 
            border-radius: 24px; 
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .scanner-wrapper { 
            position: relative; 
            border-radius: 20px; 
            overflow: hidden; 
            background: #000; 
            aspect-ratio: 1/1; 
            margin: 1.5rem 0; 
            border: 3px solid #e2e8f0;
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #4361ee, transparent);
            box-shadow: 0 0 20px #4361ee;
            top: 0;
            z-index: 10;
            animation: scanning 2.5s infinite linear;
        }

        @keyframes scanning {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        .badge-status {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-camera {
            background: linear-gradient(135deg, #4361ee 0%, #6b7bff 100%);
            color: white;
            border: none;
            padding: 13px 26px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
        }

        .footer {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Responsivitas untuk Navbar Text */
        @media (max-width: 768px) {
            .top-nav { padding: 15px 20px; }
            .card-login { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <div class="brand-header">
        <div class="brand-logo">
            <i class="bi bi-buildings"></i>
        </div>
        <div>
            <div class="brand-text">E-IZIN</div>
            <div class="d-none d-md-block" style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                SMK CANDA BHIRAWA PARE
            </div>
            <div class="d-block d-md-none" style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 600;">
                SMK CB PARE
            </div>
        </div>
    </div>
    <a href="<?= site_url('/') ?>" class="btn-glass">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</nav>

<div class="main-container">
    <div class="card-login">
        <h4 class="fw-bold">Login Siswa</h4>
        <p>Silakan scan kartu pelajar Anda untuk melanjutkan ke dashboard</p>

        <div class="scanner-wrapper">
            <div class="scan-line"></div>
            <div id="reader"></div>
        </div>

        <div id="result" class="mt-2">
            <span class="badge-status">
                <i class="bi bi-camera me-1"></i> Menunggu pemindaian...
            </span>
        </div>

        <div class="camera-controls mt-3">
            <button type="button" class="btn-camera" id="btnSwitchCamera">
                <i class="bi bi-arrow-repeat"></i> Ganti Kamera
            </button>
        </div>

        <div class="footer">
            <p>&copy; <?= date('Y') ?> SMK CANDA BHIRAWA PARE</p>
        </div>
    </div>
</div>

<script>
    let currentFacingMode = "environment"; // Kamera belakang
    const html5QrCode = new Html5Qrcode("reader");
    
    // Fungsi Scan Sukses (Tetap seperti sebelumnya dengan SweetAlert)
    function onScanSuccess(decodedText, decodedResult) {
        html5QrCode.stop().then(() => {
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => {});

            Swal.fire({
                title: 'Verifikasi Data',
                text: 'Sedang mengecek identitas...',
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
                success: function(response) {
                    if(response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Selamat Datang, ' + (response.nama || 'Siswa'),
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "<?= site_url('siswa/dashboard') ?>";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Akses Ditolak',
                            text: response.message,
                            confirmButtonText: 'Coba Lagi'
                        }).then(() => { restartScanner(); });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sesi Berakhir',
                        text: 'Memuat ulang halaman...',
                    }).then(() => { location.reload(); });
                }
            });
        });
    }

    function startScanner(facingMode) {
        currentFacingMode = facingMode;
        html5QrCode.start({ facingMode: facingMode }, { fps: 20, qrbox: 250 }, onScanSuccess)
        .catch(err => { console.error(err); });
    }

    function restartScanner() {
        startScanner(currentFacingMode);
    }

    // Jalankan awal
    startScanner("environment");

    // LOGIKA GANTI KAMER DENGAN CEK JUMLAH KAMERA
    document.getElementById('btnSwitchCamera').addEventListener('click', function() {
        const btn = this;

        // Cek daftar kamera yang tersedia
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length > 1) {
                // Jika kamera lebih dari 1, lakukan switch
                const newMode = currentFacingMode === "environment" ? "user" : "environment";
                
                // Beri efek loading pada tombol saat proses ganti
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
                btn.disabled = true;

                html5QrCode.stop().then(() => {
                    startScanner(newMode);
                    btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ganti Kamera';
                    btn.disabled = false;
                });
            } else {
                // JIKA KAMERA HANYA 1, TAMPILKAN SWEETALERT
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi Kamera',
                    text: 'Maaf, kamera Anda hanya ada 1 atau tidak ada kamera tambahan yang terdeteksi.',
                    confirmButtonColor: '#4361ee'
                });
            }
        }).catch(err => {
            console.error("Gagal mendeteksi kamera", err);
            Swal.fire('Error', 'Gagal mengakses perangkat kamera.', 'error');
        });
    });
</script>