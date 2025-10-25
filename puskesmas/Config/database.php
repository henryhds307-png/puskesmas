<?php
/**
 * Database Connection File
 * Kompatibel: PHP 5.6 – 8.3
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ======= KONFIGURASI DATABASE =======
$host     = "localhost";
$dbname   = "db_puskesmas"; // Ganti sesuai nama database kamu
$username = "root";         // Default XAMPP user
$password = "";             // Kosongkan jika tanpa password (XAMPP)

// ======= KONFIGURASI PDO =======
try {
    $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";

    $pdo = new PDO($dsn, $username, $password);

    // Mode error ke exception agar mudah debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch mode default jadi associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
