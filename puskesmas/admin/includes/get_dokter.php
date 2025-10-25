<?php
require_once('../Connections/koneksi.php');

if (isset($_GET['kd_poli']) && $_GET['kd_poli'] != '') {
    $kd_poli = mysqli_real_escape_string($koneksi, $_GET['kd_poli']);

    $query = "SELECT kd_dokter, nm_dokter FROM dokter WHERE kd_poli = '$kd_poli' ORDER BY nm_dokter ASC";
    $result = mysqli_query($koneksi, $query);

    echo "<option value=''>Pilih Dokter</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        // value harus kode dokter saja
        echo "<option value='" . htmlspecialchars($row['kd_dokter']) . "'>" . htmlspecialchars($row['nm_dokter']) . "</option>";
    }
} else {
    echo "<option value=''>Pilih Dokter</option>";
}
?>

