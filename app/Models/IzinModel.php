<?php

namespace App\Models;

use CodeIgniter\Model;

class IzinModel extends Model
{
    protected $table = 'izin';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'siswa_id',
        'status',
        'keterangan',
        'waktu'
    ];

    public function getLaporan($tanggal = null)
    {
        $builder = $this->db->table('izin')
            ->select('izin.*, siswa.nis, siswa.nama, siswa.kelas, siswa.jurusan')
            ->join('siswa', 'siswa.id = izin.siswa_id', 'left')
            ->orderBy('izin.waktu', 'DESC');

        if ($tanggal) {
            $builder->where('DATE(izin.waktu)', $tanggal);
        }

        return $builder->get()->getResultArray();
    }
}
