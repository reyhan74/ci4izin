<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\WaliKelasModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $waliModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->waliModel  = new WaliKelasModel();
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
                ->with('error', 'Akses wali kelas tidak valid');
        }

        // Ambil siswa berdasarkan kelas & jurusan wali
        $siswa = $this->siswaModel
            ->where('kelas', $wali['kelas'])
            ->where('jurusan', $wali['jurusan'])
            ->orderBy('nama', 'ASC')
            ->findAll();

        return view('wali/siswa/index', [
            'kelas'   => $wali['kelas'],
            'jurusan' => $wali['jurusan'],
            'siswa'   => $siswa
        ]);
    }
}
