<?= $this->extend('layout/admin'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

<style>
    .rounded-lg { border-radius: 15px !important; }
    .table thead th { border: none; color: #6e707e; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    
    /* MODIFIKASI: Tampilkan Kiri, Cari Kanan */
    .dataTables_wrapper .row:first-child {
        display: flex;
        justify-content: space-between; /* Menyebar ke kiri dan kanan */
        align-items: center;
        margin-bottom: 15px;
        padding: 0 15px;
    }

    .dataTables_length select {
        border-radius: 20px;
        padding: 5px 10px;
        border: 1px solid #d1d3e2;
        outline: none;
    }

    .dataTables_filter input {
        border-radius: 20px;
        padding: 5px 15px;
        border: 1px solid #d1d3e2;
        outline: none;
    }

    .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 10px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
            <p class="text-muted small">Otomasi pembuatan QR Code untuk seluruh siswa.</p>
        </div>
        <div class="d-flex" style="gap: 10px;">
            <a id="btnCetak" href="<?= site_url('admin/qr-siswa/cetak?filter_kelas=all') ?>" target="_blank" class="btn btn-dark shadow-sm px-4 rounded-pill">
                <i class="fas fa-print mr-2"></i> Cetak
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100">
                <div class="card-body">
                    <label class="font-weight-bold text-dark mb-2">Pilih Kelas & Jurusan</label>
                    <select id="filterKelas" class="form-control custom-select rounded-pill">
                        <option value="all">-- Semua Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>">
                                <?= $k['kelas'] ?> - <?= $k['jurusan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100">
                <div class="card-body text-center">
                    <button id="btnGenerateAll" class="btn btn-primary btn-block rounded-pill font-weight-bold shadow-sm mb-3">
                        ⚡ Generate QR
                    </button>
                    <div class="progress rounded-pill" style="height: 20px;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table class="table table-hover align-middle" id="tabelUtama">
                    <thead class="bg-light text-center">
                        <tr>
                            <th style="width: 8%">No</th>
                            <th class="text-left">Nama Siswa</th>
                            <th>QR Code</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableSiswa">
                        <?php $no = 1; foreach ($siswa as $s): ?>
                            <?php $qrUrl = base_url("uploads/qrcode/qr_" . $s['unique_code'] . ".png"); ?>
                            <tr data-kelas="<?= $s['id_kelas'] ?>">
                                <td class="text-center text-muted font-weight-bold"><?= $no++ ?></td>
                                <td class="font-weight-bold text-dark"><?= esc($s['nama_siswa']) ?></td>
                                <td class="text-center">
                                    <div class="border d-inline-block p-1 bg-white rounded shadow-sm">
                                        <img id="qr-img-<?= $s['id_siswa'] ?>" 
                                             src="<?= $qrUrl ?>" 
                                             width="65" 
                                             onerror="this.style.display='none'">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success rounded-pill px-4 btnGenerate shadow-sm" 
                                            data-id="<?= $s['id_siswa'] ?>">
                                        Generate
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // Inisialisasi DataTable
    const table = $('#tabelUtama').DataTable({
        "paging": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        "pageLength": 10,
        // Layout: l = length, f = filter (Cari). 
        // Menggunakan Bootstrap flexbox di dalam dom
        "dom": '<"row mx-0"<"col-sm-12 d-flex justify-content-between align-items-center px-0"lf>>rtip',
        "language": {
            "search": "Cari Nama:",
            "lengthMenu": "Tampilkan _MENU_",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": {
                "next": '<i class="fas fa-chevron-right"></i>',
                "previous": '<i class="fas fa-chevron-left"></i>'
            }
        }
    });

    // 1. FILTER LOGIC
    document.getElementById("filterKelas").addEventListener("change", function () {
        let kelas = this.value;
        
        document.getElementById("btnCetak").href = "<?= site_url('admin/qr-siswa/cetak') ?>?filter_kelas=" + kelas;
        document.getElementById("btnPdf").href = "<?= site_url('admin/qr-siswa/downloadPdf') ?>?filter_kelas=" + kelas;

        $.fn.dataTable.ext.search.pop();
        if (kelas !== "all") {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                return $(table.row(dataIndex).node()).attr('data-kelas') === kelas;
            });
        }
        table.draw();
    });

    // 2. GENERATE SINGLE FUNCTION
    function executeGenerate(id, tombol) {
        tombol.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        return fetch("<?= site_url('admin/qr-siswa/generateSingle') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_siswa=" + id
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                let img = document.getElementById("qr-img-" + id);
                if(img) {
                    img.src = data.file + "?t=" + new Date().getTime();
                    img.style.display = "inline";
                }
                tombol.innerHTML = "✔ Berhasil";
                tombol.className = "btn btn-sm btn-outline-secondary rounded-pill px-4 btnGenerate";
            }
        });
    }

    $(document).on('click', '.btnGenerate', function() {
        executeGenerate(this.dataset.id, this);
    });

    // 3. GENERATE ALL
    document.getElementById("btnGenerateAll").addEventListener("click", function () {
        let filteredRows = table.rows({ filter: 'applied' }).nodes();
        let total = filteredRows.length;

        if(total === 0) return alert("Data kosong.");

        let done = 0;
        $(filteredRows).each(function(index, row) {
            let btn = row.querySelector(".btnGenerate");
            let id = btn.dataset.id;

            setTimeout(() => {
                executeGenerate(id, btn).then(() => {
                    done++;
                    let percent = Math.floor((done / total) * 100);
                    let bar = document.getElementById("progressBar");
                    bar.style.width = percent + "%";
                    bar.innerHTML = percent + "%";
                });
            }, index * 400); 
        });
    });
});
</script>

<?= $this->endSection(); ?>
