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
         helper('url'); // Pastikan URL helper dimuat untuk current_url() dan base_url()

        // Ambil nilai 'tanggalMulai' dan 'tanggalSelesai' dari query string (URL)
        $tanggalMulai = $this->request->getGet('tanggalMulai');
        $tanggalSelesai = $this->request->getGet('tanggalSelesai');

        // Inisialisasi variabel pemesanan
        $pemesanan = [];

        // Logika filter berdasarkan rentang tanggal
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            // Jika kedua tanggal filter ada, panggil method model untuk rentang tanggal
            $pemesanan = $this->pemesananModel->getPemesananByDateRange($tanggalMulai, $tanggalSelesai);
        } elseif (!empty($tanggalMulai)) {
            // Jika hanya tanggal mulai yang ada, filter dari tanggal mulai hingga akhir hari ini
            // Atau Anda bisa memutuskan untuk memfilter hanya pada tanggal itu saja
            // Contoh ini akan memfilter hanya pada tanggal yang dipilih
            $pemesanan = $this->pemesananModel->getPemesananByDate($tanggalMulai);
            $tanggalSelesai = $tanggalMulai; // Untuk mengisi input tanggalSelesai di view
        } else {
            // Jika tidak ada filter tanggal sama sekali, tampilkan data untuk hari ini
            $tanggalMulai = date('Y-m-d');
            $tanggalSelesai = date('Y-m-d');
            $pemesanan = $this->pemesananModel->getPemesananByDate($tanggalMulai);
        }

        $data = [
            'title' => 'Data Pemesanan', // Judul halaman
            'pemesanan' => $pemesanan,
            'tanggalMulai' => $tanggalMulai,   // Kirim kembali nilai filter ke view
            'tanggalSelesai' => $tanggalSelesai // Kirim kembali nilai filter ke view
        ];

        // Sesuaikan path view Anda, contoh: 'admin/pemesanan/index' atau 'pelanggan/pemesanan/index'
        return view('admin/pemesanan/index', $data); 
    }
}

    // public function edit($id)



    // // public function edit($id)
    // // {
    // //     $pemesanan = $this->pemesananModel->find($id);

    // //     if (!$pemesanan) {
    // //         return redirect()->to(base_url('admin/pemesanan'))->with('error', 'Data tidak ditemukan.');
    // //     }

    // //     $data = [
    // //         'title' => 'Ubah Status Pemesanan',
    // //         'pemesanan' => $pemesanan
    // //     ];

    // //     return view('admin/pemesanan/edit', $data);
    // // }

    // // public function update($id)
    // // {
    // //     $status = $this->request->getPost('status');

    // //     $this->pemesananModel->update($id, ['status' => $status]);

    // //     return redirect()->to(base_url('admin/pemesanan'))->with('success', 'Status berhasil diperbarui.');
    // // }

