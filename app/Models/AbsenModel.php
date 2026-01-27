<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $table = 'tb_absen';
    protected $primaryKey = 'id_absen';
    protected $allowedFields = ['id_siswa', 'tanggal', 'status'];
    protected $useTimestamps = false;
}
