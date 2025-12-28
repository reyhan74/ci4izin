<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attempt()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = (new UserModel())
            ->where('email', $email)
            ->first();

        // validasi user
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Email atau password salah');
        }

        // set session
        session()->set([
            'login'   => true,
            'user_id' => $user['id'],
            'nama'    => $user['nama'],
            'role'    => $user['role']
        ]);

        // redirect berdasarkan role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if ($user['role'] === 'wali') {
            return redirect()->to('/wali/dashboard');
        }
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}