<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

/**
 * Menjaga sinkronisasi status lamaran di seluruh sistem.
 */
class LamaranStatusService
{
    public const PENDING = 'pending';

    public const MENUNGGU_VALIDASI = 'menunggu validasi administrasi';

    public const LULUS_ADMINISTRASI = 'lolos administrasi';

    public const WAWANCARA = 'wawancara';

    public const PSIKOTES = 'psikotes';

    public const SELEKSI_LANJUTAN = 'seleksi lanjutan';

    public const DITERIMA = 'diterima';

    public const DITOLAK = 'ditolak';

    /** @var list<string>|null */
    private static ?array $statusColumns = null;

    /**
     * Kolom status yang benar-benar ada di tabel lamaran.
     *
     * @return list<string>
     */
    public static function statusColumns(BaseConnection $db): array
    {
        if (self::$statusColumns !== null) {
            return self::$statusColumns;
        }

        $columns = [];

        if ($db->fieldExists('status', 'lamaran')) {
            $columns[] = 'status';
        }
        if ($db->fieldExists('status_lamaran', 'lamaran')) {
            $columns[] = 'status_lamaran';
        }
        if ($db->fieldExists('status_terakhir', 'lamaran')) {
            $columns[] = 'status_terakhir';
        }

        self::$statusColumns = $columns;

        return $columns;
    }

    public static function resetColumnCache(): void
    {
        self::$statusColumns = null;
    }

    /**
     * Payload update/insert status — hanya field yang ada di DB.
     *
     * @return array<string, string>
     */
    public static function statusPayload(BaseConnection $db, string $status): array
    {
        $normalized = self::normalize($status);
        $payload    = [];

        foreach (self::statusColumns($db) as $column) {
            $payload[$column] = $normalized;
        }

        return $payload;
    }

    /**
     * Ekspresi SQL untuk mengambil status kanonis (ranking, laporan).
     */
    public static function statusSelectExpression(BaseConnection $db, string $alias = 'l'): string
    {
        $parts = [];

        if ($db->fieldExists('status_terakhir', 'lamaran')) {
            $parts[] = "NULLIF({$alias}.status_terakhir, '')";
        }
        if ($db->fieldExists('status_lamaran', 'lamaran')) {
            $parts[] = "NULLIF({$alias}.status_lamaran, '')";
        }
        if ($db->fieldExists('status', 'lamaran')) {
            $parts[] = "{$alias}.status";
        }

        if ($parts === []) {
            return "'pending'";
        }

        return count($parts) === 1 ? $parts[0] : 'COALESCE(' . implode(', ', $parts) . ')';
    }

    public static function normalize(string $status): string
    {
        $status = strtolower(trim($status));

        $aliases = [
            'diproses'           => self::PENDING,
            'lulus administrasi' => self::LULUS_ADMINISTRASI,
            'lolos administrasi' => self::LULUS_ADMINISTRASI,
            'interview'          => self::WAWANCARA,
            'tes psikotes'       => self::PSIKOTES,
            'hired'              => self::DITERIMA,
        ];

        return $aliases[$status] ?? $status;
    }

    public static function label(string $status): string
    {
        $normalized = self::normalize($status);

        $labels = [
            self::PENDING              => 'Pending',
            self::MENUNGGU_VALIDASI  => 'Menunggu Validasi Administrasi',
            self::LULUS_ADMINISTRASI => 'Lolos Administrasi',
            self::WAWANCARA          => 'Wawancara',
            self::PSIKOTES           => 'Psikotes',
            self::SELEKSI_LANJUTAN   => 'Seleksi Lanjutan',
            self::DITERIMA           => 'Diterima',
            self::DITOLAK            => 'Ditolak',
        ];

        return $labels[$normalized] ?? ucwords($normalized);
    }

    public static function sync(BaseConnection $db, int $idLamaran, string $status): bool
    {
        return $db->table('lamaran')
            ->where('id_lamaran', $idLamaran)
            ->update([
                'status' => $status,
                'status_lamaran' => $status,
            ]);
    }

    public static function resolveFromRow(array $row): string
    {
        foreach (['status_terakhir', 'status_lamaran', 'status'] as $field) {
            if (! empty($row[$field])) {
                return self::normalize((string) $row[$field]);
            }
        }

        return self::PENDING;
    }

    /**
     * Status yang boleh tampil di Manage Applicants (setelah validasi administrasi).
     *
     * @return list<string>
     */
    public static function manageEligibleStatuses(): array
    {
        return [
            self::LULUS_ADMINISTRASI,
            self::WAWANCARA,
            self::PSIKOTES,
            self::SELEKSI_LANJUTAN,
            self::DITERIMA,
            self::DITOLAK,
        ];
    }

    /**
     * Status yang masih di tahap ranking / validasi dokumen (belum masuk manage).
     *
     * @return list<string>
     */
    public static function rankingPhaseStatuses(): array
    {
        return [
            self::PENDING,
            self::MENUNGGU_VALIDASI,
        ];
    }

    public static function isManageEligible(string $status): bool
    {
        return in_array(self::normalize($status), self::manageEligibleStatuses(), true);
    }

    public static function isRankingPhase(string $status): bool
    {
        return in_array(self::normalize($status), self::rankingPhaseStatuses(), true);
    }

    /**
     * @param list<array<string, mixed>> $rows
     *
     * @return list<array<string, mixed>>
     */
    public static function filterManageRows(array $rows): array
    {
        return array_values(array_filter(
            $rows,
            static fn (array $row): bool => self::isManageEligible(self::resolveFromRow($row))
        ));
    }
}
