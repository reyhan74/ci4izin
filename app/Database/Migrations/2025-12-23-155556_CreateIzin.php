<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIzin extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type'=>'INT','auto_increment'=>true],
        'siswa_id' => ['type'=>'INT'],
        'status' => ['type'=>'ENUM','constraint'=>['keluar','kembali']],
        'keterangan' => ['type'=>'TEXT','null'=>true],
        'waktu' => ['type'=>'DATETIME']
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('siswa_id','siswa','id','CASCADE','CASCADE');
    $this->forge->createTable('izin');
}


    public function down()
    {
        //
    }
}