<?php

namespace App\Models;

use CodeIgniter\Model;

class IzinModel extends Model
{
    // Sesuaikan dengan nama tabel di database Anda
    protected $table      = 'tb_izin_siswa'; 
    protected $primaryKey = 'id_izin';

    protected $allowedFields = [
        'id_siswa',
        'jenis_izin',
        'waktu',
        'keterangan',
        'status'
    ];

    // Mengambil data izin lengkap dengan JOIN ke tabel siswa, kelas, dan jurusan
    public function getLaporanFull($tgl_awal = null, $tgl_akhir = null)
    {
        $builder = $this->db->table($this->table)
            ->select('tb_izin_siswa.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_siswa', 'tb_siswa.id_siswa = tb_izin_siswa.id_siswa')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan');

        // Filter berdasarkan tanggal (asumsi kolom 'waktu' berisi datetime/timestamp)
        if ($tgl_awal && $tgl_akhir) {
            $builder->where("DATE(tb_izin_siswa.waktu) >=", $tgl_awal);
            $builder->where("DATE(tb_izin_siswa.waktu) <=", $tgl_akhir);
        }

        return $builder->orderBy('tb_izin_siswa.waktu', 'DESC')->get()->getResultArray();
    }
}
