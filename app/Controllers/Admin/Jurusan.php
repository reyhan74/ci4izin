<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Jurusan',
            'jurusan' => $this->jurusanModel->findAll()
        ];

        return view('admin/jurusan/index', $data);
    }

    public function create()
    {
        return view('admin/jurusan/create', [
            'title' => 'Tambah Jurusan'
        ]);
    }

    public function store()
    {
        $this->jurusanModel->save([
            'jurusan' => $this->request->getPost('jurusan')
        ]);

        return redirect()->to('/admin/jurusan')->with('success', 'Jurusan berhasil ditambah');
    }

    public function edit($id)
    {
        return view('admin/jurusan/edit', [
            'title'   => 'Edit Jurusan',
            'jurusan' => $this->jurusanModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->jurusanModel->update($id, [
            'jurusan' => $this->request->getPost('jurusan')
        ]);

        return redirect()->to('/admin/jurusan')->with('success', 'Jurusan berhasil diupdate');
    }

    public function delete($id)
    {
        $this->jurusanModel->delete($id);

        return redirect()->to('/admin/jurusan')->with('success', 'Jurusan berhasil dihapus');
    }
}
