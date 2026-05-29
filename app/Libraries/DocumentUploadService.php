<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Upload aman dokumen PDF ke public/uploads/.
 */
class DocumentUploadService
{
    public const MAX_SIZE_KB = 5120; // 5 MB

    public const ALLOWED_MIME = 'application/pdf';

    public const ALLOWED_EXT = 'pdf';

    /**
     * @return array{filename: string, path: string, uploaded_at: string}
     */
    public function uploadPdf(UploadedFile $file, string $subDirectory): array
    {
        if (! $file->isValid()) {
            throw new \RuntimeException('File upload tidak valid atau gagal dikirim.');
        }

        if ($file->hasMoved()) {
            throw new \RuntimeException('File sudah diproses sebelumnya.');
        }

        $extension = strtolower($file->getClientExtension() ?? '');
        $mime      = $file->getMimeType();

        if ($extension !== self::ALLOWED_EXT) {
            throw new \RuntimeException('Hanya file PDF yang diperbolehkan.');
        }

        if ($mime !== self::ALLOWED_MIME && $mime !== 'application/octet-stream') {
            throw new \RuntimeException('Tipe file tidak valid. Unggah dokumen PDF.');
        }

        if ($file->getSizeByUnit('kb') > self::MAX_SIZE_KB) {
            throw new \RuntimeException('Ukuran file maksimal ' . self::MAX_SIZE_KB . ' KB (5 MB).');
        }

        $subdir = trim($subDirectory, '/');
        $target = FCPATH . 'uploads/' . $subdir;

        if (! is_dir($target) && ! mkdir($target, 0755, true) && ! is_dir($target)) {
            throw new \RuntimeException('Folder upload tidak dapat dibuat.');
        }

        $storedName = $file->getRandomName();

        if (! $file->move($target, $storedName, true)) {
            throw new \RuntimeException('Gagal menyimpan file ke server.');
        }

        $fullPath = $target . DIRECTORY_SEPARATOR . $storedName;

        if (! is_file($fullPath) || ! $this->isPdfFile($fullPath)) {
            @unlink($fullPath);
            throw new \RuntimeException('File ditolak karena bukan PDF yang valid.');
        }

        return [
            'filename'    => $file->getClientName(),
            'path'        => 'uploads/' . $subdir . '/' . $storedName,
            'uploaded_at' => date('Y-m-d H:i:s'),
        ];
    }

    private function isPdfFile(string $path): bool
    {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return false;
        }

        $header = fread($handle, 5);
        fclose($handle);

        return str_starts_with($header, '%PDF-');
    }

    public function deleteIfExists(?string $relativePath): void
    {
        if (empty($relativePath)) {
            return;
        }

        $full = FCPATH . ltrim(str_replace(['../', '..\\'], '', $relativePath), '/');

        if (is_file($full)) {
            @unlink($full);
        }
    }
}
