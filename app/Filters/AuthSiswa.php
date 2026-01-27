<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthSiswa implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika session id_siswa tidak ada, tendang kembali ke halaman login QR
        if (!session()->get('id_siswa')) {
            return redirect()->to('/login-siswa')->with('error', 'Silakan scan QR Code terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan untuk saat ini
    }
}