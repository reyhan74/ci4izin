<h3 align="center">Riwayat Izin Siswa</h3>
<table border="1" width="100%" cellpadding="6" cellspacing="0">
    <tr>
        <th>Waktu</th>
        <th>Jenis Izin</th>
        <th>Keterangan</th>
    </tr>
    <?php foreach($histori as $h): ?>
    <tr>
        <td><?= $h['waktu'] ?></td>
        <td><?= $h['jenis_izin'] ?></td>
        <td><?= $h['keterangan'] ?></td>
    </tr>
    <?php endforeach ?>
</table>
