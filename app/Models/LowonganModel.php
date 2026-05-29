<?php

namespace App\Models;

use CodeIgniter\Model;

class LowonganModel extends Model
{
    protected $table      = 'lowongan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_pekerjaan',
        'deskripsi',
        'start_date',
        'end_date',
        'status',
    ];

    public function getActiveJobs()
    {
        return $this->where('status', 'active')
                    ->where('end_date >=', date('Y-m-d'))
                    ->findAll();
    }
}
