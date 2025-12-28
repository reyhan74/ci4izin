<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | E-Presensi Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --accent: #4361ee;
            --bg-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            color: #f8fafc;
            overflow: hidden;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 16px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        }

        .btn-login {
            background: var(--accent);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        .btn-login:hover {
            background: #3a0ca3;
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -3px rgba(67, 97, 238, 0.4);
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .input-group-text {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            border-radius: 12px;
        }

        /* Float animation */
        .floating-circles div {
            position: absolute;
            background: rgba(67, 97, 238, 0.05);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>

<body>

    <div class="floating-circles d-none d-md-block">
        <div style="width: 300px; height: 300px; top: -100px; left: -100px;"></div>
        <div style="width: 200px; height: 200px; bottom: -50px; right: 10%;"></div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4 px-4">
                
                <div class="text-center mb-4 animate__animated animate__fadeInDown">
                    <div class="brand-logo">
                        <i class="bi bi-qr-code-scan text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-1">E-Presensi</h4>
                    <p class="text-white-50 small">Selamat datang kembali, Admin!</p>
                </div>

                <div class="login-card animate__animated animate__fadeInUp">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger bg-danger bg-opacity-10 border-0 text-danger small rounded-3 mb-4 d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('/login') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-white-50">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="admin@sekolah.id" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label small fw-bold text-white-50">Password</label>
                                <a href="#" class="text-accent small text-decoration-none" style="color: var(--accent)">Lupa?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                            Masuk Ke Panel <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>
                </div>

                <p class="text-center mt-4 text-white-50 x-small">
                    &copy; <?= date('Y') ?> IT Support  By rhn.dev
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>