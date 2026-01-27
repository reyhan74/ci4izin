<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuru implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // belum login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // login tapi bukan guru
        if (session()->get('role') !== 'guru') {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
