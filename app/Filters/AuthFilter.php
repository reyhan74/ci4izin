<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $roles = null)
    {
        $session = session();

        // belum login
        if (!$session->get('login')) {
            return redirect()->to('/login');
        }

        // cek role jika ada
        if ($roles) {
            $userRole = $session->get('role');

            if (!in_array($userRole, $roles)) {
                return redirect()->to('/login')->with('error', 'Akses ditolak');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu apa-apa
    }
}