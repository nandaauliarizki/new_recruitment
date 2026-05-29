<?= $this->extend('layouts/pelamar') ?>

<?= $this->section('content') ?>

<style>
    body { background: #f8f5ef; }
    .file-upload-box {
        border: 2px dashed #dee2e6;
        border-radius: 16px;
        padding: 1.25rem;
        transition: border-color 0.2s, background 0.2s;
        cursor: pointer;
    }
    .file-upload-box:hover, .file-upload-box.has-file {
        border-color: #ffc107;
        background: #fffdf5;
    }
    .file-name-preview {
        font-size: 0.875rem;
        color: #495057;
        word-break: break-all;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-5">
        <h1 class="fw-bold" style="font-size:30px;">Form Lamaran</h1>
        <p class="text-muted">
            Lengkapi kriteria dan unggah dokumen PDF untuk melamar
            <strong><?= esc($lowongan['nama_pekerjaan']) ?></strong>
        </p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-4"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $field => $err): ?>
                    <li>
                        <?php if (is_string($field) && ! is_numeric($field)): ?>
                            <strong><?= esc(ucfirst(str_replace('_', ' ', $field))) ?>:</strong>
                        <?php endif; ?>
                        <?= esc(is_array($err) ? implode(' ', $err) : $err) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($validation) && $validation->getErrors()): ?>
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0">
                <?php foreach ($validation->getErrors() as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php $pelamar = $pelamar ?? []; ?>

    <form action="<?= base_url('lamaran/simpan') ?>" method="post" enctype="multipart/form-data" id="formLamaran">
        <?= csrf_field() ?>
        <input type="hidden" name="id_lowongan" value="<?= $id_lowongan ?>">

        <!-- DATA DIRI -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
            <div class="card-body p-5">

                <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-warning">person</span>
                    Data Diri
                </h5>

                <div class="row g-4">

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Jenis Kelamin <span class="text-danger">*</span>
                        </label>

                        <select name="jenis_kelamin"
                                class="form-select form-select-lg rounded-4 <?= isset($validation) && $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="">Pilih jenis kelamin</option>

                            <option value="Laki-laki"
                                <?= old('jenis_kelamin', $pelamar['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' ?>>
                                Laki-laki
                            </option>

                            <option value="Perempuan"
                                <?= old('jenis_kelamin', $pelamar['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>
                                Perempuan
                            </option>

                        </select>

                        <?php if (isset($validation) && $validation->hasError('jenis_kelamin')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('jenis_kelamin')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tempat Lahir <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="tempat_lahir"
                            value="<?= old('tempat_lahir', $pelamar['tempat_lahir'] ?? '') ?>"
                            placeholder="Contoh: Banjarmasin"
                            class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('tempat_lahir') ? 'is-invalid' : '' ?>"
                            required>

                        <?php if (isset($validation) && $validation->hasError('tempat_lahir')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('tempat_lahir')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                            name="tanggal_lahir"
                            value="<?= old('tanggal_lahir', $pelamar['tanggal_lahir'] ?? '') ?>"
                            class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('tanggal_lahir') ? 'is-invalid' : '' ?>"
                            required>

                        <?php if (isset($validation) && $validation->hasError('tanggal_lahir')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('tanggal_lahir')) ?>
                            </div>
                        <?php endif; ?>
                    </div>


                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="nama_lengkap"
                            value="<?= old('nama_lengkap', $pelamar['nama_lengkap'] ?? '') ?>"
                            placeholder="Tulis nama lengkap"
                            class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('nama_lengkap') ? 'is-invalid' : '' ?>"
                            required>

                        <?php if (isset($validation) && $validation->hasError('nama_lengkap')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('nama_lengkap')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pendidikan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Pendidikan Terakhir <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="pendidikan"
                            value="<?= old('pendidikan', $pelamar['pendidikan'] ?? '') ?>"
                            placeholder="Tulis pendidikan terakhir"
                            class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('pendidikan') ? 'is-invalid' : '' ?>"
                            required>

                        <?php if (isset($validation) && $validation->hasError('pendidikan')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('pendidikan')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- No HP -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            No HP <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="no_hp"
                            value="<?= old('no_hp', $pelamar['no_hp'] ?? '') ?>"
                            placeholder="Contoh: 081234567890"
                            class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('no_hp') ? 'is-invalid' : '' ?>"
                            required>

                        <?php if (isset($validation) && $validation->hasError('no_hp')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('no_hp')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Alamat <span class="text-danger">*</span>
                        </label>

                        <textarea name="alamat"
                                rows="4"
                                placeholder="Tulis alamat lengkap"
                                class="form-control form-control-lg rounded-4 <?= isset($validation) && $validation->hasError('alamat') ? 'is-invalid' : '' ?>"
                                required><?= old('alamat', $pelamar['alamat'] ?? '') ?></textarea>

                        <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                            <div class="invalid-feedback d-block">
                                <?= esc($validation->getError('alamat')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- DOKUMEN -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;">
            <div class="card-body p-5">
                <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-warning">description</span>
                    Upload Dokumen
                </h5>
                <p class="text-muted small mb-4">Format PDF, maksimal 5 MB per file.</p>

                <div class="row g-4">
                    <?php
                    $docs = [
                        'cv' => ['label' => 'CV', 'required' => true, 'icon' => 'badge'],
                        'surat_lamaran' => ['label' => 'Surat Lamaran Kerja', 'required' => true, 'icon' => 'mail'],
                        'ijazah' => ['label' => 'Ijazah', 'required' => true, 'icon' => 'school'],
                        'dokumen_pendukung' => ['label' => 'Dokumen Pendukung (opsional)', 'required' => false, 'icon' => 'attach_file', 'hint' => 'contoh : SIM, sertifikat, transkrip nilai, portfolio, dll. dalam satu PDF.'],
                    ];
                    foreach ($docs as $name => $meta):
                    ?>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <?= esc($meta['label']) ?>
                            <?= $meta['required'] ? '<span class="text-danger">*</span>' : '' ?>
                        </label>
                        <label class="file-upload-box d-block mb-0" for="file_<?= $name ?>">
                            <div class="d-flex align-items-center gap-3">
                                <span class="material-symbols-outlined fs-2 text-warning"><?= $meta['icon'] ?></span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium">Klik untuk memilih file PDF</span>
                                    <?php if (! empty($meta['hint'])): ?>
                                        <small class="text-muted"><?= esc($meta['hint']) ?></small>
                                    <?php endif; ?>
                                    <div class="file-name-preview mt-2" id="preview_<?= $name ?>"></div>
                                </div>
                            </div>
                            <input type="file"
                                   class="d-none doc-file-input"
                                   id="file_<?= $name ?>"
                                   name="<?= $name ?>"
                                   accept="application/pdf,.pdf"
                                   data-preview="preview_<?= $name ?>"
                                   <?= $meta['required'] ? 'required' : '' ?>>
                        </label>
                        <?php if (isset($validation) && $validation->hasError($name)): ?>
                            <div class="invalid-feedback d-block"><?= esc($validation->getError($name)) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- KRITERIA -->
        <?php foreach ($kriteria as $i => $k): ?>
        <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;overflow:hidden;">
            <div class="card-body p-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;border-radius:12px;background:#fff3cd;display:flex;align-items:center;justify-content:center;font-weight:700;color:#856404;">
                        <?= $i + 1 ?>
                    </div>
                    <h5 class="fw-bold mb-0"><?= esc($k['nama_kriteria']) ?></h5>
                </div>

                <?php if (isset($sub[$k['id_kriteria']]) && ! empty($sub[$k['id_kriteria']])): ?>
                    <label class="fw-semibold mb-3 d-block">Pilih Kualifikasi <span class="text-danger">*</span></label>
                    <div class="row g-3">
                        <?php foreach ($sub[$k['id_kriteria']] as $s): ?>
                        <div class="col-md-4">
                            <label class="d-block" style="cursor:pointer;">
                                <input type="radio"
                                       name="kriteria_<?= $k['id_kriteria'] ?>"
                                       value="<?= $s['id_sub'] ?>"
                                       required
                                       class="d-none"
                                       onchange="selectOption(this)">
                                <div class="sub-option p-4 border rounded-4 text-center" style="transition:0.2s;">
                                    <div class="fw-bold"><?= esc($s['nama_sub']) ?></div>
                                </div>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted fst-italic">Tidak ada sub kriteria tersedia</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="d-flex gap-3 mt-4">
            <a href="<?= base_url('pelamar/dashboard') ?>" class="btn btn-outline-secondary px-4 py-3 rounded-4 fw-semibold">Batal</a>
            <button type="submit" class="btn px-5 py-3 rounded-4 fw-bold" style="background:#ffc107;border:none;">Kirim Lamaran</button>
        </div>
    </form>
</div>

<style>
.sub-option { background: #fff; border-color: #dee2e6 !important; }
.sub-option:hover { border-color: #ffc107 !important; background: #fffdf0; }
.sub-option.selected { border-color: #ffc107 !important; background: #fff3cd; }
</style>

<script>
function selectOption(input) {
    const group = input.closest('.row');
    group.querySelectorAll('.sub-option').forEach(el => el.classList.remove('selected'));
    input.nextElementSibling.classList.add('selected');
}

document.querySelectorAll('.sub-option').forEach(el => {
    el.addEventListener('click', function () {
        const input = this.closest('label').querySelector('input[type="radio"]');
        input.checked = true;
        selectOption(input);
    });
});

document.querySelectorAll('.doc-file-input').forEach(input => {
    input.addEventListener('change', function () {
        const preview = document.getElementById(this.dataset.preview);
        const box = this.closest('.file-upload-box');
        if (this.files && this.files[0]) {
            const f = this.files[0];
            const ext = f.name.split('.').pop().toLowerCase();
            if (ext !== 'pdf') {
                preview.innerHTML = '<span class="text-danger">Hanya file PDF yang diperbolehkan.</span>';
                this.value = '';
                box.classList.remove('has-file');
                return;
            }
            if (f.size > 5 * 1024 * 1024) {
                preview.innerHTML = '<span class="text-danger">Ukuran maksimal 5 MB.</span>';
                this.value = '';
                box.classList.remove('has-file');
                return;
            }
            preview.textContent = f.name + ' (' + (f.size / 1024).toFixed(1) + ' KB)';
            box.classList.add('has-file');
        } else {
            preview.textContent = '';
            box.classList.remove('has-file');
        }
    });
});
</script>

<?= $this->endSection() ?>
