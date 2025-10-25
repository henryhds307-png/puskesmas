<?php
require_once('../Connections/koneksi.php');

// Ambil input POST secara aman
$awal_periode  = isset($_POST['awal_periode']) ? trim($_POST['awal_periode']) : '';
$akhir_periode = isset($_POST['akhir_periode']) ? trim($_POST['akhir_periode']) : '';
$filter_dipakai = isset($_POST['filter']);

// Query dasar (relasi antar tabel utama)
$query_base = "
    SELECT 
        pasien.id_pasien,
        pasien.nm_pasien,
        pasien.jenkel,
        pasien.tmpt_lahir,
        pasien.tgl_lahir,
        pasien.alamat,
        pasien.no_hp,
        pendaftaran.tgl_berobat,
        pendaftaran.keluhan,
        poli.nm_poli,
        dokter.nm_dokter
    FROM pasien
    LEFT JOIN pendaftaran ON pasien.id_pasien = pendaftaran.id_pasien
    LEFT JOIN poli ON pendaftaran.kd_poli = poli.kd_poli
    LEFT JOIN dokter ON pendaftaran.kd_dokter = dokter.kd_dokter
    WHERE 1
";

// Fungsi validasi tanggal
function is_valid_date_iso($date) {
    $dt = @DateTime::createFromFormat('Y-m-d', $date);
    return ($dt && $dt->format('Y-m-d') === $date);
}

$result = false;
$stmt = null;

if ($filter_dipakai && $awal_periode !== '' && $akhir_periode !== '') {
    if (!is_valid_date_iso($awal_periode) || !is_valid_date_iso($akhir_periode)) {
        die("<div class='alert alert-danger'>Format tanggal tidak valid (gunakan YYYY-MM-DD).</div>");
    }
    if ($awal_periode > $akhir_periode) {
        die("<div class='alert alert-danger'>Tanggal awal harus sebelum atau sama dengan tanggal akhir.</div>");
    }

    $query = $query_base . " AND pendaftaran.tgl_berobat BETWEEN ? AND ? ORDER BY pasien.id_pasien ASC";
    $stmt = mysqli_prepare($koneksi, $query);
    if ($stmt === false) {
        die("<div class='alert alert-danger'>Prepare failed: " . htmlspecialchars(mysqli_error($koneksi)) . "</div>");
    }

    mysqli_stmt_bind_param($stmt, "ss", $awal_periode, $akhir_periode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $query = $query_base . " ORDER BY pasien.id_pasien ASC";
    $result = mysqli_query($koneksi, $query);
}
?>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title"><b>Data Pendaftaran Pasien</b></h2>

        <!-- Form Filter -->
        <form method="POST" action="">
          <center><h3><b>PILIH RENTANG</b></h3></center>
          <table width="100%">
            <tr>
              <td align="center"><b>Awal Periode</b></td>
              <td><input type="date" name="awal_periode" class="form-control" value="<?php echo htmlspecialchars($awal_periode); ?>" required></td>
            </tr>
            <tr>
              <td align="center"><b>Akhir Periode</b></td>
              <td><input type="date" name="akhir_periode" class="form-control" value="<?php echo htmlspecialchars($akhir_periode); ?>" required></td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <button class="btn btn-success" name="filter"><i class="fa fa-search"></i> Sortir Data</button>
                <a href="index.php?page=laporan" class="btn btn-primary"><i class="fa fa-refresh"></i> Tampilkan Semua</a>
              </td>
            </tr>
          </table>
        </form>

        <br>

        <!-- Tabel -->
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>Jenis Kelamin</th>
              <th>TTL</th>
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
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['id_pasien'] . " - " . $row['nm_pasien']) ?></td>
                <td><?= htmlspecialchars($row['jenkel']) ?></td>
                <td><?= htmlspecialchars($row['tmpt_lahir'] . ", " . $row['tgl_lahir']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= $row['nm_poli'] ? "<b>" . htmlspecialchars($row['nm_poli']) . "</b>" : '<font color="red"><b>Belum Ditentukan</b></font>' ?></td>
                <td><?= $row['nm_dokter'] ? "<b>" . htmlspecialchars($row['nm_dokter']) . "</b>" : '<font color="red"><b>Belum Ditentukan</b></font>' ?></td>
                <td><?= htmlspecialchars($row['tgl_berobat']) ?></td>
                <td><?= htmlspecialchars($row['keluhan']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td>
                  <?php
                  if (empty($row['nm_dokter']) || empty($row['nm_poli'])) {
                      echo '<font color="red"><b>Belum Ditanggapi</b></font>';
                  } else {
                      echo '<font color="blue"><b>Sudah Ditanggapi</b></font>';
                  }
                  ?>
                </td>
                <td align="center">
                  <a href="?page=tanggapi_pendaftaran&id_pasien=<?= urlencode($row['id_pasien']) ?>" class="btn btn-warning btn-sm">
                    <i class="mdi mdi-table-edit"></i> Tanggapi
                  </a>
                  <a href="h_pendaftaran.php?id_pasien=<?= urlencode($row['id_pasien']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?');">
                    <i class="mdi mdi-delete"></i> Hapus
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

<?php
if ($stmt) {
    mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);
?>
