<?php
require_once('../Connections/koneksi.php');

// --- UPDATE DATA DOKTER ---
if (isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1") {

  // Escape semua input
  $nm_dokter = mysqli_real_escape_string($koneksi, $_POST['nm_dokter']);
  $nip_dokter = mysqli_real_escape_string($koneksi, $_POST['nip_dokter']);
  $spesialis = mysqli_real_escape_string($koneksi, $_POST['spesialis']);
  $kd_poli = mysqli_real_escape_string($koneksi, $_POST['kd_poli']);
  $kd_dokter = mysqli_real_escape_string($koneksi, $_POST['kd_dokter']);

  $query = "
    UPDATE dokter 
    SET nm_dokter='$nm_dokter', 
        nip_dokter='$nip_dokter', 
        spesialis='$spesialis', 
        kd_poli='$kd_poli'
    WHERE kd_dokter='$kd_dokter'
  ";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>
      alert('Data berhasil diubah!');
      document.location.href='?page=data_dokter';
    </script>";
    exit;
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}

// --- AMBIL DATA UNTUK EDIT ---
$kd_dokter = isset($_GET['kd_dokter']) ? mysqli_real_escape_string($koneksi, $_GET['kd_dokter']) : '';
$query = "SELECT * FROM dokter WHERE kd_dokter='$kd_dokter'";
$result = mysqli_query($koneksi, $query);
$row_ubah_data = mysqli_fetch_assoc($result);

// --- AMBIL DATA POLI UNTUK DROPDOWN ---
$poli = mysqli_query($koneksi, "SELECT * FROM poli");
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table width="100%">
            <tr>
              <td align="left"><h2 class="card-title"><b>Ubah Data Dokter</b></h2></td>
              <td width="80%"></td>
            </tr>
          </table>

          <div class="table-responsive">
            <form action="" method="post" name="form1" id="form1">
              <table id="example1" class="table table-dark">
                <tr>
                  <td align="right">Kode Dokter:</td>
                  <td><?php echo htmlspecialchars($row_ubah_data['kd_dokter']); ?></td>
                </tr>
                <tr>
                  <td align="right">Nama Dokter:</td>
                  <td><input type="text" name="nm_dokter" class="form-control" value="<?php echo htmlspecialchars($row_ubah_data['nm_dokter']); ?>" required></td>
                </tr>
                <tr>
                  <td align="right">NIP Dokter:</td>
                  <td><input type="text" name="nip_dokter" class="form-control" value="<?php echo htmlspecialchars($row_ubah_data['nip_dokter']); ?>" required></td>
                </tr>
                <tr>
                  <td align="right">Spesialis:</td>
                  <td><input type="text" name="spesialis" class="form-control" value="<?php echo htmlspecialchars($row_ubah_data['spesialis']); ?>" required></td>
                </tr>
                <tr>
                  <td align="right">Nama Poli:</td>
                  <td>
                    <select name="kd_poli" id="kd_poli" class="form-control" required>
                      <option value="">-- Pilih Poli --</option>
                      <?php while ($row = mysqli_fetch_assoc($poli)) { ?>
                        <option value="<?php echo $row['kd_poli']; ?>" 
                          <?php if ($row_ubah_data['kd_poli'] == $row['kd_poli']) echo 'selected'; ?>>
                          <?php echo $row['kd_poli'] . ' - ' . $row['nm_poli']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <input type="hidden" name="kd_dokter" value="<?php echo htmlspecialchars($row_ubah_data['kd_dokter']); ?>">
                    <input type="hidden" name="MM_update" value="form1">
                    <input type="submit" value="Ubah Data" class="btn btn-warning btn-sm">
                  </td>
                </tr>
              </table>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
mysqli_free_result($result);
mysqli_free_result($poli);
?>
