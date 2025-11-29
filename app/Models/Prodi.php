<?php

namespace App\Models;

use CodeIgniter\Model;

class Prodi extends Model
{
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $allowedFields    = ['nama_prodi', 'id_jurusan'];
    protected $useTimestamps    = false;

    // Relasi: ambil jurusan dari prodi
    public function getWithJurusan()
    {
        return $this->select('prodi.*, jurusan.nama_jurusan')
                    ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan');
    }
}

