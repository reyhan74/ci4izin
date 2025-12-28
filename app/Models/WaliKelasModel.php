<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliKelasModel extends Model
{
    protected $table = 'wali_kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'kelas', 'jurusan'];
}
