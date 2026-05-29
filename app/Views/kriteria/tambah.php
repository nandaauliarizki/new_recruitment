<h2>Tambah Kriteria</h2>

<form action="<?= base_url('kriteria/simpan') ?>" method="post">

<input type="hidden"
       name="id_lowongan"
       value="<?= $id_lowongan ?>">

<label>Nama Kriteria</label><br>

<input type="text"
       name="nama_kriteria"
       required>

<br><br>

<label>Bobot</label><br>

<input type="number"
       step="0.1"
       name="bobot"
       required>

<br><br>

<label>Atribut</label><br>

<select name="atribut">

<option value="benefit">
Benefit
</option>

<option value="cost">
Cost
</option>

</select>

<br><br>

<button type="submit">
Simpan
</button>

</form>