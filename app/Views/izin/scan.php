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
            --primary: #4f46e5; 
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --success: #10b981; 
            --danger: #ef4444; 
            --warning: #f59e0b;
            --bg: #0f172a; 
            --card-bg: rgba(255, 255, 255, 0.98);
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
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
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .top-nav {
            width: 100%; 
            padding: 15px 20px; 
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            gap: 10px;
            position: absolute; 
            top: 0; 
            z-index: 1000;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.3);
        }

        .logo {
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-glass {
            background: var(--glass-bg); 
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white; 
            padding: 8px 14px; 
            border-radius: 12px; 
            font-weight: 600; 
            font-size: 0.75rem; 
            text-decoration: none;
            display: flex; 
            align-items: center; 
            gap: 6px; 
            transition: all 0.3s ease;
        }
        .btn-glass:hover { 
            background: rgba(255, 255, 255, 0.2); 
            color: #fff; 
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .main-container {
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            padding: 20px; 
            margin-top: 60px; 
        }

        .card-scan {
            width: 100%; 
            max-width: 420px; 
            background: var(--card-bg); 
            border-radius: 32px; 
            padding: 2rem 1.5rem; 
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .card-scan:hover {
            transform: translateY(-5px);
        }

        .card-scan::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .header-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .header-section h4 {
            font-weight: 800;
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section p {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .status-selector { 
            background: #f1f5f9; 
            padding: 6px; 
            border-radius: 18px; 
            display: flex; 
            gap: 6px; 
            margin-bottom: 1.5rem; 
            box-shadow: var(--shadow-sm);
        }

        .btn-status { 
            border: none; 
            padding: 12px; 
            border-radius: 14px; 
            font-weight: 700; 
            font-size: 0.85rem; 
            flex: 1; 
            color: var(--text-secondary); 
            background: transparent; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-status:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: scale(1.02);
        }

        .btn-status.active { 
            background: white; 
            box-shadow: var(--shadow-md); 
            transform: scale(1.05);
        }
        .btn-status.active[data-status="keluar"] { color: var(--danger); }
        .btn-status.active[data-status="kembali"] { color: var(--success); }

        .form-control-custom {
            background: #f8fafc; 
            border: 2px solid var(--border-color);
            padding: 12px 16px; 
            border-radius: 14px; 
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }
        .form-control-custom:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); 
            outline: none; 
            transform: translateY(-2px);
        }

        .scanner-wrapper { 
            position: relative; 
            border-radius: 24px; 
            overflow: hidden; 
            background: #000; 
            aspect-ratio: 1/1; 
            margin-top: 1.5rem; 
            border: 5px solid #fff;
            box-shadow: var(--shadow-lg);
            min-height: 300px;
            transition: all 0.3s ease;
        }

        .scanner-wrapper:hover {
            box-shadow: var(--shadow-xl);
        }

        .laser { 
            position: absolute; 
            left: 5%; 
            right: 5%; 
            height: 3px; 
            background: var(--danger); 
            box-shadow: 0 0 15px var(--danger); 
            z-index: 20; 
            animation: move 2.5s infinite ease-in-out; 
        }

        @keyframes move { 
            0%, 100% { top: 15%; opacity: 0.3; } 
            50% { top: 85%; opacity: 1; } 
        }

        .scanner-controls {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
            gap: 10px;
        }

        .scanner-btn {
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-switch-camera {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            color: var(--text-primary);
            box-shadow: var(--shadow-sm);
        }

        .btn-switch-camera:hover {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-switch-camera:active {
            transform: translateY(0);
        }

        .settings-panel {
            position: fixed;
            right: -320px;
            top: 0;
            bottom: 0;
            width: 320px;
            background: white;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
            z-index: 1100;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 2rem 1.5rem;
            overflow-y: auto;
        }

        .settings-panel.open {
            right: 0;
        }

        .settings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .settings-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .settings-close:hover {
            background: #f1f5f9;
            color: var(--danger);
            transform: rotate(90deg);
        }

        .settings-section {
            margin-bottom: 2rem;
        }

        .settings-section h5 {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .settings-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
        }

        .settings-option label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .toggle-switch {
            position: relative;
            width: 52px;
            height: 28px;
            background: #e2e8f0;
            border-radius: 28px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.active::after {
            transform: translateX(24px);
        }

        .settings-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .settings-btn:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.5);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(79, 70, 229, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
            }
        }

        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: var(--shadow-lg);
            transform: translateX(400px);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1200;
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: linear-gradient(135deg, var(--success), #059669);
        }

        .notification.error {
            background: linear-gradient(135deg, var(--danger), #dc2626);
        }

        .notification.warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
        }

        .camera-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 30;
            border-radius: 24px;
            color: white;
            font-weight: 600;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .camera-loading i {
            font-size: 2.5rem;
            margin-right: 15px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .camera-error {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 30;
            border-radius: 24px;
            color: white;
            font-weight: 600;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .camera-error i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: var(--danger);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .camera-error button {
            margin-top: 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .camera-error button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Desktop specific styles */
        @media (min-width: 768px) {
            .scanner-wrapper {
                max-height: 400px;
                aspect-ratio: 4/3;
            }
        }

        @media (max-width: 576px) {
            .card-scan {
                max-width: 100%;
                border-radius: 24px;
            }
            
            .scanner-wrapper {
                aspect-ratio: 3/4;
            }

            .settings-panel {
                width: 100%;
                right: -100%;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <div class="logo">
        <i class="bi bi-qr-code-scan"></i>
        Smart Scan
    </div>
    <div class="nav-buttons">
        <a href="<?= site_url('login-siswa') ?>" class="btn-glass">
            <i class="bi bi-person-circle"></i> Login Siswa
        </a>
        <a href="<?= site_url('login') ?>" class="btn-glass">
            <i class="bi bi-shield-lock"></i> Admin
        </a>
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
                       placeholder="Alasan (Contoh: Fotocopy, Sakit)" required>
            </div>

            <div class="scanner-wrapper">
                <div class="laser" id="laser"></div>
                <div id="reader"></div>
                <div class="camera-loading" id="cameraLoading" style="display: none;">
                    <i class="bi bi-arrow-repeat"></i>
                    <div>
                        <div>Mengganti kamera...</div>
                        <small>Mohon tunggu sebentar</small>
                    </div>
                </div>
                <div class="camera-error" id="cameraError" style="display: none;">
                    <i class="bi bi-camera-video-off"></i>
                    <div>Kamera tidak dapat diakses</div>
                    <div class="small">Pastikan kamera terhubung dan izinkan akses kamera di browser</div>
                    <button type="button" id="retryCamera">
                        <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                    </button>
                </div>
            </div>

            <div class="scanner-controls">
                <button type="button" id="switchCamera" class="scanner-btn btn-switch-camera">
                    <i class="bi bi-camera"></i> Switch Camera
                </button>
            </div>
        </form>
    </div>
</div>

<p class="text-center mt-3 text-white-50 small animate__animated animate__fadeIn animate__delay-1s">
    <i class="bi bi-code-slash"></i> &copy; <?= date('Y') ?> rhn.dev
</p>

<!-- Settings Panel -->
<div class="settings-panel" id="settingsPanel">
    <div class="settings-header">
        <h5><i class="bi bi-gear-fill"></i> Pengaturan</h5>
        <button type="button" class="settings-close" id="closeSettings">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <div class="settings-section">
        <h5>Scanner</h5>
        <div class="settings-option">
            <label><i class="bi bi-phone-vibrate"></i> Vibration</label>
            <div class="toggle-switch active" id="vibrationToggle"></div>
        </div>
        <div class="settings-option">
            <label><i class="bi bi-crosshair"></i> Auto Focus</label>
            <div class="toggle-switch active" id="focusToggle"></div>
        </div>
    </div>
    
    <div class="settings-section">
        <h5>Tampilan</h5>
        <div class="settings-option">
            <label><i class="bi bi-circle-half"></i> High Contrast</label>
            <div class="toggle-switch" id="contrastToggle"></div>
        </div>
        <div class="settings-option">
            <label><i class="bi bi-type-h1"></i> Large Text</label>
            <div class="toggle-switch" id="textToggle"></div>
        </div>
    </div>

    <div class="settings-section">
        <h5>Tentang</h5>
        <div class="text-muted small">
            <p>Smart Scan v1.0</p>
            <p>Sistem scan QR untuk izin siswa yang modern dan responsif.</p>
            <p class="mt-3">
                <i class="bi bi-github"></i> 
                <a href="#" class="text-decoration-none">GitHub</a>
            </p>
        </div>
    </div>
</div>

<button type="button" class="settings-btn pulse" id="settingsBtn">
    <i class="bi bi-gear-fill"></i>
</button>

<!-- Notification -->
<div class="notification" id="notification">
    <i class="bi bi-check-circle"></i>
    <span id="notificationText">Notification</span>
</div>

<script>
    // Initialize variables
    const html5QrCode = new Html5Qrcode("reader");
    const ketInput = document.getElementById('keterangan');
    const statusInput = document.getElementById('status');
    const switchCameraBtn = document.getElementById('switchCamera');
    const settingsBtn = document.getElementById('settingsBtn');
    const settingsPanel = document.getElementById('settingsPanel');
    const closeSettingsBtn = document.getElementById('closeSettings');
    const notification = document.getElementById('notification');
    const notificationText = document.getElementById('notificationText');
    const cameraLoading = document.getElementById('cameraLoading');
    const cameraError = document.getElementById('cameraError');
    const retryCameraBtn = document.getElementById('retryCamera');
    
    let isProcessing = false;
    let isScanning = false;
    let currentCameraId = null;
    let cameras = [];
    let settings = {
        vibration: true,
        autoFocus: true,
        highContrast: false,
        largeText: false
    };

    // Load settings from localStorage
    function loadSettings() {
        const savedSettings = localStorage.getItem('scanSettings');
        if (savedSettings) {
            settings = { ...settings, ...JSON.parse(savedSettings) };
            applySettings();
        }
    }

    // Save settings to localStorage
    function saveSettings() {
        localStorage.setItem('scanSettings', JSON.stringify(settings));
    }

    // Apply settings to UI
    function applySettings() {
        // Update toggle switches
        document.getElementById('vibrationToggle').classList.toggle('active', settings.vibration);
        document.getElementById('focusToggle').classList.toggle('active', settings.autoFocus);
        document.getElementById('contrastToggle').classList.toggle('active', settings.highContrast);
        document.getElementById('textToggle').classList.toggle('active', settings.largeText);
        
        // Apply high contrast
        if (settings.highContrast) {
            document.documentElement.style.setProperty('--card-bg', 'rgba(255, 255, 255, 1)');
            document.documentElement.style.setProperty('--text-primary', '#000000');
            document.documentElement.style.setProperty('--text-secondary', '#333333');
        } else {
            document.documentElement.style.setProperty('--card-bg', 'rgba(255, 255, 255, 0.98)');
            document.documentElement.style.setProperty('--text-primary', '#1e293b');
            document.documentElement.style.setProperty('--text-secondary', '#64748b');
        }
        
        // Apply large text
        if (settings.largeText) {
            document.body.style.fontSize = '18px';
        } else {
            document.body.style.fontSize = '';
        }
    }

    // Show notification with enhanced animation
    function showNotification(message, type = 'success') {
        notificationText.textContent = message;
        notification.className = `notification ${type}`;
        notification.classList.add('show');
        
        // Update icon based on type
        const icon = notification.querySelector('i');
        icon.className = type === 'success' ? 'bi bi-check-circle-fill' : 
                       type === 'error' ? 'bi bi-x-circle-fill' : 
                       'bi bi-exclamation-circle-fill';
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    // Vibrate if enabled
    function vibrate() {
        if (settings.vibration && 'vibrate' in navigator) {
            navigator.vibrate([100, 50, 100]);
        }
    }

    // Set status with enhanced animation
    function setStatus(val, btn) {
        document.querySelectorAll('.btn-status').forEach(b => {
            b.classList.remove('active');
            b.style.transform = 'scale(1)';
        });
        
        btn.classList.add('active');
        btn.style.transform = 'scale(1.05)';
        statusInput.value = val;
        
        const isKeluar = val === 'keluar';
        const color = isKeluar ? '#ef4444' : '#10b981';
        const laser = document.getElementById('laser');
        laser.style.background = `linear-gradient(90deg, ${color}, ${color}dd)`;
        laser.style.boxShadow = `0 0 20px ${color}`;
        
        ketInput.required = isKeluar;
        ketInput.placeholder = isKeluar ? "Alasan Keluar (Wajib)" : "Kembali (Opsional)";
        
        // Add pulse effect to input
        ketInput.style.animation = 'pulse 0.5s';
        setTimeout(() => {
            ketInput.style.animation = '';
        }, 500);
    }

    // Get available cameras with better error handling
    async function getCameras() {
        try {
            const devices = await Html5Qrcode.getCameras();
            cameras = devices;
            if (devices && devices.length) {
                currentCameraId = devices[0].id;
                return true;
            }
            return false;
        } catch (err) {
            console.error('Error getting cameras:', err);
            showNotification('Gagal mendapatkan akses kamera', 'error');
            return false;
        }
    }

    // Start scanner with enhanced configuration
    function startScanner() {
        if (!currentCameraId) {
            showCameraError();
            return;
        }

        // Hide error state if visible
        cameraError.style.display = 'none';

        const config = {
            fps: 20,
            qrbox: { width: 250, height: 250 }
        };

        // Adjust qrbox size for desktop
        if (window.innerWidth >= 768) {
            config.qrbox = { width: 300, height: 300 };
        }

        if (settings.autoFocus) {
            config.focusMode = 'continuous';
        }

        html5QrCode.start(
            { deviceId: { exact: currentCameraId } },
            config,
            (decodedText) => {
                if (isProcessing) return;

                if (statusInput.value === 'keluar' && !ketInput.value.trim()) {
                    isProcessing = true;
                    showNotification('Wajib isi alasan untuk izin keluar!', 'warning');
                    ketInput.focus();
                    ketInput.style.animation = 'pulse 1s infinite';
                    setTimeout(() => { 
                        isProcessing = false; 
                        ketInput.style.animation = '';
                    }, 2000);
                    return;
                }
                processScan(decodedText);
            }
        ).then(() => {
            isScanning = true;
            showNotification('Scanner siap digunakan', 'success');
        }).catch(err => {
            console.error('Error starting scanner:', err);
            showCameraError();
            isScanning = false;
        });
    }

    // Show camera error state with enhanced UI
    function showCameraError() {
        cameraError.style.display = 'flex';
        cameraLoading.style.display = 'none';
    }

    // Stop scanner
    function stopScanner() {
        return html5QrCode.stop().then(() => {
            isScanning = false;
        }).catch(err => {
            console.error('Error stopping scanner:', err);
            isScanning = false;
        });
    }

    // Switch camera with enhanced animation
    async function switchCamera() {
        if (cameras.length <= 1) {
            showNotification('Hanya ada satu kamera yang tersedia', 'warning');
            return;
        }

        // Show loading indicator
        cameraLoading.style.display = 'flex';
        cameraError.style.display = 'none';
        switchCameraBtn.disabled = true;
        switchCameraBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Switching...';

        try {
            // Find the next camera
            const currentIndex = cameras.findIndex(camera => camera.id === currentCameraId);
            const nextIndex = (currentIndex + 1) % cameras.length;
            const nextCameraId = cameras[nextIndex].id;

            // Stop current scanner
            if (isScanning) {
                await stopScanner();
            }

            // Switch to next camera
            currentCameraId = nextCameraId;

            // Start scanner with new camera
            startScanner();

            showNotification('Kamera berhasil diubah', 'success');
        } catch (err) {
            console.error('Error switching camera:', err);
            showNotification('Gagal mengganti kamera', 'error');
            showCameraError();
        } finally {
            // Hide loading indicator
            cameraLoading.style.display = 'none';
            switchCameraBtn.disabled = false;
            switchCameraBtn.innerHTML = '<i class="bi bi-camera"></i> Switch Camera';
        }
    }

    // Process scan with enhanced feedback
    async function processScan(qrCode) {
        isProcessing = true;
        
        // Show loading with custom style
        Swal.fire({ 
            title: 'Memproses...', 
            html: 'Sedang memvalidasi data',
            allowOutsideClick: false, 
            didOpen: () => { 
                Swal.showLoading();
                // Add custom animation
                const content = Swal.getHtmlContainer();
                if (content) {
                    content.querySelector('.swal2-title').style.color = 'var(--primary)';
                }
            } 
        });

        const formData = new FormData(document.getElementById('scanForm'));
        formData.append('qr_code', qrCode);

        try {
            const response = await fetch('<?= site_url('izin/process') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || 'Server Error');
            }

            const data = await response.json();

            if (data.status === 'success') {
                vibrate();
                showNotification(data.message || 'Scan berhasil!', 'success');
                ketInput.value = '';
                
                // Success animation
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil!', 
                    text: data.message,
                    confirmButtonColor: 'var(--primary)',
                    timer: 2000, 
                    showConfirmButton: false 
                });
            } else {
                vibrate();
                showNotification(data.message || 'Scan gagal', 'error');
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Gagal', 
                    text: data.message,
                    confirmButtonColor: 'var(--danger)'
                });
            }
        } catch (err) {
            vibrate();
            showNotification('Terjadi kesalahan: ' + err.message.substring(0, 50), 'error');
            Swal.fire({ 
                icon: 'error', 
                title: 'System Error', 
                text: 'Periksa koneksi atau coba lagi nanti',
                confirmButtonColor: 'var(--danger)'
            });
        } finally {
            setTimeout(() => { isProcessing = false; }, 2500);
        }
    }

    // Event listeners with enhanced interactions
    switchCameraBtn.addEventListener('click', switchCamera);
    retryCameraBtn.addEventListener('click', () => {
        getCameras().then(hasCamera => {
            if (hasCamera) {
                startScanner();
            } else {
                showCameraError();
            }
        });
    });
    
    // Settings panel with smooth animations
    settingsBtn.addEventListener('click', () => {
        settingsPanel.classList.add('open');
        settingsBtn.classList.remove('pulse');
    });
    
    closeSettingsBtn.addEventListener('click', () => {
        settingsPanel.classList.remove('open');
    });
    
    // Close settings panel when clicking outside
    document.addEventListener('click', (e) => {
        if (!settingsPanel.contains(e.target) && !settingsBtn.contains(e.target)) {
            settingsPanel.classList.remove('open');
        }
    });
    
    // Settings toggles with enhanced animations
    document.getElementById('vibrationToggle').addEventListener('click', function() {
        this.classList.toggle('active');
        settings.vibration = this.classList.contains('active');
        saveSettings();
        vibrate(); // Test vibration
    });
    
    document.getElementById('focusToggle').addEventListener('click', function() {
        this.classList.toggle('active');
        settings.autoFocus = this.classList.contains('active');
        saveSettings();
        
        // Restart scanner with animation
        if (isScanning) {
            cameraLoading.style.display = 'flex';
            stopScanner().then(() => {
                startScanner();
            });
        }
    });
    
    document.getElementById('contrastToggle').addEventListener('click', function() {
        this.classList.toggle('active');
        settings.highContrast = this.classList.contains('active');
        saveSettings();
        applySettings();
    });
    
    document.getElementById('textToggle').addEventListener('click', function() {
        this.classList.toggle('active');
        settings.largeText = this.classList.contains('active');
        saveSettings();
        applySettings();
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            settingsPanel.classList.remove('open');
        }
        if (e.key === 'c' && e.ctrlKey) {
            e.preventDefault();
            switchCamera();
        }
    });

    // Initialize with enhanced loading
    window.addEventListener('load', () => {
        loadSettings();
        getCameras().then(hasCamera => {
            if (hasCamera) {
                startScanner();
            } else {
                showCameraError();
            }
        });
    });

    // Handle page visibility change
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && isScanning) {
            stopScanner();
        } else if (!document.hidden && !isScanning && currentCameraId) {
            startScanner();
        }
    });
</script>
</body>
</html>