<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use CodeIgniter\Controller;


class SiswaDashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function auth()
    {
        if (!session()->get('id_siswa')) {
            redirect()->to('/login-siswa')->send();
            exit;
        }
    }

    private function buildQuery($id_siswa)
    {
        $mulai   = $this->request->getGet('mulai');
        $selesai = $this->request->getGet('selesai');
        $hari    = $this->request->getGet('hari');

        $builder = $this->db->table('tb_izin_siswa')
            ->where('id_siswa', $id_siswa);

        if ($mulai && $selesai) {
            $builder->where('DATE(waktu) >=', $mulai)
                    ->where('DATE(waktu) <=', $selesai);
        }

        if ($hari) {
            $builder->where('DAYNAME(waktu)', $hari);
        }

        return $builder;
    }

    public function index()
    {
        $this->auth();
        $id_siswa = session()->get('id_siswa');

        $builder = $this->buildQuery($id_siswa);

        $data['histori'] = $builder
            ->orderBy('waktu', 'DESC')
            ->get()->getResultArray();

        $data['izin_terakhir'] = $this->db->table('tb_izin_siswa')
            ->where('id_siswa', $id_siswa)
            ->orderBy('waktu', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        $data['nama_siswa'] = session()->get('nama_siswa');

        return view('siswa/dashboard', $data);
    }

    public function exportExcel()
    {
        $this->auth();
        $id_siswa = session()->get('id_siswa');

        $data = $this->buildQuery($id_siswa)
            ->orderBy('waktu', 'ASC')
            ->get()->getResultArray();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=riwayat_izin_siswa.xls");

        echo "Waktu\tJenis Izin\tKeterangan\n";
        foreach ($data as $d) {
            echo "{$d['waktu']}\t{$d['jenis_izin']}\t{$d['keterangan']}\n";
        }
        exit;
    }

    public function exportPdf()
    {
        $this->auth();
        $id_siswa = session()->get('id_siswa');

        $data['histori'] = $this->buildQuery($id_siswa)
            ->orderBy('waktu', 'ASC')
            ->get()->getResultArray();

        $html = view('siswa/izin_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('riwayat_izin_siswa.pdf', ['Attachment' => true]);
    }
}
