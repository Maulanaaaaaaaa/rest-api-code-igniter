<?php

namespace App\Controllers;

use App\Models\Prodi;
use App\Models\Jurusan;
use CodeIgniter\RESTful\ResourceController;


/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request 
 */
class ProdiController extends ResourceController
{
    protected $modelName = Prodi::class;
    protected $format    = 'json';

    public function index()
    {
        // join biar sekalian nampilin jurusan
        $data = $this->model
            ->select('prodi.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan')
            ->findAll();

        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->model
            ->select('prodi.*, jurusan.nama_jurusan')
            ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan')
            ->where('prodi.id_prodi', $id)
            ->first();

        if (!$data) {
            return $this->failNotFound('Prodi tidak ditemukan');
        }

        return $this->respond($data);
    }

    public function create()
    {
        $rules = [
            'nama_prodi' => 'required|min_length[3]',
            'id_jurusan' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // cek foreign key jurusan
        $jurusanModel = new Jurusan();
        if (! $jurusanModel->find($this->request->getVar('id_jurusan'))) {
            return $this->failNotFound('Jurusan tidak ditemukan');
        }

        $id = $this->model->insert([
            'nama_prodi' => $this->request->getVar('nama_prodi'),
            'id_jurusan' => $this->request->getVar('id_jurusan'),
        ], true);

        return $this->respondCreated([
            'message' => 'Prodi berhasil ditambahkan',
            'data'    => $this->model->find($id),
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        $rules = [
            'nama_prodi' => 'required|min_length[3]',
            'id_jurusan' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if (! $this->model->find($id)) {
            return $this->failNotFound('Prodi tidak ditemukan');
        }

        // cek foreign key jurusan
        $jurusanModel = new Jurusan();
        if (! $jurusanModel->find($data['id_jurusan'])) {
            return $this->failNotFound('Jurusan tidak ditemukan');
        }

        $this->model->update($id, $data);
        return $this->respond([
            'message' => 'Prodi berhasil diupdate',
            'data'    => $this->model->find($id),
        ]);
    }

    public function delete($id = null)
    {
        if (! $this->model->find($id)) {
            return $this->failNotFound('Prodi tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Prodi berhasil dihapus']);
    }
}
