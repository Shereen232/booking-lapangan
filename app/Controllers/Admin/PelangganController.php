<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PemesananModel;

class PelangganController extends BaseController
{
    protected $pemesananModel;
    protected $userModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $userModel = new UserModel();
        $pelanggan = $userModel->findAll();

        return view('admin/pelanggan/index', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function create()
    {
        return view('admin/pelanggan/create');
    }

    public function store()
    {
        $userModel = new UserModel();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[3]',
            'email' => 'valid_email',
            'no_hp' => 'permit_empty|integer|min_length[10]|max_length[14]',
            'alamat' => 'permit_empty',
            'password' => 'required|min_length[6]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
        // Simpan data pelanggan
        $data = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role'   => 'pelanggan',
            'password' => $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : null
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/admin/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pelanggan.');
        }
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
        
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
    
        $userModel->update($id, $data);

        return redirect()->to('/admin/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Hapus semua pemesanan milik user
        $this->pemesananModel->where('user_id', $id)->delete();

        // Baru hapus user
        $this->userModel->delete($id);

        session()->setFlashdata('success', 'Pelanggan dan semua pesanannya berhasil dihapus.');
        return redirect()->to(base_url('admin/pelanggan'));
    }


}
