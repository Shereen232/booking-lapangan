<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\PemesananModel;

class JadwalController extends BaseController
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
        $data['jadwals'] = $this->pembayaranModel->getJadwalByUserId($userId);
        return view('pelanggan/jadwal-saya/index', $data);
    }

}
