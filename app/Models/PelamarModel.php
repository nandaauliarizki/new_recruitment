<?php

namespace App\Models;

use CodeIgniter\Model;

class PelamarModel extends Model
{
    protected $table = 'pelamar';

    protected $primaryKey = 'id_pelamar';

    protected $allowedFields = [
        'nama_pelamar',
        'email',
        'no_hp',
        'tanggal_lahir',
        'pendidikan',
        'tanggal_lamar',
        'status',
        'id_user',
    ];
}
