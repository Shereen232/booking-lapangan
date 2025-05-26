<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LapanganModel;
use App\Models\PemesananModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $userModel = new UserModel();
        $lapanganModel = new LapanganModel();
        $pemesananModel = new PemesananModel();

        $data = [
            'title'              => 'Dashboard Admin',
            'totalPelanggan'     => $userModel->where('role', 'pelanggan')->countAllResults(),
            'totalLapangan'      => $lapanganModel->countAllResults(),
            'totalPemesanan'     => $pemesananModel->countAllResults(),
            'pemesananHariIni'   => $pemesananModel
                                        ->where('DATE(tanggal_pesan)', date('Y-m-d'))
                                        ->countAllResults(),
            'totalPembayaran'    => $pemesananModel
                                        ->where('status', 'settlement') // asumsi 'settlement' = sukses
                                        ->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
