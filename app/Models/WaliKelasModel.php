<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliKelasModel extends Model
{
    protected $table            = 'wali_kelas';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'user_id',
        'id_kelas'
    ];

    protected $useTimestamps = true;

    /**
     * Ambil data wali kelas lengkap (guru + kelas + jurusan)
     */
    public function getWaliKelasLengkap()
    {
        return $this->db->table($this->table)
            ->select('wali_kelas.id,
                      userizin.username,
                      tb_kelas.kelas,
                      tb_jurusan.nama_jurusan AS jurusan')
            ->join('userizin', 'userizin.id = wali_kelas.user_id')
            ->join('tb_kelas', 'tb_kelas.id_kelas = wali_kelas.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id_jurusan = tb_kelas.id_jurusan')
            ->get()
            ->getResultArray();
    }
}
