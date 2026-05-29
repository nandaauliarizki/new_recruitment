<?= $this->extend('layouts/pelamar') ?>

<?= $this->section('content') ?>

<h3 class="mb-4">
    Daftar Lowongan Pekerjaan
</h3>

<div class="card shadow border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Nama Posisi
                        </th>

                        <th>
                            Deskripsi
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

<?php $no=1; ?>
<?php foreach($lowongan as $l): ?>

<tr>

<td>
    <?= $no++ ?>
</td>

<td>

<strong>
<?= $l['nama_pekerjaan'] ?>
</strong>

</td>

<td>

<span class="text-muted">

<?= substr(
        $l['deskripsi'],
        0,
        80
    ) ?>...

</span>

</td>

<td class="text-center">

<a href="<?= base_url(
        'lamaran/'.$l['id']
    ) ?>"

class="btn btn-primary rounded-pill px-3">

    Lihat Detail

</a>

</td>

</tr>

<?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection() ?>