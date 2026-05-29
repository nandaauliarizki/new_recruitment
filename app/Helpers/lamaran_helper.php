<?php

use App\Libraries\LamaranStatusService;
use Config\Database;

if (! function_exists('sync_lamaran_status')) {
    function sync_lamaran_status(int $idLamaran, string $status): bool
    {
        return LamaranStatusService::sync(Database::connect(), $idLamaran, $status);
    }
}

if (! function_exists('lamaran_status_label')) {
    function lamaran_status_label(string $status): string
    {
        return LamaranStatusService::label($status);
    }
}

if (! function_exists('lamaran_status_normalize')) {
    function lamaran_status_normalize(string $status): string
    {
        return LamaranStatusService::normalize($status);
    }
}

if (! function_exists('lamaran_status_from_row')) {
    function lamaran_status_from_row(array $row): string
    {
        return LamaranStatusService::resolveFromRow($row);
    }
}

if (! function_exists('lamaran_status_badge_class')) {
    function lamaran_status_badge_class(string $status): string
    {
        return match (lamaran_status_normalize($status)) {
            LamaranStatusService::DITERIMA           => 'bg-success',
            LamaranStatusService::DITOLAK            => 'bg-danger',
            LamaranStatusService::LULUS_ADMINISTRASI => 'bg-primary',
            LamaranStatusService::MENUNGGU_VALIDASI  => 'bg-info text-dark',
            LamaranStatusService::WAWANCARA          => 'bg-info',
            LamaranStatusService::PSIKOTES           => 'bg-secondary',
            LamaranStatusService::SELEKSI_LANJUTAN   => 'bg-warning text-dark',
            default                                  => 'bg-warning text-dark',
        };
    }
}
