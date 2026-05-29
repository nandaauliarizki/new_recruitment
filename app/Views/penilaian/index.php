<h2>Input Penilaian</h2>

<form action="<?= base_url('penilaian/simpan') ?>" method="post">

<table border="1">
<tr>
    <th>Pelamar</th>
    <?php foreach ($kriteria as $k): ?>
        <th><?= $k['nama_kriteria'] ?></th>
    <?php endforeach; ?>
</tr>

<?php foreach ($pelamar as $p): ?>
<tr>
    <td><?= $p['nama_pelamar'] ?></td>

    <?php foreach ($kriteria as $k): ?>
    <td>
        <input type="number"
        value="<?php
            foreach ($penilaian as $pn) {
                if ($pn['id_pelamar'] == $p['id_pelamar'] && $pn['id_kriteria'] == $k['id_kriteria']) {
                    echo $pn['nilai'];
                }
            }
        ?>"
        name="nilai[<?= $p['id_pelamar'] ?>][<?= $k['id_kriteria'] ?>]">    </td>
    <?php endforeach; ?>

</tr>
<?php endforeach; ?>

</table>

<button type="submit">Simpan Penilaian</button>
</form>