<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Siswa extends BaseController
{
    protected $helpers = ['form', 'url'];
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $id_kelas = $this->request->getVar('filter_kelas');
        $id_jurusan = $this->request->getVar('filter_jurusan');

        $db = \Config\Database::connect();
        $data_kelas = $db->table('tb_kelas')->get()->getResultArray();
        $data_jurusan = $db->table('tb_jurusan')->get()->getResultArray();

        $query = $this->siswaModel->select('tb_siswa.*, tb_kelas.kelas, tb_jurusan.jurusan')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
                    ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan');

        if ($id_kelas) $query->where('tb_siswa.id_kelas', $id_kelas);
        if ($id_jurusan) $query->where('tb_kelas.id_jurusan', $id_jurusan);

        $data = [
            'title'          => 'Daftar Siswa',
            'siswa'          => $query->findAll(),
            'data_kelas'     => $data_kelas,
            'data_jurusan'   => $data_jurusan,
            'filter_kelas'   => $id_kelas,
            'filter_jurusan' => $id_jurusan
        ];

        return view('admin/siswa/index', $data);
    }

    public function downloadTemplate()
    {
        $db = \Config\Database::connect();
        
        // Ambil data kelas lengkap dengan nama jurusannya untuk referensi
        $data_referensi = $db->table('tb_kelas')
            ->select('tb_kelas.id_kelas, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- HEADER TABEL UTAMA (Data yang akan di-import) ---
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'NAMA_SISWA');
        $sheet->setCellValue('C1', 'JENIS_KELAMIN');
        $sheet->setCellValue('D1', 'ID_KELAS');
        $sheet->setCellValue('E1', 'NO_HP');

        // Kolom F dikosongkan (Spacer)

        // --- HEADER DAFTAR REFERENSI (Hanya panduan pengisian) ---
        $sheet->setCellValue('G1', 'PANDUAN ID KELAS');
        $sheet->setCellValue('H1', 'NAMA KELAS');
        $sheet->setCellValue('I1', 'JURUSAN');

        // Styling Header Utama (A-E)
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9EAD3');

        // Styling Header Panduan (G-I) - Warna berbeda agar tidak tertukar
        $sheet->getStyle('G1:I1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('G1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF4E73DF');

        // --- CONTOH DATA ISI (Baris 2) ---
        $sheet->setCellValue('A2', '12345');
        $sheet->setCellValue('B2', 'Nama Contoh');
        $sheet->setCellValue('C2', 'L');
        $sheet->setCellValue('D2', '1'); 
        $sheet->setCellValue('E2', '08123456789');

        // --- MEMASUKKAN DAFTAR REFERENSI KE KOLOM G, H, I ---
        $rowRef = 2;
        foreach ($data_referensi as $ref) {
            $sheet->setCellValue('G' . $rowRef, $ref['id_kelas']);
            $sheet->setCellValue('H' . $rowRef, $ref['kelas']);
            $sheet->setCellValue('I' . $rowRef, $ref['jurusan']);
            $rowRef++;
        }

        // Auto size kolom agar rapi dan teks tidak terpotong
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Memberi border pada area referensi agar terlihat seperti tabel bantuan
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('G1:I' . ($rowRef - 1))->applyFromArray($styleArray);

        // Proses download
        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Siswa_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $rules = [
            'file_excel' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]|max_size[file_excel,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Format file salah (harus .xls/.xlsx) atau ukuran terlalu besar.');
        }

        try {
            $extension = $file->getClientExtension();
            $reader = ($extension == 'xlsx') ? new \PhpOffice\PhpSpreadsheet\Reader\Xlsx() : new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            
            $spreadsheet = $reader->load($file->getTempName());
            $dataExcel = $spreadsheet->getActiveSheet()->toArray();

            $db = \Config\Database::connect();
            $successCount = 0;
            $skipCount = 0;
            $errorLog = [];

            foreach ($dataExcel as $key => $row) {
                // Skip header (baris 0) dan pastikan kolom NIS & ID_KELAS tidak kosong
                if ($key == 0 || empty($row[0])) continue;

                $nis      = trim($row[0]);
                $nama     = trim($row[1]);
                $jk       = strtoupper(trim($row[2]));
                $id_kelas = trim($row[3]);
                $no_hp    = trim($row[4]);

                // 1. Cek duplikasi NIS
                if ($this->siswaModel->where('nis', $nis)->first()) {
                    $skipCount++;
                    continue; 
                }

                // 2. VALIDASI FOREIGN KEY: Cek apakah ID Kelas benar-benar ada di database
                $kelas = $db->table('tb_kelas')->where('id_kelas', $id_kelas)->get()->getRow();
                
                if (!$kelas) {
                    $errorLog[] = "Baris $key: ID Kelas ($id_kelas) tidak ditemukan di database.";
                    $skipCount++;
                    continue;
                }

                // 3. Simpan data jika valid
                $this->siswaModel->save([
                    'nis'           => $nis,
                    'nama_siswa'    => $nama,
                    'jenis_kelamin' => ($jk == 'L' ? 'Laki-laki' : 'Perempuan'),
                    'id_kelas'      => $id_kelas,
                    'no_hp'         => $no_hp,
                    'foto'          => 'default.png',
                    'unique_code'   => bin2hex(random_bytes(8))
                ]);
                
                $successCount++;
            }

            $msg = "$successCount data berhasil diimpor.";
            if ($skipCount > 0) $msg .= " $skipCount data dilewati (Duplikat atau ID Kelas salah).";
            
            if (!empty($errorLog)) {
                // Tampilkan pesan error spesifik jika ada ID Kelas yang salah
                return redirect()->to('/admin/siswa')->with('success', $msg)->with('error', implode('<br>', $errorLog));
            }

            return redirect()->to('/admin/siswa')->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $kelas = $db->table('tb_kelas')
            ->select('tb_kelas.*, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->get()->getResultArray();

        $data = [
            'title' => 'Tambah Siswa Baru',
            'kelas' => $kelas,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/siswa/create', $data);
    }

    public function saveSiswa()
    {
        $rules = [
            'nis'      => 'required|is_unique[tb_siswa.nis]',
            'nama'     => 'required',
            'id_kelas' => 'required',
            'jk'       => 'required',
            'foto'     => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $jk_input = $this->request->getVar('jk');
        $jenis_kelamin = ($jk_input == 'L') ? 'Laki-laki' : 'Perempuan';

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/foto-siswa', $namaFoto);

        $this->siswaModel->save([
            'nis'           => $this->request->getVar('nis'),
            'nama_siswa'    => $this->request->getVar('nama'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'jenis_kelamin' => $jenis_kelamin,
            'no_hp'         => $this->request->getVar('no_hp'),
            'foto'          => $namaFoto,
            'unique_code'   => bin2hex(random_bytes(8))
        ]);

        session()->setFlashdata('success', 'Data siswa berhasil disimpan!');
        return redirect()->to('/admin/siswa');
    }

    public function show($id)
    {
        $siswa = $this->siswaModel->select('tb_siswa.*, tb_kelas.kelas, tb_jurusan.jurusan')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->where('tb_siswa.id_siswa', $id)
            ->first();

        if (!$siswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Siswa dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title' => 'Profil Detail Siswa',
            'siswa' => $siswa
        ];

        return view('admin/siswa/show', $data);
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa) {
            return redirect()->to('/admin/siswa')->with('error', 'Data tidak ditemukan.');
        }

        $kelas = $db->table('tb_kelas')
            ->select('tb_kelas.*, tb_jurusan.jurusan')
            ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan')
            ->get()->getResultArray();

        $data = [
            'title' => 'Edit Data Siswa',
            'siswa' => $siswa,
            'kelas' => $kelas
        ];

        return view('admin/siswa/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nis'      => "required|is_unique[tb_siswa.nis,id_siswa,$id]",
            'nama'     => 'required|min_length[3]',
            'id_kelas' => 'required',
            'jk'       => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $jk_input = $this->request->getVar('jk');
        $jenis_kelamin = ($jk_input == 'L' || $jk_input == 'Laki-laki') ? 'Laki-laki' : 'Perempuan';

        $fileFoto = $this->request->getFile('foto');
        $oldFoto  = $this->request->getVar('fotoLama');

        if ($fileFoto->getError() == 4) {
            $namaFoto = $oldFoto;
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/foto-siswa', $namaFoto);
            if ($oldFoto != 'default.png' && file_exists('uploads/foto-siswa/' . $oldFoto)) {
                unlink('uploads/foto-siswa/' . $oldFoto);
            }
        }

        $this->siswaModel->update($id, [
            'nis'           => $this->request->getVar('nis'),
            'nama_siswa'    => $this->request->getVar('nama'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'jenis_kelamin' => $jenis_kelamin,
            'no_hp'         => $this->request->getVar('no_hp'),
            'foto'          => $namaFoto
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if ($siswa['foto'] != 'default.png' && file_exists('uploads/foto-siswa/' . $siswa['foto'])) {
            unlink('uploads/foto-siswa/' . $siswa['foto']);
        }

        $this->siswaModel->delete($id);
        return redirect()->to('/admin/siswa')->with('success', 'Data berhasil dihapus.');
    }

    public function cetak_qr()
    {
        $data['title'] = 'Cetak QR Code';
        $filter_kelas = $this->request->getGet('filter_kelas');
        $filter_jurusan = $this->request->getGet('filter_jurusan');

        $db = \Config\Database::connect();
        $data['data_kelas'] = $db->table('tb_kelas')->get()->getResultArray();
        $data['data_jurusan'] = $db->table('tb_jurusan')->get()->getResultArray();

        $query = $this->siswaModel->select('tb_siswa.*, tb_kelas.kelas, tb_jurusan.jurusan')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
                    ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan');

        if ($filter_kelas) $query->where('tb_siswa.id_kelas', $filter_kelas);
        if ($filter_jurusan) $query->where('tb_kelas.id_jurusan', $filter_jurusan);
        
        $data['siswa'] = $query->findAll();
        $data['filter_kelas'] = $filter_kelas;
        $data['filter_jurusan'] = $filter_jurusan;

        return view('admin/siswa/cetak_qr', $data);
    }
}