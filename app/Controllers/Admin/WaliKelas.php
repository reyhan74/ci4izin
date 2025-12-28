<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WaliKelasModel;


class WaliKelas extends BaseController
{
    protected $userModel;
    protected $waliModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->waliModel = new WaliKelasModel();
    }

    // LIST + FORM
    public function index()
    {
        return view('admin/walikelas/index', [
            // hanya user role wali
            'guru' => $this->userModel->where('role', 'wali')->findAll(),

            // data wali kelas
            'wali' => $this->waliModel
                ->select('wali_kelas.*, users.nama')
                ->join('users', 'users.id = wali_kelas.user_id')
                ->findAll()
        ]);
    }

    // SIMPAN PENETAPAN
    public function store()
    {
        $userId = $this->request->getPost('user_id');

        // pastikan user adalah wali
        $user = $this->userModel
            ->where('id', $userId)
            ->where('role', 'wali')
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User bukan wali kelas');
        }

        // cek apakah sudah punya kelas
        if ($this->waliModel->where('user_id', $userId)->first()) {
            return redirect()->back()->with('error', 'Guru ini sudah memiliki kelas');
        }

        $this->waliModel->insert([
            'user_id' => $userId,
            'kelas'   => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
        ]);

        return redirect()->back()->with('success', 'Wali kelas berhasil ditetapkan');
    }
}
