<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Siswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }

        .card {
            width: 48%;
            border: 2px solid #1E3A8A;
            border-radius: 12px;
            padding: 12px;
            margin: 8px;
            float: left;
            text-align: center;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .logo {
            width: 45px;
            height: 45px;
        }

        .school {
            font-size: 14px;
            font-weight: bold;
            color: #1E3A8A;
            line-height: 1.2;
        }

        .qr {
            margin: 10px 0;
        }

        .qr img {
            width: 170px;
            height: 170px;
        }

        .kelas {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
        }

        .nama {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .link {
            font-size: 11px;
            margin-top: 6px;
            color: #333;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

<?php foreach ($siswa as $row): ?>

    <div class="card">

        <!-- HEADER SEKOLAH -->
        <div class="header">
            <img src="<?= FCPATH . 'img/logo.png' ?>" class="logo">
            <div class="school">
                SMK CANDA BHIRAWA<br>
                PARE
            </div>
        </div>

        <!-- QR CODE -->
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $row['unique_code'] ?>">
        </div>

        <!-- DATA SISWA -->
        <div class="kelas">
            <?= $row['kelas'] ?>
        </div>

        <div class="nama">
            <?= $row['nama_siswa'] ?>
        </div>

        <!-- LINK -->
        <div class="link">
            https://pkl.smkcbpare.sch.id/
        </div>

    </div>

<?php endforeach; ?>

<div class="clear"></div>

</body>
</html>
