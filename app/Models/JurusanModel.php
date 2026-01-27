<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table      = 'tb_jurusan';
    protected $primaryKey = 'id'; // Pastikan sesuai nama kolom di database Anda
    protected $allowedFields = ['jurusan'];

    /**
     * Mengambil semua data jurusan untuk dropdown filter
     */
    public function getDataJurusan()
    {
        return $this->findAll();
    }
}