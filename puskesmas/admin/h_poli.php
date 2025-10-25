<?php
require_once('../Connections/koneksi.php');

// Pastikan koneksi aktif
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Hapus data berdasarkan kd_poli
if (isset($_GET['kd_poli']) && $_GET['kd_poli'] != "") {
    $kd_poli = mysqli_real_escape_string($koneksi, $_GET['kd_poli']);

    // Jalankan query hapus
    $query_delete = "DELETE FROM poli WHERE kd_poli = '$kd_poli'";
    $result = mysqli_query($koneksi, $query_delete);

    if ($result) {
        echo "<script>
                alert('Data Poli berhasil dihapus!');
                document.location.href='index.php?page=data_poli';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                document.location.href='index.php?page=data_poli';
              </script>";
    }
}
?>
