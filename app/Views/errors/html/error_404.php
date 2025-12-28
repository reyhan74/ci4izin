<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #4361ee; --bg: #0f172a; --glass: rgba(255, 255, 255, 0.03); --border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .glow { position: absolute; width: 40vw; height: 40vw; background: var(--primary); filter: blur(100px); opacity: 0.15; z-index: 0; border-radius: 50%; }
        .container { position: relative; z-index: 10; text-align: center; background: var(--glass); backdrop-filter: blur(20px); border: 1px solid var(--border); padding: 4rem 2rem; border-radius: 40px; width: 90%; max-width: 500px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); }
        h1 { font-size: clamp(6rem, 15vw, 9rem); font-weight: 800; margin: 0; line-height: 1; background: linear-gradient(to bottom, #fff, var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -5px; }
        h2 { font-size: 1.5rem; margin: 1rem 0; }
        p { color: #94a3b8; line-height: 1.6; margin-bottom: 2.5rem; }
        .btn { display: inline-flex; align-items: center; gap: 10px; background: var(--primary); color: #fff; padding: 14px 30px; border-radius: 18px; text-decoration: none; font-weight: 700; transition: 0.3s; }
        .btn:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(67,97,238,0.4); filter: brightness(1.1); }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="container">
        <h1>404</h1>
        <h2>Halaman Hilang</h2>
        <p>Maaf, alamat yang Anda tuju tidak ditemukan atau telah dipindahkan ke lokasi lain.</p>
        <a href="<?= site_url('/') ?>" class="btn">
            <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>