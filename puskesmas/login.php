<?php
require_once('Connections/password_compat.php');
require_once('Connections/koneksi.php');

session_start();

/* -----------------------------------------
   PROSES LOGIN (mysqli + password_verify)
--------------------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Gunakan isset untuk kompatibilitas PHP < 7
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  // Jika field kosong
  if ($username === '' || $password === '') {
      header("Location: login.php?pesan=gagal");
      exit;
  }

  // Query user
  $stmt = $koneksi->prepare("SELECT username, password FROM login WHERE username = ? LIMIT 1");
  if (!$stmt) {
      error_log("Prepare failed: " . $koneksi->error);
      header("Location: login.php?pesan=gagal");
      exit;
  }

  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 0) {
      // user tidak ditemukan
      $stmt->close();
      header("Location: login.php?pesan=gagal");
      exit;
  }

  $stmt->bind_result($dbUser, $dbPass);
  $stmt->fetch();
  $stmt->close();

  // Verifikasi password
  $login_valid = false;

  if (function_exists('password_verify')) {
      // PHP >= 5.5
      $login_valid = password_verify($password, $dbPass);
  } else {
      // fallback untuk PHP lama (plaintext)
      $login_valid = ($password === $dbPass);
  }

  if (!$login_valid) {
      header("Location: login.php?pesan=gagal");
      exit;
  }

  // Jika berhasil login
  session_regenerate_id(true);
  $_SESSION['MM_Username'] = $dbUser;
  $_SESSION['MM_UserGroup'] = ''; // optional, bisa tambahkan role nanti

  header("Location: admin/index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PUSKESMAS PERUMNAS BT.6 - Login</title>

  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="img/favicon.png" />
</head>

<body>
  <div class="support-note">
    <span class="note-ie">
      <?php 
        if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
          echo "<div class='alert alert-danger text-center'>Username atau Password tidak sesuai!</div>";
        }
      ?>
    </span>
  </div>

  <div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center">
                <img src="img/favicon.png" alt="logo">
                <h4>Sistem Pendaftaran Pasien Puskesmas Perumnas Batu 6</h4>
              </div>
              <h6 class="font-weight-light text-center">Masuk untuk melanjutkan</h6>

              <form action="login.php" method="POST" class="pt-3" id="login">
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                  <input class="btn btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="submit" value="SIGN IN">
                  <a class="btn btn-warning btn-lg font-weight-medium auth-form-btn" href="http://localhost/puskesmas/">Dashboard</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- base:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
</body>
</html>
