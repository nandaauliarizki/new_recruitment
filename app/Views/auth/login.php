
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Login - Sistem Rekrutmen
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

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            margin:0;
            padding:0;
            background:#f7f3ec;
        }

        /* ================= */
        /* LOGIN WRAPPER */
        /* ================= */

        .login-wrapper{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        /* ================= */
        /* LOGIN CARD */
        /* ================= */

        .login-card{

            width:100%;
            max-width:520px;

            background:#ffffff;

            border-radius:20px;

            padding:50px;

            border:1px solid #e8d8b5;

            box-shadow:
                0 10px 35px rgba(0,0,0,0.08);

        }

        /* ================= */
        /* TITLE */
        /* ================= */

        .login-title{

            text-align:center;

            font-size:30px;

            font-weight:700;

            color:#111;

            margin-bottom:10px;

        }

        .login-subtitle{

            text-align:center;

            color:#666;

            margin-bottom:40px;

            font-size:16px;

        }

        /* ================= */
        /* FORM */
        /* ================= */

        .form-label{

            font-weight:600;

            margin-bottom:10px;

            color:#222;

        }

        .form-control{

            height:58px;

            border-radius:14px;

            border:1px solid #d9c7a3;

            padding-left:18px;

            font-size:16px;

        }

        .form-control:focus{

            box-shadow:none;

            border-color:#ffc107;

        }

        /* ================= */
        /* PASSWORD AREA */
        /* ================= */

        .password-wrapper{
            position:relative;
        }

        .password-icon{

            position:absolute;

            right:18px;

            top:50%;

            transform:translateY(-50%);

            color:#777;

            cursor:pointer;

            font-size:20px;

        }

        /* ================= */
        /* OPTIONS */
        /* ================= */

        .login-options{

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-top:18px;

            margin-bottom:28px;

            font-size:14px;

        }


        /* ================= */
        /* BUTTON */
        /* ================= */

        .btn-login{

            height:58px;

            border:none;

            border-radius:14px;

            background:#ffc107;

            font-size:18px;

            font-weight:700;

            color:#222;

            transition:0.3s;

        }

        .btn-login:hover{

            background:#e0a800;

        }

        /* ================= */
        /* DIVIDER */
        /* ================= */

        .divider{

            text-align:center;

            margin:35px 0;

            position:relative;

            color:#777;

            font-size:14px;

        }

        .divider::before{

            content:'';

            position:absolute;

            left:0;

            top:50%;

            width:42%;

            height:1px;

            background:#ddd;

        }

        .divider::after{

            content:'';

            position:absolute;

            right:0;

            top:50%;

            width:42%;

            height:1px;

            background:#ddd;

        }

       
       

        /* ================= */
        /* REGISTER */
        /* ================= */

        .register-text{

            margin-top:35px;

            text-align:center;

            font-size:15px;

            color:#555;

        }

        .register-text a{

            text-decoration:none;

            font-weight:700;

            color:#b07d00;

        }

        /* ================= */
        /* ALERT */
        /* ================= */

        .alert{

            border-radius:12px;

            margin-bottom:20px;

        }

        /* ================= */
        /* MOBILE */
        /* ================= */

        @media(max-width:576px){

            .login-card{

                padding:35px 25px;

            }

            .login-title{

                font-size:32px;

            }

        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <!-- TITLE -->

        <h1 class="login-title">
            Welcome Back
        </h1>

        <p class="login-subtitle">
            Please enter your details to sign in
        </p>

        <!-- ERROR -->

        <?php if(session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">

                <?= session()->getFlashdata('error') ?>

            </div>

        <?php endif; ?>

        <!-- FORM -->

        <form
            action="<?= base_url('login/proses') ?>"
            method="post"
        >

            <!-- EMAIL -->

            <div class="mb-4">

                <label class="form-label">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="name@company.com"
                    required
                >

            </div>

            <!-- PASSWORD -->

            <div class="mb-3">

                <div class="d-flex justify-content-between">

                    <label class="form-label">
                        Password
                    </label>

                </div>

                <div class="password-wrapper">

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter password"
                        id="password"
                        required
                    >

                    <i class="bi bi-eye password-icon"
                       id="togglePassword"></i>

                </div>

            </div>

            <!-- OPTIONS -->

            <div class="login-options">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="remember"
                    >

                    <label class="form-check-label"
                           for="remember">

                        Remember for 30 days

                    </label>

                </div>

            </div>

            <!-- BUTTON -->

            <button
                type="submit"
                class="btn btn-login w-100"
            >

                Login

            </button>

        </form>

        <!-- DIVIDER -->

        <div class="divider">
            OR
        </div>

       

        <!-- REGISTER -->

        <div class="register-text">

            Don't have an account?

            <a href="<?= base_url('register') ?>">

                Sign up

            </a>

        </div>

    </div>

</div>

<!-- SHOW PASSWORD -->

<script>

    const togglePassword =
        document.getElementById('togglePassword');

    const password =
        document.getElementById('password');

    togglePassword.addEventListener('click', function(){

        const type =
            password.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        password.setAttribute('type', type);

        this.classList.toggle('bi-eye');

        this.classList.toggle('bi-eye-slash');

    });

</script>

</body>

</html>
