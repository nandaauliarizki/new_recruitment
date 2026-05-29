-- Perbaikan cepat: kolom database rekrutmen
-- Jalankan di phpMyAdmin / MySQL CLI

-- Profil pelamar
ALTER TABLE `pelamar`
  ADD COLUMN `no_telepon` VARCHAR(20) NULL AFTER `email`;

ALTER TABLE `pelamar`
  ADD COLUMN `tanggal_lahir` DATE NULL AFTER `no_telepon`;

-- (Lewati jika error Duplicate column)

-- Perbaikan cepat: kolom status lamaran

-- Tambah status_lamaran jika belum ada
SET @db := DATABASE();

SET @sql := (
    SELECT IF(
        COUNT(*) = 0,
        'ALTER TABLE `lamaran` ADD COLUMN `status_lamaran` VARCHAR(100) NULL AFTER `status`',
        'SELECT 1'
    )
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'lamaran' AND COLUMN_NAME = 'status_lamaran'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Tambah status_terakhir jika belum ada
SET @sql := (
    SELECT IF(
        COUNT(*) = 0,
        'ALTER TABLE `lamaran` ADD COLUMN `status_terakhir` VARCHAR(100) NULL AFTER `status_lamaran`',
        'SELECT 1'
    )
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'lamaran' AND COLUMN_NAME = 'status_terakhir'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Sinkron data lama
UPDATE `lamaran`
SET
  `status_lamaran` = COALESCE(`status_lamaran`, `status`),
  `status_terakhir` = COALESCE(`status_terakhir`, `status_lamaran`, `status`)
WHERE `status` IS NOT NULL;
