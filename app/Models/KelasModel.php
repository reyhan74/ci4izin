<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table      = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = ['kelas', 'id_jurusan'];

    /**
     * FUNGSI BARU: Mengambil data kelas + jurusan untuk filter QR
     */
    public function getDataKelas()
    {
        return $this->db->table($this->table)
            ->select('tb_kelas.id_kelas, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->orderBy('tb_kelas.kelas', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function editKelas($id)
    {
        // ... kode editKelas Anda yang sudah ada ...
    }
}