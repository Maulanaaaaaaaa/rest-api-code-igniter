<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    /**
     * Middleware sederhana untuk validasi token JWT
     */
    private function checkAuth()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (! $authHeader || strpos($authHeader, 'Bearer ') !== 0) {
            return $this->failUnauthorized('Token tidak ditemukan');
        }

        $token = substr($authHeader, 7);
        $claims = verify_jwt($token);

        if (! $claims) {
            return $this->failUnauthorized('Token tidak valid / kadaluarsa');
        }

        return $claims; // return isi token (claims)
    }

    /**
     * Ambil semua user (hanya untuk yang punya token valid)
     */
    public function index()
    {
        $claims = $this->checkAuth();
        if (is_object($claims) && $claims instanceof \CodeIgniter\HTTP\ResponseInterface) {
            return $claims; // kalau gagal auth
        }

        $userModel = new UserModel();
        $users = $userModel
            ->select('users.id, users.name, users.username, users.email, users.nip, users.role, users.jenis_kelamin, prodi.nama_prodi, jurusan.nama_jurusan')
            ->join('prodi', 'prodi.id_prodi = users.id_prodi', 'left')
            ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan', 'left')
            ->findAll();

        return $this->respond([
            'status' => 'success',
            'data'   => $users
        ]);
    }

    /**
     * Ambil detail user berdasarkan ID (butuh token juga)
     */
    public function show($id)
    {
        $claims = $this->checkAuth();
        if (is_object($claims) && $claims instanceof \CodeIgniter\HTTP\ResponseInterface) {
            return $claims;
        }

        $userModel = new UserModel();
        $user = $userModel
            ->select('users.id, users.name, users.username, users.email, users.nip, users.role, users.jenis_kelamin, prodi.nama_prodi, jurusan.nama_jurusan')
            ->join('prodi', 'prodi.id_prodi = users.id_prodi', 'left')
            ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan', 'left')
            ->find($id);

        if (! $user) {
            return $this->failNotFound('User tidak ditemukan');
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $user
        ]);
    }

    /**
     * Ambil profil user yang sedang login (berdasarkan token JWT)
     */
    public function me()
    {
        $claims = $this->checkAuth();
        if (is_object($claims) && $claims instanceof \CodeIgniter\HTTP\ResponseInterface) {
            return $claims;
        }

        $userModel = new UserModel();
        $user = $userModel
            ->select('users.id, users.name, users.username, users.email, users.nip, users.role, users.jenis_kelamin, prodi.nama_prodi, jurusan.nama_jurusan')
            ->join('prodi', 'prodi.id_prodi = users.id_prodi', 'left')
            ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan', 'left')
            ->find($claims->id); // id dari token

        return $this->respond([
            'status' => 'success',
            'data'   => $user
        ]);
    }
}
