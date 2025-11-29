<?php

namespace App\Controllers;

use App\Models\Jurusan;
use CodeIgniter\RESTful\ResourceController;
use Config\App;

class JurusanController extends ResourceController
{
    protected $modelName = 'App\Models\Jurusan';
    protected $format    = 'json';

    public function index()
    {
        $data = [
            'message' => 'success',
            'data_jurusan' => $this->model->findAll()
        ];
        
        return $this->respond($data, 200);
        
    }
}
