<?php
require_once('../Connections/koneksi.php');

// Tangani update data jadwal dokter
if (isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1") {
    // Ambil data dari form
    $id_jadwal = $_POST['id_jadwal'];
    $kd_dokter = $_POST['kd_dokter'];
    $spesialis = $_POST['spesialis'];
    $hari = $_POST['hari'];
    $jam_awal = $_POST['jam_awal'];
    $jam_akhir = $_POST['jam_akhir'];

    // Gunakan prepared statement
    $stmt = mysqli_prepare($koneksi, "UPDATE jdwl_dokter 
                                      SET kd_dokter = ?, spesialis = ?, hari = ?, jam_awal = ?, jam_akhir = ? 
                                      WHERE id_jadwal = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $kd_dokter, $spesialis, $hari, $jam_awal, $jam_akhir, $id_jadwal);
        if (mysqli_stmt_execute($stmt)) {
            ?>
            <script>
                alert('Data berhasil diubah!');
                document.location.href = '?page=jadwal_dokter';
            </script>
            <?php
        } else {
            die("Gagal mengubah data: " . mysqli_error($koneksi));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Gagal menyiapkan query update: " . mysqli_error($koneksi));
    }
}

// Ambil data jadwal untuk form edit
$colname_ubah_data = isset($_GET['id_jadwal']) ? $_GET['id_jadwal'] : -1;

$stmt2 = mysqli_prepare($koneksi, "SELECT * 
                                  FROM jdwl_dokter 
                                  INNER JOIN v_dokter 
                                  ON jdwl_dokter.kd_dokter = v_dokter.kd_dokter 
                                  WHERE jdwl_dokter.id_jadwal = ?");
mysqli_stmt_bind_param($stmt2, "s", $colname_ubah_data);
mysqli_stmt_execute($stmt2);
$result = mysqli_stmt_get_result($stmt2);
$row_ubah_data = mysqli_fetch_assoc($result);

if (!$row_ubah_data) {
    die("Data tidak ditemukan!");
}
?>

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table width="100%">
            <tr>
              <td align="left" valign="middle">
                <h2 class="card-title"><b>Ubah Jadwal Praktik Dokter</b></h2>
              </td>
              <td width="50%"></td>
              <td align="right"></td>
            </tr>
          </table>
          <p>
          <div class="table-responsive">
            <form method="post" name="form1" id="form1">
              <table id='example1' class='table table-dark'>
                <tr valign="baseline">
                  <td align="right">ID. Jadwal:</td>
                  <td><?php echo htmlspecialchars($row_ubah_data['id_jadwal']); ?></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Kode Dokter:</td>
                  <td><?php echo htmlspecialchars($row_ubah_data['kd_dokter']); ?></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Nama Dokter:</td>
                  <td><input type="text" name="nm_dokter" class="form-control" 
                    value="<?php echo htmlspecialchars($row_ubah_data['nm_dokter']); ?>" readonly /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">NIP Dokter:</td>
                  <td><input type="text" name="nip_dokter" class="form-control" 
                    value="<?php echo htmlspecialchars($row_ubah_data['nip_dokter']); ?>" readonly /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Spesialis:</td>
                  <td><input type="text" name="spesialis" class="form-control" 
                    value="<?php echo htmlspecialchars($row_ubah_data['spesialis']); ?>" readonly /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Hari:</td>
                  <td>
                    <select class="form-control" name="hari" style="width:100%;">
                      <option selected value="<?php echo htmlspecialchars($row_ubah_data['hari']); ?>">
                        <?php echo htmlspecialchars($row_ubah_data['hari']); ?>
                      </option>
                      <?php
                      $hari_list = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
                      foreach ($hari_list as $h) {
                          echo "<option value='$h'>$h</option>";
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Jam Awal:</td>
                  <td><input type="time" name="jam_awal" class="form-control" 
                    value="<?php echo htmlspecialchars($row_ubah_data['jam_awal']); ?>" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Jam Akhir:</td>
                  <td><input type="time" name="jam_akhir" class="form-control" 
                    value="<?php echo htmlspecialchars($row_ubah_data['jam_akhir']); ?>" /></td>
                </tr>
                <tr valign="baseline">
                  <td></td>
                  <td><input type="submit" value="Ubah Data" class="btn btn-warning btn-block btn-sm" /></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1" />
              <input type="hidden" name="kd_dokter" value="<?php echo htmlspecialchars($row_ubah_data['kd_dokter']); ?>" />
              <input type="hidden" name="id_jadwal" value="<?php echo htmlspecialchars($row_ubah_data['id_jadwal']); ?>" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
mysqli_free_result($result);
mysqli_stmt_close($stmt2);
?>
