<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'tb_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $allowedFields    = ['nis', 'nama_siswa', 'id_kelas', 'jenis_kelamin', 'no_hp', 'unique_code', 'foto'];

    public function getSiswaFull()
    {
        return $this->db->table($this->table)
            ->select('tb_siswa.*, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->get()->getResultArray();
    }
}
