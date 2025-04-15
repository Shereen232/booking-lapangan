<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jam_buka',
        'jam_tutup',
        'harga_per_jam',
        'durasi_minimal',
        'kontak_admin',
        'foto_default'
    ];
}
