<?php require_once('../src/db/koneksi.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm_pasien = $_POST['nm_pasien'];
    $jenkel = $_POST['jenkel'];
    $tmpt_lahir = $_POST['tmpt_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $kd_poli = $_POST['kd_poli'];
    $nm_dokter = $_POST['nm_dokter'];
    $tgl_berobat = $_POST['tgl_berobat'];
    $keluhan = $_POST['keluhan'];
    $no_hp = $_POST['no_hp'];

    $insertSQL = sprintf("INSERT INTO pasien (nm_pasien, jenkel, tmpt_lahir, tgl_lahir, alamat, kd_poli, nm_dokter, tgl_berobat, keluhan, no_hp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($nm_pasien, "text"),
        GetSQLValueString($jenkel, "text"),
        GetSQLValueString($tmpt_lahir, "text"),
        GetSQLValueString($tgl_lahir, "date"),
        GetSQLValueString($alamat, "text"),
        GetSQLValueString($kd_poli, "text"),
        GetSQLValueString($nm_dokter, "text"),
        GetSQLValueString($tgl_berobat, "date"),
        GetSQLValueString($keluhan, "text"),
        GetSQLValueString($no_hp, "text"));

    mysqli_select_db($koneksi, $database_koneksi);
    $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));

    echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location.href = 'jadwal_penanganan.php';
          </script>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Form Pendaftaran Pasien</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nm_pasien">Nama Pasien:</label>
            <input type="text" name="nm_pasien" required>

            <label for="jenkel">Jenis Kelamin:</label>
            <select name="jenkel" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>

            <label for="tmpt_lahir">Tempat Lahir:</label>
            <input type="text" name="tmpt_lahir" required>

            <label for="tgl_lahir">Tanggal Lahir:</label>
            <input type="date" name="tgl_lahir" required>

            <label for="alamat">Alamat:</label>
            <textarea name="alamat" required></textarea>

            <label for="tgl_berobat">Tanggal Penanganan:</label>
            <input type="date" name="tgl_berobat" required>

            <label for="keluhan">Keluhan:</label>
            <textarea name="keluhan" required></textarea>

            <label for="no_hp">No. HP/WA:</label>
            <input type="text" name="no_hp" required>

            <input type="submit" value="DAFTARKAN PASIEN">
        </form>
    </div>
</body>
</html>