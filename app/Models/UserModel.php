<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    const ADMIN = 'admin';
    const PELANGGAN = 'pelanggan';

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'email', 'no_hp', 'alamat', 'password'];

    public function getPelanggan()
    {
        return $this->where('role', self::PELANGGAN)->findAll();
    }

    /**
     * Cari pelanggan by keyword (nama/email), return maksimal N baris.
     */
    public function searchPelanggan(string $q = '', int $limit = 20): array
    {
        $builder = $this->where('role', self::PELANGGAN);

        if ($q !== '') {
            $builder = $builder->groupStart()
                        ->like('nama', $q)
                        ->orLike('email', $q)
                      ->groupEnd();
        }

        return $builder->orderBy('nama', 'ASC')
                       ->select('id, nama, email, no_hp')
                       ->limit($limit)
                       ->find();
    }
}
