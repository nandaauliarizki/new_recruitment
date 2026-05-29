<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-[#201b11]">Ranking Results</h1>
        <p class="text-gray-500 mt-1">
            Semua pelamar lowongan ini — ranking SAW, lalu validasi dokumen via <strong>Seleksi &amp; Dokumen</strong>.
            Setelah disetujui, kandidat muncul di Manage Applicants.
        </p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#f5efe6] border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Rank</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Candidate</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Final Score</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($hasil as $h):
                $st = lamaran_status_from_row(['status' => $h['status']]);
            ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-5">
                        <?php if ($no == 1): ?>
                            <span class="bg-yellow-400 text-black px-3 py-1 rounded-lg font-bold">#<?= $no ?></span>
                        <?php else: ?>
                            <span class="bg-gray-200 px-3 py-1 rounded-lg font-semibold">#<?= $no ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-5">
                        <h3 class="font-semibold text-[#201b11]"><?= esc($h['nama']) ?></h3>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-lg font-bold text-yellow-600"><?= number_format($h['nilai'], 3) ?></span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold <?= lamaran_status_badge_class($st) ?> text-white">
                            <?= lamaran_status_label($st) ?>
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col gap-2 items-center min-w-[200px]">
                            <?php if ($st === 'pending'): ?>
                                <a href="<?= base_url('perhitungan/luluskan/' . $h['id_lamaran']) ?>"
                                   class="text-sm text-center bg-blue-100 text-blue-800 px-3 py-2 rounded-lg font-semibold hover:bg-blue-200"
                                   onclick="return confirm('Tandai pelamar menunggu validasi dokumen administrasi?');">
                                    Tandai Menunggu Validasi
                                </a>
                            <?php endif; ?>

                            <a href="<?= base_url('lamaran/seleksi/' . $h['id_lamaran']) ?>"
                               class="bg-yellow-400 text-black px-4 py-2 rounded-lg text-sm font-semibold text-center hover:opacity-90">
                                Validasi Berkas
                            </a>

                            <!-- <form method="post" action="<?= base_url('lamaran/update-status') ?>" class="w-full">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_lamaran" value="<?= $h['id_lamaran'] ?>">
                                <select name="status" class="border rounded-lg px-2 py-1 text-sm w-full">
                                    <option value="pending">Pending</option>
                                    <option value="menunggu validasi administrasi">Menunggu Validasi</option>
                                    <option value="lolos administrasi">Lolos Administrasi</option>
                                    <option value="wawancara">Wawancara</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="diterima">Diterima</option>
                                </select>
                                <button type="submit" class="mt-1 w-full bg-gray-800 text-white px-2 py-1 rounded text-xs">Update</button>
                            </form> -->
                        </div>
                    </td>
                </tr>
            <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
