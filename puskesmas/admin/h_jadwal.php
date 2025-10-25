<?php
require_once('../Connections/koneksi.php');

// Pastikan parameter dikirim
if (isset($_GET['id_jadwal']) && $_GET['id_jadwal'] != "") {
    $id_jadwal = $_GET['id_jadwal'];

    // Siapkan query hapus dengan prepared statement
    $stmt = mysqli_prepare($koneksi, "DELETE FROM jdwl_dokter WHERE id_jadwal = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id_jadwal);
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil hapus, arahkan kembali ke daftar
            header("Location: index.php?page=jadwal_dokter");
            exit;
        } else {
            die("Gagal menghapus data: " . mysqli_error($koneksi));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Gagal menyiapkan query: " . mysqli_error($koneksi));
    }
} else {
    echo "<script>alert('ID Jadwal tidak ditemukan!'); window.location='index.php?page=jadwal_dokter';</script>";
}
?>
