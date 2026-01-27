<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table      = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = ['kelas', 'id_jurusan'];

    /**
     * Mengambil semua data kelas untuk dropdown filter
     */
    public function editKelas($id)
    {
        $kelas = $this->getKelas($id);
        if (!empty($kelas)) {
        $data = $this->inputValues();
        return $this->builder->where('id_kelas', $kelas->id_kelas)->update($data);
    }
    return false;
}
}