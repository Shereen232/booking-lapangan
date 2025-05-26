<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Simpan data user ke dalam session
            $session->set([
                'user_id'   => $user['id'],
                'nama'      => $user['nama'],
                'email'     => $user['email'],
                'no_hp'     => $user['no_hp'],
                'alamat'    => $user['alamat'],
                'role'      => $user['role'],
                'isLoggedIn'=> true
            ]);

            // Arahkan sesuai role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin');
            } elseif ($user['role'] === 'pelanggan') {
                return redirect()->to('/pelanggan');
            } else {
                // fallback jika role tidak dikenal
                return redirect()->to('/')->with('error', 'Role tidak dikenali.');
            }

        } else {
            // Jika gagal login
            return redirect()->back()->withInput()->with('error', 'Email atau password salah');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $validation = \Config\Services::validation();

        // Aturan validasi input
        $rules = [
            'nama'              => 'required|min_length[3]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'no_hp'             => 'required|numeric|min_length[11]',
            'alamat'            => 'required|min_length[5]',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'required|matches[password]'
        ];

        // Jalankan validasi
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Mohon periksa kembali inputan Anda.')
                ->with('validation', $validation);
        }

        // Simpan ke database
        $userModel = new \App\Models\UserModel();

        $userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'alamat'   => $this->request->getPost('alamat'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pelanggan'
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

}
