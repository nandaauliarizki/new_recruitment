<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pelamar</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* ======================
           LAYOUT
        ====================== */

        .wrapper {
            display: flex;
        }

        .main-content {
            flex: 1;
        }

        .content {
            padding: 100px 20px 20px;
        }

        /* ======================
           TOPBAR
        ====================== */

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;

            background-color: #ffffff;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-box {
            margin: -20px -20px 20px -20px;
        }

        /* ======================
           NAVIGATION
        ====================== */

        .nav-link-custom {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding-bottom: 6px;
            transition: 0.3s;
        }

        .nav-link-custom:hover {
            color: #d4a017;
        }

        .nav-link-custom.active {
            color: #d4a017;
            font-weight: 600;
        }

        .nav-link-custom.active::after {
            content: '';

            position: absolute;
            left: 0;
            bottom: 0;

            width: 100%;
            height: 3px;

            background: #d4a017;
            border-radius: 20px;
        }

        /* ======================
           PROFILE
        ====================== */

        .profile-avatar {
            width: 42px;
            height: 42px;

            border-radius: 50%;
            background: #ffc107;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
            color: #222;
        }

        .profile-image {
            width: 42px;
            height: 42px;

            border-radius: 50%;
            object-fit: cover;

            border: 2px solid #ffc107;
        }

        /* ======================
           BUTTON
        ====================== */

        .btn-primary {
            border-radius: 30px;
            padding: 8px 18px;
        }

        /* ======================
           TABLE
        ====================== */

        .table-hover tbody tr:hover {
            background-color: #f2f6ff;
        }

    </style>
</head>

<body>

    <?php $uri = service('uri'); ?>

    <div class="wrapper">

        <!-- MAIN CONTENT -->
        <div class="main-content">

            <!-- TOPBAR -->
            <div class="topbar">

                <!-- KOSONG KIRI -->
                <div style="width: 120px;"></div>

                <!-- MENU -->
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

                <!-- PROFILE -->
                <div class="d-flex align-items-center gap-3">

                    <!-- LOGOUT -->
                    <a
                        href="<?= base_url('logout') ?>"
                        class="btn btn-outline-warning btn-sm"
                    >
                        Logout
                    </a>

                    <!-- PROFILE BUTTON -->
                    <a
                        href="<?= base_url('pelamar/profile') ?>"
                        class="text-decoration-none"
                    >

                        <?php if (session()->get('foto')): ?>

                            <img
                                src="<?= base_url('uploads/profile/' . session()->get('foto')) ?>"
                                class="profile-image"
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

</body>
</html>