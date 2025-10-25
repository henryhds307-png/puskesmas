<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_puskesmas");
if ($koneksi) {
    echo "Koneksi berhasil!";
} else {
    echo "Gagal konek: " . mysqli_connect_error();
}
?>
