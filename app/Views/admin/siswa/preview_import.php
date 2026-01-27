<div class="container-fluid">
    <h4 class="mb-3">Preview Data Import</h4>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>ID Kelas</th>
                    <th>No HP</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr class="<?= $r['valid'] ? '' : 'table-danger'; ?>">
                    <td><?= esc($r['nis']) ?></td>
                    <td><?= esc($r['nama']) ?></td>
                    <td><?= esc($r['jk']) ?></td>
                    <td><?= esc($r['kelas']) ?></td>
                    <td><?= esc($r['no_hp']) ?></td>
                    <td>
                        <?= $r['valid']
                            ? '<span class="badge badge-success">Valid</span>'
                            : '<span class="badge badge-danger">Invalid</span>' ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <form action="/admin/siswa/import" method="post">
        <?= csrf_field() ?>
        <button class="btn btn-success mt-3">
            <i class="fas fa-check"></i> Import Sekarang
        </button>
        <a href="/admin/siswa" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
