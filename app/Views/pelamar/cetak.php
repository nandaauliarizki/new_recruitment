<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelamar</title>

    <style>

        body{
            font-family: Arial, sans-serif;
        }

        h2{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table,
        th,
        td{
            border:1px solid black;
        }

        th,
        td{
            padding:8px;
            text-align:left;
        }

    </style>

</head>
<body>

<h2>LAPORAN DATA PELAMAR</h2>

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pendidikan</th>
            <th>Lowongan</th>
            <th>Tanggal Lamar</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        <?php $no=1; ?>

        <?php foreach($pelamar as $p): ?>

        <tr>

            <td><?= $no++ ?></td>
            <td><?= $p['nama_pelamar'] ?></td>
            <td><?= $p['email'] ?></td>
            <td><?= $p['pendidikan'] ?></td>
            <td><?= $p['nama_pekerjaan'] ?></td>
            <td><?= $p['tanggal_lamar'] ?></td>
            <td><?= ucfirst(lamaran_status_from_row($p)) ?></td>

        </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<script>
    window.print();
</script>

</body>
</html>