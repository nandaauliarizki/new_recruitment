<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Edit Data Pelamar</h1>
        <p class="text-gray-500 mt-1">Perbarui informasi pelamar</p>
    </div>

    <!-- FORM -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">

        <form action="<?= base_url('pelamar/update/' . $pelamar['id_pelamar']) ?>"
              method="post"
              class="space-y-5">

            <?= csrf_field() ?>

            <div>
                <label class="block font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama"
                       value="<?= esc($pelamar['nama_pelamar']) ?>"
                       required
                       class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block font-semibold mb-2">Email</label>
                <input type="email" name="email"
                       value="<?= esc($pelamar['email']) ?>"
                       required
                       class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block font-semibold mb-2">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan"
                       value="<?= esc($pelamar['pendidikan']) ?>"
                       class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block font-semibold mb-2">Pengalaman (tahun)</label>
                <input type="number" name="pengalaman"
                       value="<?= esc($pelamar['pengalaman']) ?>"
                       min="0"
                       class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="flex gap-4 pt-2">
                <a href="<?= base_url('pelamar') ?>"
                   class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 transition font-semibold">
                    Batal
                </a>
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 px-8 py-3 rounded-xl font-bold transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>
