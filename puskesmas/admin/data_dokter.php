<?php
require_once('../Connections/koneksi.php');

// --- Query Data Dokter ---
$query_data = "SELECT * FROM v_dokter";
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
              <h2 class="card-title"><b>Data Dokter</b></h2>
            </td>
            <td width="80%"></td>
            <td align="right">
              <a href="?page=tambah_dokter">
                <button type="button" class="btn btn-success btn-icon-text">
                  <font color="white"><b><i class="mdi mdi-book-plus menu-icon"></i> Tambah Dokter</b></font>
                </button>
              </a>
            </td>
          </tr>
        </table>
        <p>

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Dokter</th>
              <th>Nama Dokter</th>
              <th>NIP Dokter</th>
              <th>Spesialis</th>
              <th>Kode Poli</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['kd_dokter']); ?></td>
                <td><?php echo htmlspecialchars($row['nm_dokter']); ?></td>
                <td><?php echo htmlspecialchars($row['nip_dokter']); ?></td>
                <td><?php echo htmlspecialchars($row['spesialis']); ?></td>
                <td><?php echo htmlspecialchars($row['kd_poli']); ?></td>
                <td align="center" valign="top">
                  <a href="?page=t_jadwal_dokter&kd_dokter=<?php echo urlencode($row['kd_dokter']); ?>">
                    <button type="button" class="btn btn-primary btn-icon-text">
                      <i class="mdi mdi-book-plus menu-icon"></i> Tambah Jadwal
                    </button>
                  </a>
                  <a href="?page=e_dokter&kd_dokter=<?php echo urlencode($row['kd_dokter']); ?>">
                    <button type="button" class="btn btn-warning btn-icon-text">
                      <i class="mdi mdi-table-edit menu-icon"></i>
                    </button>
                  </a>
                  <a href="h_dokter.php?kd_dokter=<?php echo urlencode($row['kd_dokter']); ?>">
                    <button type="button" class="btn btn-danger btn-icon-text">
                      <i class="mdi mdi-delete-forever menu-icon"></i>
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

<?php
mysqli_free_result($data);
?>
