<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKriteriaModel extends Model
{
    protected $table = 'sub_kriteria';

    protected $primaryKey = 'id_sub';

    protected $allowedFields = [
        'id_kriteria',
        'nama_sub',
        'nilai'
    ];
}