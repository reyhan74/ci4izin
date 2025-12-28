<form action="<?= site_url('izin/store') ?>" method="post">
    <?= csrf_field() ?>

    <input type="hidden" name="qr_code" id="qr_code">

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="keluar">Keluar</option>
            <option value="kembali">Kembali</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <input type="text" name="keterangan" class="form-control">
    </div>

    <button class="btn btn-success">Simpan Izin</button>
</form>

<script>
function onScanSuccess(decodedText) {
    document.getElementById('qr_code').value = decodedText;
}
</script>
