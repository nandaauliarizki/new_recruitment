<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRecruitmentDocumentsAndProfileFields extends Migration
{
    public function up()
    {
        // --- pelamar: profil pelamar ---
        $pelamarFields = [
            'no_telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'email',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'no_telepon',
            ],
        ];

        foreach ($pelamarFields as $field => $definition) {
            if (! $this->db->fieldExists($field, 'pelamar')) {
                $this->forge->addColumn('pelamar', [$field => $definition]);
            }
        }

        // --- lamaran: kolom status (jika belum ada) ---
        if (! $this->db->fieldExists('status_lamaran', 'lamaran')) {
            $this->forge->addColumn('lamaran', [
                'status_lamaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'status',
                ],
            ]);
        }

        if (! $this->db->fieldExists('status_terakhir', 'lamaran')) {
            $after = $this->db->fieldExists('status_lamaran', 'lamaran') ? 'status_lamaran' : 'status';
            $this->forge->addColumn('lamaran', [
                'status_terakhir' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => $after,
                ],
            ]);
        }

        // --- lamaran: dokumen lamaran ---
        $lamaranDocFields = [
            'cv_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cv_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'cv_uploaded_at' => ['type' => 'DATETIME', 'null' => true],
            'surat_lamaran_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'surat_lamaran_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'surat_lamaran_uploaded_at' => ['type' => 'DATETIME', 'null' => true],
            'ijazah_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ijazah_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'ijazah_uploaded_at' => ['type' => 'DATETIME', 'null' => true],
            'dokumen_pendukung_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dokumen_pendukung_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'dokumen_pendukung_uploaded_at' => ['type' => 'DATETIME', 'null' => true],
            'admin_validated_at' => ['type' => 'DATETIME', 'null' => true],
            'admin_validated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ];

        foreach ($lamaranDocFields as $field => $definition) {
            if (! $this->db->fieldExists($field, 'lamaran')) {
                unset($definition['after']);
                $this->forge->addColumn('lamaran', [$field => $definition]);
            }
        }

        // --- tahapan_rekrutmen: dokumen seleksi admin ---
        $tahapanFields = [
            'dokumen_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'dokumen'],
            'dokumen_path' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true, 'after' => 'dokumen_filename'],
            'dokumen_uploaded_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'dokumen_path'],
            'jenis_dokumen' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'dokumen_uploaded_at'],
        ];

        foreach ($tahapanFields as $field => $definition) {
            if (! $this->db->fieldExists($field, 'tahapan_rekrutmen')) {
                $this->forge->addColumn('tahapan_rekrutmen', [$field => $definition]);
            }
        }
    }

    public function down()
    {
        $lamaranDrop = [
            'cv_filename', 'cv_path', 'cv_uploaded_at',
            'surat_lamaran_filename', 'surat_lamaran_path', 'surat_lamaran_uploaded_at',
            'ijazah_filename', 'ijazah_path', 'ijazah_uploaded_at',
            'dokumen_pendukung_filename', 'dokumen_pendukung_path', 'dokumen_pendukung_uploaded_at',
            'admin_validated_at', 'admin_validated_by',
        ];

        foreach ($lamaranDrop as $field) {
            if ($this->db->fieldExists($field, 'lamaran')) {
                $this->forge->dropColumn('lamaran', $field);
            }
        }

        foreach (['no_telepon', 'tanggal_lahir'] as $field) {
            if ($this->db->fieldExists($field, 'pelamar')) {
                $this->forge->dropColumn('pelamar', $field);
            }
        }

        foreach (['dokumen_filename', 'dokumen_path', 'dokumen_uploaded_at', 'jenis_dokumen'] as $field) {
            if ($this->db->fieldExists($field, 'tahapan_rekrutmen')) {
                $this->forge->dropColumn('tahapan_rekrutmen', $field);
            }
        }
    }
}
