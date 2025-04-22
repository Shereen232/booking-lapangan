<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AkunController extends BaseController
{
    public function index()
    {
        // Dummy user id, nanti ganti dari session
        $userId = 1;

        $userModel = new UserModel();
        $akun = $userModel->find($userId);

        return view('pelanggan/akun/index', [
            'akun' => $akun
        ]);
    }

    public function update()
    {
        $userId = $this->request->getPost('id');

        $data = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $userModel = new UserModel();
        $userModel->update($userId, $data);

        return redirect()->to(base_url('pelanggan/akun'))->with('success', 'Data akun berhasil diperbarui!');
    }
}
