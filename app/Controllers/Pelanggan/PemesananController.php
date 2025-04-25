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
        try {
            $request = service('request');
            $lapanganId = $request->getPost('lapangan_id');
            $tanggal = $request->getPost('tanggal');
            $jamMulai = $request->getPost('jam_mulai');
            $jamSelesai = $request->getPost('jam_selesai');
            $jumlahAir = (int) $request->getPost('jumlah_air');
            $biayaTambahan = $request->getPost('biaya') ?? []; // array
            $catatan = $request->getPost('catatan');

            // ==== Simulasi session sementara ====
            $userId = 1; // anggap user login id 1
            $namaPemesan = 'User Dummy';

            // Ambil data harga per jam
            $lapanganModel = new \App\Models\LapanganModel();
            $lapangan = $lapanganModel->find($lapanganId);
            if (!$lapangan) {
                return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
            }

            // Hitung total bayar
            $durasi = (int)substr($jamSelesai, 0, 2) - (int)substr($jamMulai, 0, 2);
            if ($durasi <= 0) {
                return redirect()->back()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
            }

            $total = $durasi * $lapangan['harga_per_jam'];
            $total += $jumlahAir * 5000;

            foreach ($biayaTambahan as $biaya) {
                $total += (int)$biaya;
            }

            $order_id = uniqid();

            // Simpan ke database
            $pemesananModel = new \App\Models\PemesananModel();
            $pemesananModel->save([
                'user_id'       => $userId,
                'order_id'      => $order_id,
                'nama_pemesan'  => $namaPemesan,
                'lapangan_id'   => $lapanganId,
                'tanggal_pesan' => $tanggal,
                'jam_mulai'     => $jamMulai,
                'jam_selesai'   => $jamSelesai,
                'jumlah_air'    => $jumlahAir,
                'catatan'       => $catatan,
                'total_bayar'   => $total,
                'status'        => 'pending' // default status
            ]);

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => (int)$total
                ],
                'customer_details' => [
                    'first_name' => $namaPemesan,
                    'email' => 'customer@example.com',
                    'phone' => '08123456789'
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $id = $pemesananModel->getInsertID();

            $pemesananModel->update($id, [
                'snaptoken' => $snapToken
            ]);            

            return response()->setJSON([
                'success' => true,
                'message' => 'Pemesanan berhasil, silakan melakukan pembayaran.',
                'total' => $total,
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal melakukan pemesanan: ' . $e->getMessage());

            return response()->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pemesanan: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function updateStatus()
    {
        $pemesananModel = new \App\Models\PemesananModel();

        $data = $this->request->getJSON();
        // Misalnya update ke database
        $pemesananModel->where('order_id', $data->order_id)
                                ->set([
                                    'status' => $data->transaction_status,
                                    'payment_type'      => $data->payment_type,
                                    'total_bayar'      => $data->gross_amount
                                ])->update();

        return $this->response->setJSON(['status' => 'success']);
    }

}
