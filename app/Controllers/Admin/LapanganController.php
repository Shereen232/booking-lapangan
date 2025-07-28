<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LapanganModel;

class LapanganController extends BaseController
{
    protected $lapanganModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
    }

    public function index()
    {
        $data['lapangan'] = $this->lapanganModel->findAll();
        return view('admin/lapangan/index', $data);
    }

    public function create()
    {
        return view('admin/lapangan/create');
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/lapangan', $namaFoto);
        }

        $this->lapanganModel->save([
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'), 
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('success', 'Data lapangan berhasil ditambahkan.');
        return redirect()->to(base_url('admin/lapangan'));

    }

    public function edit($id)
    {
        $data['lapangan'] = $this->lapanganModel->find($id);

        if (!$data['lapangan']) {
            return redirect()->to(base_url('admin/lapangan'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/lapangan/edit', $data);
    }

    public function update($id)
    {
        $lapangan = $this->lapanganModel->find($id);

        if (!$lapangan) {
            return redirect()->to(base_url('admin/lapangan'))->with('error', 'Data tidak ditemukan.');
        }

        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $lapangan['foto']; // Default pakai foto lama

        if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
            // Hapus foto lama
            if ($namaFoto && file_exists('uploads/lapangan/' . $namaFoto)) {
                unlink('uploads/lapangan/' . $namaFoto);
            }

            // Upload foto baru
            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move('uploads/lapangan', $namaFoto);
        }

        $this->lapanganModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'), // ⬅️ Ditambahkan
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('admin/lapangan'))->with('success', 'Data lapangan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $lapangan = $this->lapanganModel->find($id);

        if (!$lapangan) {
            return redirect()->to(base_url('admin/lapangan'))->with('error', 'Data tidak ditemukan.');
        }

        if ($lapangan['foto'] && file_exists('uploads/lapangan/' . $lapangan['foto'])) {
            unlink('uploads/lapangan/' . $lapangan['foto']);
        }

        $this->lapanganModel->delete($id);

        return redirect()->to(base_url('admin/lapangan'))->with('success', 'Data lapangan berhasil dihapus.');
    }
}
