<h2>Tambah Sub Kriteria</h2>

<form action="<?= base_url('subkriteria/simpan') ?>" method="post">

<input type="hidden"
       name="id_kriteria"
       value="<?= $id_kriteria ?>">

<label>Nama Sub</label><br>

<input type="text"
       name="nama_sub"
       required>

<br><br>

<label>Nilai</label><br>

<input type="number"
       step="0.1"
       name="nilai"
       required>

<br><br>

<button type="submit">
Simpan
</button>

</form>