<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\JurusanModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $jurusanModel;

    public function __construct()
    {
        $this->kelasModel   = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    // ==============================
    // INDEX
    // ==============================
    public function index()
    {
        $kelas = $this->kelasModel
            ->select('tb_kelas.*, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->findAll();

        return view('admin/kelas/index', [
            'title' => 'Data Kelas',
            'kelas' => $kelas
        ]);
    }

    // ==============================
    // CREATE
    // ==============================
    public function create()
    {
        return view('admin/kelas/create', [
            'title'   => 'Tambah Kelas',
            'jurusan' => $this->jurusanModel->findAll()
        ]);
    }

    // ==============================
    // STORE
    // ==============================
    public function store()
    {
        $rules = [
            'kelas'      => 'required',
            'id_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->kelasModel->save([
            'kelas'      => $this->request->getPost('kelas'),
            'id_jurusan' => $this->request->getPost('id_jurusan')
        ]);

        return redirect()->to('/admin/kelas')
            ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    // ==============================
    // EDIT
    // ==============================
    public function edit($id)
    {
        return view('admin/kelas/edit', [
            'title'   => 'Edit Kelas',
            'kelas'   => $this->kelasModel->find($id),
            'jurusan' => $this->jurusanModel->findAll()
        ]);
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update($id)
    {
        $rules = [
            'kelas'      => 'required',
            'id_jurusan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->kelasModel->update($id, [
            'kelas'      => $this->request->getPost('kelas'),
            'id_jurusan' => $this->request->getPost('id_jurusan')
        ]);

        return redirect()->to('/admin/kelas')
            ->with('success', 'Data kelas berhasil diperbarui!');
    }

    // ==============================
    // DELETE
    // ==============================
    public function delete($id)
    {
        $this->kelasModel->delete($id);

        return redirect()->to('/admin/kelas')
            ->with('success', 'Data kelas berhasil dihapus!');
    }
}
