<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Jobs</h1>
            <p class="text-gray-500 text-sm mt-0.5">Kelola lowongan pekerjaan dan status posting</p>
        </div>
        <button onclick="openModal()"
            class="bg-yellow-400 hover:bg-yellow-500 text-black px-5 py-3 rounded-2xl font-bold transition flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined">add</span>
            Tambah Lowongan
        </button>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- STATUS FILTER TABS -->
    <div class="flex flex-wrap gap-2 mb-6">
        <?php
        $tabs = [
            ''        => 'Semua',
            'active'  => 'Active Posted',
            'draft'   => 'Draft',
            'expired' => 'Expired',
        ];
        $tabColors = [
            ''        => 'bg-gray-800 text-white',
            'active'  => 'bg-green-600 text-white',
            'draft'   => 'bg-gray-500 text-white',
            'expired' => 'bg-red-600 text-white',
        ];
        foreach ($tabs as $key => $label):
            $isActive = ($filter ?? '') === $key;
            $count    = $key === '' ? $counts['all'] : $counts[$key];
        ?>
        <a href="<?= base_url('admin/lowongan' . ($key ? '?status=' . $key : '')) ?>"
           class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition
                  <?= $isActive ? $tabColors[$key] : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            <?= $label ?>
            <span class="<?= $isActive ? 'bg-white/25' : 'bg-gray-100' ?> text-xs px-2 py-0.5 rounded-full font-bold <?= $isActive ? 'text-current' : 'text-gray-600' ?>">
                <?= $count ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-5 text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="text-left px-6 py-5 text-xs font-semibold text-gray-500 uppercase">Nama Pekerjaan</th>
                        <th class="text-left px-6 py-5 text-xs font-semibold text-gray-500 uppercase">Deskripsi</th>
                        <th class="text-left px-6 py-5 text-xs font-semibold text-gray-500 uppercase">Periode</th>
                        <th class="text-left px-6 py-5 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-center px-6 py-5 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lowongan)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-400">Belum ada data lowongan</td>
                        </tr>
                    <?php endif; ?>
                    <?php $no = 1; ?>
                    <?php foreach ($lowongan as $l): ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="px-6 py-5 text-gray-500"><?= $no++ ?></td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-800"><?= esc($l['nama_pekerjaan']) ?></div>
                                <?php if (!empty($l['end_date'])):
                                    $today = new DateTime('today');
                                    $end   = new DateTime($l['end_date']);
                                    $diff  = (int) $today->diff($end)->format('%r%a');
                                    if ($diff > 0 && $diff <= 7 && $l['status'] === 'active'): ?>
                                        <div class="text-xs text-orange-500 mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size:12px">schedule</span>
                                            Berakhir <?= $diff ?> hari lagi
                                        </div>
                                    <?php endif; endif; ?>
                            </td>
                            <td class="px-6 py-5 text-gray-600 text-sm max-w-xs">
                                <?= character_limiter($l['deskripsi'], 70) ?>
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-600">
                                <?php if (!empty($l['start_date']) && !empty($l['end_date'])): ?>
                                    <div class="font-medium"><?= date('d M Y', strtotime($l['start_date'])) ?></div>
                                    <div class="text-gray-400 text-xs">→ <?= date('d M Y', strtotime($l['end_date'])) ?></div>
                                <?php else: ?>
                                    <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <?php if ($l['status'] === 'active'): ?>
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Active Posted</span>
                                <?php elseif ($l['status'] === 'expired'): ?>
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Expired</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('lowongan/edit/' . $l['id']) ?>"
                                       class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-xl transition flex items-center gap-1 text-sm">
                                        <span class="material-symbols-outlined text-base">edit</span> Edit
                                    </a>
                                    <a href="<?= base_url('lowongan/hapus/' . $l['id']) ?>"
                                       onclick="return confirm('Yakin hapus lowongan ini?')"
                                       class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-xl transition flex items-center gap-1 text-sm">
                                        <span class="material-symbols-outlined text-base">delete</span> Hapus
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

<!-- MODAL TAMBAH LOWONGAN -->
<div id="modal-overlay"
     class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden"
     onclick="closeModalOutside(event)">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Tambah Lowongan</h3>
                <p class="text-sm text-gray-500 mt-0.5">Setelah simpan, tambahkan kriteria SAW di halaman edit</p>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                <span class="material-symbols-outlined text-gray-600">close</span>
            </button>
        </div>

        <form action="<?= base_url('lowongan/simpan-basic') ?>" method="POST" class="p-6 space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama Pekerjaan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_pekerjaan" required placeholder="e.g. Accounting Staff"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kualifikasi</label>
                <textarea name="deskripsi" rows="3" placeholder="Tulis Kualifikasi Untuk Posisi ini..."
                          class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Start Date</label>
                    <input type="date" name="start_date"
                           class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        End Date <span class="text-xs text-gray-400">(expired)</span>
                    </label>
                    <input type="date" name="end_date"
                           class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                    <option value="draft">Draft — belum dipublikasi</option>
                    <option value="active">Active Posted — langsung tayang</option>
                </select>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal()"
                        class="flex-1 py-3 rounded-2xl border border-gray-300 font-semibold text-gray-700 hover:bg-gray-50 transition text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 rounded-2xl bg-yellow-400 hover:bg-yellow-500 font-bold text-black transition text-sm">
                    Buat & Tambah Kriteria →
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal-overlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('modal-overlay').classList.add('hidden');
    document.body.style.overflow = '';
}
function closeModalOutside(e) {
    if (e.target === document.getElementById('modal-overlay')) closeModal();
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
</script>

<?= $this->endSection() ?>


 
