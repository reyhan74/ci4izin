<?php $role = session('role'); ?>

<div class="d-flex flex-column p-3 text-white bg-dark vh-100" style="width: 250px;">
    <h5 class="mb-4">Admin Panel</h5>

    <ul class="nav nav-pills flex-column mb-auto gap-1">

        <li class="nav-item">
            <a href="<?= site_url('admin/dashboard') ?>" class="nav-link text-white">
                🏠 Dashboard
            </a>
        </li>

        <?php if ($role === 'admin'): ?>
        <li>
            <a href="<?= site_url('admin/users') ?>" class="nav-link text-white">
                👤 Manajemen User
            </a>
        </li>
        <?php endif ?>

        <?php if (in_array($role, ['admin', 'guru'])): ?>
        <li>
            <a href="<?= site_url('admin/siswa') ?>" class="nav-link text-white">
                🎓 Data Siswa
            </a>
        </li>
        <?php endif ?>

        <li>
            <a href="<?= site_url('admin/izin') ?>" class="nav-link text-white">
                📄 Data Izin
            </a>
        </li>

    </ul>

    <hr>

    <div>
        <small><?= esc(session('nama')) ?></small><br>
        <span class="badge bg-secondary"><?= esc($role) ?></span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-light w-100 mt-2">
            Logout
        </a>
    </div>
</div>