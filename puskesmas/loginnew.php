<?php
session_start();
require_once('../Connections/koneksi.php'); // pastikan pakai koneksi mysqli

// Jika user sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        echo "<script>alert('Username dan Password harus diisi.');</script>";
    } else {
        // Ambil data user berdasarkan username
        $sql = "SELECT username, password FROM login WHERE username = ?";
        if ($stmt = mysqli_prepare($koneksi, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Verifikasi password
                if (password_verify($password, $row['password'])) {
                    // Jika cocok → buat session login
                    $_SESSION['username'] = $row['username'];
                    echo "<script>
                            alert('Login berhasil!');
                            window.location.href = 'dashboard.php';
                          </script>";
                    exit;
                } else {
                    echo "<script>alert('Password salah!');</script>";
                }
            } else {
                echo "<script>alert('Username tidak ditemukan!');</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Kesalahan database: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Puskesmas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-lg">
        <div class="card-header text-center bg-primary text-white">
          <h4>Login Admin</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
        <div class="card-footer text-center small text-muted">
          &copy; <?= date('Y'); ?> Puskesmas
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
