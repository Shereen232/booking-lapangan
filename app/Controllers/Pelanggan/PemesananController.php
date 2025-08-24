<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\FasilitasModel;
use App\Models\LapanganModel;
use App\Models\PemesananFasilitasModel;

class PemesananController extends BaseController
{
    
    protected $lapanganModel, $fasilitasModel, $pemesananFasilitasModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
        $this->fasilitasModel = new FasilitasModel();
        $this->pemesananFasilitasModel = new PemesananFasilitasModel();
    }

    // Tampilkan daftar lapangan
    public function index()
    {
        $data['lapangan'] = $this->lapanganModel->findAll();
        return view('pelanggan/pemesanan/index', $data);
    }

    private function konversiHari(string $englishDay): string
    {
        $map = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        return $map[$englishDay] ?? $englishDay;
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

        // Ambil data pengaturan
        $pengaturanModel = new \App\Models\PengaturanModel();
        $pengaturan = $pengaturanModel->first();

        // Cek hari tutup
        $hariTutup = explode(',', $pengaturan['hari_tutup'] ?? '');
        $hariTanggal = $this->konversiHari(date('l', strtotime($tanggal)));
        $isTutup = in_array($hariTanggal, $hariTutup);

        // Ambil jadwal booking HANYA untuk tanggal yang dipilih
        $pemesananModel = new \App\Models\PemesananModel();
        $jadwal_terbooking = $pemesananModel->where('lapangan_id', $id)
            ->where('tanggal_pesan', $tanggal)
            ->findAll();

        // Hitung sisa slot
        $jam_operasional = strtotime($pengaturan['jam_tutup']) - strtotime($pengaturan['jam_buka']);
        $jumlah_slot = $jam_operasional / 3600; // Konversi ke jam
        $sisa_slot = $jumlah_slot - count($jadwal_terbooking);

        $data = [
            'lapangan' => $lapangan,
            'jadwal_terbooking' => $jadwal_terbooking,
            'sisa_slot' => $sisa_slot,
            'pengaturan' => $pengaturan,
            'isTutup' => $isTutup,
            'tanggal' => $tanggal,
            'fasilitas' => $this->fasilitasModel->findAll()
        ];

        return view('pelanggan/pemesanan/detail', $data);
    }


    // Simpan pemesanan
    public function simpan()
    {
        $session = session();
        try {
            $request = service('request');
            $lapanganId = $request->getPost('lapangan_id');
            $tanggal = $request->getPost('tanggal');
            $jamMulai = $request->getPost('jam_mulai');
            $jamSelesai = $request->getPost('jam_selesai');
            $catatan = $request->getPost('catatan');
            $total_bayar = $request->getPost('total_bayar');
            $fasilitas = $request->getPost('fasilitas');

            // ==== Simulasi session sementara ====
            $userId = $session->get('user_id'); // anggap user login
            $namaPemesan = $session->get('nama');

            // Ambil pengaturan dan cek hari tutup
            $pengaturanModel = new \App\Models\PengaturanModel();
            $pengaturan = $pengaturanModel->first();

            $hariTutup = explode(',', $pengaturan['hari_tutup'] ?? '');
            $hariTanggal = $this->konversiHari(date('l', strtotime($tanggal)));
            
            if (in_array($hariTanggal, $hariTutup)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Maaf, pemesanan tidak tersedia karena hari tersebut adalah hari tutup.'
                ]);
            }

            // Ambil data lapangan
            $lapangan = $this->lapanganModel->find($lapanganId);
            if (!$lapangan) {
                return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
            }

            $order_id = uniqid();

            // Simpan ke database
            $pemesananModel = new \App\Models\PemesananModel();
            $pemesananModel->save([
                'user_id'             => $userId,
                'order_id'            => $order_id,
                'nama_pemesan'        => $namaPemesan,
                'lapangan_id'         => $lapanganId,
                'tanggal_pesan'       => $tanggal,
                'jam_mulai'           => $jamMulai,
                'jam_selesai'         => $jamSelesai,
                'catatan'             => $catatan,
                'total_bayar'         => $total_bayar,
                'status'              => 'pending'
            ]);
            
            $insertId = $pemesananModel->insertID();

            // Simpan fasilitas (jika ada)
            if (!empty($fasilitas)) {
                $rows = [];
                foreach ($fasilitas as $fId => $qty) {
                    if ($qty > 0) { // hanya simpan kalau qty > 0
                        $rows[] = [
                            'pemesanan_id' => $insertId,
                            'fasilitas_id' => $fId,
                            'qty'          => $qty
                        ];
                    }
                }
                if (!empty($rows)) {
                    $this->pemesananFasilitasModel->insertBatch($rows);
                }
            }

            // Midtrans
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => (int)$total_bayar
                ],
                'customer_details' => [
                    'first_name' => $namaPemesan,
                    'email' => 'customer@example.com',
                    'phone' => '08123456789'
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $id = $pemesananModel->getInsertID();
            $pemesananModel->update($id, ['snaptoken' => $snapToken]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pemesanan berhasil.',
                'total' => $total_bayar,
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal simpan pemesanan: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }


    public function updateStatus()
    {
        $pemesananModel = new \App\Models\PemesananModel();
        $data = $this->request->getJSON();

        // Cek status pembayaran
        $updateData = [
            'status' => $data->transaction_status,
            'payment_type' => $data->payment_type,
            'total_bayar' => $data->gross_amount
        ];

        // Tambahkan kode booking jika pembayaran settlement
        if ($data->transaction_status === 'settlement') {
            // Generate kode booking unik (misal: KBK-20250806-XXXX)
            $kodeBooking = 'KBK-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
            $updateData['kode_booking'] = $kodeBooking;
        }

        $pemesananModel->where('order_id', $data->order_id)
                    ->set($updateData)
                    ->update();

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $pemesananModel = new \App\Models\PemesananModel();
        $pemesanan = $pemesananModel->find($id);

        if (!$pemesanan) {
            return redirect()->to(base_url('pelanggan/pembayaran'))->with('error', 'Data tidak ditemukan.');
        }

        $pemesananModel->delete($id);

        return redirect()->to(base_url('pelanggan/pembayaran'))->with('success', 'Berhasil.');
    }

    

}
