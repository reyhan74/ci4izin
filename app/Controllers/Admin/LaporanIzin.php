<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IzinModel;

class LaporanIzin extends BaseController
{
    protected $izinModel;

    public function __construct()
    {
        $this->izinModel = new IzinModel();
    }

    public function index()
    {
        $tanggal = $this->request->getGet('tanggal');

        return view('admin/laporan_izin/index', [
            'title'   => 'Laporan Izin Siswa',
            'izin'    => $this->izinModel->getLaporan($tanggal),
            'tanggal' => $tanggal
        ]);
    }
}
