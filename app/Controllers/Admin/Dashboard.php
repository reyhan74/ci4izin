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

    // 1. Total Seluruh Siswa
    $totalSiswa = $this->siswa->countAll();

    // 2. Izin Hari Ini (Total semua transaksi izin hari ini)
    $izinHariIni = $this->izin
        ->where('DATE(waktu)', $today)
        ->countAllResults();

    // 3. SEDANG KELUAR (Logika Perbaikan)
    // Menghitung siswa yang status terakhirnya hari ini adalah 'keluar'
    $izinKeluar = $this->izin
        ->select('siswa_id')
        ->where('DATE(waktu)', $today)
        ->groupBy('siswa_id')
        ->having('MAX(CASE WHEN status = "keluar" THEN 1 ELSE 0 END) > MAX(CASE WHEN status = "kembali" THEN 1 ELSE 0 END)')
        ->countAllResults();

    // 4. SUDAH KEMBALI (Logika Perbaikan)
    // Menghitung siswa yang sudah pernah keluar dan status terakhirnya hari ini adalah 'kembali'
    $izinKembali = $this->izin
        ->select('siswa_id')
        ->where('DATE(waktu)', $today)
        ->groupBy('siswa_id')
        ->having('MAX(CASE WHEN status = "kembali" THEN 1 ELSE 0 END) >= MAX(CASE WHEN status = "keluar" THEN 1 ELSE 0 END)')
        ->countAllResults();

    // 5. Izin Terbaru
    $izinTerbaru = $this->izin
        ->select('izin.*, siswa.nama')
        ->join('siswa', 'siswa.id = izin.siswa_id')
        ->orderBy('waktu', 'DESC')
        ->limit(5)
        ->find();

    // 6. Data Grafik
    $grafikLabels = [];
    $grafikData   = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $grafikLabels[] = date('D', strtotime($date));
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