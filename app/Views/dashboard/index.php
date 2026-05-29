<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- STAT CARDS -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600">work</span>
            </div>
            <p class="text-gray-500 text-sm">Total Lowongan</p>
        </div>
        <h2 class="text-3xl font-bold"><?= $total_lowongan ?></h2>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600">campaign</span>
            </div>
            <p class="text-gray-500 text-sm">Job Aktif</p>
        </div>
        <h2 class="text-3xl font-bold"><?= $open_jobs ?></h2>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500">event_busy</span>
            </div>
            <p class="text-gray-500 text-sm">Job Expired</p>
        </div>
        <h2 class="text-3xl font-bold"><?= $expired_jobs ?></h2>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-600">groups</span>
            </div>
            <p class="text-gray-500 text-sm">Total Pelamar</p>
        </div>
        <h2 class="text-3xl font-bold"><?= $total_pelamar ?></h2>
    </div>

</div>

<!-- JOB POSTING STATUS -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">

    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-lg">Status Job Posting</h3>
            <p class="text-sm text-gray-400 mt-0.5">Durasi tayang & lamaran masuk per lowongan aktif</p>
        </div>
        <a href="<?= base_url('admin/lowongan') ?>" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
            Kelola Jobs <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Posisi</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode Posting</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Sisa Hari</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelamar</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($job_postings)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">Belum ada job posting aktif</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($job_postings as $jp):
                        $today     = new DateTime('today');
                        $endDate   = $jp['end_date']   ? new DateTime($jp['end_date'])   : null;
                        $startDate = $jp['start_date'] ? new DateTime($jp['start_date']) : null;
                        $days_left = $endDate ? (int) $today->diff($endDate)->format('%r%a') : null;
                    ?>
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-800"><?= esc($jp['nama_pekerjaan']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php if ($startDate && $endDate): ?>
                                <?= $startDate->format('d M Y') ?> → <?= $endDate->format('d M Y') ?>
                            <?php else: ?>
                                <span class="text-gray-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($days_left === null): ?>
                                <span class="text-gray-400">—</span>
                            <?php elseif ($days_left < 0): ?>
                                <span class="text-red-600 font-semibold text-sm">Sudah berakhir</span>
                            <?php elseif ($days_left === 0): ?>
                                <span class="text-orange-600 font-bold text-sm">Berakhir hari ini</span>
                            <?php elseif ($days_left <= 7): ?>
                                <span class="inline-flex items-center gap-1 text-orange-500 font-semibold text-sm">
                                    <span class="material-symbols-outlined text-base">schedule</span>
                                    <?= $days_left ?> hari lagi
                                </span>
                            <?php else: ?>
                                <span class="text-green-600 text-sm"><?= $days_left ?> hari lagi</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?= base_url('pelamar?lowongan=' . $jp['id']) ?>"
                               class="inline-flex items-center justify-center min-w-[2rem] h-8 px-3 rounded-full bg-blue-100 text-blue-700 font-bold text-sm hover:bg-blue-200 transition">
                                <?= $jp['total_applicants'] ?>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($jp['status'] === 'active'): ?>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Active Posted</span>
                            <?php elseif ($jp['status'] === 'draft'): ?>
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">Draft</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Expired</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- RECENT APPLICATIONS -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-lg">Lamaran Terbaru</h3>
            <p class="text-sm text-gray-400 mt-0.5">5 lamaran terakhir yang masuk</p>
        </div>
        <a href="<?= base_url('pelamar') ?>" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
            Semua Pelamar <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Pelamar</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Posisi</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent)): ?>
                    <tr><td colspan="4" class="text-center py-12 text-gray-400">Belum ada lamaran masuk</td></tr>
                <?php endif; ?>
                <?php foreach ($recent as $r): ?>
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-semibold"><?= esc($r['nama_pelamar']) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= esc($r['nama_pekerjaan']) ?></td>
                    <td class="px-6 py-4 text-gray-500 text-sm"><?= $r['tanggal'] ? date('d M Y', strtotime($r['tanggal'])) : '—' ?></td>
                    <td class="px-6 py-4">
                        <?php $st = strtolower($r['status'] ?? 'belum divalidasi'); ?>
                        <?php if ($st === 'sudah divalidasi'): ?>
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Sudah Divalidasi
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                Belum Divalidasi
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
