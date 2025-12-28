<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <span class="navbar-brand">
        <i class="bi bi-person-circle"></i>
        <?= session('role') ?>
    </span>

    <span class="text-muted">
        <?= date('d M Y') ?>
    </span>
</nav>