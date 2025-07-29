<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemesananModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PembayaranController extends BaseController
{
    protected $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    public function index()
    {
        // Jika tidak ada input dari GET, default ke hari ini
        $tanggalMulai = $this->request->getVar('tanggalMulai') ?? date('Y-m-d');
        $tanggalSelesai = $this->request->getVar('tanggalSelesai') ?? date('Y-m-d');


        // Gunakan alias agar sesuai dengan view
        $query = $this->pemesananModel
            ->select('pemesanan.*, users.nama AS nama_pemesan, lapangan.nama AS nama_lapangan')
            ->join('users', 'users.id = pemesanan.user_id')
            ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id'); // pastikan 'id' benar

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $query->where('pemesanan.tanggal_pesan >=', $tanggalMulai)
                  ->where('pemesanan.tanggal_pesan <=', $tanggalSelesai);
        }



        $data = [
            'pemesanan' => $query->orderBy('pemesanan.tanggal_pesan', 'desc')->findAll(),
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ];


        return view('admin/pembayaran/index', $data);
    }

    public function exportPdf()
    {
        // Jika tidak ada input dari GET, default ke hari ini
        $tanggalMulai = $this->request->getVar('tanggalMulai') ?? date('Y-m-d');
        $tanggalSelesai = $this->request->getVar('tanggalSelesai') ?? date('Y-m-d');


        $query = $this->pemesananModel
            ->select('pemesanan.*, users.nama AS nama_pemesan, lapangan.nama AS nama_lapangan')
            ->join('users', 'users.id = pemesanan.user_id')
            ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id'); // pastikan 'id' benar

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $query->where('pemesanan.tanggal_pesan >=', $tanggalMulai)
                  ->where('pemesanan.tanggal_pesan <=', $tanggalSelesai);
        }

        $data = [
            'pemesanan' => $query->findAll(),
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ];

        $html = view('admin/pembayaran/laporan_pdf', $data); // Ubah sesuai view PDF yang akan kamu buat

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('Laporan_Pembayaran_' . date('Ymd') . '.pdf', ['Attachment' => 0]);
        exit();
    }
}
