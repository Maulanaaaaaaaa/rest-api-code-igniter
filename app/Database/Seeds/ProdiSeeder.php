<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_prodi' => 'D3 Informatika',     'id_jurusan' => 1],
            ['nama_prodi' => 'S1 Sistem Informasi','id_jurusan' => 2],
            ['nama_prodi' => 'S1 Teknik Elektro',  'id_jurusan' => 3],
            ['nama_prodi' => 'S1 Manajemen',       'id_jurusan' => 4],
            ['nama_prodi' => 'S1 Akuntansi',       'id_jurusan' => 5],
        ];

        $this->db->table('prodi')->insertBatch($data);
    }
}
