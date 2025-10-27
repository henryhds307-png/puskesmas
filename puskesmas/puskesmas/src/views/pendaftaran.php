<?php require_once('../../src/db/koneksi.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Pendaftaran Pasien</h1>
    </header>
    <main>
        <form method="post" action="pendaftaran.php">
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
    </main>
    <footer>
        <p>&copy; 2023 Puskesmas Perumnas Batu 6</p>
    </footer>
</body>
</html>