<?php
require_once('../Connections/koneksi.php');

// Ambil data user
$query_data = "SELECT * FROM login";
$data = mysqli_query($koneksi, $query_data) or die(mysqli_error($koneksi));
?>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <table width="100%">
          <tr>
            <td align="left" valign="middle">
              <h2 class="card-title"><b>Data User</b></h2>
            </td>
            <td width="80%"></td>
            <td align="right">
              <a href="?page=tambah_user">
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
              <th>Username</th>
              <th>Password</th>
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
                <td><?php echo htmlspecialchars($row_data['username']); ?></td>
                <td>********</td>
                <td align="center">
                  <a href="?page=e_user&username=<?php echo urlencode($row_data['username']); ?>">
                    <button type="button" class="btn btn-warning btn-icon-text">
                      <font color="white"><b><i class="mdi mdi-table-edit menu-icon"></i></b></font>
                    </button>
                  </a>
                  <a href="h_user.php?username=<?php echo urlencode($row_data['username']); ?>" onclick="return confirm('Yakin ingin menghapus user ini?');">
                    <button type="button" class="btn btn-danger btn-icon-text">
                      <font color="white"><b><i class="mdi mdi-delete-forever menu-icon"></i></b></font>
                    </button>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php mysqli_free_result($data); ?>
      </div>
    </div>
  </div>
</div>
