<?php

namespace App\Models;

use CodeIgniter\Model;

class TahapanRekrutmenModel extends Model
{
    protected $table = 'tahapan_rekrutmen';

    protected $primaryKey = 'id_tahapan';

    protected $allowedFields = [
        'id_lamaran',
        'tahapan',
        'nama_tahap',
        'status',
        'catatan',
        'dokumen',
        'dokumen_filename',
        'dokumen_path',
        'dokumen_uploaded_at',
        'jenis_dokumen',
        'created_at',
    ];
}
