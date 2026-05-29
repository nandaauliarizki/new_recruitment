<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Register - Sistem Rekrutmen
    </title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family:'Poppins', sans-serif;
        }

        body{

            margin:0;
            padding:0;

            background:#f7f3ec;

        }

        /* ================= */
        /* WRAPPER */
        /* ================= */

        .register-wrapper{

            min-height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

            padding:30px;

        }

        /* ================= */
        /* CARD */
        /* ================= */

        .register-card{

            width:100%;
            max-width:580px;

            background:#ffffff;

            border-radius:22px;

            padding:45px;

            border:1px solid #e7d6b5;

            box-shadow:
                0 10px 35px rgba(0,0,0,0.08);

        }

        /* ================= */
        /* TITLE */
        /* ================= */

        .register-title{

            text-align:center;

            font-size:38px;

            font-weight:700;

            color:#111;

            margin-bottom:10px;

        }

        .register-subtitle{

            text-align:center;

            color:#666;

            margin-bottom:35px;

        }

        /* ================= */
        /* FORM */
        /* ================= */

        .form-label{

            font-weight:600;

            margin-bottom:8px;

            color:#222;

        }

        .form-control{

            height:56px;

            border-radius:14px;

            border:1px solid #d9c7a3;

            padding-left:18px;

        }

        .form-control:focus{

            box-shadow:none;

            border-color:#ffc107;

        }

        /* ================= */
        /* BUTTON */
        /* ================= */

        .btn-register{

            height:56px;

            border:none;

            border-radius:14px;

            background:#ffc107;

            font-size:17px;

            font-weight:700;

            color:#222;

            transition:0.3s;

        }

        .btn-register:hover{

            background:#e0a800;

        }

        /* ================= */
        /* LOGIN LINK */
        /* ================= */

        .login-link{

            text-align:center;

            margin-top:28px;

            color:#666;

        }

        .login-link a{

            text-decoration:none;

            color:#b07d00;

            font-weight:700;

        }

        /* ================= */
        /* MOBILE */
        /* ================= */

        @media(max-width:576px){

            .register-card{

                padding:35px 25px;

            }

            .register-title{

                font-size:30px;

            }

        }

    </style>

</head>

<body>

<div class="register-wrapper">

    <div class="register-card">

        <!-- TITLE -->

        <h1 class="register-title">
            Create Account
        </h1>

        <p class="register-subtitle">
            Register to apply for job vacancies
        </p>

        <!-- FORM -->

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-3 mb-4">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php
        $fieldErrors = $fieldErrors ?? [];
        if ($fieldErrors !== []):
        ?>
            <div class="alert alert-danger rounded-3 mb-4">
                <strong>Periksa data berikut:</strong>
                <ul class="mb-0 ps-3 mt-2">
                    <?php foreach ($fieldErrors as $field => $err): ?>
                        <li>
                            <?php if (is_string($field) && ! is_numeric($field)): ?>
                                <strong><?= esc(ucfirst(str_replace('_', ' ', $field))) ?>:</strong>
                            <?php endif; ?>
                            <?= esc(is_array($err) ? implode(' ', $err) : $err) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-3 mb-4"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <form action="<?= base_url('register/proses') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control <?= ! empty($fieldErrors['nama']) ? 'is-invalid' : '' ?>"
                       placeholder="Hanya huruf dan spasi" value="<?= old('nama') ?>" required>
                <?php if (! empty($fieldErrors['nama'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['nama']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control <?= ! empty($fieldErrors['email']) ? 'is-invalid' : '' ?>"
                       placeholder="nama@email.com" value="<?= old('email') ?>" required>
                <?php if (! empty($fieldErrors['email'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['email']) ?></div>
                <?php endif; ?>
            </div>

            <?php if (! empty($has_no_telepon)): ?>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                <input type="text" name="no_telepon" class="form-control <?= ! empty($fieldErrors['no_telepon']) ? 'is-invalid' : '' ?>"
                       placeholder="081234567890" value="<?= old('no_telepon') ?>" inputmode="numeric" required>
                <?php if (! empty($fieldErrors['no_telepon'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['no_telepon']) ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (! empty($has_tanggal_lahir)): ?>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_lahir" class="form-control <?= ! empty($fieldErrors['tanggal_lahir']) ? 'is-invalid' : '' ?>"
                       value="<?= old('tanggal_lahir') ?>" required>
                <?php if (! empty($fieldErrors['tanggal_lahir'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['tanggal_lahir']) ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control <?= ! empty($fieldErrors['password']) ? 'is-invalid' : '' ?>"
                       placeholder="Min. 6 karakter" required>
                <?php if (! empty($fieldErrors['password'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['password']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirm" class="form-control <?= ! empty($fieldErrors['password_confirm']) ? 'is-invalid' : '' ?>"
                       required>
                <?php if (! empty($fieldErrors['password_confirm'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($fieldErrors['password_confirm']) ?></div>
                <?php endif; ?>
            </div>

            <!-- BUTTON -->

            <button
                type="submit"
                class="btn btn-register w-100"
            >

                Register

            </button>

        </form>

        <!-- LOGIN -->

        <div class="login-link">

            Already have an account?

            <a href="<?= base_url('login') ?>">

                Login

            </a>

        </div>

    </div>

</div>

</body>

</html>