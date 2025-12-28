<!DOCTYPE html>
<html>
<head>
    <title>Kartu QR Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .card {
            width: 350px;
            border: 2px solid #000;
            padding: 15px;
            text-align: center;
        }
        .school {
            font-weight: bold;
            font-size: 16px;
        }
        .qr img {
            margin: 10px 0;
        }
        .info {
            text-align: left;
            font-size: 14px;
        }
        .footer {
            margin-top: 10px;
            font-size: 12px;
        }

        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>

<button onclick="window.print()">🖨 Cetak Kartu</button>

<div class="card">
    <div class="school">
        KARTU IZIN SISWA
    </div>

    <div class="qr">
        <img src="<?= base_url('uploads/qr/'.$siswa['qr_code']) ?>" width="180">
    </div>

    <div class="info">
        <p><strong>NIS</strong> : <?= esc($siswa['nis']) ?></p>
        <p><strong>Nama</strong> : <?= esc($siswa['nama']) ?></p>
        <p><strong>Kelas</strong> : <?= esc($siswa['kelas']) ?></p>
        <p><strong>Jurusan</strong> : <?= esc($siswa['jurusan']) ?></p>
    </div>

    <div class="footer">
        Scan QR untuk izin masuk & keluar
    </div>
</div>

</body>
</html>
