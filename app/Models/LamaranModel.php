<?php

namespace App\Models;

use CodeIgniter\Model;

class LamaranModel extends Model
{
    protected $table = 'lamaran';

    protected $primaryKey = 'id_lamaran';

    protected $allowedFields = [
        'id_pelamar',
        'id_lowongan',
        'tanggal',
        'status',
        'status_lamaran',
        'status_terakhir',
        'cv_filename',
        'cv_path',
        'cv_uploaded_at',
        'surat_lamaran_filename',
        'surat_lamaran_path',
        'surat_lamaran_uploaded_at',
        'ijazah_filename',
        'ijazah_path',
        'ijazah_uploaded_at',
        'dokumen_pendukung_filename',
        'dokumen_pendukung_path',
        'dokumen_pendukung_uploaded_at',
        'admin_validated_at',
        'admin_validated_by',
    ];

    protected $useTimestamps = false;

    /**
     * Dokumen lamaran yang dapat diunduh admin/pelamar.
     *
     * @return array<string, array{label: string, filename: string, path: string}>
     */
    public function getDocumentMap(array $lamaran): array
    {
        $map = [];

        $types = [
            'cv'                 => ['label' => 'CV', 'filename' => 'cv_filename', 'path' => 'cv_path'],
            'surat_lamaran'      => ['label' => 'Surat Lamaran Kerja', 'filename' => 'surat_lamaran_filename', 'path' => 'surat_lamaran_path'],
            'ijazah'             => ['label' => 'Ijazah', 'filename' => 'ijazah_filename', 'path' => 'ijazah_path'],
            'dokumen_pendukung'  => ['label' => 'Dokumen Pendukung', 'filename' => 'dokumen_pendukung_filename', 'path' => 'dokumen_pendukung_path'],
        ];

        foreach ($types as $key => $meta) {
            if (! empty($lamaran[$meta['path']])) {
                $map[$key] = [
                    'label'    => $meta['label'],
                    'filename' => $lamaran[$meta['filename']] ?? basename($lamaran[$meta['path']]),
                    'path'     => $lamaran[$meta['path']],
                ];
            }
        }

        return $map;
    }
}
