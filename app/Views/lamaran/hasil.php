<h2>Hasil Ranking</h2>

<table border="1">
<tr>
    <th>Ranking</th>
    <th>Nama</th>
    <th>Nilai</th>
</tr>

<?php $no = 1; ?>
<?php foreach($hasil as $h): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $h['nama'] ?></td>
    <td><?= round($h['nilai'], 3) ?></td>
</tr>
<?php endforeach; ?>
</table>