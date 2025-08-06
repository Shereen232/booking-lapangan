<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'order_id',
        'user_id', 
        'nama_pemesan',
        'kode_booking',
        'lapangan_id', 
        'tanggal_pesan', 
        'jam_mulai', 
        'jam_selesai',
        'total_bayar',
        'status',
        'payment_type',
        'catatan',
        'snaptoken',
        'tambahan_fasilitas'
    ];

    public function getPemesanan()
    {
        return $this->db->table('pemesanan')
                        ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                        ->join('users', 'users.id = pemesanan.user_id')
                        ->select('pemesanan.*, lapangan.nama as nama_lapangan, users.nama as nama_pemesan')
                        ->orderBy('pemesanan.id', 'DESC') // urutkan dari terbaru
                        ->get()->getResultArray(); 
    }

    public function getAllPemesanan()
    {
        return $this->select('pemesanan.*, users.nama as nama_pemesan, lapangan.nama as nama_lapangan')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->orderBy('pemesanan.id', 'DESC') // urutkan dari terbaru
                    ->findAll();
    }

    public function getPemesananByDate(string $date)
    {
        return $this->select('pemesanan.*, users.nama as nama_pemesan, lapangan.nama as nama_lapangan')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->where('pemesanan.tanggal_pesan', $date)
                    ->orderBy('pemesanan.tanggal_pesan', 'DESC') // urutkan dari terbaru
                    ->findAll();
    }

    public function getPemesananByDateRange(string $startDate, string $endDate)
    {
        return $this->select('pemesanan.*, lapangan.nama as nama_lapangan, users.nama as nama_pemesan')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->where('pemesanan.tanggal_pesan >=', $startDate)
                    ->where('pemesanan.tanggal_pesan <=', $endDate)
                    ->orderBy('pemesanan.tanggal_pesan', 'DESC') // urutkan dari terbaru
                    ->findAll();
    }

    public function getWithRelationUserId($userId)
    {
        return $this->select('pemesanan.*, pemesanan.status as status_pembayaran, pemesanan.id as id_pesanan, lapangan.*')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->where('user_id', $userId)
                    ->findAll();
    }

    public function getJadwalByUserId($id)
    {
        return $this->select('pemesanan.*, pemesanan.status as status_pembayaran, lapangan.*')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->where('user_id', $id)
                    ->where('pemesanan.status', 'settlement')
                    ->findAll();
    }

    public function getBookingByDate($id, $tanggal)
    {
        return $this->where('lapangan_id', $id)
                    ->where('tanggal_pesan', $tanggal)
                    ->orderBy('jam_mulai', 'ASC')
                    ->findAll();
    }
    
}