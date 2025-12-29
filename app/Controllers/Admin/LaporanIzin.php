<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IzinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanIzin extends BaseController
{
    public function index()
    {
        $izinModel = new IzinModel();

        // Ambil data filter dari URL
        $tanggal = $this->request->getGet('tanggal');
        $nama    = $this->request->getGet('nama');
        $kelas   = $this->request->getGet('kelas');
        $jurusan = $this->request->getGet('jurusan');

        // Query dengan Join ke tabel siswa
        $builder = $izinModel->select('izin.*, siswa.nama, siswa.nis, siswa.kelas, siswa.jurusan')
                             ->join('siswa', 'siswa.id = izin.siswa_id');

        // Terapkan Filter jika ada input
        if (!empty($tanggal)) {
            $builder->where('DATE(izin.waktu)', $tanggal);
        }
        if (!empty($nama)) {
            $builder->groupStart()
                    ->like('siswa.nama', $nama)
                    ->orLike('siswa.nis', $nama)
                    ->groupEnd();
        }
        if (!empty($kelas)) {
            $builder->where('siswa.kelas', $kelas);
        }
        if (!empty($jurusan)) {
            $builder->where('siswa.jurusan', $jurusan);
        }

        $data = [
            // Kirim balik data ke view agar filter tetap terisi (sticky form)
            'izin'           => $builder->orderBy('izin.waktu', 'DESC')->findAll(),
            'tanggal'        => $tanggal,
            'nama_search'    => $nama,
            'kelas_search'   => $kelas,
            'jurusan_search' => $jurusan
        ];

        // PASTI KAN FILE INI ADA DI: app/Views/admin/laporan_izin.php
        return view('admin/laporan_izin/index', $data);
    }

    public function exportExcel()
    {
        $izinModel = new IzinModel();
        
        // Ambil filter yang sama agar data yang didownload sesuai dengan yang difilter
        $tanggal = $this->request->getGet('tanggal');
        $nama    = $this->request->getGet('nama');
        $kelas   = $this->request->getGet('kelas');
        $jurusan = $this->request->getGet('jurusan');

        $builder = $izinModel->select('izin.*, siswa.nama, siswa.nis, siswa.kelas, siswa.jurusan')
                             ->join('siswa', 'siswa.id = izin.siswa_id');

        if ($tanggal) $builder->where('DATE(izin.waktu)', $tanggal);
        if ($nama)    $builder->like('siswa.nama', $nama)->orLike('siswa.nis', $nama);
        if ($kelas)   $builder->where('siswa.kelas', $kelas);
        if ($jurusan) $builder->where('siswa.jurusan', $jurusan);

        $dataIzin = $builder->orderBy('izin.waktu', 'DESC')->findAll();

        // Proses Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header Tabel
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NAMA SISWA');
        $sheet->setCellValue('C1', 'NIS');
        $sheet->setCellValue('D1', 'KELAS');
        $sheet->setCellValue('E1', 'JURUSAN');
        $sheet->setCellValue('F1', 'STATUS');
        $sheet->setCellValue('G1', 'KETERANGAN');
        $sheet->setCellValue('H1', 'WAKTU');

        // Isi Data
        $column = 2;
        foreach ($dataIzin as $key => $value) {
            $sheet->setCellValue('A' . $column, ($key + 1));
            $sheet->setCellValue('B' . $column, $value['nama']);
            $sheet->setCellValue('C' . $column, $value['nis']);
            $sheet->setCellValue('D' . $column, $value['kelas']);
            $sheet->setCellValue('E' . $column, $value['jurusan']);
            $sheet->setCellValue('F' . $column, strtoupper($value['status']));
            $sheet->setCellValue('G' . $column, $value['keterangan']);
            $sheet->setCellValue('H' . $column, $value['waktu']);
            $column++;
        }

        // Style header bold
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Izin_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}