<?php

namespace App\Models;

use CodeIgniter\Model;

class Jurusan extends Model
{
     protected $table            = 'jurusan';
    protected $primaryKey       = 'id_jurusan';
    protected $allowedFields    = ['nama_jurusan'];
    protected $useTimestamps    = false; // kalau pakai created_at / updated_at bisa diubah ke true
}
