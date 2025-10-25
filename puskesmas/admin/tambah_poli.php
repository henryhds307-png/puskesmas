<?php
require_once('../Connections/koneksi.php');

// ======== Tambah Data Poli ========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['MM_insert'] == 'form2') {
    $kd_poli = $_POST['kd_poli'];
    $nm_poli = $_POST['nm_poli'];

    // Gunakan prepared statement
    $stmt = $koneksi->prepare("INSERT INTO poli (kd_poli, nm_poli) VALUES (?, ?)");
    $stmt->bind_param("ss", $kd_poli, $nm_poli);
    $stmt->execute();

    echo "<script>
        alert('Data berhasil ditambahkan!');
        document.location.href = '?page=data_poli';
    </script>";
    exit;
}

// ======== Kode Otomatis ========
$result = mysqli_query($koneksi, "SELECT * FROM poli");
$num = mysqli_num_rows($result);

if ($num != 0) {
    $kode = $num + 1;
} else {
    $kode = 1;
}

// Membuat format kode otomatis
$bikin_kode = str_pad($kode, 3, "0", STR_PAD_LEFT);
$kode_jadi = "P$bikin_kode";
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
                <h2 class="card-title"><b>Tambah Data Poli</b></h2>
              </td>
              <td width="80%"></td>
              <td align="right"></td>
            </tr>
          </table>
          <p></p>
          <form method="post">
            <table id="example1" class="table table-dark">
              <tr valign="baseline">
                <td align="right">Kode Poli:</td>
                <td>
                  <input type="text" name="kd_poli" class="form-control" value="<?php echo htmlspecialchars($kode_jadi); ?>" readonly required />
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right">Nama Poli:</td>
                <td>
                  <input type="text" name="nm_poli" class="form-control" required />
                </td>
              </tr>
              <tr valign="baseline">
                <td></td>
                <td>
                  <input type="submit" value="Tambah Poli" class="btn btn-block btn-primary btn-sm" />
                </td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
