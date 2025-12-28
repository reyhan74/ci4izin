<!DOCTYPE html>
<html>
<head>
    <title>Scan Izin</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

<h3>Scan QR Izin</h3>

<select id="status">
    <option value="keluar">Keluar</option>
    <option value="kembali">Kembali</option>
</select>

<br><br>

<input type="text" id="keterangan" placeholder="Keterangan">

<div id="reader" style="width:300px"></div>

<form method="post" action="<?= site_url('izin/process') ?>" id="form">
    <input type="hidden" name="qr_code" id="qr_code">
    <input type="hidden" name="status" id="statusField">
    <input type="hidden" name="keterangan" id="ketField">
</form>

<script>
const qr = new Html5Qrcode("reader");

qr.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    (text) => {
        document.getElementById('qr_code').value = text;
        document.getElementById('statusField').value =
            document.getElementById('status').value;
        document.getElementById('ketField').value =
            document.getElementById('keterangan').value;

        qr.stop();
        document.getElementById('form').submit();
    }
);
</script>

</body>
</html>
