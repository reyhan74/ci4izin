<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        // Pastikan Model UserModel mengarah ke tabel 'userizin'
        $this->user = new UserModel();
    }

    public function index()
    {
        return view('admin/user/index', [
            'title' => 'Daftar Pengguna',
            'users' => $this->user->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/user/create', [
            'title' => 'Tambah User Baru',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        // Validasi input sesuai kolom di database
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[userizin.email]',
            'password' => 'required|min_length[5]',
            'role'     => 'required|in_list[admin,guru,wali]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->user->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'), // 'admin', 'guru', atau 'wali'
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userData = $this->user->find($id);
        
        if (!$userData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User dengan ID $id tidak ditemukan");
        }

        return view('admin/user/edit', [
            'title'      => 'Edit User',
            'user'       => $userData,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        // Cek email unik kecuali untuk email milik user ini sendiri
        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[userizin.email,id,$id]",
            'role'  => 'required|in_list[admin,guru,wali]',
        ];

        // Password opsional saat update
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[5]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'id'    => $id,
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        // Hanya update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->user->save($data);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->user->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
    }
}