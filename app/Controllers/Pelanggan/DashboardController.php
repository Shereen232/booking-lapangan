<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('pelanggan/dashboard', [
            'totalPemesanan'   => 10,
            'jadwalTerdekat'   => '25 Mei 2025, 17:00',
            'statusPembayaran' => 'Lunas'
        ]);
    }
}
