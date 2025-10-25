<?php
/**
 * Mengambil tanggal berobat berdasarkan dokter
 * Kompatibel PHP 5.6 – 8.3
 */

require_once '../config/database.php';

if (!isset($_GET['nm_dokter'])) {
    exit('');
}

$nm_dokter = $_GET['nm_dokter'];

try {
    $stmt = $pdo->prepare("SELECT tgl_berobat FROM jdwl_dokter WHERE nm_dokter = ? ORDER BY tgl_berobat ASC LIMIT 1");
    $stmt->execute(array($nm_dokter));
    $row = $stmt->fetch();

    if ($row && !empty($row['tgl_berobat'])) {
        echo htmlspecialchars($row['tgl_berobat']);
    } else {
        echo '';
    }
} catch (PDOException $e) {
    echo '';
}
?>
