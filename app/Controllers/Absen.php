<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\AbsenModel;

class Absen extends BaseController
{
    protected $siswa;
    protected $absen;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->absen = new AbsenModel();
    }

    public function index()
    {
        $data['siswa'] = $this->siswa->findAll();
        return view('guru/absen/index', $data);
    }

    public function simpan()
    {
        $tanggal = date('Y-m-d');
        $absen   = $this->request->getPost('absen');

        foreach ($absen as $id_siswa => $status) {
            $this->absen->insert([
                'id_siswa' => $id_siswa,
                'tanggal'  => $tanggal,
                'status'   => $status
            ]);
        }

        return redirect()->back()->with('success', 'Absen berhasil disimpan');
    }
}
