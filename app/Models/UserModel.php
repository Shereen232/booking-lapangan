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
}
