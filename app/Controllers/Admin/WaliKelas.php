<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WaliKelasModel;

class WaliKelas extends BaseController
{
    protected $userModel;
    protected $waliModel; // Menggunakan w kecil

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->waliModel = new WaliKelasModel();
    }

    public function index()
    {
        return view('admin/walikelas/index', [
            // Hanya ambil user dengan role 'wali'
            'guru' => $this->userModel->where('role', 'wali')->findAll(),

            // Ambil data wali kelas beserta nama gurunya
            'wali' => $this->waliModel
                ->select('wali_kelas.*, users.nama')
                ->join('users', 'users.id = wali_kelas.user_id')
                ->findAll()
        ]);
    }

    public function store()
    {
        // Gunakan $this->waliModel (w kecil) sesuai deklarasi di atas
        $this->waliModel->insert([
            'user_id' => $this->request->getPost('user_id'),
            'kelas'   => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan')
        ]);
        return redirect()->back()->with('success', 'Wali kelas berhasil ditugaskan.');
    }

    public function update($id)
    {
        $this->waliModel->update($id, [
            'user_id' => $this->request->getPost('user_id'),
            'kelas'   => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan')
        ]);
        return redirect()->back()->with('success', 'Data penugasan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->waliModel->delete($id);
        return redirect()->back()->with('success', 'Data penugasan berhasil dihapus.');
    }
}