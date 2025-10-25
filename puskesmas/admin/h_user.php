<?php
require_once('../Connections/koneksi.php');

// Pastikan koneksi aktif
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses hapus user berdasarkan username
if (isset($_GET['username']) && $_GET['username'] != "") {
    $username = mysqli_real_escape_string($koneksi, $_GET['username']);

    // Jalankan query hapus
    $query_delete = "DELETE FROM login WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query_delete);

    if ($result) {
        echo "<script>
                alert('Data user berhasil dihapus!');
                document.location.href='index.php?page=data_user';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                document.location.href='index.php?page=data_user';
              </script>";
    }
}
?>
