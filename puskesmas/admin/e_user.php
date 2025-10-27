<?php
require_once('../Connections/password_compat.php');
require_once('../Connections/koneksi.php');

// ===== Polyfill untuk PHP <5.5 =====

// Tambahkan PASSWORD_BCRYPT jika belum ada
if (!defined('PASSWORD_BCRYPT')) {
    define('PASSWORD_BCRYPT', 1);
}

// Tambahkan random_bytes() jika belum ada (PHP <7)
if (!function_exists('random_bytes')) {
    function random_bytes($length = 16) {
        $bytes = '';
        for ($i = 0; $i < $length; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
        return $bytes;
    }
}

// Tambahkan password_hash() jika belum ada (PHP <5.5)
if (!function_exists('password_hash')) {
    function password_hash($password, $algo = PASSWORD_BCRYPT, $options = array()) {
        $cost = isset($options['cost']) ? $options['cost'] : 10;
        $salt = isset($options['salt']) 
            ? $options['salt'] 
            : substr(strtr(base64_encode(random_bytes(16)), '+', '.'), 0, 22);
        return crypt($password, sprintf('$2y$%02d$', $cost) . $salt);
    }
}
?>

<?php
require_once('../Connections/koneksi.php'); // pastikan koneksi mysqli disini

// === Handle Update Form ===
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        echo "<script>alert('Username dan Password wajib diisi.'); history.back();</script>";
        exit;
    }

    // Enkripsi password baru (hash bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    // Update data user pakai prepared statement
    $sql_update = "UPDATE login SET password = ? WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $sql_update);
    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href='?page=data_user';
              </script>";
    } else {
        echo "<script>alert('Gagal mengubah data: " . mysqli_error($koneksi) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}

// === Ambil Data User untuk Ditampilkan di Form ===
$row_ubah_data = null;

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $sql_select = "SELECT username, password FROM login WHERE username = ?";
    $stmt2 = mysqli_prepare($koneksi, $sql_select);
    mysqli_stmt_bind_param($stmt2, "s", $username);
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);
    $row_ubah_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt2);
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
              <td align="left" valign="middle"><h2 class="card-title"><b>Ubah Data User</b></h2></td>
              <td width="80%"></td>
              <td align="right"></td>
            </tr>
          </table>

          <div class="table-responsive">
            <?php if ($row_ubah_data): ?>
              <form action="" method="post" name="form1" id="form1">
                <table id='example1' class='table table-dark'>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Username:</td>
                    <td>
                      <input type="text" name="username" value="<?php echo htmlspecialchars($row_ubah_data['username']); ?>" readonly class="form-control" />
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Password Baru:</td>
                    <td>
                      <input type="password" name="password" class="form-control" required placeholder="Masukkan password baru" />
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td>
                      <input type="submit" value="Ubah Data" class="btn btn-block btn-warning btn-sm" />
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
              </form>
            <?php else: ?>
              <p class="text-danger">Data user tidak ditemukan.</p>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
