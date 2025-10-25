<?php
// pendaftaran.php
// -------------------------------------------
// Versi modern & aman by ChatGPT (Henry Damanik Edition)
// -------------------------------------------

// Koneksi database
require_once 'config.php'; // pastikan file ini berisi variabel $koneksi = new mysqli(...);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dengan filter
    $nm_pasien   = trim($_POST['nm_pasien'] ?? '');
    $jenkel      = trim($_POST['jenkel'] ?? '');
    $tmpt_lahir  = trim($_POST['tmpt_lahir'] ?? '');
    $tgl_lahir   = trim($_POST['tgl_lahir'] ?? '');
    $alamat      = trim($_POST['alamat'] ?? '');
    $kd_poli     = trim($_POST['kd_poli'] ?? '');
    $nm_dokter   = trim($_POST['nm_dokter'] ?? '');
    $tgl_berobat = trim($_POST['tgl_berobat'] ?? '');
    $keluhan     = trim($_POST['keluhan'] ?? '');
    $no_hp       = trim($_POST['no_hp'] ?? '');

    // Validasi sederhana
    if ($nm_pasien === '' || $jenkel === '' || $tgl_lahir === '' || $alamat === '') {
        echo "<script>alert('Harap lengkapi data wajib diisi!'); history.back();</script>";
        exit;
    }

    // Siapkan query (Prepared Statement)
    $sql = "INSERT INTO pasien 
        (nm_pasien, jenkel, tmpt_lahir, tgl_lahir, alamat, kd_poli, nm_dokter, tgl_berobat, keluhan, no_hp)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param(
        "ssssssssss",
        $nm_pasien, $jenkel, $tmpt_lahir, $tgl_lahir,
        $alamat, $kd_poli, $nm_dokter, $tgl_berobat, $keluhan, $no_hp
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Data pasien berhasil ditambahkan!');
            window.location.href = 'jadwal_penanganan.php';
        </script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
    $koneksi->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran Pasien</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Pendaftaran Pasien</h4>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="" id="formPendaftaran" novalidate>

                <div class="mb-3">
                    <label class="form-label">Nama Pasien *</label>
                    <input type="text" name="nm_pasien" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin *</label>
                    <select name="jenkel" class="form-select" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tmpt_lahir" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir *</label>
                        <input type="date" name="tgl_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat *</label>
                    <textarea name="alamat" class="form-control" rows="2" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Poli</label>
                        <input type="text" name="kd_poli" value="" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Dokter</label>
                        <input type="text" name="nm_dokter" value="" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Berobat</label>
                    <input type="date" name="tgl_berobat" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" maxlength="15">
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validasi frontend
document.getElementById('formPendaftaran').addEventListener('submit', function(e) {
    const nama = this.nm_pasien.value.trim();
    const jenkel = this.jenkel.value;
    const tgl = this.tgl_lahir.value;

    if (!nama || !jenkel || !tgl) {
        alert('Harap isi semua kolom wajib bertanda *');
        e.preventDefault();
    }
});
</script>

</body>
</html>
