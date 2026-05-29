<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold">Update Tahap Rekrutmen</h1>
        <p class="text-gray-500 mt-1">Kelola proses seleksi dan unggah dokumen hasil seleksi</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-xl"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-xl"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger rounded-xl">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc(is_array($e) ? implode(', ', $e) : $e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Pelamar</p>
                <h3 class="font-bold text-lg"><?= esc($lamaran['nama_pelamar']) ?></h3>
            </div>
            <div>
                <p class="text-sm text-gray-500">Lowongan</p>
                <h3 class="font-bold text-lg"><?= esc($lamaran['nama_pekerjaan']) ?></h3>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
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

    <!-- <?php if ($status !== 'lolos administrasi'): ?>
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <form method="post" action="<?= base_url('lamaran/validasi-administrasi/' . $lamaran['id_lamaran']) ?>"
              class="flex flex-wrap items-center gap-4"
              onsubmit="return confirm('Setujui validasi administrasi?');">
            <?= csrf_field() ?>
            <span class="text-amber-900">Dokumen belum divalidasi administrasi.</span>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                Setujui Lolos Administrasi
            </button>
        </form>
    </div>
    <?php endif; ?> -->

    <div class="bg-white rounded-2xl border p-6">
        <h2 class="text-xl font-bold mb-4">Upload Dokumen Seleksi (Admin)</h2>
        <form action="<?= base_url('lamaran/updateTahap/' . $lamaran['id_lamaran']) ?>"
              method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block font-semibold mb-2">Tahapan Rekrutmen</label>
                <select name="status" required class="w-full h-12 px-4 rounded-xl border">
                    <option value="">-- Pilih Tahapan --</option>
                    <option value="lolos administrasi">Lolos Administrasi</option>
                    <option value="wawancara">Wawancara</option>
                    <option value="psikotes">Psikotes</option>
                    <option value="seleksi lanjutan">Seleksi Lanjutan</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <!-- <div>
                <label class="block font-semibold mb-2">Jenis Dokumen</label>
                <select name="jenis_dokumen" class="w-full h-12 px-4 rounded-xl border">
                    <option value="surat_panggilan_interview">Surat Panggilan Interview</option>
                    <option value="hasil_tes">Hasil Tes</option>
                    <option value="surat_penerimaan">Surat Penerimaan</option>
                    <option value="surat_penolakan">Surat Penolakan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div> -->

            <div>
                <label class="block font-semibold mb-2">File PDF (opsional, max 5 MB)</label>
                <input type="file" name="dokumen" accept=".pdf,application/pdf"
                       class="form-control rounded-xl border p-3" id="dokumenSeleksi">
                <div class="form-text" id="previewSeleksi"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Catatan HR</label>
                <textarea name="catatan" rows="4" class="w-full p-4 rounded-xl border"></textarea>
            </div>

            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 px-6 py-3 rounded-xl font-bold">
                Simpan Tahapan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <div class="p-6 border-b"><h2 class="text-xl font-bold">Riwayat Tahapan</h2></div>
        <div class="divide-y">
            <?php foreach ($riwayat as $r): ?>
            <div class="p-6 flex flex-wrap justify-between gap-4">
                <div>
                    <h3 class="font-bold capitalize"><?= lamaran_status_label($r['tahapan']) ?></h3>
                    <p class="text-gray-600 mt-1"><?= esc($r['catatan']) ?></p>
                    <?php if (! empty($r['jenis_dokumen'])): ?>
                        <p class="text-sm text-gray-500 mt-1">Jenis: <?= esc(str_replace('_', ' ', $r['jenis_dokumen'])) ?></p>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500"><?= esc($r['created_at']) ?></p>
                    <?php if (! empty($r['dokumen_path']) || ! empty($r['dokumen'])): ?>
                        <a href="<?= base_url('lamaran/dokumen-seleksi/' . $r['id_tahapan']) ?>"
                           class="text-blue-600 hover:underline text-sm font-semibold" target="_blank">
                            Download Dokumen
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<script>
document.getElementById('dokumenSeleksi')?.addEventListener('change', function () {
    const el = document.getElementById('previewSeleksi');
    if (this.files?.[0]) {
        el.textContent = this.files[0].name;
    } else {
        el.textContent = '';
    }
});
</script>

<?= $this->endSection() ?>
