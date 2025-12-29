<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\IzinModel;

class Izin extends BaseController
{
    public function index()
    {
        return view('izin/scan');
    }

    public function process()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/izin');
        }

        $qr         = trim($this->request->getPost('qr_code'));
        $status     = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('nis', $qr)->first();

        if (!$siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Siswa tidak ditemukan!']);
        }

        $izinModel = new IzinModel();
        $insert = $izinModel->insert([
            'siswa_id'   => $siswa['id'],
            'status'     => $status,
            'keterangan' => $keterangan,
            'waktu'      => date('Y-m-d H:i:s')
        ]);

        if ($insert) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $siswa['nama'] . ' berhasil dicatat (' . $status . ')'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    }
}