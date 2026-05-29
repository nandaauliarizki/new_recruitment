<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelamar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* LAYOUT FLEX */

        .wrapper {
            display: flex;
        }

        /* SIDEBAR */

        /*.sidebar {
            width: 220px;
            height: 100vh;
            background-color: #0d6efd;
            color: white;
            padding-top: 20px;

            transition: all 0.3s;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Saat Sidebar Ditutup */

        .sidebar.hide {
            margin-left: -220px;
        }

        /* MAIN CONTENT */

        .main-content {
            flex: 1;
            transition: all 0.3s;
        }

        /* TOPBAR */

        .topbar {
            background-color: white;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-link-custom{

        color:#666;

        text-decoration:none;

        font-weight:500;

        position:relative;

        padding-bottom:6px;

        transition:0.3s;
    }

    .nav-link-custom:hover{

        color:#d4a017;
    }

    .nav-link-custom.active{

        color:#d4a017;

        font-weight:600;
    }

    .nav-link-custom.active::after{

        content:'';

        position:absolute;

        bottom:0;
        left:0;

        width:100%;
        height:3px;

        background:#d4a017;

        border-radius:20px;
    }

    .profile-avatar{

        width:40px;

        height:40px;

        border-radius:50%;

        background:#ffc107;

        display:flex;

        align-items:center;

        justify-content:center;

        font-weight:700;

        color:#222;
    }

        .content {
            padding: 20px;
        }

        .btn-primary {
            border-radius: 30px;
            padding: 8px 18px;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f6ff;
        }

        /* Tombol Toggle */

        #toggleSidebar {
            margin-right: 10px;
        }

    </style>

</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <!-- <div class="sidebar" id="sidebar">

        <h4 class="text-center mb-4">
            Pelamar
        </h4>

        <a href="<?= base_url('pelamar/dashboard') ?>">
            Dashboard
        </a>

        <a href="<?= base_url('lowongan') ?>">
            Lowongan
        </a>

        <a href="<?= base_url('lamaran/status') ?>">
            Lamaran Saya
        </a>

        <a href="<?= base_url('pelamar/profil') ?>">
            Profil
        </a>

        <a href="<?= base_url('logout') ?>">
            Logout
        </a>

    </div> -->

    <!-- MAIN -->
    <div class="main-content">

       <!-- TOPBAR -->

        <div class="topbar">

            <!-- KOSONG KIRI -->
            <div style="width:120px;"></div>

            <!-- MENU TENGAH -->
            <div class="d-flex align-items-center gap-4">

                <?php $uri = service('uri'); ?>

            <div class="d-flex align-items-center gap-4">

                <a
                    href="<?= base_url('pelamar/dashboard') ?>"
                    class="nav-link-custom <?= ($uri->getSegment(2) == 'dashboard') ? 'active' : '' ?>"
                >
                    Home
                </a>

                <a
                    href="<?= base_url('lamaran/status') ?>"
                    class="nav-link-custom <?= ($uri->getSegment(1) == 'lamaran') ? 'active' : '' ?>"
                >
                    My Applications
                </a>

            </div>

                <!-- <a
                    href="<?= base_url('lamaran/status') ?>"
                    class="nav-link-custom"
                >
                    My Applications
                </a> -->

            </div>

            <!-- PROFILE KANAN -->
             
            <div class="d-flex align-items-center gap-3">

                <!-- LOGOUT -->
                <a
                    href="<?= base_url('logout') ?>"
                    class="btn btn-outline-warning btn-sm"
                >
                    Logout
                </a>

                <!-- PROFILE AVATAR -->
                <a
                    href="<?= base_url('pelamar/profile') ?>"
                    class="text-decoration-none"
                >

                    <?php if(session()->get('foto')): ?>

                        <img
                            src="<?= base_url('uploads/profile/' . session()->get('foto')) ?>"
                            width="42"
                            height="42"
                            style="
                                border-radius:50%;
                                object-fit:cover;
                                border:2px solid #ffc107;
                            "
                        >

                    <?php else: ?>

                        <div class="profile-avatar">

                            <?= strtoupper(
                                substr(
                                    session()->get('nama'),
                                    0,
                                    1
                                )
                            ) ?>

                        </div>

                    <?php endif; ?>

                </a>

            </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="content">

                        <?= $this->renderSection('content') ?>

                    </div>

                </div>

            </div>

<!-- JAVASCRIPT -->

<script>

document
.getElementById("toggleSidebar")
.addEventListener("click", function () {

    document
    .getElementById("sidebar")
    .classList.toggle("hide");

});

</script>

</body>
</html>