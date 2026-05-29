<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
 {
    protected $table = 'penilaian';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'id_lamaran',
        'id_kriteria',
        'nilai'

    ];
}