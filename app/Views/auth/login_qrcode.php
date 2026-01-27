<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Siswa | Smart School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { --primary: #4f46e5; --success: #10b981; --bg: #0f172a; }
        
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

        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1000;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(10px); 
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
        .btn-glass:hover { background: rgba(255, 255, 255, 0.2); color: #fff; transform: translateY(-2px); }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: 40px;
        }

        .card-login {
            width: 100%; 
            max-width: 420px; 
            background: rgba(255, 255, 255, 0.98); 
            border-radius: 32px; 
            padding: 2.5rem 2rem; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .scanner-wrapper { 
            position: relative; 
            border-radius: 24px; 
            overflow: hidden; 
            background: #000; 
            aspect-ratio: 1/1; 
            margin: 1.5rem 0; 
            border: 5px solid #f1f5f9;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Scan Line Effect */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--primary);
            box-shadow: 0 0 15px var(--primary);
            top: 0;
            z-index: 10;
            animation: scanning 2s infinite linear;
        }

        @keyframes scanning {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        #reader { border: none !important; }
        #reader video { border-radius: 15px; }

        @media (max-width: 480px) {
            .card-login { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <a href="<?= site_url('/') ?>" class="btn-glass">
        <i class="bi bi-arrow-left"></i> Kembali ke Scan Izin
    </a>
</nav>

<div class="main-container">
    <div class="card-login animate__animated animate__fadeInUp">
        <div class="mb-3">
            <div class="display-6 text-primary mb-2">
                <i class="bi bi-person-bounding-box"></i>
            </div>
            <h4 class="fw-800 mb-1">Login Siswa</h4>
            <p class="text-muted small">Scan kartu pelajar Anda untuk masuk ke Dashboard</p>
        </div>

        <div class="scanner-wrapper">
            <div class="scan-line"></div>
            <div id="reader"></div>
        </div>

        <div id="result" class="mt-2">
            <span class="badge bg-light text-muted p-2 rounded-pill">
                <i class="bi bi-camera me-1"></i> Menunggu scan...
            </span>
        </div>

        <div class="mt-4">
            <p class="text-muted" style="font-size: 0.7rem;">&copy; <?= date('Y') ?> Smart School System</p>
        </div>
    </div>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Matikan scanner segera setelah berhasil scan
        html5QrCode.stop();
        
        // Efek Suara
        const audio = new Audio('https://www.soundjay.com/buttons/beep-07a.mp3');
        audio.play().catch(() => {});

        Swal.fire({
            title: 'Memverifikasi...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: "<?= site_url('loginsiswa/cekLogin') ?>",
            type: "POST",
            data: { 
                qr_code: decodedText,
                <?= csrf_token() ?>: "<?= csrf_hash() ?>" // Tambahkan CSRF jika CodeIgniter
            },
            dataType: "json",
            success: function(response) {
                if(response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= site_url('siswa/dashboard') ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: response.message,
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        location.reload(); // Restart scanner
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Koneksi ke server terputus.', 'error');
            }
        });
    }

    // Inisialisasi Scanner yang lebih modern
    const html5QrCode = new Html5Qrcode("reader");
    const config = { 
        fps: 20, 
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0 
    };

    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            console.error("Gagal start kamera:", err);
            document.getElementById('result').innerHTML = `<span class='text-danger'>Kamera tidak ditemukan</span>`;
        });
</script>
</body>
</html>