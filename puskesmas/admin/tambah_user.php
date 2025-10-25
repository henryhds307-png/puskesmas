<?php
require_once('../Connections/koneksi.php'); // pastikan koneksi mysqli ada di sini

// fallback untuk password_hash jika tidak tersedia
if (!function_exists('password_hash')) {
  function password_hash_fallback($password, $algo = PASSWORD_BCRYPT, $options = ['cost' => 10]) {
      $cost = isset($options['cost']) ? (int)$options['cost'] : 10;
      if (function_exists('random_bytes')) {
          $bytes = random_bytes(16);
      } elseif (function_exists('openssl_random_pseudo_bytes')) {
          $bytes = openssl_random_pseudo_bytes(16);
      } else {
          $bytes = '';
          for ($i = 0; $i < 16; $i++) { $bytes .= chr(mt_rand(0, 255)); }
      }
      $salt = str_replace('+', '.', substr(base64_encode($bytes), 0, 22));
      $salt = sprintf('$2y$%02d$%s$', $cost, $salt);
      return crypt($password, $salt);
  }
} else {
  function password_hash_fallback($password, $algo = PASSWORD_BCRYPT, $options = ['cost' => 10]) {
      return password_hash($password, $algo, $options);
  }
}

// Tangani submit form
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

    // Ambil & bersihkan input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validasi sederhana
    if ($username === '' || $password === '') {
        echo "<script>alert('Username dan Password harus diisi.');</script>";
    } else {
        // 1) Cek apakah username sudah ada
        $sql_check = "SELECT COUNT(*) AS cnt FROM login WHERE username = ?";
        if ($stmt = mysqli_prepare($koneksi, $sql_check)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $cnt);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        } else {
            // Jika prepare gagal
            echo "<script>alert('Terjadi kesalahan DB: " . mysqli_error($koneksi) . "');</script>";
            $cnt = 0; // supaya tidak blocking flow, tapi idealnya handle error lebih baik
        }

        if ($cnt > 0) {
            // Username sudah digunakan
            echo "<script>
                    alert('Username sudah digunakan, silakan pilih username lain.');
                    history.back();
                  </script>";
        } else {
            // 2) Hash password dengan password_hash
          //  $hashed = password_hash($password, PASSWORD_DEFAULT);
              $hashed = password_hash_fallback($password, PASSWORD_BCRYPT, ['cost' => 10]);

            // 3) Insert dengan prepared statement
            $sql_insert = "INSERT INTO login (username, password) VALUES (?, ?)";
            if ($stmt2 = mysqli_prepare($koneksi, $sql_insert)) {
                mysqli_stmt_bind_param($stmt2, "ss", $username, $hashed);
                $exec = mysqli_stmt_execute($stmt2);
                if ($exec) {
                    echo "<script>
                            alert('Data berhasil ditambahkan!');
                            document.location.href = '?page=data_user';
                          </script>";
                } else {
                    echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');</script>";
                }
                mysqli_stmt_close($stmt2);
            } else {
                echo "<script>alert('Gagal menyiapkan query: " . mysqli_error($koneksi) . "');</script>";
            }
        }
    }
}
?>

<!-- partial HTML form -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table width="100%"><tr><td align="left" valign="middle"><h2 class="card-title"><b> Tambah Data User</b></h2></td>
          <td width="80%"></td><td align="right"></td></tr></table>

          <form action="" method="post" name="form2" id="form2" autocomplete="off">
            <table id='example1' class='table table-dark'>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Username:</td>
                <td>
                  <input type="text" name="username" value="" size="32" class="form-control" required />
                </td>
              </tr>

              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Password:</td>
                <td>
                  <input type="password" name="password" class="form-control" required size="32" />
                </td>
              </tr>

              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><input type="submit" value="Tambah User" class="btn btn-block btn-primary btn-sm" /></td>
              </tr>
            </table>

            <input type="hidden" name="MM_insert" value="form2" />
          </form>

          <div class="table-responsive"><p>&nbsp;</p></div>
        </div>
      </div>
    </div>
  </div>
</div>
