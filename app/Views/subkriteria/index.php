<h2>Data Sub Kriteria</h2>

<a href="<?= base_url('subkriteria/tambah/'.$id_kriteria) ?>"
   class="btn btn-primary">
   + Tambah Sub
</a>

<br><br>

<table border="1">

<tr>
    <th>No</th>
    <th>Nama Sub</th>
    <th>Nilai</th>
    <th>Aksi</th>
</tr>

<?php $no=1; ?>
<?php foreach($sub as $s): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= $s['nama_sub'] ?></td>

<td><?= $s['nilai'] ?></td>

<td>

<a href="<?= base_url('subkriteria/hapus/'.$s['id_sub']) ?>"
   onclick="return confirm('Yakin?')">
   Hapus
</a>

</td>

</tr>

<?php endforeach; ?>

</table>