<h2>Data Kriteria</h2>

<a href="<?= base_url('kriteria/tambah/'.$id_lowongan) ?>"
   class="btn btn-primary">
   + Tambah Kriteria
</a>

<br><br>

<table border="1">

<tr>
    <th>No</th>
    <th>Nama Kriteria</th>
    <th>Bobot</th>
    <th>Atribut</th>
    <th>Aksi</th>
</tr>

<?php $no=1; ?>
<?php foreach($kriteria as $k): ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $k['nama_kriteria'] ?></td>
    <td><?= $k['bobot'] ?></td>
    <td><?= $k['atribut'] ?></td>

    <td>

    <a href="<?= base_url('kriteria/hapus/'.$k['id_kriteria']) ?>"
       onclick="return confirm('Yakin?')">
       Hapus
    </a>
    <a href="<?= base_url('subkriteria/'.$k['id_kriteria']) ?>"
   class="btn btn-success btn-sm">
   📋 Sub
    </a>

    </td>

</tr>

<?php endforeach; ?>

</table>