<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananModel;

class PemesananController extends BaseController
{
    protected $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pemesanan',
            'pemesanan' => $this->pemesananModel->getWithRelationsLapangan()
        ];

        return view('admin/pemesanan/index', $data);
    }

    public function edit($id)
    {
        $pemesanan = $this->pemesananModel->find($id);

        if (!$pemesanan) {
            return redirect()->to(base_url('admin/pemesanan'))->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Ubah Status Pemesanan',
            'pemesanan' => $pemesanan
        ];

        return view('admin/pemesanan/edit', $data);
    }

    public function update($id)
    {
        $status = $this->request->getPost('status');

        $this->pemesananModel->update($id, ['status' => $status]);

        return redirect()->to(base_url('admin/pemesanan'))->with('success', 'Status berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->pemesananModel->delete($id);
        return redirect()->to(base_url('admin/pemesanan'))->with('success', 'Data pemesanan berhasil dihapus.');
    }
}
