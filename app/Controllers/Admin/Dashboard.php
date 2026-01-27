<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\IzinModel;

class Dashboard extends BaseController
{
    protected $siswa;
    protected $izin;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->izin  = new IzinModel();
    }

    public function index()
    {
        $today = date('Y-m-d');
        $db = \Config\Database::connect();

        // 1. Total Seluruh Siswa
        $totalSiswa = $this->siswa->countAll();

        // 2. Total Transaksi Hari Ini
        $izinHariIni = $this->izin->where('DATE(waktu)', $today)->countAllResults();

        // 3. LOGIKA SUBQUERY (Mencari Scan Terakhir per Siswa)
        // Penting: Nama tabel harus tb_izin_siswa
        $subQuery = $db->table('tb_izin_siswa')
            ->select('id_siswa, MAX(waktu) as waktu_terakhir')
            ->where('DATE(waktu)', $today)
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        // Ambil baris data terakhir tersebut
        $statusTerakhirSiswa = $db->table('tb_izin_siswa')
            ->select('jenis_izin')
            ->join("($subQuery) as latest", "latest.id_siswa = tb_izin_siswa.id_siswa AND latest.waktu_terakhir = tb_izin_siswa.waktu")
            ->get()
            ->getResultArray();

        $izinKeluar = 0;
        $izinKembali = 0;

        foreach ($statusTerakhirSiswa as $row) {
            // PERHATIKAN: Sesuaikan besar kecil huruf (Case Sensitive) dengan database Anda
            if ($row['jenis_izin'] === 'Keluar') {
                $izinKeluar++;
            } 
            // Di screenshot Anda tulisannya "KEMBALI", maka gunakan "Kembali" atau "KEMBALI"
            elseif ($row['jenis_izin'] === 'Kembali') {
                $izinKembali++;
            }
        }

        // 4. Izin Terbaru
        $izinTerbaru = $this->izin
            ->select('tb_izin_siswa.*, tb_siswa.nama_siswa')
            ->join('tb_siswa', 'tb_siswa.id_siswa = tb_izin_siswa.id_siswa')
            ->orderBy('tb_izin_siswa.waktu', 'DESC')
            ->limit(5)
            ->findAll();

        // 5. Data Grafik
        $grafikLabels = [];
        $grafikData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $grafikLabels[] = date('d M', strtotime($date));
            $grafikData[]   = $this->izin->where('DATE(waktu)', $date)->countAllResults();
        }

        return view('admin/dashboard', [
            'totalSiswa'   => $totalSiswa,
            'izinHariIni'  => $izinHariIni,
            'izinKeluar'   => $izinKeluar,
            'izinKembali'  => $izinKembali,
            'izinTerbaru'  => $izinTerbaru,
            'grafikLabels' => json_encode($grafikLabels),
            'grafikData'   => json_encode($grafikData)
        ]);
    }
}