<?php

namespace App\Controllers;

use App\Models\Jurusan;
use CodeIgniter\RESTful\ResourceController;


/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request 
 */
class JurusanController extends ResourceController
{
    protected $modelName = Jurusan::class;
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Jurusan tidak ditemukan');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $rules = [
            'nama_jurusan' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $id = $this->model->insert([
            'nama_jurusan' => $this->request->getVar('nama_jurusan'),
        ], true);

        return $this->respondCreated([
            'message' => 'Jurusan berhasil ditambahkan',
            'data'    => $this->model->find($id),
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        $rules = [
            'nama_jurusan' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if (! $this->model->find($id)) {
            return $this->failNotFound('Jurusan tidak ditemukan');
        }

        $this->model->update($id, $data);
        return $this->respond([
            'message' => 'Jurusan berhasil diupdate',
            'data'    => $this->model->find($id),
        ]);
    }

    public function delete($id = null)
    {
        if (! $this->model->find($id)) {
            return $this->failNotFound('Jurusan tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Jurusan berhasil dihapus']);
    }
}
