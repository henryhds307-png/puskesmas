<?php
require_once('../Connections/koneksi.php');

// Pastikan koneksi aktif
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query ambil data pasien + poli
$query_data = "
SELECT 
pasien.id_pasien,
pasien.nm_pasien,
pasien.jenkel,
pasien.tmpt_lahir,
pasien.tgl_lahir,
pasien.alamat,
pasien.tgl_berobat,
pasien.keluhan,
pasien.no_hp,
dokter.nm_dokter,
poli.nm_poli
FROM pasien
LEFT JOIN poli ON pasien.kd_poli = poli.kd_poli
LEFT JOIN dokter ON pasien.nm_dokter = dokter.nm_dokter
ORDER BY pasien.id_pasien DESC ";
$data = mysqli_query($koneksi, $query_data);

if (!$data) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td align="left" valign="middle">
                            <h2 class="card-title"><b>Data Pendaftaran Pasien</b></h2>
                        </td>
                        <td width="80%"></td>
                        <td align="right"></td>
                    </tr>
                </table>

                <hr/>
                <h3><b>SELAMAT DATANG <font color="red">ADMINISTRATOR</font> PADA</b></h3>
                <h1><b><font color="blue">SISTEM INFORMASI PENDAFTARAN PASIEN DI PUSKESMAS PERUMNAS BATU 6</font></b></h1>
                <hr/>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Kelamin</th>
                            <th>Tpt/Tgl. Lahir</th>
                            <th>Alamat</th>
                            <th>Poli</th>
                            <th>Dokter</th>
                            <th>Tgl. Berobat</th>
                            <th>Keluhan</th>
                            <th>No HP</th>
                            <th>Respon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row_data = mysqli_fetch_assoc($data)) { 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row_data['id_pasien']); ?> - <?= htmlspecialchars($row_data['nm_pasien']); ?></td>
                            <td><?= htmlspecialchars($row_data['jenkel']); ?></td>
                            <td><?= htmlspecialchars($row_data['tmpt_lahir']); ?>, <?= htmlspecialchars($row_data['tgl_lahir']); ?></td>
                            <td><?= htmlspecialchars($row_data['alamat']); ?></td>
                            <td>
                                <?php 
                                $ps1 = $row_data['nm_poli'];
                                if ($ps1 == 'Belum Ditentukan') {
                                    echo '<font color="red"><b>Poli Belum Ditentukan</b></font>'; 
                                } else {
                                    echo '<b><font color="black">' . htmlspecialchars($ps1) . '</font></b>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                $ps2 = $row_data['nm_dokter'];
                                if (empty($ps2)) {
                                    echo '<font color="red"><b>Dokter Belum Ditentukan</b></font>'; 
                                } else {
                                    echo '<b><font color="black">' . htmlspecialchars($ps2) . '</font></b>';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row_data['tgl_berobat']); ?></td>
                            <td><?= htmlspecialchars($row_data['keluhan']); ?></td>
                            <td><?= htmlspecialchars($row_data['no_hp']); ?></td>
                            <td>
                                <?php 
                                if (empty($ps2) || $ps1 == 'Belum Ditentukan') {
                                    echo '<font color="red"><b>Dokter Belum Ditentukan</b></font>'; 
                                } else {
                                    echo '<b><font color="blue">Sudah Ditanggapi</font></b>';
                                }
                                ?>
                            </td>
                            <td align="center" valign="top">
                                <a href="?page=tanggapi_pendaftaran&id_pasien=<?= urlencode($row_data['id_pasien']); ?>">
                                    <button type="button" class="btn btn-warning btn-icon-text">
                                        <i class="mdi mdi-table-edit menu-icon"></i> 
                                        <b>Tanggapi</b>
                                    </button>
                                </a>
                                <p></p>
                                <a href="h_pendaftaran.php?id_pasien=<?= urlencode($row_data['id_pasien']); ?>" onclick="return confirm('Yakin hapus data ini?');">
                                    <button type="button" class="btn btn-danger btn-icon-text">
                                        <i class="mdi mdi-delete-forever menu-icon"></i>
                                        <b>Hapus</b>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php mysqli_free_result($data); ?>