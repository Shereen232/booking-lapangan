<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;

class PengaturanController extends BaseController
{
    protected $pengaturanModel;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        $pengaturan = $this->pengaturanModel->first(); // ambil baris pertama
        return view('admin/pengaturan/index', ['pengaturan' => $pengaturan]);
    }

    public function update()
    {
        $id = $this->request->getPost('id') ?? 1;

        $data = [
            'jam_buka' => $this->request->getPost('jam_buka'),
            'jam_tutup' => $this->request->getPost('jam_tutup'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
            'durasi_minimal' => $this->request->getPost('durasi_minimal'),
            'kontak_admin' => $this->request->getPost('kontak_admin')
        ];

        $file = $this->request->getFile('foto_default');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/pengaturan', $newName);
            $data['foto_default'] = $newName;
        }

        $this->pengaturanModel->update($id, $data);

        return redirect()->to(base_url('admin/pengaturan'))->with('success', 'Pengaturan berhasil diperbarui');
    }
}
