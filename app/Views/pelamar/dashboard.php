<?= $this->extend('layouts/pelamar') ?>

<?= $this->section('content') ?>

<style>

    body{
        background:#f8f5ef;
    }

    .welcome-box{

        background: linear-gradient(
            135deg,
            #ffc107,
            #ffda6a
        );

        border-radius:0px;

        padding:40px;

        color:#222;

        margin-bottom:30px;
    }

    .welcome-title{

        font-size:32px;

        font-weight:700;
    }

    .stat-card{

        border:none;

        border-radius:20px;

        transition:0.3s;

        box-shadow:
            0 10px 25px rgba(0,0,0,0.05);
    }

    .stat-card:hover{

        transform:translateY(-5px);
    }

    .stat-icon{

        width:60px;
        height:60px;

        border-radius:15px;

        display:flex;
        align-items:center;
        justify-content:center;

        font-size:26px;

        margin-bottom:15px;
    }

    .job-card{

        border:none;

        border-radius:22px;

        overflow:hidden;

        transition:0.3s;

        box-shadow:
            0 10px 30px rgba(0,0,0,0.05);

        height:100%;
    }

    .job-card:hover{

        transform:translateY(-5px);
    }

    .job-badge{

        background:#fff3cd;

        color:#856404;

        padding:6px 14px;

        border-radius:50px;

        font-size:13px;

        font-weight:600;
    }

    .btn-apply{

        background:#ffc107;

        border:none;

        border-radius:12px;

        font-weight:600;

        padding:10px;
    }

    .btn-apply:hover{

        background:#e0a800;
    }

</style>

<!-- WELCOME -->

<div class="welcome-box">

    <div class="row align-items-center">

        <div class="col-md-8">

            <div class="welcome-title">
                Selamat Datang,
                <?= session()->get('nama') ?> 👋
            </div>

            <p class="mt-3 mb-0 fs-5">

                Pantau lowongan dan status
                lamaran pekerjaan Anda.

            </p>

        </div>

    </div>

</div>

<!-- STATISTIK -->

<div class="row g-4 mb-5">

    <!-- TOTAL LOWONGAN -->

    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <div
                    class="stat-icon"
                    style="background:#dbeafe;color:#2563eb;"
                >
                    📄
                </div>

                <h6 class="text-muted">
                    Total Lowongan
                </h6>

                <h2 class="fw-bold">
                    <?= $totalLowongan ?>
                </h2>

            </div>

        </div>

    </div>

    <!-- TOTAL LAMARAN -->

    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <div
                    class="stat-icon"
                    style="background:#dcfce7;color:#16a34a;"
                >
                    ✅
                </div>

                <h6 class="text-muted">
                    Lamaran Saya
                </h6>

                <h2 class="fw-bold">
                    <?= $totalLamaran ?>
                </h2>

            </div>

        </div>

    </div>

    <!-- PENDING -->

    <div class="col-md-4">

        <div class="card stat-card">

            <div class="card-body">

                <div
                    class="stat-icon"
                    style="background:#fef3c7;color:#d97706;"
                >
                    ⏳
                </div>

                <h6 class="text-muted">
                    Pending
                </h6>

                <h2 class="fw-bold">
                    <?= $pending ?>
                </h2>

            </div>

        </div>

    </div>

</div>

<!-- LOWONGAN -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3 class="fw-bold">
        Lowongan Tersedia
    </h3>

</div>

<div class="row g-4">

    <?php foreach($lowongan as $l): ?>

        <div class="col-md-6 col-lg-4">

            <div class="card job-card">

                <div class="card-body d-flex flex-column">

                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >

                        <span class="job-badge">

                            Full Time

                        </span>

                    </div>

                    <h4 class="fw-bold mb-3">

                        <?= $l['nama_pekerjaan'] ?>

                    </h4>

                    <p class="text-muted flex-grow-1">

                        <?= $l['deskripsi'] ?>

                    </p>

                    <a
                        href="<?= base_url('lamar/'.$l['id']) ?>"
                        class="btn btn-apply mt-3"
                    >

                        Lamar Sekarang

                    </a>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

<?= $this->endSection() ?>