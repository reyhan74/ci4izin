<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>400 - Permintaan Bermasalah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --danger: #ef4444; --bg: #0f172a; --glass: rgba(255, 255, 255, 0.03); --border: rgba(255, 255, 255, 0.1); }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .glow { position: absolute; width: 40vw; height: 40vw; background: var(--danger); filter: blur(100px); opacity: 0.1; z-index: 0; border-radius: 50%; }
        .container { position: relative; z-index: 10; text-align: center; background: var(--glass); backdrop-filter: blur(20px); border: 1px solid var(--border); padding: 4rem 2rem; border-radius: 40px; width: 90%; max-width: 500px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); }
        .icon { font-size: 4rem; color: var(--danger); margin-bottom: 1rem; display: block; }
        h1 { font-size: 5rem; font-weight: 800; margin: 0; line-height: 1; color: #fff; }
        h2 { font-size: 1.5rem; margin: 1rem 0; color: var(--danger); }
        .msg-box { background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 12px; border: 1px dashed var(--border); margin-bottom: 2rem; font-size: 0.9rem; color: #94a3b8; }
        .btn { display: inline-flex; align-items: center; gap: 10px; background: #fff; color: var(--bg); padding: 14px 30px; border-radius: 18px; text-decoration: none; font-weight: 700; transition: 0.3s; }
        .btn:hover { background: var(--danger); color: #fff; transform: translateY(-5px); }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="container">
        <span class="icon"><i class="bi bi-exclamation-octagon-fill"></i></span>
        <h1>400</h1>
        <h2>Permintaan Tidak Valid</h2>
        <div class="msg-box">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                Maaf, permintaan Anda tidak dapat diproses karena kesalahan sistem atau data tidak lengkap.
            <?php endif; ?>
        </div>
        <a href="javascript:history.back()" class="btn">
            <i class="bi bi-arrow-left"></i> Kembali Sebelumnya
        </a>
    </div>
</body>
</html>