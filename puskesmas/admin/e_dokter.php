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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE dokter SET nm_dokter=%s, nip_dokter=%s, spesialis=%s, kd_poli=%s, no_hp=%s WHERE kd_dokter=%s",
                       GetSQLValueString($_POST['nm_dokter'], "text"),
                       GetSQLValueString($_POST['nip_dokter'], "text"),
                       GetSQLValueString($_POST['spesialis'], "text"),
                       GetSQLValueString($_POST['kd_poli'], "text"),
                       GetSQLValueString($_POST['kd_dokter'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  
  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  ?>
  <script>
        alert('data berhasil diubah!');
        document.location.href = '?page=data_dokter';
      </script>
  <?php 
}

$colname_ubah_data = "-1";
if (isset($_GET['kd_dokter'])) {
  $colname_ubah_data = $_GET['kd_dokter'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_ubah_data = sprintf("SELECT * FROM dokter WHERE kd_dokter = %s", GetSQLValueString($colname_ubah_data, "text"));
$ubah_data = mysql_query($query_ubah_data, $koneksi) or die(mysql_error());
$row_ubah_data = mysql_fetch_assoc($ubah_data);
$totalRows_ubah_data = mysql_num_rows($ubah_data);
?>
<!-- partial -->
        <div class="content-wrapper">
        
      
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <table width="100%"><tr><td align="left" valign="middle"><h2 class="card-title"><b>Ubah Data Dokter</b></h2></td>
                <td width="80%"></td><td align="right"></td></tr></table>
                   <p>
                  <div class="table-responsive">
                    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                      <table id='example1' class='table table-dark'>
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Kode Dokter:</td>
                          <td><?php echo $row_ubah_data['kd_dokter']; ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Nama Dokter:</td>
                          <td><input type="text" name="nm_dokter" class="form-control" value="<?php echo htmlentities($row_ubah_data['nm_dokter'], ENT_COMPAT, ''); ?>" size="32" /></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">NIP Dokter:</td>
                          <td><input type="text" name="nip_dokter" class="form-control" value="<?php echo htmlentities($row_ubah_data['nip_dokter'], ENT_COMPAT, ''); ?>" size="32" /></td>
                        </tr>
                         <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Spesialis:</td>
                          <td><input type="text" name="spesialis" class="form-control" value="<?php echo htmlentities($row_ubah_data['spesialis'], ENT_COMPAT, ''); ?>" size="32" /></td>
                        </tr>
                         <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Nama Poli:</td>
                          <td>
                          <div class="form-group has-feedback">
                          <select name="kd_poli" id="kd_poli" required="required" class="form-control select"><option value="kd_poli" class="form-control">Pilih Nama Poli<?php $link=mysqli_connect("localhost","root","","db_puskesmas");
                          $Result1 = mysqli_query($link,"SELECT * FROM poli");
                          while($row=mysqli_fetch_array($Result1,MYSQLI_ASSOC))
                          {
                            echo "<option value=$row[kd_poli]>$row[kd_poli] - $row[nm_poli]</option>";
                            echo"<br/>";
                          }
                          ?></option></select>
        
                      </div>
                      </td>
                      </tr>   
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">&nbsp;</td>
                          <td><input type="submit" value="Ubah Data"  class="btn btn-block btn-warning btn-sm"/></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_update" value="form1" />
                      <input type="hidden" name="kd_dokter" value="<?php echo $row_ubah_data['kd_dokter']; ?>" />
                    </form>
                    <p>&nbsp;</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- row end -->
        
           
          <!-- row end -->
        </div>
        <!-- content-wrapper ends -->
        <?php
mysql_free_result($ubah_data);
?>
