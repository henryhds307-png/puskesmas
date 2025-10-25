<?php
require_once 'Connections/koneksi.php';

// Helper sederhana untuk ambil nilai integer dari GET
function get_int($key, $default = 0) {
    return isset($_GET[$key]) && is_numeric($_GET[$key]) ? (int) $_GET[$key] : $default;
}

// Pengaturan pagination
$maxRows_jadwal = 10;
$pageNum_jadwal = get_int('pageNum_jadwal', 0);
$startRow_jadwal = $pageNum_jadwal * $maxRows_jadwal;

// Query utama dengan JOIN yang benar
$query_jadwal = "
    SELECT pasien.*, poli.nm_poli
    FROM pasien
    INNER JOIN poli ON pasien.kd_poli = poli.kd_poli
    ORDER BY pasien.tgl_berobat DESC
";

// Hitung total data untuk pagination
$totalRowsResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pasien");
if (!$totalRowsResult) {
    die("Database error: " . mysqli_error($koneksi));
}
$totalRowData = mysqli_fetch_assoc($totalRowsResult);
$totalRows_jadwal = (int)$totalRowData['total'];
mysqli_free_result($totalRowsResult);

// Ambil data terbatas sesuai halaman
$query_limit_jadwal = $query_jadwal . " LIMIT " . intval($startRow_jadwal) . ", " . intval($maxRows_jadwal);
$jadwal = mysqli_query($koneksi, $query_limit_jadwal);
if (!$jadwal) {
    die("Query failed: " . mysqli_error($koneksi));
}

// Hitung total halaman
$totalPages_jadwal = ceil($totalRows_jadwal / $maxRows_jadwal) - 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Penanganan Pasien</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .pagination {
            text-align: center;
            margin-top: 15px;
        }
        .pagination a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 2px;
            border: 1px solid #007BFF;
            border-radius: 4px;
            color: #007BFF;
            text-decoration: none;
        }
        .pagination a:hover {
            background-color: #007BFF;
            color: #fff;
        }
        .pagination .active {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Daftar Jadwal Penanganan Pasien</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID - Nama Pasien</th>
            <th>Jenis Kelamin</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Poli</th>
            <th>Tanggal Berobat</th>
            <th>Keluhan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = $startRow_jadwal + 1;
        while ($row_jadwal = mysqli_fetch_assoc($jadwal)) { 
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['id_pasien'] . ' - ' . $row_jadwal['nm_pasien']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['jenkel']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['tmpt_lahir'] . ', ' . $row_jadwal['tgl_lahir']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['alamat']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['nm_poli']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['tgl_berobat']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['keluhan']); ?></td>
            <td><?php echo htmlspecialchars($row_jadwal['status']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($pageNum_jadwal > 0): ?>
        <a href="?pageNum_jadwal=0">&laquo; Awal</a>
        <a href="?pageNum_jadwal=<?php echo max(0, $pageNum_jadwal - 1); ?>">&lsaquo; Sebelumnya</a>
    <?php endif; ?>

    <span class="active">Halaman <?php echo $pageNum_jadwal + 1; ?> dari <?php echo $totalPages_jadwal + 1; ?></span>

    <?php if ($pageNum_jadwal < $totalPages_jadwal): ?>
        <a href="?pageNum_jadwal=<?php echo min($totalPages_jadwal, $pageNum_jadwal + 1); ?>">Berikutnya &rsaquo;</a>
        <a href="?pageNum_jadwal=<?php echo $totalPages_jadwal; ?>">Akhir &raquo;</a>
    <?php endif; ?>
</div>

<?php
// Tutup koneksi & bebaskan hasil
mysqli_free_result($jadwal);
mysqli_close($koneksi);
?>

</body>
</html>
