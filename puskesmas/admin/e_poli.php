<?php
require_once('../Connections/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['MM_update'] == 'form1') {
    $nm_poli = $_POST['nm_poli'];
    $kd_poli = $_POST['kd_poli'];

    // Gunakan prepared statement agar aman
    $stmt = $koneksi->prepare("UPDATE poli SET nm_poli = ? WHERE kd_poli = ?");
    $stmt->bind_param("ss", $nm_poli, $kd_poli);
    $stmt->execute();

    echo "<script>
        alert('Data berhasil diubah!');
        document.location.href = '?page=data_poli';
    </script>";
    exit;
}

// Ambil data berdasarkan kd_poli
if (isset($_GET['kd_poli'])) {
    $kd_poli = $_GET['kd_poli'];
    $stmt = $koneksi->prepare("SELECT * FROM poli WHERE kd_poli = ?");
    $stmt->bind_param("s", $kd_poli);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_ubah_data = $result->fetch_assoc();
} else {
    die("<script>alert('Kode poli tidak ditemukan!');history.back();</script>");
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
                <h2 class="card-title"><b>Ubah Data Poli</b></h2>
              </td>
              <td width="80%"></td>
              <td align="right"></td>
            </tr>
          </table>
          <p></p>
          <div class="table-responsive">
            <form method="post">
              <table id="example1" class="table table-dark">
                <tr valign="baseline">
                  <td align="right">Kode Poli:</td>
                  <td><?php echo htmlspecialchars($row_ubah_data['kd_poli']); ?></td>
                </tr>
                <tr valign="baseline">
                  <td align="right">Nama Poli:</td>
                  <td>
                    <input type="text" name="nm_poli" value="<?php echo htmlspecialchars($row_ubah_data['nm_poli']); ?>" size="32" class="form-control" required />
                  </td>
                </tr>
                <tr valign="baseline">
                  <td></td>
                  <td>
                    <input type="submit" value="Ubah Data" class="btn btn-warning btn-sm" />
                  </td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1" />
              <input type="hidden" name="kd_poli" value="<?php echo htmlspecialchars($row_ubah_data['kd_poli']); ?>" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
