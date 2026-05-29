-- Jalankan jika migration spark belum dijalankan
-- Database: rekrutmen

-- Kolom status lamaran (wajib untuk sinkronisasi status)
ALTER TABLE `lamaran`
  ADD COLUMN `status_lamaran` VARCHAR(100) NULL AFTER `status`;

ALTER TABLE `lamaran`
  ADD COLUMN `status_terakhir` VARCHAR(100) NULL AFTER `status_lamaran`;

-- Jika error "Duplicate column", lewati baris di atas dan lanjut ke bawah.

ALTER TABLE `pelamar`
  ADD COLUMN IF NOT EXISTS `no_telepon` VARCHAR(20) NULL AFTER `email`,
  ADD COLUMN IF NOT EXISTS `tanggal_lahir` DATE NULL AFTER `no_telepon`;

ALTER TABLE `lamaran`
  ADD COLUMN IF NOT EXISTS `cv_filename` VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS `cv_path` VARCHAR(500) NULL,
  ADD COLUMN IF NOT EXISTS `cv_uploaded_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `surat_lamaran_filename` VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS `surat_lamaran_path` VARCHAR(500) NULL,
  ADD COLUMN IF NOT EXISTS `surat_lamaran_uploaded_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `ijazah_filename` VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS `ijazah_path` VARCHAR(500) NULL,
  ADD COLUMN IF NOT EXISTS `ijazah_uploaded_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `dokumen_pendukung_filename` VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS `dokumen_pendukung_path` VARCHAR(500) NULL,
  ADD COLUMN IF NOT EXISTS `dokumen_pendukung_uploaded_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `admin_validated_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `admin_validated_by` INT UNSIGNED NULL;

ALTER TABLE `tahapan_rekrutmen`
  ADD COLUMN IF NOT EXISTS `dokumen_filename` VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS `dokumen_path` VARCHAR(500) NULL,
  ADD COLUMN IF NOT EXISTS `dokumen_uploaded_at` DATETIME NULL,
  ADD COLUMN IF NOT EXISTS `jenis_dokumen` VARCHAR(100) NULL;

-- Sinkronkan status lama (opsional, jalankan sekali)
UPDATE `lamaran`
SET
  `status_lamaran` = COALESCE(NULLIF(LOWER(TRIM(`status_lamaran`)), ''), LOWER(TRIM(`status`))),
  `status_terakhir` = COALESCE(NULLIF(LOWER(TRIM(`status_terakhir`)), ''), LOWER(TRIM(`status`))),
  `status` = COALESCE(NULLIF(LOWER(TRIM(`status`)), ''), LOWER(TRIM(`status_lamaran`)))
WHERE `status` IS NOT NULL OR `status_lamaran` IS NOT NULL;
