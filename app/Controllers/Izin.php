<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\IzinModel;

class Izin extends BaseController
{
    protected $siswaModel;
    protected $izinModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->izinModel  = new IzinModel();
    }

    // =====================================
    // HALAMAN SCAN
    // =====================================
    public function index()
    {
        return view('izin/scan', [
            'title' => 'Scan QR Izin'
        ]);
    }

    // =====================================
    // PROSES SCAN QR
    // =====================================
    public function store()
    {
        $qr         = trim($this->request->getPost('qr'));
        $status     = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        if (!$qr || !$status) {
            return redirect()->back()->with('error', 'QR atau status kosong');
        }

        // QR = NIS langsung
        $siswa = $this->siswaModel->where('nis', $qr)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'QR tidak terdaftar');
        }

        $this->izinModel->insert([
            'siswa_id'   => $siswa['id'],
            'status'     => $status,
            'keterangan' => $keterangan,
            'waktu'      => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Izin berhasil dicatat');
    }


    // =====================================
    // RIWAYAT IZIN (ADMIN)
    // =====================================
    public function riwayat()
    {
        $izin = $this->izinModel
            ->select('izin.*, siswa.nis, siswa.nama, siswa.kelas')
            ->join('siswa', 'siswa.id = izin.siswa_id')
            ->orderBy('waktu', 'DESC')
            ->findAll();

        return view('izin/riwayat', [
            'title' => 'Riwayat Izin',
            'izin'  => $izin
        ]);
    }
}
