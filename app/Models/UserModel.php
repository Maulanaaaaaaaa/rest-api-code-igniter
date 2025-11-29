<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name',
        'username',     // 👈 tambahkan username
        'email',
        'password',
        'role',
        'nip',
        'jenis_kelamin',
        'id_prodi',
    ];
    protected $useTimestamps    = true;

    // Relasi: ambil prodi + jurusan dari user
    public function getWithProdiJurusan()
    {
        return $this->select('users.*, prodi.nama_prodi, jurusan.nama_jurusan')
                    ->join('prodi', 'prodi.id_prodi = users.id_prodi', 'left')
                    ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan', 'left');
    }
}
