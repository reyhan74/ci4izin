<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        // Menginisialisasi koneksi database agar variabel $this->db tersedia di semua anak class
        $this->db = \Config\Database::connect();
    }
}