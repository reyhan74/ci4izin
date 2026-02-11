<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* Standar ID Card Portrait (ISO 7810) */
        @page {
            size: A4;
            margin: 10mm;
        }

        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            margin: 0; 
            padding: 20px;
            background-color: #f0f2f5; 
            color: #333;
        }
        
        .container { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, 5.4cm); 
            gap: 10mm; 
            justify-content: center;
        }

        /* Desain Kartu Modern Minimalis */
        .card { 
            width: 5.4cm;
            height: 8.56cm;
            background: #ffffff;
            border-radius: 12px; 
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            page-break-inside: avoid;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e1e4e8;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            padding: 12px 10px;
            background: #ffffff;
            height: 1.6cm;
        }
        .logo {
            width: 30px;
            height: auto;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .school-info {
            text-align: left;
        }
        .school-name {
            font-weight: 800;
            font-size: 8.5px;
            margin: 0;
            color: #1a1a1a;
            letter-spacing: 0.2px;
            line-height: 1.2;
        }
        .school-sub {
            font-size: 7px;
            margin: 2px 0 0 0;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* Bagian Utama QR */
        .qr-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            background: radial-gradient(circle at center, #ffffff 0%, #fafafa 100%);
        }
        
        .qr-wrapper {
            padding: 8px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .qr-img { 
            width: 3.2cm; 
            height: 3.2cm; 
            display: block;
        }

        /* Info Siswa */
        .info-container {
            padding: 5px 5px 15px 5px;
            text-align: center;
        }

        .nama { 
            font-weight: 700; 
            font-size: 10.5px; 
            margin: 0;
            color: #1a1a1a;
            text-transform: uppercase;
            padding: 0 8px;
            line-height: 1.3;
        }
        
        .jurusan-box {
            margin-top: 6px;
            display: inline-block;
            padding: 4px 10px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #f1f5f9;
        }

        .kelas-text { 
            font-size: 9px; 
            color: #2563eb; 
            font-weight: 800;
            display: block;
        }
        
        .jurusan-text {
            font-size: 8px;
            color: #64748b;
            font-weight: 600;
            display: block;
            margin-top: 2px;
            text-transform: uppercase;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #ffffff;
            padding: 7px 0;
            font-size: 8px;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.8px;
            text-transform: lowercase;
        }

        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .container { gap: 5mm; padding: 0; }
            .card { 
                box-shadow: none; 
                border: 1px solid #eee; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 30px; padding: 20px; background: #fff; border-bottom: 1px solid #ddd;">
        <button onclick="window.print()" style="padding: 12px 35px; font-weight: bold; cursor: pointer; background: #2563eb; color: #fff; border: none; border-radius: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
            🖨️ CETAK SEKARANG
        </button>
    </div>

    <div class="container">
        <?php foreach ($siswa as $s): ?>
            <div class="card">
                <div class="header">
                    <img src="<?= base_url('img/logo.png') ?>" class="logo" alt="Logo">
                    <div class="school-info">
                        <p class="school-name">SMK CANDA BHIRAWA PARE</p>
                        <p class="school-sub">Student Digital ID</p>
                    </div>
                </div>

                <div class="qr-body">
                    <div class="qr-wrapper">
                        <?php 
                            // Menggunakan pengecekan file atau langsung ke folder upload
                            $qrFile = base_url("uploads/qrcode/qr_" . $s['unique_code'] . ".png"); 
                        ?>
                        <img src="<?= $qrFile ?>" class="qr-img" alt="QR">
                    </div>
                </div>
                
                <div class="info-container">
                    <div class="nama"><?= esc($s['nama_siswa']) ?></div>
                    <div class="jurusan-box">
                        <span class="kelas-text"><?= esc($s['kelas']) ?> <?= esc($s['jurusan'] ?? '-') ?></span>
                    </div>
                </div>

                <div class="footer">
                    izin.rhn.web.id
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>