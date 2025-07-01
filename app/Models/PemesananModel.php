<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_lapangan', 'id_user', 'tanggal_pesan', 'jam_mulai', 'jam_selesai', 'total_bayar', 'status'];

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
    
}