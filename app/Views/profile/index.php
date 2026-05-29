<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Setting Profile</h2>

            <p class="text-muted mb-0">
                Kelola informasi akun dan keamanan password
            </p>
        </div>

    </div>

    <!-- ALERT SUCCESS -->
    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4">

            <?= session()->getFlashdata('success') ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <!-- ALERT ERROR -->
    <?php if(session()->getFlashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4">

            <?= session()->getFlashdata('error') ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <div class="row g-4">

        <!-- PROFILE CARD -->
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <!-- TOP BANNER -->
                <div class="bg-dark" style="height:120px;"></div>

                <div class="card-body text-center px-4 pb-4">

                    <!-- FOTO -->
                    <div style="margin-top:-70px;">

                        <?php if(session()->get('foto')): ?>

                            <img
                                src="<?= base_url('uploads/profile/' . session()->get('foto')) ?>"
                                width="130"
                                height="130"
                                class="rounded-circle border border-4 border-white shadow"
                                style="object-fit:cover;"
                            >

                        <?php else: ?>

                            <img
                                src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama')) ?>&size=200&background=random"
                                width="130"
                                height="130"
                                class="rounded-circle border border-4 border-white shadow"
                            >

                        <?php endif; ?>

                    </div>

                    <!-- INFO -->
                    <div class="mt-3">

                        <h4 class="fw-bold mb-1">
                            <?= session()->get('nama') ?>
                        </h4>

                        <p class="text-muted mb-2">
                            <?= session()->get('email') ?>
                        </p>

                        <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase">
                            <?= session()->get('role') ?>
                        </span>

                    </div>

                    <hr class="my-4">

                    <div class="row text-center g-3">

                        <div class="col-6">

                            <div class="bg-light rounded-4 p-3">

                                <h5 class="fw-bold mb-1">
                                    Profile
                                </h5>

                                <small class="text-muted">
                                    Active Account
                                </small>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="bg-light rounded-4 p-3">

                                <h5 class="fw-bold mb-1">
                                    Secure
                                </h5>

                                <small class="text-muted">
                                    Password Protected
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- FORM -->
        <div class="col-lg-7">

            <!-- UPDATE PROFILE -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-2 mb-4">

                        <div class="bg-primary bg-opacity-10 rounded-3 p-2">

                            <span class="material-symbols-outlined text-primary">
                                person
                            </span>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">
                                Informasi Profile
                            </h5>

                            <small class="text-muted">
                                Perbarui data akun anda
                            </small>

                        </div>

                    </div>

                    <form
                        action="<?= base_url('profile/update') ?>"
                        method="post"
                        enctype="multipart/form-data"
                    >

                        <?= csrf_field() ?>

                        <div class="row g-3">

                            <!-- NAMA -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control rounded-3"
                                    value="<?= $user['nama'] ?>"
                                >

                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control rounded-3"
                                    value="<?= $user['email'] ?>"
                                >

                            </div>

                            <!-- FOTO -->
                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Upload Foto Profile
                                </label>

                                <input
                                    type="file"
                                    name="foto"
                                    class="form-control rounded-3"
                                >

                            </div>

                        </div>

                        <button class="btn btn-primary rounded-3 px-4 mt-4">
                            Simpan Perubahan
                        </button>

                    </form>

                </div>

            </div>

            <!-- PASSWORD -->
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-2 mb-4">

                        <div class="bg-danger bg-opacity-10 rounded-3 p-2">

                            <span class="material-symbols-outlined text-danger">
                                lock
                            </span>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">
                                Ubah Password
                            </h5>

                            <small class="text-muted">
                                Pastikan password anda aman
                            </small>

                        </div>

                    </div>

                    <form
                        action="<?= base_url('profile/change-password') ?>"
                        method="post"
                    >

                        <?= csrf_field() ?>

                        <div class="row g-3">

                            <!-- OLD PASSWORD -->
                            <div class="col-md-12">

                                <label class="form-label fw-semibold">
                                    Password Lama
                                </label>

                                <input
                                    type="password"
                                    name="old_password"
                                    class="form-control rounded-3"
                                >

                            </div>

                            <!-- NEW PASSWORD -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Password Baru
                                </label>

                                <input
                                    type="password"
                                    name="new_password"
                                    class="form-control rounded-3"
                                >

                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    name="confirm_password"
                                    class="form-control rounded-3"
                                >

                            </div>

                        </div>

                        <button class="btn btn-dark rounded-3 px-4 mt-4">
                            Update Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>