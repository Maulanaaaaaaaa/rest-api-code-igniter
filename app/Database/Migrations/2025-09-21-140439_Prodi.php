<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prodi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_jurusan' => [ // foreign key ke jurusan
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id_prodi', true);

        // Foreign key ke jurusan
        $this->forge->addForeignKey('id_jurusan', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('prodi');
    }

    public function down()
    {
        $this->forge->dropTable('prodi');
    }
}
