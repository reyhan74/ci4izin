<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Pengaturan Kertas Print */
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .card-qr { border: 1px solid #eee !important; box-shadow: none !important; break-inside: avoid; }
            .container { width: 100% !important; max-width: 100% !important; padding: 0 !important; }
        }

        .card-qr {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            background: white;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .qr-img { width: 130px; height: 130px; object-fit: contain; }
        .student-name { font-weight: bold; font-size: 13px; color: #333; margin-top: 8px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .student-nis { font-size: 11px; color: #777; }
        .class-badge { font-size: 10px; background: #eef2ff; color: #4e73df; padding: 2px 8px; border-radius: 50px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="no-print mb-4 d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
        <div>
            <h4 class="mb-0">Siap Cetak QR Code</h4>
            <small class="text-muted">Total: <?= count($siswa); ?> Siswa</small>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-print"></i> Print Sekarang
            </button>
            <button onclick="window.close()" class="btn btn-light border px-4">Tutup</button>
        </div>
    </div>

    <div class="row">
        <?php foreach ($siswa as $s): ?>
            <div class="col-3">
                <div class="card-qr shadow-sm">
                    <div class="mb-2">
                        <span class="class-badge text-uppercase"><?= $s['kelas']; ?></span>
                    </div>
                    
                    <?php 
                        $qrPath = 'uploads/qr-siswa/qr_' . $s['unique_code'] . '.png';
                        $qrSrc = (file_exists(FCPATH . $qrPath)) ? base_url($qrPath) : "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . $s['unique_code'];
                    ?>
                    
                    <img src="<?= $qrSrc; ?>" class="qr-img" alt="QR">
                    
                    <div class="student-name"><?= $s['nama_siswa']; ?></div>
                    <div class="student-nis"><?= $s['nis']; ?></div>
                    
                    <div class="mt-2 py-1 bg-light rounded border text-monospace" style="font-size: 9px; color: #e74a3b;">
                        <?= $s['unique_code']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html>