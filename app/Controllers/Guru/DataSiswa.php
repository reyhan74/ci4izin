<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JurusanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataSiswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;
    protected $jurusanModel;

    // Rule validasi dasar (disesuaikan dengan nama input di form)
    protected $siswaValidationRules = [
        'nis'     => 'required|min_length[4]|max_length[20]',
        'nama'    => 'required|min_length[3]',
        'id_kelas' => 'required',
        'jk'      => 'required',
        'no_hp'   => 'required|numeric|min_length[5]'
    ];

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        helper(['form', 'url', 'text']); // Tambah helper text untuk random_string
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Siswa',
            'ctx'     => 'siswa',
            'kelas'   => $this->kelasModel->findAll(),
            'jurusan' => $this->jurusanModel->findAll()
        ];

        return view('guru/data/data-siswa', $data);
    }

    public function formTambahSiswa()
    {
        $data = [
            'title' => 'Tambah Data Siswa',
            'ctx'   => 'siswa',
            'kelas' => $this->kelasModel->findAll(),
        ];

        return view('guru/data/create/create-data-siswa', $data);
    }

    public function saveSiswa()
    {
        // 1. Tambah validasi khusus NIS unique & Foto
        $rules = $this->siswaValidationRules;
        $rules['nis'] .= '|is_unique[tb_siswa.nis]';
        $rules['foto'] = 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]';

        if (!$this->validate($rules)) {
            return view('guru/data/create/create-data-siswa', [
                'title'      => 'Tambah Data Siswa',
                'ctx'        => 'siswa',
                'kelas'      => $this->kelasModel->findAll(),
                'validation' => $this->validator
            ]);
        }

        // 2. Handle Upload Foto
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/foto-siswa/', $namaFoto);

        // 3. Simpan ke Database
        $this->siswaModel->insert([
            'nis'           => $this->request->getPost('nis'),
            'nama_siswa'    => $this->request->getPost('nama'),    // Mapping ke DB
            'id_kelas'      => $this->request->getPost('id_kelas'),
            'jenis_kelamin' => $this->request->getPost('jk'),      // Mapping ke DB
            'no_hp'         => $this->request->getPost('no_hp'),
            'unique_code'   => random_string('alnum', 32),        // Generate unik
            'foto'          => $namaFoto
        ]);

        session()->setFlashdata('msg', 'Data siswa berhasil ditambahkan');
        return redirect()->to('/guru/siswa');
    }

    public function formEditSiswa($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) throw new PageNotFoundException("Siswa ID $id tidak ditemukan");

        $data = [
            'title' => 'Edit Data Siswa',
            'ctx'   => 'siswa',
            'data'  => $siswa,
            'kelas' => $this->kelasModel->findAll()
        ];

        return view('guru/data/edit/edit-data-siswa', $data);
    }

    public function updateSiswa()
    {
        $idSiswa = $this->request->getPost('id'); // ID dari input hidden
        $siswaLama = $this->siswaModel->find($idSiswa);

        // 1. Validasi NIS jika berubah
        $rules = $this->siswaValidationRules;
        if ($siswaLama['nis'] != $this->request->getPost('nis')) {
            $rules['nis'] .= '|is_unique[tb_siswa.nis]';
        }
        $rules['foto'] = 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]';

        if (!$this->validate($rules)) {
            return view('guru/data/edit/edit-data-siswa', [
                'title'      => 'Edit Data Siswa',
                'ctx'        => 'siswa',
                'data'       => $siswaLama,
                'kelas'      => $this->kelasModel->findAll(),
                'validation' => $this->validator
            ]);
        }

        // 2. Handle Foto Baru
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $siswaLama['foto'];

        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/foto-siswa/', $namaFoto);
            
            // Hapus foto lama
            if ($siswaLama['foto'] && file_exists('uploads/foto-siswa/' . $siswaLama['foto'])) {
                unlink('uploads/foto-siswa/' . $siswaLama['foto']);
            }
        }

        // 3. Update DB
        $this->siswaModel->update($idSiswa, [
            'nis'           => $this->request->getPost('nis'),
            'nama_siswa'    => $this->request->getPost('nama'),
            'id_kelas'      => $this->request->getPost('id_kelas'),
            'jenis_kelamin' => $this->request->getPost('jk'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'foto'          => $namaFoto
        ]);

        session()->setFlashdata('msg', 'Data siswa berhasil diperbarui');
        return redirect()->to('/guru/siswa');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if ($siswa) {
            // Hapus file foto
            if ($siswa['foto'] && file_exists('uploads/foto-siswa/' . $siswa['foto'])) {
                unlink('uploads/foto-siswa/' . $siswa['foto']);
            }
            $this->siswaModel->delete($id);
            session()->setFlashdata('msg', 'Data berhasil dihapus');
        }
        return redirect()->to('/guru/siswa');
    }
}