<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => ['type'=>'INT','auto_increment'=>true],
        'nama' => ['type'=>'VARCHAR','constraint'=>100],
        'email' => ['type'=>'VARCHAR','constraint'=>100],
        'password' => ['type'=>'VARCHAR','constraint'=>255],
        'role' => ['type'=>'ENUM','constraint'=>['admin','guru','wali']],
        'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('users');
}


    public function down()
    {
        //
    }
}