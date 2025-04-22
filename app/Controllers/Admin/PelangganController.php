<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class PelangganController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $pelanggan = $userModel->findAll();

        return view('admin/pelanggan/index', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $pelanggan = $userModel->find($id);

        if (!$pelanggan) {
            return redirect()->to('/admin/pelanggan')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/pelanggan/edit', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $data = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $userModel->update($id, $data);

        return redirect()->to('/admin/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/admin/pelanggan')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
