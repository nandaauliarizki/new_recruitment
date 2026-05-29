<?= $this->extend('layouts/pelamar') ?>

<?= $this->section('content') ?>

<style>
    .page-title { font-size: 32px; font-weight: 700; color: #2b2b2b; }
    .application-card { border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: #fff; }
    .table thead { background: #fff3cd; }
    .status-badge { padding: 8px 14px; border-radius: 30px; font-size: 13px; font-weight: 600; display: inline-block; }
</style>

<div class="container-fluid">
    <div class="mb-5">
        <h1 class="page-title">My Applications</h1>
        <p class="text-muted">Pantau seluruh progres lamaran pekerjaan Anda di sini.</p>
    </div>

    <?php if (empty($lamaran)): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <h4 class="mb-3">Belum Ada Lamaran</h4>
            <a href="<?= base_url('lowongan') ?>" class="btn btn-warning px-4">Lihat Lowongan</a>
        </div>
    <?php else: ?>
        <div class="application-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Job Position</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Application Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lamaran as $l):
                            $st = lamaran_status_from_row($l);
                            $badgeClass = match ($st) {
                                'diterima' => 'bg-success text-white',
                                'ditolak' => 'bg-danger text-white',
                                'lolos administrasi' => 'bg-primary text-white',
                                'menunggu validasi administrasi' => 'bg-info text-dark',
                                'wawancara' => 'bg-info text-white',
                                'psikotes' => 'bg-secondary text-white',
                                default => 'bg-warning text-dark',
                            };
                        ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= esc($l['nama_pekerjaan']) ?></div>
                                <small class="text-muted"><?= character_limiter($l['deskripsi'] ?? '', 90) ?></small>
                            </td>
                            <td class="text-center">
                                <span class="status-badge <?= $badgeClass ?>">
                                    <?= lamaran_status_label($st) ?>
                                </span>
                            </td>
                            <td class="text-end text-muted">
                                <?= $l['tanggal'] ? date('d M Y', strtotime($l['tanggal'])) : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
