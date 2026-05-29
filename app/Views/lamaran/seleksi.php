<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold">Seleksi Kandidat</h1>
        <p class="text-gray-500 mt-1">Validasi dokumen dan kelola status seleksi</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-xl"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-xl"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nama Pelamar</p>
                <h3 class="font-bold text-lg"><?= esc($lamaran['nama_pelamar']) ?></h3>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Posisi Dilamar</p>
                <h3 class="font-bold text-lg"><?= esc($lamaran['nama_pekerjaan']) ?></h3>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Email</p>
                <p class="font-semibold"><?= esc($lamaran['email']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Status Saat Ini</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= lamaran_status_badge_class($status) ?> text-white">
                    <?= lamaran_status_label($status) ?>
                </span>
            </div>
        </div>
    </div>

    <?= view('lamaran/_dokumen_admin', [
        'documents'  => $documents,
        'id_lamaran' => $lamaran['id_lamaran'],
    ]) ?>

    <!-- <?php if ($status !== 'admin_validated_at'): ?>
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-bold text-lg mb-3">Validasi Administrasi</h3>
        <p class="text-gray-600 mb-4">
            Setelah memeriksa keaslian ijazah dan dokumen lainnya, setujui pelamar untuk status
            <strong>Lolos Administrasi</strong>.
        </p>
        <form method="post" action="<?= base_url('lamaran/validasi-administrasi/' . $lamaran['id_lamaran']) ?>"
              onsubmit="return confirm('Setujui dokumen dan nyatakan Lolos Administrasi?');">
            <?= csrf_field() ?>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold">
                Setujui — Lolos Administrasi
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="alert alert-success rounded-xl">
        Dokumen administrasi telah disetujui
        <?= ! empty($lamaran['admin_validated_at']) ? ' pada ' . date('d M Y H:i', strtotime($lamaran['admin_validated_at'])) : '' ?>.
    </div>
    <?php endif; ?> -->

    <div class="bg-white rounded-2xl border p-6">
        <form method="post" action="<?= base_url('lamaran/update-seleksi') ?>" class="space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="id_lamaran" value="<?= $lamaran['id_lamaran'] ?>">

            
            <div>
                <label class="block font-semibold mb-2">Validasai Berkas Pelamar</label>
                <select name="status" required class="w-full h-12 px-4 rounded-xl border border-gray-300">
                    <option value="" selected disabled>--Validasi Berkas--</option>
                    <option value="lolos administrasi">Lolos Administrasi</option>
                    <option value="ditolak">Tidak Lolos Administrasi</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-2">Catatan</label>
                <textarea name="catatan" rows="4" class="w-full p-4 rounded-xl border border-gray-300"
                          placeholder="Tuliskan catatan seleksi..."></textarea>
            </div>

            <div class="flex gap-4">
                <a href="<?= base_url('pelamar') ?>" class="px-6 py-3 rounded-xl bg-gray-200 font-semibold">Batal</a>
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 px-8 py-3 rounded-xl font-bold">Simpan Status</button>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
