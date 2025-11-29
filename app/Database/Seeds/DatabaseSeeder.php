<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Urutan penting! FK harus tersedia dulu
        $this->call(JurusanSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
