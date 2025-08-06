<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananModel;
use Dompdf\Dompdf; 
use Dompdf\Options; 

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

    public function exportPdf()
    {
        // Ambil nilai 'tanggalMulai' dan 'tanggalSelesai' dari query string (URL)
        $tanggalMulai = $this->request->getGet('tanggalMulai');
        $tanggalSelesai = $this->request->getGet('tanggalSelesai');

        $pemesanan = [];
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            // Jika kedua tanggal filter ada, panggil method model untuk rentang tanggal
            $pemesanan = $this->pemesananModel->getPemesananByDateRange($tanggalMulai, $tanggalSelesai);
        } elseif (!empty($tanggalMulai)) {
            // Jika hanya tanggal mulai yang ada, filter hanya pada tanggal itu saja
            $pemesanan = $this->pemesananModel->getPemesananByDate($tanggalMulai);
            $tanggalSelesai = $tanggalMulai; // Sesuaikan agar konsisten di laporan
        } else {
            // Jika tidak ada filter, ambil semua data atau atur rentang default (misal: semua data)
            $pemesanan = $this->pemesananModel->getAllPemesanan(); // Anda perlu membuat method ini di model
            $tanggalMulai = null; // Set null jika tidak ada filter spesifik
            $tanggalSelesai = null; // Set null jika tidak ada filter spesifik
        }

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Penting jika Anda memiliki gambar eksternal atau CSS
        $dompdf = new Dompdf($options);

        $data = [
            'pemesanan' => $pemesanan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ];

        // Load view yang akan di-render sebagai PDF
        // Pastikan path view ini benar, misalnya 'admin/pemesanan/pdf_template'
        $html = view('admin/pemesanan/laporan_pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Atur ukuran kertas dan orientasi (misal: portrait atau landscape)
        $dompdf->render();

        // Output PDF ke browser
        // "Attachment" => 0 akan membuka di browser, "Attachment" => 1 akan langsung mengunduh
        $filename = "Laporan_Pemesanan_" . date('Ymd_His') . ".pdf";
        $dompdf->stream($filename, array("Attachment" => 0));
        exit(); // Penting untuk menghentikan eksekusi setelah PDF di-stream
    }

    public function create()
    {
        $lapanganModel = new \App\Models\LapanganModel();
        $data = [
            'title' => 'Tambah Pemesanan',
            'lapangan' => $lapanganModel->findAll(),
        ];
        return view('admin/pemesanan/create', $data);
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

