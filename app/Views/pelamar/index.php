<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- HEADER -->

    <div class="flex flex-col md:flex-row
                md:items-center
                md:justify-between
                gap-4">

        <div>

            <h1 class="text-3xl font-bold">
                Manage Applicants
            </h1>

            <p class="text-gray-500 mt-1">
                Kandidat yang sudah <strong>lolos validasi administrasi</strong> dari Ranking SAW.
                Pelamar baru ada di menu <a href="<?= base_url('perhitungan') ?>" class="text-indigo-600 font-semibold hover:underline">Ranking SAW</a>.
            </p>

        </div>

    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-xl px-4 py-3 text-red-800 bg-red-50 border border-red-200">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-xl px-4 py-3 text-green-800 bg-green-50 border border-green-200">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- FILTER -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">

        <form
            action="<?= base_url('pelamar') ?>"
            method="get"
            class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end"
        >

            <!-- FILTER LOWONGAN -->
            <div class="md:col-span-3">

                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    Job Vacancy
                </label>

                <select
                    name="lowongan"
                    class="w-full h-12 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >

                    <option value="">
                        All Vacancies
                    </option>

                    <?php foreach($lowongan as $l): ?>

                        <option
                            value="<?= $l['id'] ?>"
                            <?= (request()->getGet('lowongan') == $l['id']) ? 'selected' : '' ?>
                        >
                            <?= $l['nama_pekerjaan'] ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- FILTER STATUS -->
            <div class="md:col-span-3">

                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    Recruitment Status
                </label>

                <select
                    name="status"
                    class="w-full h-12 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >

                    <option value="">
                        Semua Status (Lolos Administrasi+)
                    </option>

                    <option value="lolos administrasi"
                        <?= (request()->getGet('status') == 'lolos administrasi') ? 'selected' : '' ?>>
                        Lolos Administrasi
                    </option>

                    <option value="wawancara"
                        <?= (request()->getGet('status') == 'wawancara') ? 'selected' : '' ?>>
                        Wawancara
                    </option>

                    <option value="psikotes"
                        <?= (request()->getGet('status') == 'psikotes') ? 'selected' : '' ?>>
                        Psikotes
                    </option>

                    <option value="seleksi lanjutan"
                        <?= (request()->getGet('status') == 'seleksi lanjutan') ? 'selected' : '' ?>>
                        Seleksi Lanjutan
                    </option>

                    <option value="diterima"
                        <?= (request()->getGet('status') == 'diterima') ? 'selected' : '' ?>>
                        Diterima
                    </option>

                    <option value="ditolak"
                        <?= (request()->getGet('status') == 'ditolak') ? 'selected' : '' ?>>
                        Ditolak
                    </option>

                </select>

            </div>

            <!-- SEARCH -->
            <div class="md:col-span-3">

                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    Applicant Name
                </label>

                <div class="relative">

                    <span class="material-symbols-outlined absolute left-3 top-3 text-gray-400">
                        search
                    </span>

                    <input
                        type="text"
                        name="keyword"
                        value="<?= request()->getGet('keyword') ?>"
                        placeholder="Search..."
                        class="w-full h-12 pl-10 pr-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    >

                </div>

            </div>

            <!-- BUTTON -->
            <div class="md:col-span-3 flex gap-3">

                <button
                    type="submit"
                    class="flex-1 h-12 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-xl transition"
                >

                    Apply Filter

                </button>

                <a
                    href="<?= base_url('pelamar') ?>"
                    class="flex-1 h-12 border border-gray-300 rounded-xl flex items-center justify-center font-semibold text-gray-700 hover:bg-gray-100 transition"
                >

                    Reset

                </a>

            </div>

        </form>

    </div>

    <!-- TABLE -->

    <div class="bg-white
                rounded-2xl
                border
                overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nama Pelamar
                        </th>

                        <th class="px-6 py-4 text-left">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left">
                            Pendidikan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Lowongan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tanggal Lamar
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                            
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($pelamar)): ?>

                        <tr>

                            <td colspan="8"
                                class="text-center
                                       py-10
                                       text-gray-500">

                                Belum ada kandidat yang lolos validasi administrasi

                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php $no = 1; ?>

                    <?php foreach($pelamar as $p): ?>

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-6 py-4">
                            <?= $no++ ?>
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            <?= $p['nama_pelamar'] ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= $p['email'] ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= $p['pendidikan'] ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= $p['nama_pekerjaan'] ?? '-' ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= $p['tanggal_lamar'] ?>
                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-4">

                            <?php

                            $status = lamaran_status_from_row($p);

                            ?>

                            <?php if($status == 'diterima'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-green-100
                                             text-green-700
                                             font-semibold">

                                    Diterima

                                </span>

                            <?php elseif($status == 'ditolak'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-red-100
                                             text-red-700
                                             font-semibold">

                                    Ditolak

                                </span>

                            <?php elseif($status == 'menunggu validasi administrasi'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-cyan-100
                                             text-cyan-800
                                             font-semibold">

                                    Menunggu Validasi

                                </span>

                            <?php elseif($status == 'lolos administrasi'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-blue-100
                                             text-blue-700
                                             font-semibold">

                                    Lulus Administrasi

                                </span>

                            <?php elseif($status == 'wawancara'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-purple-100
                                             text-purple-700
                                             font-semibold">

                                    Wawancara

                                </span>

                            <?php elseif($status == 'psikotes'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-indigo-100
                                             text-indigo-700
                                             font-semibold">

                                    Psikotes

                                </span>

                            <?php elseif($status == 'seleksi lanjutan'): ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-orange-100
                                             text-orange-700
                                             font-semibold">

                                    Seleksi Lanjutan

                                </span>

                            <?php else: ?>

                                <span class="px-3 py-1
                                             rounded-full
                                             text-sm
                                             bg-yellow-100
                                             text-yellow-700
                                             font-semibold">

                                    Pending

                                </span>

                            <?php endif; ?>

                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-3">

                                <!-- DETAIL -->
                                <a href="<?= base_url(
                                    'pelamar/detail/'.$p['id_pelamar']
                                ) ?>"
                                   class="text-sky-600 hover:text-sky-800">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </a>

                                <!-- UPDATE STATUS -->
                                <a href="<?= base_url(
                                    'lamaran/proses/'.$p['id_lamaran']
                                ) ?>"
                                   class="text-blue-600 hover:text-blue-800">

                                    <span class="material-symbols-outlined">
                                        edit_note
                                    </span>

                                </a>

                                <!-- DELETE -->
                                <a href="<?= base_url(
                                    'pelamar/hapus/'.$p['id_pelamar']
                                ) ?>"
                                   onclick="return confirm('Yakin hapus pelamar?')"
                                   class="text-red-600 hover:text-red-800">

                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>

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
