<?php
// Nonaktifkan error notice tapi tetap tampilkan error penting
error_reporting(E_ALL & ~E_NOTICE);

// Konfigurasi database
$host = 'localhost';
$database = 'db_puskesmas';
$user = 'root';
$pass = '';

// Koneksi ke database menggunakan mysqli
$koneksi = mysqli_connect($host, $user, $pass, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// (Opsional) Set karakter UTF-8 agar tidak ada masalah huruf
mysqli_set_charset($koneksi, "utf8");
?>
