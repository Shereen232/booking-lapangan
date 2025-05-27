<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AlreadyLoggedIn implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Misalnya session 'isLoggedIn' menandakan user sudah login
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role');
            if ($role === UserModel::ADMIN) return redirect()->to('/admin');
            if ($role === UserModel::PELANGGAN) return redirect()->to('/pelanggan');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}
