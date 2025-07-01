<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\LapanganModel;

class Home extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard', ['title' => 'Dashboard Admin']);
    }

     public function index()
    {
        helper('url'); // Pastikan URL helper dimuat

        $lapanganModel = new LapanganModel();
        $lapanganData = $lapanganModel->findAll(); // Mengambil semua data lapangan dari database

        // Data yang akan dikirimkan ke view
        $data = [
            'title' => 'Get Futsal - Booking Lapangan Tanpa Ribet',
            'lapangan' => $lapanganData // Meneruskan data lapangan ke view
        ];

        // Memuat view 'landing_page' dan mengirimkan data ke dalamnya
        return view('landing_page', $data);
    }
    
}
