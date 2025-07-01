<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'order_id',
        'user_id', 
        'nama_pemesan',
        'lapangan_id', 
        'tanggal_pesan', 
        'jam_mulai', 
        'jam_selesai',
        'total_bayar',
        'status',
        'payment_type',
        'catatan',
        'snaptoken'
    ];

    public function getPemesanan()
    {
        return $this->db->table('pemesanan')
                        ->join('lapangan', 'lapangan.id = pemesanan.id_lapangan')
                        ->join('users', 'users.id = pemesanan.id_user')
                        ->select('pemesanan.*, lapangan.nama as nama_lapangan, users.nama as nama_pemesan')
                        ->get()->getResultArray(); 
    }

    public function getAllPemesanan()
    {
        return $this->select('pemesanan.*, users.nama as nama_pemesan, lapangan.nama as nama_lapangan')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->orderBy('pemesanan.tanggal_pesan', 'DESC')
                    ->orderBy('pemesanan.jam_mulai', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil data pemesanan berdasarkan tanggal.
     *
     * @param string $date Tanggal dalam format YYYY-MM-DD
     * @return array
     */
    public function getPemesananByDate(string $date)
    {
        return $this->select('pemesanan.*, users.nama as nama_pemesan, lapangan.nama as nama_lapangan')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->where('pemesanan.tanggal_pesan', $date)
                    ->orderBy('pemesanan.jam_mulai', 'ASC')
                    ->findAll();
    }

    public function getPemesananByDateRange(string $startDate, string $endDate)
    {
        $builder = $this->db->table('pemesanan')
                            ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                            ->join('users', 'users.id = pemesanan.user_id')
                            ->select('pemesanan.*, lapangan.nama as nama_lapangan, users.nama as nama_pemesan');

        // Menambahkan kondisi WHERE untuk rentang tanggal
        $builder->where('pemesanan.tanggal_pesan >=', $startDate);
        $builder->where('pemesanan.tanggal_pesan <=', $endDate);

        return $builder->get()->getResultArray();
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

    public function getBookingByDate($tanggal)
    {
        return $this->where('tanggal_pesan', $tanggal)->findAll();
    }
    
}