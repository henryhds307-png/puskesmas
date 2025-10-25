<?php
require_once('../Connections/koneksi.php');

// === PROSES TAMBAH DATA ===
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "form2") {
    $id_jadwal  = $_POST['id_jadwal'];
    $kd_dokter  = $_POST['kd_dokter'];
    $spesialis  = $_POST['spesialis'];
    $hari       = $_POST['hari'];
    $jam_awal   = $_POST['jam_awal'];
    $jam_akhir  = $_POST['jam_akhir'];

    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($koneksi, "
        INSERT INTO jdwl_dokter (id_jadwal, kd_dokter, spesialis, hari, jam_awal, jam_akhir)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $id_jadwal, $kd_dokter, $spesialis, $hari, $jam_awal, $jam_akhir);
        if (mysqli_stmt_execute($stmt)) {
            ?>
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = '?page=jadwal_dokter';
            </script>
            <?php
        } else {
            die("Gagal menambahkan data: " . mysqli_error($koneksi));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Gagal menyiapkan query insert: " . mysqli_error($koneksi));
    }
}

// === AMBIL DATA DOKTER UNTUK FORM ===
$colname_ubah_data = isset($_GET['kd_dokter']) ? $_GET['kd_dokter'] : "-1";
$stmt2 = mysqli_prepare($koneksi, "SELECT * FROM v_dokter WHERE kd_dokter = ?");
mysqli_stmt_bind_param($stmt2, "s", $colname_ubah_data);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$row_ubah_data = mysqli_fetch_assoc($result2);

// === BUAT KODE OTOMATIS UNTUK id_jadwal ===
$sql2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jdwl_dokter");
$row2 = mysqli_fetch_assoc($sql2);
$num2 = $row2['total'];

if ($num2 <> 0) {
    $kode2 = $num2 + 1;
} else {
    $kode2 = 1;
}
$bikin_kode2 = str_pad($kode2, 3, "0", STR_PAD_LEFT);
$kode_jadi2 = "J" . $bikin_kode2;
?>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table width="100%">
            <tr>
              <td align="left" valign="middle">
                <h2 class="card-title"><b>Tambah Data Jadwal Dokter</b></h2>
              </td>
              <td width="80%"></td>
              <td align="right"></td>
            </tr>
          </table>
          <p>
          <form method="post" name="form2" id="form2">
            <table id='example1' class='table table-dark'>

              <tr valign="baseline">
                <td align="right">Kode Dokter:</td>
                <td><input type="text" name="kd_dokter" size="32" class="form-control"
                  value="<?php echo htmlspecialchars($row_ubah_data['kd_dokter']); ?>" readonly required/></td>
              </tr>

              <tr valign="baseline">
                <td align="right">ID. Jadwal:</td>
                <td><input type="text" name="id_jadwal" size="32" class="form-control"
                  value="<?php echo $kode_jadi2; ?>" readonly required/></td>
              </tr>

              <tr valign="baseline">
                <td align="right">Nama Dokter:</td>
                <td><input type="text" name="nm_dokter" class="form-control" readonly required
                  value="<?php echo htmlspecialchars($row_ubah_data['nm_dokter']); ?>" /></td>
              </tr>

              <tr valign="baseline">
                <td align="right">NIP Dokter:</td>
                <td><input type="text" name="nip_dokter" class="form-control" readonly required
                  value="<?php echo htmlspecialchars($row_ubah_data['nip_dokter']); ?>" /></td>
              </tr>

              <tr valign="baseline">
                <td align="right">Spesialis:</td>
                <td><input type="text" name="spesialis" class="form-control" readonly required
                  value="<?php echo htmlspecialchars($row_ubah_data['spesialis']); ?>" /></td>
              </tr>

              <tr valign="baseline">
                <td align="right">Nama Poli:</td>
                <td>
                  <div class="form-group has-feedback">
                    <select name="kd_poli" id="kd_poli" required class="form-control select">
                      <option value="">Pilih Nama Poli</option>
                      <?php
                      // Ambil data poli
                      $poliQuery = mysqli_query($koneksi, "SELECT * FROM poli");
                      while ($row = mysqli_fetch_assoc($poliQuery)) {
                          echo "<option value='" . htmlspecialchars($row['kd_poli']) . "'>" .
                                htmlspecialchars($row['kd_poli']) . " - " .
                                htmlspecialchars($row['nm_poli']) .
                              "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </td>
              </tr>

              <tr valign="baseline">
                <td align="right">No. HP:</td>
                <td><input type="text" name="no_hp" class="form-control" required /></td>
              </tr>

              <tr valign="baseline">
                <td align="right">Hari Praktik:</td>
                <td>
                  <select class="form-control select" name="hari" style="width:100%;" required>
                    <option selected value="">Pilih Hari Praktik</option>
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
                <td align="right">Jam Mulai Praktik:</td>
                <td><input type="time" name="jam_awal" class="form-control" required /></td>
              </tr>

              <tr valign="baseline">
                <td align="right">Jam Selesai Praktik:</td>
                <td><input type="time" name="jam_akhir" class="form-control" required /></td>
              </tr>

              <tr valign="baseline">
                <td></td>
                <td><input type="submit" value="Tambah Dokter" class="btn btn-primary btn-block btn-sm"/></td>
              </tr>

            </table>
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
mysqli_free_result($result2);
mysqli_stmt_close($stmt2);
?>
