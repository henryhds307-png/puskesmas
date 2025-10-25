<?php require_once('../Connections/koneksi.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $koneksi;

  $theValue = mysqli_real_escape_string($koneksi, $theValue);

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

if (isset($_GET['id_pasien']) && $_GET['id_pasien'] != "") {
  $id_pasien = GetSQLValueString($_GET['id_pasien'], "text");

  // Query delete
  $deleteSQL1 = "DELETE FROM pasien WHERE id_pasien=$id_pasien";
  $deleteSQL2 = "DELETE FROM pendaftaran WHERE id_pasien=$id_pasien";

  // Jalankan query dan cek hasil
  if (!mysqli_query($koneksi, $deleteSQL1)) {
    die("Error menghapus pasien: " . mysqli_error($koneksi));
  }

  if (!mysqli_query($koneksi, $deleteSQL2)) {
    die("Error menghapus pendaftaran: " . mysqli_error($koneksi));
  }

  // Redirect setelah berhasil
  $deleteGoTo = "index.php?page=pendaftaran";
  header("Location: $deleteGoTo");
  exit;
}
?>
