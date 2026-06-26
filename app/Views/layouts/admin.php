<!DOCTYPE html>
<html lang="en">

<head>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>

    <style>
        .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
    }

    .sidebar-collapsed{
    width:80px !important;
}

.sidebar-collapsed .menu-text{
    display:none;
}

.sidebar-collapsed .logo-text{
    display:none;
}

.sidebar-collapsed a{
    justify-content:center;
}
</style>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'RecruitFlow' ?></title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- ICON -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
          rel="stylesheet">

    <style>

        body{
            font-family:'Inter',sans-serif;
            background:#fff8f2;
        }

        .material-symbols-outlined{
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
        }

    </style>

</head>

<body class="bg-[#fff8f2] text-[#201b11]">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
            class="flex flex-col
                    w-64
                    bg-[#201b11]
                    text-white
                    p-4
                    transition-all duration-300">

        <!-- LOGO -->
        <div class="mb-10 logo-text">

            <h2 class="text-2xl font-bold">
                RecruitFlow
            </h2>

            <p class="text-sm text-gray-300">
                Admin Portal
            </p>

        </div>

        <!-- MENU -->
        <nav class="flex flex-col gap-2">

            <!-- DASHBOARD -->
            <a href="<?= base_url('dashboard') ?>"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                <?= (($menu ?? '') == 'dashboard')
                        ? 'bg-yellow-400 text-black font-semibold'
                        : 'hover:bg-gray-700'
                ?>">

                <span class="material-symbols-outlined">
                    dashboard
                </span>

                <span class="menu-text">
                    Dashboard
                </span>

            </a>

            <!-- LOWONGAN -->
            <a href="<?= base_url('admin/lowongan') ?>"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                <?= (($menu ?? '') == 'lowongan') 
                    ? 'bg-yellow-400 text-black font-semibold'
                    : 'hover:bg-gray-700'
                ?>">

                <span class="material-symbols-outlined">
                    work
                </span>

                <span class="menu-text">
                    Manage Jobs
                </span>

            </a>

            <!-- RANKING -->
            <a href="<?= base_url('perhitungan') ?>"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                <?= (($menu ?? '') === 'ranking')
                    ? 'bg-yellow-400 text-black font-semibold'
                    : 'hover:bg-gray-700'
                ?>">

                <span class="material-symbols-outlined">
                    leaderboard
                </span>

                <span class="menu-text">
                    Ranking Kandidat
                </span>

            </a>

            <!-- PELAMAR -->
            <a href="<?= base_url('pelamar') ?>"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                <?= (($menu ?? '') === 'pelamar')
                    ? 'bg-yellow-400 text-black font-semibold'
                    : 'hover:bg-gray-700'
                ?>">

                <span class="material-symbols-outlined">
                    groups
                </span>

                <span class="menu-text">
                    Manage Applicants
                </span>

            </a>

        </nav>

    </aside>

    <!-- MAIN -->
    <main class="flex-1">

        <!-- TOPBAR -->
        <header class="bg-white border-b px-8 py-4">

            <div class="flex justify-between items-center">

                 <!-- BUTTON SIDEBAR -->
                <button id="toggleSidebar"
                        class="btn border-0 shadow-none">

                    <span class="material-symbols-outlined">
                        menu
                    </span>

                </button>

                <!-- PROFILE DROPDOWN -->
                <div class="dropdown">

                    <button
                        class="btn border-0 p-0"
                        type="button"
                        data-bs-toggle="dropdown"
                    >

                        <?php if(session()->get('foto')): ?>

                            <img
                                src="<?= base_url('uploads/profile/' . session()->get('foto')) ?>"
                                width="45"
                                height="45"
                                style="border-radius:50%; object-fit:cover;"
                            >

                        <?php else: ?>

                            <img
                                src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama')) ?>"
                                width="45"
                                height="45"
                                style="border-radius:50%;"
                            >

                        <?php endif; ?>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                        <li class="px-3 py-2">

                            <div class="fw-bold">
                                <?= session()->get('nama') ?>
                            </div>

                            <small class="text-muted">
                                <?= session()->get('role') ?>
                            </small>

                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>

                            <a
                                class="dropdown-item"
                                href="<?= base_url('profile') ?>"
                            >
                                Setting Profile
                            </a>

                        </li>

                        <li>

                            <a
                                class="dropdown-item text-danger"
                                href="<?= base_url('logout') ?>"
                            >
                                Logout
                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <div class="p-8">

            <?= $this->renderSection('content') ?>

        </div>

    </main>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const btn = document.getElementById('toggleSidebar');

    btn.addEventListener('click', function () {

        sidebar.classList.toggle('sidebar-collapsed');

    });

});
</script>
</body>
</html>