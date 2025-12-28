<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\IzinModel;
use App\Models\WaliKelasModel;

class Izin extends BaseController
{
    protected $izinModel;
    protected $waliModel;

    public function __construct()
    {
        $this->izinModel = new IzinModel();
        $this->waliModel = new WaliKelasModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil kelas wali
        $wali = $this->waliModel
            ->where('user_id', $userId)
            ->first();

        if (!$wali) {
            return redirect()->to('/login')
                ->with('error', 'Akses wali tidak valid');
        }

        // Ambil izin siswa di kelas wali
        $izin = $this->izinModel
            ->select('izin.*, siswa.nama, siswa.nis, siswa.kelas, siswa.jurusan')
            ->join('siswa', 'siswa.id = izin.siswa_id')
            ->where('siswa.kelas', $wali['kelas'])
            ->where('siswa.jurusan', $wali['jurusan'])
            ->orderBy('izin.waktu', 'DESC')
            ->findAll();

        return view('wali/izin/index', [
            'kelas'   => $wali['kelas'],
            'jurusan' => $wali['jurusan'],
            'izin'    => $izin
        ]);
    }
}
