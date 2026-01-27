<?php

namespace App\Controllers;

use App\Models\UserizinModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/' . session()->get('role') . '/dashboard');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserizinModel();
        $user  = $model->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'id'        => $user['id'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        // Redirect sesuai role yang tersedia
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if ($user['role'] === 'wali') {
            return redirect()->to('/wali/dashboard');
        }

        if ($user['role'] === 'guru') {
            return redirect()->to('/guru/dashboard');
        }

        // fallback
        return redirect()->to('/login')->with('error', 'Role tidak dikenali');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
