<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananModel;

class PembayaranController extends BaseController
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
            'pemesanan' => $this->pemesananModel->getAllPemesanan()
        ];

        return view('admin/pembayaran/index', $data);
    }
}
