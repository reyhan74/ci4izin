<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserIzinModel;
use App\Models\WaliKelasModel;
use App\Models\KelasModel;
use Config\Database;

class WaliKelas extends BaseController
{
    protected $userModel;
    protected $waliModel;
    protected $kelasModel;
    protected $db;

    public function __construct()
    {
        $this->userModel  = new UserIzinModel();
        $this->waliModel  = new WaliKelasModel();
        $this->kelasModel = new KelasModel();
        $this->db = Database::connect(); // ✅ wajib
    }

    public function index()
    {
        // Ambil guru
        $guru = $this->userModel
                    ->where('role', 'guru')
                    ->findAll();

        // Ambil wali kelas lengkap
        $wali = $this->db->table('wali_kelas')
            ->select('
                wali_kelas.id,
                userizin.nama,
                tb_kelas.kelas,
                tb_jurusan.nama_jurusan AS jurusan
            ')
            ->join('userizin', 'userizin.id = wali_kelas.user_id')
            ->join('tb_kelas', 'tb_kelas.id_kelas = wali_kelas.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id_jurusan = tb_kelas.id_jurusan')
            ->get()
            ->getResultArray();

        return view('admin/walikelas/index', [
            'guru' => $guru,
            'wali' => $wali,
        ]);
    }

    public function store()
    {
        $this->waliModel->insert([
            'user_id'  => $this->request->getPost('user_id'),
            'id_kelas' => $this->request->getPost('id_kelas'),
        ]);

        return redirect()->back()->with('success', 'Wali kelas berhasil ditambahkan');
    }

    public function delete($id)
    {
        $this->waliModel->delete($id);
        return redirect()->back()->with('success', 'Data wali kelas dihapus');
    }
}
