<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
// Library untuk Excel
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

        return view('guru/siswa/index', $data);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Tabel Excel
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'NAMA_SISWA');
        $sheet->setCellValue('C1', 'JENIS_KELAMIN');
        $sheet->setCellValue('D1', 'ID_KELAS');
        $sheet->setCellValue('E1', 'NO_HP');

        // Contoh Data (Baris 2)
        $sheet->setCellValue('A2', '12345');
        $sheet->setCellValue('B2', 'Andi Siswanto');
        $sheet->setCellValue('C2', 'L');
        $sheet->setCellValue('D2', '1'); // ID Kelas (cek tb_kelas)
        $sheet->setCellValue('E2', '08123456789');

        // Proses download
        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Siswa_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    // ... (fungsi create, saveSiswa, show, edit, update, delete tetap sama)

    public function import()
    {
        $file = $this->request->getFile('file_excel');

        // Validasi file
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'File tidak valid atau sudah dipindahkan.');
        }

        $rules = [
            'file_excel' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]|max_size[file_excel,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Format file harus .xls/.xlsx dan maksimal 2MB.');
        }

        try {
            $extension = $file->getClientExtension();
            $reader = ($extension == 'xlsx') ? new \PhpOffice\PhpSpreadsheet\Reader\Xlsx() : new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            
            $spreadsheet = $reader->load($file->getTempName());
            $dataExcel = $spreadsheet->getActiveSheet()->toArray();

            $count = 0;
            foreach ($dataExcel as $key => $row) {
                // Skip baris 1 (header) dan baris yang NIS-nya kosong
                if ($key == 0 || empty($row[0])) continue;

                $nis = $row[0];
                
                // Cek apakah NIS sudah ada di database
                if ($this->siswaModel->where('nis', $nis)->first()) {
                    continue; 
                }

                // Simpan data
                $this->siswaModel->save([
                    'nis'           => $row[0],
                    'nama_siswa'    => $row[1],
                    'jenis_kelamin' => (strtoupper($row[2]) == 'L' ? 'Laki-laki' : 'Perempuan'),
                    'id_kelas'      => $row[3], // Pastikan di Excel ini adalah ANGKA ID Kelas
                    'no_hp'         => $row[4],
                    'foto'          => 'default.png',
                    'unique_code'   => bin2hex(random_bytes(8))
                ]);
                $count++;
            }

            return redirect()->to('/guru/siswa')->with('success', "$count data siswa berhasil diimpor.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membaca file: ' . $e->getMessage());
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
        return view('guru/siswa/create', $data);
    }

    public function saveSiswa()
    {
        $rules = [
            'nis'      => 'required|is_unique[tb_siswa.nis]',
            'nama'     => 'required',
            'id_kelas' => 'required',
            'jk'       => 'required', // Tambahkan validasi jenis kelamin
            'foto'     => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Logika konversi input ke Teks Lengkap
        $jk_input = $this->request->getVar('jk');
        $jenis_kelamin = ($jk_input == 'L') ? 'Laki-laki' : 'Perempuan';

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/foto-siswa', $namaFoto);

        $this->siswaModel->save([
            'nis'           => $this->request->getVar('nis'),
            'nama_siswa'    => $this->request->getVar('nama'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'jenis_kelamin' => $jenis_kelamin, // SIMPAN TEKS LENGKAP
            'no_hp'         => $this->request->getVar('no_hp'),
            'foto'          => $namaFoto,
            'unique_code'   => bin2hex(random_bytes(8))
        ]);

        session()->setFlashdata('success', 'Data siswa berhasil disimpan!');
        return redirect()->to('/guru/siswa');
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

        return view('guru/siswa/show', $data);
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $siswa = $this->siswaModel->find($id);
        
        if (!$siswa || !is_array($siswa)) {
            return redirect()->to('/guru/siswa')->with('error', 'Data siswa tidak ditemukan.');
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

        return view('guru/siswa/edit', $data);
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

        // Logika konversi input ke Teks Lengkap
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
            'jenis_kelamin' => $jenis_kelamin, // SIMPAN TEKS LENGKAP
            'no_hp'         => $this->request->getVar('no_hp'),
            'foto'          => $namaFoto
        ]);

        return redirect()->to('/guru/siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if ($siswa['foto'] != 'default.png' && file_exists('uploads/foto-siswa/' . $siswa['foto'])) {
            unlink('uploads/foto-siswa/' . $siswa['foto']);
        }

        $this->siswaModel->delete($id);
        return redirect()->to('/guru/siswa')->with('success', 'Data siswa berhasil dihapus.');
    }

}