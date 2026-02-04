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
    if (!$this->request->isAJAX()) return exit('No direct access');

    $qr         = trim($this->request->getPost('qr_code') ?? '');
    $statusRaw  = $this->request->getPost('status'); 
    $keterangan = trim($this->request->getPost('keterangan') ?? '');

    // 1. Validasi Dasar
    if (!$qr) return $this->response->setJSON(['status' => 'error', 'message' => 'QR Code tidak terdeteksi']);

    // 2. Wajib Alasan Jika Keluar
    if ($statusRaw === 'keluar' && empty($keterangan)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Alasan keluar wajib diisi!']);
    }

    $siswaModel = new SiswaModel();
    $siswa = $siswaModel->where('unique_code', $qr)->first();
    if (!$siswa) return $this->response->setJSON(['status' => 'error', 'message' => 'Siswa tidak ditemukan']);

    $izinModel = new IzinModel();
    // Cari status terakhir HARI INI
    $terakhir = $izinModel->where('id_siswa', $siswa['id_siswa'])
                          ->where('DATE(waktu)', date('Y-m-d'))
                          ->orderBy('waktu', 'DESC')
                          ->first();

    // 3. Logika Alur (Anti-Curang)
    if ($statusRaw === 'keluar') {
        if ($terakhir && $terakhir['jenis_izin'] === 'Keluar') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Siswa ini sudah keluar dan belum kembali!']);
        }
    } else { // Status Kembali
        if (!$terakhir || $terakhir['jenis_izin'] === 'Kembali') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Siswa ini belum tercatat keluar hari ini']);
        }
    }

    // 4. Eksekusi Simpan
    $dataSave = [
        'id_siswa'   => $siswa['id_siswa'],
        'jenis_izin' => ($statusRaw === 'keluar' ? 'Keluar' : 'Kembali'),
        'keterangan' => $keterangan ?: '-',
        'waktu'      => date('Y-m-d H:i:s')
    ];

    if ($izinModel->insert($dataSave)) {
        return $this->response->setJSON([
            'status'  => 'success', 
            'message' => $siswa['nama_siswa'] . " berhasil tercatat " . $dataSave['jenis_izin']
        ]);
    }
}

}
