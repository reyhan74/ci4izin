<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Siswa extends BaseController
{
    protected $siswa;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
    }

    public function index()
    {
        return view('admin/siswa/index', [
            'title' => 'Data Siswa',
            'siswa' => $this->siswa->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/siswa/create', ['title' => 'Tambah Siswa']);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (!$data['nis']) {
            return redirect()->back()->with('error', 'NIS wajib diisi');
        }

        $qrFile = $this->generateQrCode($data['nis']);

        $this->siswa->insert([
            'nis'        => $data['nis'],
            'nama'       => $data['nama'],
            'kelas'      => $data['kelas'],
            'jurusan'    => $data['jurusan'],
            'qr_code'    => $qrFile,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Siswa berhasil ditambahkan');
    }

    // Fungsi Private agar tidak duplikasi kode generate QR
    private function generateQrCode($nis)
    {
        $qrFile = $nis . '.png';
        $path   = FCPATH . 'uploads/qr/';
        
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($nis);
        
        // Simpan file ke server
        $content = @file_get_contents($qrUrl);
        if($content) {
            file_put_contents($path . $qrFile, $content);
        }
        
        return $qrFile;
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file->getTempName());
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $count = 0;
        foreach ($sheetData as $i => $row) {
            if ($i == 0 || empty($row[0])) continue; 

            $nis = $row[0];
            
            // Gunakan $this->siswa (sesuai properti di constructor)
            if (!$this->siswa->where('nis', $nis)->first()) {
                
                // GENERATE QR SAAT IMPORT
                $qrFile = $this->generateQrCode($nis);

                $this->siswa->save([
                    'nis'     => $nis,
                    'nama'    => $row[1],
                    'kelas'   => $row[2],
                    'jurusan' => $row[3],
                    'qr_code' => $qrFile
                ]);
                $count++;
            }
        }

        return redirect()->to('/admin/siswa')->with('success', $count . ' Siswa berhasil di-import & QR Code digenerate.');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'KELAS');
        $sheet->setCellValue('D1', 'JURUSAN');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_import_siswa.xlsx"');
        $writer->save('php://output');
        exit;
    }

    public function edit($id)
    {
        return view('admin/siswa/edit', [
            'title' => 'Edit Siswa',
            'siswa' => $this->siswa->find($id)
        ]);
    }

    public function update($id)
    {
        $this->siswa->update($id, [
            'nis'     => $this->request->getPost('nis'),
            'nama'    => $this->request->getPost('nama'),
            'kelas'   => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil diupdate');
    }

    public function delete($id)
    {
        $data = $this->siswa->find($id);
        if ($data) {
            // Hapus file QR fisiknya juga agar storage tidak penuh
            if (file_exists(FCPATH . 'uploads/qr/' . $data['qr_code'])) {
                unlink(FCPATH . 'uploads/qr/' . $data['qr_code']);
            }
            $this->siswa->delete($id);
        }

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil dihapus');
    }
}