-- ============================================================
-- DUMMY DATA untuk E-Recruitment
-- ============================================================

-- Lowongan tambahan
INSERT IGNORE INTO lowongan (id, nama_pekerjaan, deskripsi, created_at) VALUES
(11, 'Backend Developer',    'Pengembang API dan sistem backend dengan PHP/Laravel atau Node.js. Min S1, pengalaman 3+ tahun.', '2026-05-01 08:00:00'),
(12, 'Data Analyst',         'Menganalisis data bisnis dan membuat laporan. Menguasai SQL, Python, Excel. Min S1 Statistik/Matematika.', '2026-05-05 09:00:00'),
(13, 'HR Specialist',        'Mengelola rekrutmen, administrasi kepegawaian, dan hubungan industrial. Min S1 Psikologi/Manajemen.', '2026-05-05 09:00:00'),
(14, 'Marketing Executive',  'Merancang dan menjalankan kampanye digital marketing. Min D3, pengalaman 1+ tahun di bidang marketing.', '2026-05-10 10:00:00');

-- Users baru (role pelamar) - password 123456
INSERT IGNORE INTO users (id_user, nama, email, password, role) VALUES
(13, 'Budi Santoso',     'budi.santoso@gmail.com',    'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(14, 'Siti Rahayu',      'siti.rahayu@gmail.com',     'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(15, 'Agus Permana',     'agus.permana@gmail.com',    'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(16, 'Dewi Kurniawati',  'dewi.kurnia@gmail.com',     'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(17, 'Eko Prasetyo',     'eko.prasetyo@gmail.com',    'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(18, 'Fina Anggraini',   'fina.anggraini@gmail.com',  'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(19, 'Gilang Ramadhan',  'gilang.ramadhan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(20, 'Hana Pratiwi',     'hana.pratiwi@gmail.com',    'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(21, 'Irfan Hidayat',    'irfan.hidayat@gmail.com',   'e10adc3949ba59abbe56e057f20f883e', 'pelamar'),
(22, 'Julia Wulandari',  'julia.wulandari@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pelamar');

-- Data Pelamar
INSERT IGNORE INTO pelamar (id_pelamar, nama_pelamar, email, pendidikan, pengalaman, tanggal_lamar, status, id_user) VALUES
(17, 'Budi Santoso',    'budi.santoso@gmail.com',    'S1', 3, '2026-05-02', 'pending',     13),
(18, 'Siti Rahayu',     'siti.rahayu@gmail.com',     'S1', 1, '2026-05-03', 'pending',     14),
(19, 'Agus Permana',    'agus.permana@gmail.com',    'S2', 5, '2026-05-03', 'pending',     15),
(20, 'Dewi Kurniawati', 'dewi.kurnia@gmail.com',     'S1', 2, '2026-05-06', 'pending',     16),
(21, 'Eko Prasetyo',    'eko.prasetyo@gmail.com',    'D3', 4, '2026-05-06', 'pending',     17),
(22, 'Fina Anggraini',  'fina.anggraini@gmail.com',  'S1', 2, '2026-05-08', 'pending',     18),
(23, 'Gilang Ramadhan', 'gilang.ramadhan@gmail.com', 'S1', 1, '2026-05-11', 'pending',     19),
(24, 'Hana Pratiwi',    'hana.pratiwi@gmail.com',    'S2', 6, '2026-05-12', 'lolos_saw',   20),
(25, 'Irfan Hidayat',   'irfan.hidayat@gmail.com',   'S1', 3, '2026-05-13', 'pending',     21),
(26, 'Julia Wulandari', 'julia.wulandari@gmail.com', 'S1', 2, '2026-05-14', 'tidak_lolos', 22);

-- Lamaran dengan berbagai status
INSERT IGNORE INTO lamaran (id_lamaran, id_pelamar, id_lowongan, tanggal, status, status_lamaran) VALUES
(15, 17, 10, '2026-05-02 09:30:00', 'pending',  'pending'),
(16, 18, 11, '2026-05-03 10:15:00', 'pending',  'pending'),
(17, 19, 10, '2026-05-03 11:00:00', 'diterima', 'diterima'),
(18, 20, 12, '2026-05-06 08:45:00', 'pending',  'pending'),
(19, 21, 14, '2026-05-06 13:20:00', 'ditolak',  'ditolak'),
(20, 22, 13, '2026-05-08 09:00:00', 'pending',  'pending'),
(21, 23, 11, '2026-05-11 14:30:00', 'pending',  'pending'),
(22, 24, 10, '2026-05-12 08:00:00', 'diterima', 'diterima'),
(23, 25, 12, '2026-05-13 10:00:00', 'proses',   'proses'),
(24, 26, 14, '2026-05-14 11:00:00', 'ditolak',  'ditolak'),
(25, 17, 11, '2026-05-15 09:30:00', 'pending',  'pending'),
(26, 18, 12, '2026-05-16 10:00:00', 'pending',  'pending');

-- Tahapan rekrutmen untuk beberapa lamaran
INSERT INTO tahapan_rekrutmen (id_lamaran, tahap, tahapan, status, catatan, created_at) VALUES
(17, 'Seleksi Administrasi', 'Seleksi Administrasi', 'lulus',  'Dokumen lengkap dan memenuhi syarat', '2026-05-04 09:00:00'),
(17, 'Tes Teknis',           'Tes Teknis',           'lulus',  'Nilai tes coding 85/100, sangat baik', '2026-05-07 10:00:00'),
(17, 'Interview HR',         'Interview HR',          'lulus',  'Komunikasi baik, motivasi tinggi', '2026-05-10 14:00:00'),
(22, 'Seleksi Administrasi', 'Seleksi Administrasi', 'lulus',  'Semua dokumen lengkap', '2026-05-13 09:00:00'),
(22, 'Tes Teknis',           'Tes Teknis',           'lulus',  'Portofolio sangat bagus', '2026-05-15 10:00:00'),
(19, 'Seleksi Administrasi', 'Seleksi Administrasi', 'gagal',  'Pengalaman tidak sesuai persyaratan', '2026-05-07 09:00:00'),
(23, 'Seleksi Administrasi', 'Seleksi Administrasi', 'lulus',  'Dokumen lengkap', '2026-05-14 09:00:00'),
(23, 'Tes Kemampuan',        'Tes Kemampuan',         'proses', 'Menunggu hasil tes analitik', '2026-05-16 10:00:00');

-- Update AUTO_INCREMENT
ALTER TABLE lowongan   AUTO_INCREMENT = 15;
ALTER TABLE users      AUTO_INCREMENT = 23;
ALTER TABLE pelamar    AUTO_INCREMENT = 27;
ALTER TABLE lamaran    AUTO_INCREMENT = 27;
