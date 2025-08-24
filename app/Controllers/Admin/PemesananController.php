<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FasilitasModel;
use App\Models\PemesananFasilitasModel;
use App\Models\PemesananModel;
use Dompdf\Dompdf; 
use Dompdf\Options; 

class PemesananController extends BaseController
{
    protected $pemesananModel, $fasilitasModel, $pemesananFasilitasModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
        $this->fasilitasModel = new FasilitasModel();
        $this->pemesananFasilitasModel = new PemesananFasilitasModel();
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
            // Range tanggal → join + where manual
            $pemesanan = $this->pemesananModel
                ->select('pemesanan.*, lapangan.nama AS nama_lapangan')
                ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                ->where('tanggal_pesan >=', $tanggalMulai)
                ->where('tanggal_pesan <=', $tanggalSelesai)
                ->orderBy('tanggal_pesan','ASC')
                ->findAll();

        } elseif (!empty($tanggalMulai)) {
            // Hanya tanggalMulai → tampilkan data tepat di tanggal tersebut
            $pemesanan      = $this->pemesananModel->getPemesananByDate($tanggalMulai);
            $tanggalSelesai = $tanggalMulai;

        } else {
            // Tidak ada filter → tampilkan data hari ini
            $tanggalMulai   = date('Y-m-d');
            $tanggalSelesai = date('Y-m-d');
            $pemesanan      = $this->pemesananModel->getPemesananByDate($tanggalMulai);
        }

        foreach ($pemesanan as $i => $item) {
            $fasilitas = $this->pemesananFasilitasModel
                ->where('pemesanan_id', $item['id'])
                ->join('fasilitas', 'fasilitas.id = pemesanan_fasilitas.fasilitas_id')
                ->findAll();

            $pemesanan[$i]['fasilitas'] = $fasilitas ?? null;
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

        foreach ($pemesanan as $i => $item) {
        $fasilitas = $this->pemesananFasilitasModel
            ->where('pemesanan_id', $item['id'])
            ->join('fasilitas', 'fasilitas.id = pemesanan_fasilitas.fasilitas_id')
            ->findAll();

        $pemesanan[$i]['fasilitas'] = $fasilitas ?? null;
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
        $pelangganModel = new \App\Models\UserModel();
        $data = [
            'title' => 'Tambah Pemesanan',
            'lapangan' => $lapanganModel->findAll(),
            'fasilitas' => $this->fasilitasModel->findAll(),
            'pelanggan' => $pelangganModel->getPelanggan(),
        ];
        return view('admin/pemesanan/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        // Aturan validasi input
        $rules = [
            'nama_pemesan'      => 'required',
            'no_hp'             => 'required|numeric',
            'email'             => 'required|valid_email',
            'lapangan_id'       => 'required',
            'tanggal_pesan'     => 'required',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'total_bayar'       => 'required'
        ];

        // Jalankan validasi
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Mohon periksa kembali inputan Anda.')
                ->with('validation', $validation);
        }

        // Ambil post
        $data = $this->request->getPost();

        // Siapkan data fasilitas (jika ada)
        $fasilitas = isset($data['fasilitas']) ? $data['fasilitas'] : [];

        // Generate kolom tambahan
        $data['order_id']     = uniqid();
        $data['kode_booking'] = 'KBK-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $data['status']       = 'settlement';
        $data['payment_type'] = 'cash';

        // Jika tidak memilih user → biarkan user_id NULL (jangan ikut disimpan)
        if (empty($data['user_id'])) {
            unset($data['user_id']);
        }

        // Hapus field yg tidak perlu disimpan
        unset(
            $data['csrf_test_name'],
            $data['harga_lapangan'],
            $data['harga_fasilitas'],
            $data['fasilitas'],      // sudah dipisah di atas
            $data['no_hp'],          // jika kamu TIDAK mau simpannya ke tabel pemesanan, hapus ini
            $data['email']           // -- jika mau simpan, pindahkan ke tabel pemesanan
        );

        // Simpan data pemesanan
        $this->pemesananModel->save($data);
        $insertId = $this->pemesananModel->insertID();

        // Simpan fasilitas (jika ada yang dipilih)
        if (!empty($fasilitas)) {
            $rows = [];
            foreach ($fasilitas as $fId => $qty) {
                $rows[] = [
                    'pemesanan_id' => $insertId,
                    'fasilitas_id' => $fId,
                    'qty'          => $qty
                ];
            }
            $this->pemesananFasilitasModel->insertBatch($rows);
        }

        return redirect()->to(base_url('admin/pemesanan'))
            ->with('success', 'Data pemesanan berhasil ditambahkan.');
    }

}

