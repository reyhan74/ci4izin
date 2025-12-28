<?php

namespace App\Controllers;

class Guru extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('login') || session()->get('role') !== 'guru') {
            return redirect()->to('/login');
        }

        return view('guru/dashboard');
    }
}