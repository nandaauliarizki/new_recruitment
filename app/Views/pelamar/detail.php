<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex items-center gap-4">
        <a href="<?= base_url('pelamar') ?>"
           class="flex items-center gap-2 text-gray-500 hover:text-gray-800 transition">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <div>
        <h1 class="text-3xl font-bold">Detail Pelamar</h1>
        <p class="text-gray-500 mt-1">Informasi lengkap dan riwayat lamaran</p>
    </div>

    <!-- PROFIL -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">

        <div class="flex items-center gap-5 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-yellow-400 flex items-center justify-center text-2xl font-bold text-black">
                <?= strtoupper(substr($pelamar['nama_pelamar'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-2xl font-bold"><?= esc($pelamar['nama_pelamar']) ?></h2>
                <p class="text-gray-500"><?= esc($pelamar['email']) ?></p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pendidikan</p>
                <p class="font-semibold"><?= esc($pelamar['pendidikan']) ?: '-' ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">No HP</p>
                <p class="font-semibold"><?= esc($pelamar['no_hp'] ?? '-') ?></p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Jenis Kelamin</p>
                <p class="font-semibold"><?= esc($pelamar['jenis_kelamin'] ?? '-') ?></p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                <p class="font-semibold">
                    <?= esc($pelamar['tempat_lahir'] ?? '-') ?>,
                    <?= !empty($pelamar['tanggal_lahir']) ? date('d M Y', strtotime($pelamar['tanggal_lahir'])) : '-' ?>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tanggal Daftar</p>
                <p class="font-semibold">
                    <?= $pelamar['tanggal_lamar'] ? date('d M Y', strtotime($pelamar['tanggal_lamar'])) : '-' ?>
                </p>
            </div>
        </div>

    </div>

    <!-- RIWAYAT LAMARAN -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-lg">Riwayat Lamaran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Posisi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Dokumen</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($lamaran)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-400">
                                Belum ada lamaran
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach($lamaran as $l):
                        $st = lamaran_status_from_row($l);
                        $docs = $lamaranModel->getDocumentMap($l);
                    ?>
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-6 py-4"><?= $no++ ?></td>
                        <td class="px-6 py-4 font-semibold"><?= esc($l['nama_pekerjaan']) ?></td>
                        <td class="px-6 py-4 text-gray-500">
                            <?= $l['tanggal'] ? date('d M Y', strtotime($l['tanggal'])) : '-' ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= lamaran_status_badge_class($st) ?> text-white">
                                <?= lamaran_status_label($st) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if (empty($docs)): ?>
                                <span class="text-gray-400 text-sm">—</span>
                            <?php else: ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($docs as $type => $doc): ?>
                                        <a href="<?= base_url('lamaran/download/' . $l['id_lamaran'] . '/' . $type) ?>"
                                           class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded-lg font-medium"
                                           target="_blank" title="<?= esc($doc['label']) ?>">
                                            <?= esc($doc['label']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?= base_url('lamaran/proses/' . $l['id_lamaran']) ?>"
                               class="text-blue-600 hover:text-blue-800">
                                <span class="material-symbols-outlined">edit_note</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
