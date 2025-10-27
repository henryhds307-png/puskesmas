<?php require_once('../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

mysqli_select_db($koneksi, $database_koneksi);
$query_data = "SELECT * FROM poli";
$data = mysqli_query($koneksi, $query_data) or die(mysqli_error());
$row_data = mysqli_fetch_assoc($data);
$totalRows_data = mysqli_num_rows($data);
?>
<div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <table width="100%"><tr><td align="left" valign="middle"><h2 class="card-title"><b>Data Poli</b></h2></td>
                <td width="80%"></td><td align="right"><a  href="?page=tambah_poli"><button type="button" class="btn btn-success btn-icon-text"><font color="white"><b><i class="mdi mdi-book-plus menu-icon"></i> </b></font></button></a></td></tr></table><p>
                 
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No.</th>
                      <th>Kode Poli</th>
                      <th>Nama Poli</th>
     <th>Action</th>
      </tr></thead><tbody>   
    <?php $no=1; do { ?>
      <tr>
       <td><?php echo $no++; ?></td>
                        <td><?php echo $row_data['kd_poli']; ?></td>
                        <td><?php echo $row_data['nm_poli']; ?></td>
         <td align="center" valign="top"> 
                 <a  href="?page=e_poli&kd_poli=<?php echo $row_data['kd_poli']; ?>"><button type="button" class="btn btn-warning btn-icon-text"><font color="white"><b><i class="mdi mdi-table-edit menu-icon"></i>  </b></font></button></a>
                  <a  href="h_poli.php?kd_poli=<?php echo $row_data['kd_poli']; ?>"><button type="button" class="btn btn-danger btn-icon-text"><font color="white"><b> <i class="mdi mdi-delete-forever menu-icon"></i>  </b></font></button></a>
                </td> 
                      </tr>
                      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
        </tbody>
  
</table>
                </div>
            </div>
          </div>
            <?php
mysqli_free_result($data);
?>
