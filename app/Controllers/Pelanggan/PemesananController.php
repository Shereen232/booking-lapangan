<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\LapanganModel;
use App\Models\PemesananModel;

class PemesananController extends BaseController
{
    protected $lapanganModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
    }

    // Tampilkan daftar lapangan
    public function index()
    {
        $data['lapangan'] = $this->lapanganModel->findAll();
        return view('pelanggan/pemesanan/index', $data);
    }

    // Detail & form pemesanan
    public function detail($id)
{
    $lapangan = $this->lapanganModel->find($id);

    if (!$lapangan) {
        return redirect()->to(base_url('booking'))->with('error', 'Lapangan tidak ditemukan.');
    }

    // Ambil tanggal dari query string atau gunakan hari ini
    $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

    $pemesananModel = new \App\Models\PemesananModel();
    $jadwal_terbooking = $pemesananModel->where('lapangan_id', $id)
        ->where('tanggal_pesan', $tanggal)
        ->findAll();

    // Hitung sisa slot dari pengaturan (misalnya per hari 10 jam)
    $pengaturanModel = new \App\Models\PengaturanModel();
    $pengaturan = $pengaturanModel->first();
    $jam_operasional = strtotime($pengaturan['jam_tutup']) - strtotime($pengaturan['jam_buka']);
    $jumlah_slot = $jam_operasional / 3600; // Konversi ke jam

    $sisa_slot = $jumlah_slot - count($jadwal_terbooking);

    $data = [
        'lapangan' => $lapangan,
        'tanggal_pesan' => $tanggal,
        'jadwal_terbooking' => $jadwal_terbooking,
        'sisa_slot' => $sisa_slot,
    ];

    return view('pelanggan/pemesanan/detail', $data);
}




    // Simpan pemesanan
    public function simpan()
    {
        $pemesananModel = new PemesananModel();

        $lapangan_id = $this->request->getPost('lapangan_id');
        $tanggal     = $this->request->getPost('tanggal');
        $jam_mulai   = $this->request->getPost('jam_mulai');
        $jam_selesai = $this->request->getPost('jam_selesai');
        $catatan     = $this->request->getPost('catatan');
        $biayaTambahan = $this->request->getPost('biaya') ?? [];

        // Hitung durasi main (jam)
        $durasi = (int)substr($jam_selesai, 0, 2) - (int)substr($jam_mulai, 0, 2);
        if ($durasi <= 0) {
            return redirect()->back()->with('error', 'Jam selesai harus lebih besar dari jam mulai');
        }

        // Ambil harga per jam dari lapangan
        $lapangan = $this->lapanganModel->find($lapangan_id);
        $harga_per_jam = $lapangan['harga_per_jam'];

        // Hitung total bayar
        $total_bayar = $durasi * $harga_per_jam + array_sum($biayaTambahan);

        $pemesananModel->insert([
            'user_id'       => session('id'),
            'nama_pemesan'  => session('nama'),
            'lapangan_id'   => $lapangan_id,
            'tanggal'       => $tanggal,
            'jam_mulai'     => $jam_mulai,
            'jam_selesai'   => $jam_selesai,
            'status'        => 'pending',
            'catatan'       => $catatan,
            'total_bayar'   => $total_bayar
        ]);

        return redirect()->to(base_url('jadwal-saya'))->with('success', 'Pemesanan berhasil dilakukan.');
    }
}
