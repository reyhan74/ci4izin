<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        return view('admin/user/index', [
            'users' => $this->user->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/user/create');
    }

    public function store()
    {
        $this->user->save([
            'nama'     => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success','User berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/user/edit', [
            'user' => $this->user->find($id)
        ]);
    }

    public function update($id)
    {
        $data = [
            'id'       => $id,
            'nama'     => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->user->save($data);

        return redirect()->to('/admin/users')->with('success','User diperbarui');
    }

    public function delete($id)
    {
        $this->user->delete($id);
        return redirect()->to('/admin/users');
    }
}