<?php

namespace App\Filters;
use Config\Services;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        if (! $header) {
            return Services::response()
                ->setJSON(['error' => 'Token tidak ada'])
                ->setStatusCode(401);
        }

        $token = null;
        if (strpos($header, 'Bearer ') === 0) {
            $token = substr($header, 7);
        }

        if (! $token) {
            return Services::response()
                ->setJSON(['error' => 'Format token salah'])
                ->setStatusCode(401);
        }

        helper('jwt');
        $decoded = verify_jwt($token);

        if (! $decoded) {
            return Services::response()
                ->setJSON(['error' => 'Token tidak valid / expired'])
                ->setStatusCode(401);
        }

        // simpan data user biar bisa diakses di controller
        $request->user = $decoded;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
