<?php 
require_once('../Connections/koneksi.php'); 

// HAPUS fungsi GetSQLValueString di sini
// HAPUS mysqli_select_db di sini

$query_data = "SELECT * FROM jdwl_dokter INNER JOIN v_dokter ON jdwl_dokter.kd_dokter = v_dokter.kd_dokter";
$data = mysqli_query($koneksi, $query_data);

// Penanganan Error yang Aman
if (!$data) {
    echo "<div class='alert alert-danger'>Terjadi kesalahan saat memuat data.</div>"; 
    error_log("MySQL Query Error: " . mysqli_error($koneksi)); 
    exit; 
}

$row_data = mysqli_fetch_assoc($data);
$totalRows_data = mysqli_num_rows($data);
?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td align="left" valign="middle"><h2 class="card-title"><b>Data Jadwal Dokter</b></h2></td>
                        <td width="80%"></td>
                        <td align="right"></td>
                    </tr>
                </table>
                <p>
                
                <?php if ($totalRows_data > 0) { // Cek jika ada data sebelum menampilkan tabel ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Jadwal</th>
                            <th>Nama Dokter</th>
                            <th>NIP Dokter</th>
                            <th>Spesialis</th>
                            <th>Nama Poli</th>
                            <th>Waktu Praktik</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php $no=1; do { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row_data['id_jadwal']; ?></td>
                                <td><?= $row_data['nm_dokter']; ?></td>
                                <td><?= $row_data['nip_dokter']; ?></td>
                                <td><?= $row_data['spesialis']; ?></td>
                                <td><?= $row_data['nm_poli']; ?></td>
                                <td><?= $row_data['hari']; ?> <br> <?= $row_data['jam_awal']; ?> s.d <?= $row_data['jam_akhir']; ?></td>
                                <td align="center" valign="top"> 
                                    <a href="?page=e_jadwal_dokter&id_jadwal=<?= $row_data['id_jadwal']; ?>">
                                        <button type="button" class="btn btn-warning btn-icon-text"><font color="white"><b><i class="mdi mdi-table-edit menu-icon"></i> </b></font></button>
                                    </a>
                                    <a href="h_jadwal.php?id_jadwal=<?= $row_data['id_jadwal']; ?>">
                                        <button type="button" class="btn btn-danger btn-icon-text"><font color="white"><b> <i class="mdi mdi-delete-forever menu-icon"></i> </b></font></button>
                                    </a>
                                </td> 
                            </tr>
                        <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
                    </tbody>
                </table>
                <?php } else { ?>
                    <div class="alert alert-info">Belum ada data jadwal dokter yang tersedia.</div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?php
// Bebaskan memori dari hasil query
mysqli_free_result($data); 
?>