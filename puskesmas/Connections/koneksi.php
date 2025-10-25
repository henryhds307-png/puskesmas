<?php
// koneksi.php
$hostname_koneksi = "localhost";
$database_koneksi = "db_puskesmas";
$username_koneksi = "root";
$password_koneksi = "";

// Membuat koneksi ke database (MySQLi)
$koneksi = mysqli_connect($hostname_koneksi, $username_koneksi, $password_koneksi, $database_koneksi);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set karakter koneksi ke UTF-8 (penting agar data tidak rusak saat pakai karakter khusus)
if (!mysqli_set_charset($koneksi, "utf8")) {
    die("Gagal mengatur karakter set UTF-8: " . mysqli_error($koneksi));
}

// (Opsional) Matikan laporan warning MySQLi jika kamu ingin error handling manual
// mysqli_report(MYSQLI_REPORT_OFF);
?>
