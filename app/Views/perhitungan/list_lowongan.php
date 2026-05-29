<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- HEADER -->
    <div>

        <h1 class="text-3xl font-bold">
            Ranking SAW
        </h1>

        <p class="text-gray-500 mt-1">
            Semua pelamar masuk ranking SAW di sini. Setelah validasi dokumen &amp; administrasi,
            kandidat pindah ke <a href="<?= base_url('pelamar') ?>" class="text-indigo-600 font-semibold hover:underline">Manage Applicants</a>.
        </p>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nama Lowongan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Deskripsi
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($lowongan)): ?>

                        <tr>

                            <td colspan="4"
                                class="text-center py-10 text-gray-500">

                                Belum ada data lowongan

                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php $no = 1; ?>

                    <?php foreach($lowongan as $l): ?>

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-6 py-4">
                            <?= $no++ ?>
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            <?= $l['nama_pekerjaan'] ?>
                        </td>

                        <td class="px-6 py-4 text-gray-600">

                            <?= character_limiter(
                                $l['deskripsi'],
                                60
                            ) ?>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center">

                                <a href="<?= base_url(
                                    'perhitungan/hasil/'.$l['id']
                                ) ?>"
                                   class="bg-yellow-400
                                          hover:bg-yellow-500
                                          text-black
                                          px-4 py-2
                                          rounded-xl
                                          font-semibold
                                          flex items-center gap-2
                                          transition">

                                    <span class="material-symbols-outlined">
                                        leaderboard
                                    </span>

                                    Lihat Ranking

                                </a>

                            </div>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection() ?>