<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'nama'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin'
        ]);
    }
}