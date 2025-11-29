<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [ // 👉 tambahkan username
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type'       => "ENUM('pegawai','dosen','kepala unit','kepegawaian','admin')",
                'default'    => 'pegawai',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
                'null'       => false,
            ],
            'jenis_kelamin' => [
                'type'       => "ENUM('L','P')",
                'null'       => true,
            ],
            'id_prodi' => [ // relasi ke prodi
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Foreign key ke prodi
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
