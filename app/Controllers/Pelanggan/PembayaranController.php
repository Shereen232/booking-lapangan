<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\PemesananModel;

class PembayaranController extends BaseController
{
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PemesananModel();
    }

    // Tampilkan daftar lapangan
    public function index()
    {
        $session = session();

        // Ambil data satu per satu
        $userId = $session->get('user_id');
        $data['orders'] = $this->pembayaranModel->getWithRelationUserId($userId);
        return view('pelanggan/pembayaran/index', $data);
    }

}
