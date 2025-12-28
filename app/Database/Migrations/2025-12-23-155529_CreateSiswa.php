<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswa extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type'=>'INT','auto_increment'=>true],
        'nis' => ['type'=>'VARCHAR','constraint'=>20],
        'nama' => ['type'=>'VARCHAR','constraint'=>100],
        'kelas' => ['type'=>'VARCHAR','constraint'=>20],
        'jurusan' => ['type'=>'VARCHAR','constraint'=>50],
        'qr_code' => ['type'=>'VARCHAR','constraint'=>100],
        'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('siswa');
}


    public function down()
    {
        //
    }
}