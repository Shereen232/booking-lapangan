<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\PemesananFasilitasModel;
use App\Models\PemesananModel;

class JadwalController extends BaseController
{
    protected $pembayaranModel, $pemesananFasilitasModel;

    public function __construct()
    {
        $this->pembayaranModel = new PemesananModel();
        $this->pemesananFasilitasModel = new PemesananFasilitasModel();
    }

    // Tampilkan daftar lapangan
    public function index()
    {
        $session = session();

        // Ambil data satu per satu
        $userId = $session->get('user_id');
        $datas = $this->pembayaranModel->getJadwalByUserId($userId);
        foreach ($datas as $key => $item) {
            $fasilitas = $this->pemesananFasilitasModel
                ->where('pemesanan_id', $item['id_pesanan'])
                ->join('fasilitas', 'fasilitas.id = pemesanan_fasilitas.fasilitas_id')
                ->findAll();

            $datas[$key]['fasilitas'] = json_encode($fasilitas) ?? null;
        }
        $data['jadwals'] = $datas;
        return view('pelanggan/jadwal-saya/index', $data);
    }

}
