<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Izin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .scan-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .main-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            text-align: center;
        }

        /* Scanner Styling */
        #reader {
            border: none !important;
            border-radius: 24px;
            overflow: hidden;
            background: #f9fafb;
            display: flex;
            flex-direction: column-reverse;
        }

        #reader video {
            border-radius: 20px;
            object-fit: cover;
        }

        /* Custom Select Camera di Atas */
        #reader__dashboard_section_csr select {
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            margin-bottom: 20px;
            font-size: 14px;
            outline: none;
            background: #fff;
        }

        /* Mode Toggle */
        .toggle-container {
            background: #f3f4f6;
            padding: 5px;
            border-radius: 16px;
            display: flex;
            margin-bottom: 25px;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
            background: transparent;
            color: #6b7280;
        }

        .toggle-btn.active.keluar { background: #ef4444; color: white; }
        .toggle-btn.active.kembali { background: #10b981; color: white; }

        /* Input Styling */
        .input-minimal {
            border: 2px solid #f3f4f6;
            border-radius: 14px;
            padding: 14px;
            text-align: center;
            font-size: 15px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .input-minimal:focus {
            border-color: #3b82f6;
            box-shadow: none;
            background: #fff;
        }

        .label-text {
            font-size: 12px;
            font-weight: 700;
            color: #9ca3af;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: block;
        }

        /* Hide default library buttons */
        #reader__dashboard_section_csr button { display: none; }
    </style>
</head>
<body>

<div class="scan-container">
    <div class="main-card">
        <h5 class="fw-bold mb-4">E-Presensi</h5>

        <div class="toggle-container">
            <button type="button" class="toggle-btn keluar active" onclick="updateMode('keluar', this)">Keluar</button>
            <button type="button" class="toggle-btn kembali" onclick="updateMode('kembali', this)">Kembali</button>
        </div>

        <form action="<?= site_url('scan/store') ?>" method="post" id="scanForm">
            <?= csrf_field() ?>
            <input type="hidden" name="qr" id="qr">
            <input type="hidden" name="status" id="status" value="keluar">

            <label class="label-text">ALASAN WAJIB DIISI</label>
            <input type="text" name="keterangan" id="keterangan" 
                   class="form-control input-minimal" 
                   placeholder="Tulis alasan singkat..." required>

            <div id="reader"></div>
        </form>
    </div>
</div>

<script>
    const statusInput = document.getElementById('status');
    const form = document.getElementById('scanForm');
    const keterangan = document.getElementById('keterangan');

    function updateMode(val, btn) {
        document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        statusInput.value = val;
    }

    function onScanSuccess(decodedText) {
        if (!keterangan.value.trim()) {
            alert("Silakan isi alasan terlebih dahulu!");
            return;
        }
        
        // Success feedback
        document.getElementById('qr').value = decodedText;
        document.querySelector('.main-card').style.opacity = "0.5";
        
        html5QrcodeScanner.clear();
        form.submit();
    }

    const html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 20, 
        qrbox: 250,
        aspectRatio: 1.0
    });
    html5QrcodeScanner.render(onScanSuccess);
</script>

</body>
</html>