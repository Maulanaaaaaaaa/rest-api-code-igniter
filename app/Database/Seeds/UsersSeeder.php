<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'pegawai1',
                'name'          => 'Pegawai Satu',
                'email'         => 'pegawai@example.com',
                'password'      => password_hash('password123', PASSWORD_BCRYPT),
                'role'          => 'pegawai',
                'nip'           => 'p001',
                'jenis_kelamin' => 'L',
                'id_prodi'      => 1,
            ],
            [
                'username'      => 'kepalaunit',
                'name'          => 'Kepala Unit',
                'email'         => 'kepalaunit@example.com',
                'password'      => password_hash('password123', PASSWORD_BCRYPT),
                'role'          => 'kepala unit',
                'nip'           => 'p002',
                'jenis_kelamin' => 'P',
                'id_prodi'      => 2,
            ],
            [
                'username'      => 'kepegawaian',
                'name'          => 'Kepegawaian',
                'email'         => 'kepegawaian@example.com',
                'password'      => password_hash('password123', PASSWORD_BCRYPT),
                'role'          => 'kepegawaian',
                'nip'           => 'p003',
                'jenis_kelamin' => 'L',
                'id_prodi'      => 3,
            ],
            [
                'username'      => '',
                'name'          => 'Administrator',
                'email'         => 'samuel@example.com',
                'password'      => password_hash('password123', PASSWORD_BCRYPT),
                'role'          => 'dosen',
                'nip'           => 'p004',
                'jenis_kelamin' => 'P',
                'id_prodi'      => 4,
            ],
            [
                'username'      => 'dosen1',
                'name'          => 'Dosen Satu',
                'email'         => 'dosen@example.com',
                'password'      => password_hash('password123', PASSWORD_BCRYPT),
                'role'          => 'pegawai',
                'nip'           => 'p005',
                'jenis_kelamin' => 'L',
                'id_prodi'      => 5,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
