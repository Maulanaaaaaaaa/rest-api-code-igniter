<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_jurusan' => 'Teknik Informatika'],
            ['nama_jurusan' => 'Sistem Informasi'],
            ['nama_jurusan' => 'Teknik Elektro'],
            ['nama_jurusan' => 'Manajemen'],
            ['nama_jurusan' => 'Akuntansi'],
        ];

        $this->db->table('jurusan')->insertBatch($data);
    }
}
