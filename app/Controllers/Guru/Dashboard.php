<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\IzinModel;
use Config\Database;

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $izinModel;
    protected $db;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->izinModel  = new IzinModel();
        $this->db         = Database::connect();
    }

    public function index()
    {
        $today = date('Y-m-d');

        /* ===============================
           1. TOTAL SELURUH SISWA
        =============================== */
        $totalSiswa = $this->siswaModel->countAll();

        /* ===============================
           2. TOTAL IZIN HARI INI
        =============================== */
        $izinHariIni = $this->izinModel
            ->where('DATE(waktu)', $today)
            ->countAllResults();

        /* ===============================
           3. STATUS TERAKHIR TIAP SISWA HARI INI
           (Keluar / Kembali)
        =============================== */
        $subQuery = $this->db->table('tb_izin_siswa')
            ->select('id_siswa, MAX(waktu) AS waktu_terakhir')
            ->where('DATE(waktu)', $today)
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        $statusTerakhir = $this->db->table('tb_izin_siswa')
            ->select('tb_izin_siswa.jenis_izin')
            ->join(
                "($subQuery) AS latest",
                "latest.id_siswa = tb_izin_siswa.id_siswa 
                 AND latest.waktu_terakhir = tb_izin_siswa.waktu"
            )
            ->get()
            ->getResultArray();

        $izinKeluar  = 0;
        $izinKembali = 0;

        foreach ($statusTerakhir as $row) {
            if ($row['jenis_izin'] === 'Keluar') {
                $izinKeluar++;
            } elseif ($row['jenis_izin'] === 'Kembali') {
                $izinKembali++;
            }
        }

        /* ===============================
           4. IZIN TERBARU (5 DATA TERAKHIR)
        =============================== */
        $izinTerbaru = $this->izinModel
            ->select('tb_izin_siswa.*, tb_siswa.nama_siswa')
            ->join('tb_siswa', 'tb_siswa.id_siswa = tb_izin_siswa.id_siswa')
            ->orderBy('tb_izin_siswa.waktu', 'DESC')
            ->limit(5)
            ->findAll();

        /* ===============================
           5. DATA GRAFIK 7 HARI TERAKHIR
        =============================== */
        $grafikLabels = [];
        $grafikData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $grafikLabels[] = date('d M', strtotime($date));

            $grafikData[] = $this->izinModel
                ->where('DATE(waktu)', $date)
                ->countAllResults();
        }

        /* ===============================
           6. LOAD VIEW GURU
        =============================== */
        return view('guru/dashboard', [
            'totalSiswa'   => $totalSiswa,
            'izinHariIni'  => $izinHariIni,
            'izinKeluar'   => $izinKeluar,
            'izinKembali'  => $izinKembali,
            'izinTerbaru'  => $izinTerbaru,
            'grafikLabels' => json_encode($grafikLabels),
            'grafikData'   => json_encode($grafikData),
        ]);
    }
}
