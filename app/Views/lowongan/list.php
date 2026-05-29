<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Lowongan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Lowongan</h2>

        <a href="<?= base_url('lowongan/tambah') ?>" 
           class="btn btn-primary">
            + Tambah Lowongan
        </a>
    </div>

    <!-- Table -->
    <table border="1" cellpadding="8">

        <tr>
            <th>No</th>
            <th>Nama Pekerjaan</th>
            <th>Deskripsi</th>
            <th>Kriteria</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>

        <?php foreach ($lowongan as $l): ?>

            <tr>

                <td><?= $no++ ?></td>

                <td>
                    <strong>
                        <?= $l['nama_pekerjaan'] ?>
                    </strong>
                </td>

                <td>
                    <?= $l['deskripsi'] ?>
                </td>

                <td>

                    <?php if (!empty($l['kriteria'])): ?>

                        <?php foreach ($l['kriteria'] as $k): ?>

                            <b>
                                <?= $k['nama_kriteria'] ?>
                                (<?= $k['bobot'] ?>)
                            </b>

                            <br>

                            <?php if (!empty($k['sub'])): ?>

                                <ul>

                                    <?php foreach ($k['sub'] as $s): ?>

                                        <li>
                                            <?= $s['nama_sub'] ?>
                                            (<?= $s['nilai'] ?>)
                                        </li>

                                    <?php endforeach; ?>

                                </ul>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </td>

                <td>

                    <a href="<?= base_url('lowongan/edit/' . $l['id']) ?>">
                        Edit
                    </a>

                    |

                    <a href="<?= base_url('lowongan/hapus/' . $l['id']) ?>">
                        Hapus
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
