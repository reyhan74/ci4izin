<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\WaliKelasModel;
use App\Models\SiswaModel;
use App\Models\IzinModel;

class Dashboard extends BaseController
{
    protected $waliModel;
    protected $siswaModel;
    protected $izinModel;

    public function __construct()
    {
        $this->waliModel  = new WaliKelasModel();
        $this->siswaModel = new SiswaModel();
        $this->izinModel  = new IzinModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil kelas wali
        $wali = $this->waliModel
            ->where('user_id', $userId)
            ->first();

        if (!$wali) {
            return redirect()->to('/logout')
                ->with('error', 'Anda belum ditetapkan sebagai wali kelas');
        }

        // Data siswa hanya kelas wali
        $siswa = $this->siswaModel
            ->where('kelas', $wali['kelas'])
            ->where('jurusan', $wali['jurusan'])
            ->findAll();

        $totalSiswa = count($siswa);

        // Statistik izin hari ini
        $today = date('Y-m-d');

        $izinKeluar = $this->izinModel
            ->join('siswa', 'siswa.id = izin.siswa_id')
            ->where('siswa.kelas', $wali['kelas'])
            ->where('siswa.jurusan', $wali['jurusan'])
            ->where('izin.status', 'keluar')
            ->where('DATE(izin.waktu)', $today)
            ->countAllResults();

        $izinKembali = $this->izinModel
            ->join('siswa', 'siswa.id = izin.siswa_id')
            ->where('siswa.kelas', $wali['kelas'])
            ->where('siswa.jurusan', $wali['jurusan'])
            ->where('izin.status', 'kembali')
            ->where('DATE(izin.waktu)', $today)
            ->countAllResults();

        return view('wali/dashboard', [
            'wali'        => $wali,
            'totalSiswa'  => $totalSiswa,
            'izinKeluar'  => $izinKeluar,
            'izinKembali' => $izinKembali,
        ]);
    }
}
