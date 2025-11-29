<?php

namespace App\Controllers;

use App\Models\UserModel; // pakai UserModel
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;

class AuthController extends BaseController
{
    use ResponseTrait;

    /**
     * @var IncomingRequest
     */
    protected $request;

    public function register()
    {
        $rules = [
            'name'          => 'required|min_length[3]',
            'username'      => 'required|alpha_numeric|min_length[3]|is_unique[users.username]', // 👈 username wajib
            'email'         => 'permit_empty|valid_email|is_unique[users.email]', // opsional
            'password'      => 'required|min_length[6]',
            'nip'           => 'required|is_unique[users.nip]',
            'role'          => 'permit_empty|in_list[pegawai,dosen,kepala unit,kepegawaian,admin]',
            'jenis_kelamin' => 'permit_empty|in_list[L,P]',
            'id_prodi'      => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->save([
            'name'          => $this->request->getVar('name'),
            'username'      => $this->request->getVar('username'),
            'email'         => $this->request->getVar('email'),
            'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'nip'           => $this->request->getVar('nip'),
            'role'          => $this->request->getVar('role') ?? 'pegawai',
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'id_prodi'      => $this->request->getVar('id_prodi'),
        ]);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Registrasi berhasil'
        ]);
    }


    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $this->request->getVar('username'))->first();

        if (! $user || ! password_verify($this->request->getVar('password'), $user['password'])) {
            return $this->failUnauthorized('Username atau password salah');
        }

        // Generate JWT token
        $token = create_jwt([
            'id'       => $user['id'],
            'username' => $user['username'],
            'role'     => $user['role'],
        ]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => [
                'id'            => $user['id'],
                'name'          => $user['name'],
                'username'      => $user['username'],
                'email'         => $user['email'],
                'nip'           => $user['nip'],
                'role'          => $user['role'],
                'jenis_kelamin' => $user['jenis_kelamin'],
                'id_prodi'      => $user['id_prodi'],
            ]
        ]);
    }
}
