<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananFasilitasModel extends Model
{
    protected $table = 'pemesanan_fasilitas';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'pemesanan_id',
        'fasilitas_id',
        'qty',
    ];
}
