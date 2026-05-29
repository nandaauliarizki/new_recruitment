<h2>Tambah Pelamar</h2>

<form action="<?= base_url('pelamar/simpan') ?>" method="post">
    Nama: <input type="text" name="nama"><br>
    Email: <input type="email" name="email"><br>
    Pendidikan: <input type="text" name="pendidikan"><br>
    Pengalaman: <input type="number" name="pengalaman"><br>

    <button type="submit">Simpan</button>
</form>