<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class LoginSiswa extends BaseController
{
    public function index()
    {
        return view('auth/login_qrcode');
    }

    public function cekLogin()
    {
        $siswaModel = new SiswaModel();
        $code = $this->request->getPost('qr_code');

        // Cari siswa berdasarkan unique_code yang ada di foto DB Anda
        $siswa = $siswaModel->where('unique_code', $code)->first();

        if ($siswa) {
            session()->set([
                'isLoggedInSiswa' => true,
                'id_siswa'        => $siswa['id_siswa'],
                'nama_siswa'      => $siswa['nama_siswa'],
                'role'            => 'siswa'
            ]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Login Berhasil!']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'QR Code tidak terdaftar!']);
    }

    public function logout()
    {
        // Hapus semua data session
        session()->destroy();

        // Atau jika ingin spesifik menghapus session siswa saja:
        // session()->remove(['id_siswa', 'nama_siswa', 'is_login_siswa']);

        // Redirect ke halaman utama (halaman scan QR)
        return redirect()->to(site_url('/'))->with('success', 'Anda telah berhasil keluar.');
    }
}