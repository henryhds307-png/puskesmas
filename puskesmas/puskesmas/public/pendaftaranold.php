<?php require_once('../src/db/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;    
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL = sprintf("INSERT INTO pasien (nm_pasien, jenkel, tmpt_lahir, tgl_lahir, alamat, kd_poli, nm_dokter, tgl_berobat, keluhan, no_hp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['nm_pasien'], "text"),
        GetSQLValueString($_POST['jenkel'], "text"),
        GetSQLValueString($_POST['tmpt_lahir'], "text"),
        GetSQLValueString($_POST['tgl_lahir'], "date"),
        GetSQLValueString($_POST['alamat'], "text"),
        GetSQLValueString($_POST['kd_poli'], "text"),
        GetSQLValueString($_POST['nm_dokter'], "text"),
        GetSQLValueString($_POST['tgl_berobat'], "date"),
        GetSQLValueString($_POST['keluhan'], "text"),
        GetSQLValueString($_POST['no_hp'], "text"));

    mysqli_select_db($koneksi, $database_koneksi);
    $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));

    ?>
    <script>
        alert('Data berhasil ditambahkan!');
        document.location.href = 'jadwal_penanganan.php';
    </script>
    <?php 
}
?>
<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PUSKESMAS PERUMNAS BT.6 - Form Pendaftaran Pasien</title>
    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Form Pendaftaran Pasien</h1>
        </div>
    </header>
    <section id="pendaftaran" class="Feautes section">
        <div class="container">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                <table class="table table-bordered">
                    <tr>
                        <td>Nama Pasien:</td>
                        <td><input type="text" name="nm_pasien" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin:</td>
                        <td>
                            <select class="form-control" name="jenkel">
                                <option selected="selected">Pilih Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir:</td>
                        <td><input type="text" name="tmpt_lahir" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir:</td>
                        <td><input type="date" name="tgl_lahir" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Alamat:</td>
                        <td><textarea name="alamat" class="form-control" placeholder="Tulis Alamat Pasien....."></textarea></td>
                    </tr>
                    <tr>
                        <td>Tanggal Penanganan:</td>
                        <td><input type="date" name="tgl_berobat" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Keluhan:</td>
                        <td><textarea name="keluhan" class="form-control" placeholder="Tulis Keluhan Pasien....."></textarea></td>
                    </tr>
                    <tr>
                        <td>No. HP/WA:</td>
                        <td><input type="text" name="no_hp" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" class="btn btn-success" value="DAFTARKAN PASIEN"></td>
                    </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1">
            </form>
        </div>
    </section>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>