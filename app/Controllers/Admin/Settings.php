<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserizinModel;

class Settings extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserizinModel();
    }

    public function index()
    {
        if (!session()->get('id')) {
            return redirect()->to('/login');
        }

        return view('admin/settings', [
            'title' => 'Pengaturan Akun'
        ]);
    }

    public function updateProfile()
    {
        if (!session()->get('id')) {
            return redirect()->to('/login');
        }

        $id = session()->get('id');

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email')
        ];

        $this->userModel->update($id, $data);

        // Update session biar langsung berubah di UI
        session()->set($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword()
    {
        if (!session()->get('id')) {
            return redirect()->to('/login');
        }

        $id = session()->get('id');
        $password = $this->request->getPost('password');

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter');
        }

        $this->userModel->update($id, [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
