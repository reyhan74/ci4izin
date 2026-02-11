<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KelasModel;

use Dompdf\Dompdf;
use Dompdf\Options;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrSiswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
    }

    // ==========================================
    // 1. INDEX (FILTER JURUSAN + KELAS)
    // ==========================================
    public function index()
    {
        // 1. Ambil data kelas + jurusan untuk dropdown filter
        $kelas = $this->kelasModel
            ->select('tb_kelas.id_kelas, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->orderBy('tb_jurusan.jurusan', 'ASC')
            ->findAll();

        // 2. Ambil data siswa dengan Pagination (10 baris per halaman)
        // Gunakan paginate(jumlah_baris, grup_pager)
        $siswa = $this->siswaModel
            ->select('id_siswa, nama_siswa, unique_code, id_kelas')
            ->orderBy('nama_siswa', 'ASC')
            ->paginate(100, 'group1'); 

        // 3. Kirim ke view
        return view('admin/qr_siswa/index', [
            'title' => 'QR Code Siswa',
            'kelas' => $kelas,
            'siswa' => $siswa,
            'pager' => $this->siswaModel->pager // Wajib dikirim untuk menampilkan link halaman
        ]);
    }
    // ==========================================
    // 2. GENERATE SINGLE QR (AJAX)
    // ==========================================
    public function generateSingle()
    {
        $id = $this->request->getPost('id_siswa');

        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'ID siswa kosong!'
            ]);
        }

        $siswa = $this->siswaModel->find($id);

        if (!$siswa) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Siswa tidak ditemukan!'
            ]);
        }

        if (empty($siswa['unique_code'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Unique Code siswa kosong!'
            ]);
        }

        $uniqueCode = (string) $siswa['unique_code'];

        // Folder QR
        $folder = FCPATH . "uploads/qrcode/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $fileName = "qr_" . $uniqueCode . ".png";
        $filePath = $folder . $fileName;

        // Generate jika belum ada
        if (!file_exists($filePath)) {

            $qrCode = new QrCode($uniqueCode);

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $result->saveToFile($filePath);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'msg' => 'QR berhasil dibuat!',
            'file' => base_url("uploads/qrcode/" . $fileName)
        ]);
    }

    // ==========================================
    // 3. CETAK HTML SESUAI FILTER
    // ==========================================
    // public function cetak()
    // {
    //     $filter = $this->request->getGet('filter_kelas');

    //     $query = $this->siswaModel
    //         ->select('tb_siswa.*, tb_kelas.kelas')
    //         ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas');

    //     if ($filter && $filter !== "all") {
    //         $query->where('tb_siswa.id_kelas', $filter);
    //     }

    //     $siswa = $query->orderBy('tb_siswa.nama_siswa', 'ASC')->findAll();

    //     return view("admin/qr_siswa/cetak", [
    //         'title' => 'Cetak QR Siswa',
    //         'siswa' => $siswa
    //     ]);
    // }

    // Di dalam Controller QrSiswa.php
    public function cetak()
    {
        $idKelas = $this->request->getGet('filter_kelas');

        $siswa = $this->siswaModel
            ->select('tb_siswa.*, tb_kelas.kelas, tb_jurusan.jurusan') // Memilih kolom jurusan
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->where('tb_siswa.id_kelas', $idKelas)
            ->orderBy('tb_siswa.nama_siswa', 'ASC')
            ->findAll();

        return view('admin/qr_siswa/cetak', [
            'title' => 'Cetak QR Siswa',
            'siswa' => $siswa
        ]);
    }

    // ==========================================
    // 4. DOWNLOAD PDF SESUAI FILTER
    // ==========================================
    public function downloadPdf()
    {
        $filter = $this->request->getGet('filter_kelas');

        $query = $this->siswaModel
            ->select('tb_siswa.*, tb_kelas.kelas')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas');

        if ($filter && $filter !== "all") {
            $query->where('tb_siswa.id_kelas', $filter);
        }

        $siswa = $query->orderBy('tb_siswa.nama_siswa', 'ASC')->findAll();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa kosong!');
        }

        // View PDF
        $html = view("admin/qr_siswa/pdf", [
            'siswa' => $siswa
        ]);

        // Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4", "portrait");
        $dompdf->render();

        return $this->response
            ->setHeader("Content-Type", "application/pdf")
            ->setHeader("Content-Disposition", "attachment; filename=qr_siswa.pdf")
            ->setBody($dompdf->output());
    }
}
