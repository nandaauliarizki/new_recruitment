<?php
/**
 * Partial: daftar dokumen lamaran + tombol download (admin).
 *
 * @var array $documents dari LamaranModel::getDocumentMap()
 * @var int   $id_lamaran
 */
?>
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
            <span class="material-symbols-outlined text-warning">folder_open</span>
            Dokumen Pelamar
        </h5>

        <?php if (empty($documents)): ?>
            <p class="text-muted mb-0">Belum ada dokumen yang diunggah.</p>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($documents as $type => $doc): ?>
                    <div class="col-md-6">
                        <div class="border rounded-4 p-3 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <p class="fw-semibold mb-1"><?= esc($doc['label']) ?></p>
                                <p class="text-muted small mb-0 text-truncate" title="<?= esc($doc['filename']) ?>">
                                    <?= esc($doc['filename']) ?>
                                </p>
                            </div>
                            <a href="<?= base_url('lamaran/download/' . $id_lamaran . '/' . $type) ?>"
                               class="btn btn-outline-primary btn-sm rounded-3 mt-3 w-100"
                               target="_blank">
                                <span class="material-symbols-outlined align-middle" style="font-size:18px;">download</span>
                                Download
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
