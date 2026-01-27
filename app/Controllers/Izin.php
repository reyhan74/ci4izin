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
        // 🔒 Wajib AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Request tidak valid'
            ]);
        }

        // Ambil input
        $qr         = trim($this->request->getPost('qr_code'));
        $statusRaw  = $this->request->getPost('status'); // keluar / kembali
        $keterangan = trim($this->request->getPost('keterangan'));

        // Validasi dasar
        if (!$qr || !$statusRaw || !$keterangan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
        }

        // Cari siswa
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('unique_code', $qr)->first();

        if (!$siswa) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'QR Code tidak terdaftar'
            ]);
        }

        $izinModel = new IzinModel();

        // 🔍 Ambil izin terakhir siswa HARI INI
        $izinTerakhir = $izinModel
            ->where('id_siswa', $siswa['id_siswa'])
            ->where('DATE(waktu)', date('Y-m-d'))
            ->orderBy('waktu', 'DESC')
            ->first();

        // ==========================
        // 🔒 LOGIKA KUNCI IZIN
        // ==========================

        // ❌ KEMBALI tapi belum pernah KELUAR
        if ($statusRaw === 'kembali') {
            if (!$izinTerakhir || $izinTerakhir['jenis_izin'] !== 'Keluar') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak bisa kembali karena siswa belum keluar'
                ]);
            }
        }

        // ❌ KELUAR dua kali berturut-turut
        if ($statusRaw === 'keluar') {
            if ($izinTerakhir && $izinTerakhir['jenis_izin'] === 'Keluar') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Siswa belum kembali, tidak bisa keluar lagi'
                ]);
            }
        }

        // Mapping ke database
        $jenisIzin = ($statusRaw === 'kembali') ? 'Kembali' : 'Keluar';

        // Data simpan
        $data = [
            'id_siswa'   => $siswa['id_siswa'],
            'jenis_izin' => $jenisIzin,
            'keterangan' => $keterangan,
            'waktu'      => date('Y-m-d H:i:s')
        ];

        // Simpan
        if ($izinModel->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $siswa['nama_siswa'] . " berhasil dicatat ($jenisIzin)"
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menyimpan data'
        ]);
    }
}
