# Feature Proposal — RecruitFlow E-Recruitment System

> Status: Draft | Tanggal: 2026-05-19  
> Scope: Fitur yang belum ada pada sistem saat ini, dikelompokkan berdasarkan role.

---

## Legend Prioritas

| Simbol | Prioritas |
|--------|-----------|
| 🔴 | Must-have — fungsionalitas inti yang hilang |
| 🟡 | Should-have — meningkatkan UX signifikan |
| 🟢 | Nice-to-have — value tambahan |

---

## 1. Admin Role

### 1.1 Manajemen Lamaran & Seleksi

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| A1 | **Bulk action pada lamaran** | 🔴 | Approve / reject / move stage beberapa pelamar sekaligus dari tabel |
| A2 | **Upload & viewer CV/Resume** | 🔴 | Pelamar upload CV saat melamar; admin bisa preview PDF langsung di browser |
| A3 | **Checklist dokumen per lowongan** | 🔴 | Admin menentukan dokumen wajib (KTP, Ijazah, Sertifikat) saat buat lowongan |
| A4 | **Penjadwalan interview** | 🔴 | Admin input tanggal, jam, lokasi/link meet untuk setiap tahap interview; notif otomatis ke pelamar |
| A5 | **Catatan internal per pelamar** | 🟡 | Private notes hanya terlihat oleh admin — rekam hasil interview, kesan, dll |
| A6 | **Template email / notifikasi** | 🟡 | Admin edit template email untuk tiap status (undangan interview, penolakan, penerimaan) |
| A7 | **Batas kuota pelamar per lowongan** | 🟡 | Set max jumlah pelamar; otomatis tutup pendaftaran jika kuota terpenuhi |
| A8 | **Withdraw / batalkan lamaran oleh admin** | 🟡 | Admin bisa hapus/batalkan lamaran tertentu tanpa hapus data pelamar |

### 1.2 Ranking & SAW

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| A9 | **Detail skor per kriteria** | 🔴 | Tampilkan breakdown nilai SAW tiap pelamar per kriteria (bukan hanya total) |
| A10 | **Perbandingan pelamar side-by-side** | 🟡 | Pilih 2–3 pelamar, tampilkan tabel perbandingan nilai kriteria |
| A11 | **Export ranking ke Excel / PDF** | 🟡 | Download hasil ranking SAW untuk laporan rekrutmen |
| A12 | **Simulasi bobot kriteria** | 🟢 | Admin bisa ubah bobot sementara dan lihat bagaimana ranking berubah tanpa simpan |

### 1.3 Dashboard & Analitik

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| A13 | **Grafik tren lamaran** | 🟡 | Chart jumlah lamaran per minggu/bulan per lowongan |
| A14 | **Funnel rekrutmen** | 🟡 | Visualisasi berapa pelamar di tiap tahap (apply → admin review → interview → offer) |
| A15 | **Statistik time-to-hire** | 🟢 | Rata-rata hari dari apply hingga keputusan final per lowongan |
| A16 | **Laporan rekrutmen (export)** | 🟡 | Export ringkasan rekrutmen per periode ke PDF/Excel |

### 1.4 Manajemen Lowongan

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| A17 | **Duplikasi lowongan** | 🟡 | Clone lowongan lama (termasuk kriteria SAW) untuk repost dengan tanggal baru |
| A18 | **Kategori / tag lowongan** | 🟡 | Tag: Full-time, Part-time, Remote, Divisi (IT, HR, Finance, dll) untuk filter lebih mudah |
| A19 | **Auto-publish terjadwal** | 🟢 | Lowongan dengan status Draft auto-berubah ke Active pada `start_date` |
| A20 | **Arsip lowongan expired** | 🟢 | Tab arsip untuk lowongan expired agar tidak memenuhi daftar aktif |

### 1.5 User & Akses

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| A21 | **Multi-role admin** | 🟡 | Pisahkan role: Super Admin, HR Manager, Interviewer — dengan hak akses berbeda |
| A22 | **Audit log aktivitas admin** | 🟢 | Rekam siapa mengubah apa dan kapan (status lamaran, data lowongan, dll) |

---

## 2. Pelamar (Applicant) Role

### 2.1 Profil & Dokumen

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| P1 | **Upload CV / Resume** | 🔴 | Upload PDF/DOC saat melamar atau dari halaman profil; bisa dipakai ulang |
| P2 | **Upload dokumen pendukung** | 🔴 | KTP, Ijazah, Sertifikat per lowongan sesuai checklist yang ditentukan admin |
| P3 | **Foto profil** | 🟡 | Upload foto profil; tampil di card pelamar di sisi admin |
| P4 | **Indikator kelengkapan profil** | 🟡 | Progress bar "Profil kamu 60% lengkap — tambahkan pengalaman kerja" |
| P5 | **Riwayat pendidikan & pengalaman kerja** | 🟡 | Form terstruktur untuk tambah riwayat (bukan hanya field teks bebas) |

### 2.2 Melamar & Tracking

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| P6 | **Cover letter per lamaran** | 🔴 | Textarea atau upload dokumen cover letter saat apply |
| P7 | **Timeline status lamaran** | 🔴 | Visualisasi progress tahapan: Apply → Review → Interview → Offer (seperti tracking paket) |
| P8 | **Tarik / batalkan lamaran** | 🟡 | Pelamar bisa withdraw lamaran selama status masih "Pending" |
| P9 | **Simpan lowongan (bookmark)** | 🟡 | Tandai lowongan untuk dilamar nanti |
| P10 | **Informasi jadwal interview** | 🔴 | Tampilkan tanggal, jam, lokasi/link meet yang sudah dijadwalkan admin |

### 2.3 Notifikasi

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| P11 | **Notifikasi in-app** | 🔴 | Bell icon dengan daftar notifikasi: status berubah, undangan interview, dll |
| P12 | **Email notifikasi** | 🟡 | Email otomatis saat status lamaran berubah atau ada jadwal interview baru |
| P13 | **Reminder deadline lowongan** | 🟢 | Notifikasi H-3 sebelum lowongan yang di-bookmark akan expired |

### 2.4 Pencarian & Rekomendasi

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| P14 | **Filter & cari lowongan** | 🔴 | Filter berdasarkan kategori, lokasi, tipe pekerjaan; full-text search |
| P15 | **Rekomendasi lowongan** | 🟢 | Tampilkan lowongan yang cocok berdasarkan pendidikan & pengalaman di profil |

### 2.5 Akun

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| P16 | **Lupa password / reset password** | 🔴 | Flow forgot password via email |
| P17 | **Ganti password** | 🟡 | Form ubah password di halaman pengaturan akun |
| P18 | **Login via Google / LinkedIn** | 🟢 | OAuth SSO untuk kemudahan registrasi |

---

## 3. Fitur Sistem / Lintas Role

| # | Fitur | Prioritas | Keterangan |
|---|-------|-----------|------------|
| S1 | **Email transaksional (SMTP)** | 🔴 | Konfigurasi SMTP untuk kirim semua email (notif status, reset password, undangan) |
| S2 | **Penyimpanan file terpusat** | 🔴 | Folder manajemen CV & dokumen dengan kontrol akses; integrasi local storage atau S3 |
| S3 | **Responsif mobile (pelamar portal)** | 🟡 | Portal pelamar perlu audit & perbaikan tampilan di layar kecil |
| S4 | **Halaman publik lowongan** | 🟡 | URL publik yang bisa dibagikan di luar sistem — tidak perlu login untuk melihat daftar lowongan |
| S5 | **REST API** | 🟢 | Endpoint API untuk integrasi mobile app atau sistem HR lain |
| S6 | **Two-Factor Authentication (2FA)** | 🟢 | Opsional 2FA untuk akun admin |
| S7 | **Bahasa konsisten (i18n)** | 🟡 | Unifikasi bahasa — saat ini campuran Indonesia/English di UI |

---

## Roadmap Rekomendasi

### Sprint 1 — Core Gaps (🔴 Must-have)
1. Upload CV & dokumen (P1, P2, A2, A3)
2. Email SMTP + notifikasi status (S1, P11, P12)
3. Reset password (P16)
4. Cover letter saat apply (P6)
5. Timeline status lamaran visual (P7)
6. Jadwal interview — input admin & tampil di pelamar (A4, P10)

### Sprint 2 — UX Improvements (🟡 Should-have)
1. Bulk action lamaran (A1)
2. Detail skor SAW per kriteria (A9)
3. Export ranking & laporan (A11, A16)
4. Filter & search lowongan untuk pelamar (P14)
5. Catatan internal admin (A5)
6. Duplikasi lowongan (A17)

### Sprint 3 — Value Add (🟢 Nice-to-have)
1. Grafik & analitik dashboard (A13, A14, A15)
2. Simulasi bobot SAW (A12)
3. Rekomendasi lowongan (P15)
4. Halaman publik lowongan (S4)
5. Auto-publish terjadwal (A19)
6. REST API (S5)

---

*Dokumen ini adalah proposal awal. Prioritas dapat berubah sesuai kebutuhan bisnis.*
