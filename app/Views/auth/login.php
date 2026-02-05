<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin | SMK CANDA BHIRAWA PARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #4361ee;
            --primary-2: #6b7bff;
            --muted: #64748b;
            --bg: #0f172a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0 }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, #16243a 50%, #0d1f3c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
            overflow-x: hidden;
        }

        /* --- Header --- */
        .top-nav { width: 100%; padding: 18px 28px; display: flex; justify-content: space-between; align-items: center }
        .brand-header { display: flex; gap: 12px; align-items: center }
        .brand-logo-nav { width: 44px; height: 44px; border-radius: 12px; background: rgba(67,97,238,0.14); display: flex; align-items: center; justify-content: center; font-size: 20px }
        .brand-text { font-weight: 800; font-size: 1.05rem; color: #fff; line-height: 1.2 }

        .btn-glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 9px 14px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.3s }
        .btn-glass:hover { background: rgba(255,255,255,0.15); color: #fff }

        /* --- Main Content --- */
        .main-container { 
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 24px; 
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-card { 
            background: #fff; 
            color: #0b1b2b; 
            border-radius: 24px; 
            padding: 35px; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.3); 
            text-align: center;
        }

        /* Container untuk Logo IMG */
        .brand-img-container {
            width: 80px; 
            height: 80px; 
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-img-main {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Memastikan logo tidak terdistorsi */
        }

        /* --- Form Styling --- */
        .form-label { color: var(--muted) !important; text-align: left; display: block; margin-bottom: 8px; }
        .input-group-text { background: #f8fafc; border: 1px solid #e2e8f0; color: var(--muted); border-radius: 12px 0 0 12px }
        .form-control { background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; padding: 12px; border-radius: 0 12px 12px 0 }
        .form-control:focus { box-shadow: 0 0 0 4px rgba(67,97,238,0.1); border-color: var(--primary); outline: none }

        #password { border-radius: 0; border-right: none; }
        #togglePassword { border: 1px solid #e2e8f0; background: #f8fafc; color: var(--muted); border-radius: 0 12px 12px 0; border-left: none }

        .btn-login { 
            width: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-2)); 
            color: #fff; border: none; padding: 14px; border-radius: 12px; 
            font-weight: 700; transition: 0.3s; margin-top: 10px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(67,97,238,0.25); color: #fff }

        .divider { display: flex; align-items: center; margin: 25px 0; color: #cbd5e1; font-size: 0.85rem; }
        .divider::before, .divider::after { content: ""; flex: 1; height: 1px; background: #e2e8f0; }
        .divider span { padding: 0 12px; }

        .btn-siswa {
            width: 100%; border: 1px solid #e2e8f0; color: var(--primary); 
            padding: 12px; border-radius: 12px; text-decoration: none; 
            display: inline-block; font-weight: 600; transition: 0.3s;
        }
        .btn-siswa:hover { background: #f8fafc; color: var(--primary-2) }

        @media(max-width:576px) {
            .login-card { padding: 25px 20px; }
        }
    </style>
</head>

<body>

    <nav class="top-nav">
        <div class="brand-header">
            <div class="brand-logo-nav">
                <i class="bi bi-buildings text-primary"></i>
            </div>
            <div>
                <div class="brand-text">E-IZIN</div>
                <div class="d-block d-md-none" style="color: rgba(255,255,255,0.6); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">
                    SMK CB PARE
                </div>
                <div class="d-none d-md-block" style="color: rgba(255,255,255,0.6); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    SMK CANDA BHIRAWA PARE
                </div>
            </div>
        </div>
        <a href="<?= (function_exists('base_url')) ? base_url('/') : '#' ?>" class="btn-glass">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </nav>

    <div class="main-container">
        <div class="login-wrapper animate__animated animate__fadeInUp">
            
            <div class="login-card">
                <div class="brand-img-container">
                    <img src="<?= base_url('/img/logo.png') ?>" alt="Logo Admin" class="brand-img-main">
                </div>
                
                <h4 class="fw-bold text-dark">Login Aplikasi</h4>
                <p class="small mb-4">Masukkan username dan password anda</p>

                <?php if (isset($session) && $session->getFlashdata('error')) : ?>
                    <div class="alert alert-danger border-0 small rounded-3 mb-4 py-2">
                        <i class="bi bi-exclamation-circle me-1"></i> <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= (function_exists('base_url')) ? base_url('auth/attempt') : '#' ?>">
                    <?= (function_exists('csrf_field')) ? csrf_field() : '' ?>

                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Email Admin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" 
                                value="<?= (isset($old)) ? $old('email') : '' ?>" placeholder="email@email.com" required>
                        </div>
                    </div>

                    <div class="mb-4 text-start">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" 
                                placeholder="••••••••" required>
                            <button class="btn" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk Ke Panel <i class="bi bi-arrow-right-short ms-1"></i>
                    </button>

                    <div class="divider">
                        <span>ATAU</span>
                    </div>

                    <a href="<?= (function_exists('base_url')) ? base_url('login-siswa') : '#' ?>" class="btn-siswa">
                        <i class="bi bi-person-badge me-2"></i> Login Siswa
                    </a>
                </form>
            </div>

            <p class="text-center mt-4 text-white-50" style="font-size: 0.75rem;">
                &copy; <?= date('Y') ?> IT Support By <b>rhn.dev</b>
            </p>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>