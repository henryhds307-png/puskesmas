<?php
require_once('../Connections/koneksi.php');

if (isset($_GET['kd_dokter']) && $_GET['kd_dokter'] != "") {

  // Bersihkan input
  $kd_dokter = mysqli_real_escape_string($koneksi, $_GET['kd_dokter']);

  // Hapus data dokter
  $deleteSQL1 = "DELETE FROM dokter WHERE kd_dokter = '$kd_dokter'";
  $deleteSQL2 = "DELETE FROM jdwl_dokter WHERE kd_dokter = '$kd_dokter'";

  // Jalankan query
  $ok1 = mysqli_query($koneksi, $deleteSQL1);
  $ok2 = mysqli_query($koneksi, $deleteSQL2);

  if ($ok1 && $ok2) {
    echo "<script>
      alert('Data dokter berhasil dihapus!');
      document.location.href='index.php?page=data_dokter';
    </script>";
  } else {
    echo "<script>
      alert('Terjadi kesalahan: " . mysqli_error($koneksi) . "');
      history.back();
    </script>";
  }

}
?>
