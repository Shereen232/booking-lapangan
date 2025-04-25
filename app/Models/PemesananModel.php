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

    protected $useTimestamps = true;

    public function getWithRelations()
    {
        return $this->select('pemesanan.*, users.nama as nama_pelanggan, lapangan.nama as nama_lapangan')
                    ->join('users', 'users.id = pemesanan.user_id')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id');
    }

    public function getWithRelationUserId($id)
    {
        return $this->select('pemesanan.*, pemesanan.status as status_pembayaran, lapangan.*')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->where('user_id', $id)
                    ->findAll();
    }

    public function getWithRelationsLapangan()
    {
        return $this->select('pemesanan.*, lapangan.nama as nama_lapangan')
                    ->join('lapangan', 'lapangan.id = pemesanan.lapangan_id')
                    ->findAll();
    }

}
