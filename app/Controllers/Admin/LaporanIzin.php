<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IzinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanIzin extends BaseController
{
        public function index()
    {
        $izinModel = new IzinModel();
        
        $tgl_awal  = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $data = [
            'title'     => 'Laporan Keluar Masuk Siswa 2025',
            'riwayat'   => $izinModel->getLaporanFull($tgl_awal, $tgl_akhir),
            'tgl_awal'  => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ];

        return view('admin/laporan/index', $data);
    }

    public function exportExcel()
    {
        $izinModel = new IzinModel();
        $tgl_awal  = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $dataIzin = $izinModel->getLaporanFull($tgl_awal, $tgl_akhir);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- STYLING HEADER ---
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        // Judul Laporan di Baris 1
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'REKAPITULASI IZIN KELUAR MASUK SISWA - SMK CB');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header Tabel di Baris 3
        $headers = ['No', 'Tanggal/Waktu', 'NIS', 'Nama Siswa', 'Kelas & Jurusan', 'Jenis Izin', 'Keterangan'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        
        foreach ($headers as $index => $title) {
            $sheet->setCellValue($cols[$index] . '3', $title);
        }
        $sheet->getStyle('A3:G3')->applyFromArray($styleHeader);

        // --- ISI DATA ---
        $row = 4;
        foreach ($dataIzin as $key => $value) {
            $sheet->setCellValue('A' . $row, ($key + 1));
            $sheet->setCellValue('B' . $row, date('d/m/Y H:i', strtotime($value['waktu'])));
            $sheet->setCellValue('C' . $row, $value['nis']);
            $sheet->setCellValue('D' . $row, $value['nama_siswa']);
            $sheet->setCellValue('E' . $row, $value['kelas'] . ' - ' . $value['jurusan']);
            $sheet->setCellValue('F' . $row, $value['jenis_izin']);
            $sheet->setCellValue('G' . $row, $value['keterangan']);

            // Beri border pada setiap baris
            $sheet->getStyle('A' . $row . ':G' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            
            // Tengahkan teks tertentu
            $sheet->getStyle('A' . $row . ':C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            $row++;
        }

        // Otomatis atur lebar kolom sesuai isi
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // --- OUTPUT ---
        $filename = 'Laporan_Siswa_' . date('Y-m-d_H-i') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}