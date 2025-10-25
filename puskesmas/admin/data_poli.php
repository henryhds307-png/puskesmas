<?php
require_once('../Connections/koneksi.php');

// Query data poli
$query_data = "SELECT * FROM poli";
$data = mysqli_query($koneksi, $query_data) or die(mysqli_error($koneksi));
?>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <table width="100%">
          <tr>
            <td align="left" valign="middle">
              <h2 class="card-title"><b>Data Poli</b></h2>
            </td>
            <td width="80%"></td>
            <td align="right">
              <a href="?page=tambah_poli">
                <button type="button" class="btn btn-success btn-icon-text">
                  <font color="white"><b><i class="mdi mdi-book-plus menu-icon"></i></b></font>
                </button>
              </a>
            </td>
          </tr>
        </table>

        <p></p>

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Poli</th>
              <th>Nama Poli</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row_data = mysqli_fetch_assoc($data)) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row_data['kd_poli']); ?></td>
                <td><?php echo htmlspecialchars($row_data['nm_poli']); ?></td>
                <td align="center">
                  <a href="?page=e_poli&kd_poli=<?php echo urlencode($row_data['kd_poli']); ?>">
                    <button type="button" class="btn btn-warning btn-icon-text">
                      <font color="white"><b><i class="mdi mdi-table-edit menu-icon"></i></b></font>
                    </button>
                  </a>
                  <a href="h_poli.php?kd_poli=<?php echo urlencode($row_data['kd_poli']); ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">
                    <button type="button" class="btn btn-danger btn-icon-text">
                      <font color="white"><b><i class="mdi mdi-delete-forever menu-icon"></i></b></font>
                    </button>
                  </a>
                </td>
              </tr>
            <?php
            }
            mysqli_free_result($data);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
