<h2>Daftar Lowongan</h2>

<?php foreach($lowongan as $l): ?>

<div style="border:1px solid #ccc; padding:10px; margin:10px;">
    <h3><?= $l['nama_pekerjaan'] ?></h3>

    <a href="<?= base_url('lamar/'.$l['id']) ?>">
        Lamar
    </a>
</div>

<?php endforeach; ?>