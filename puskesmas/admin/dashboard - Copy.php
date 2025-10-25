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
$query_data = "SELECT * FROM pasien inner join poli where pasien.kd_poli=poli.kd_poli";
$data = mysqli_query($koneksi, $query_data) or die(mysqli_error());
$row_data = mysqli_fetch_assoc($data);
$totalRows_data = mysqli_num_rows($data);
?>
<div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <table width="100%"><tr><td align="left" valign="middle"><h2 class="card-title"><b>Data Pendaftaran Pasien</b></h2></td>
                <td width="80%"></td><td align="right"></td></tr></table><p>
                    <tr>
                      <td align="center" height="500">
                      <hr/><p><p>
                        <h3><b>SELAMAT DATANG <font color="red"> ADMINISTRATOR</font> PADA</b></h3><p>
                        <h1><b><font color="blue"> SISTEM INFORMASI PENDAFTARAN PASIEN DI PUSKESMAS PERUMNAS BATU 6</font> </b></h3><p><p>
                        <hr/>
                      </td>
                    </tr>
                  </table>
 <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>No</th>
                          <th>Nama Pasien</th>
                          <th>Jenis Klamin</th>
                          <th>Tpt/Tgl. Lahir</th>
                          <th>alamat</th>
                          <th>nm_poli</th>
                          <th>nm_dokter</th>
                          <th>tgl_berobat</th>
                          <th>keluhan</th>
                          <th>no_hp</th>
                          <th>Respon</th>
     <th>Action</th>
  </tr>
            </thead>
            <?php $no=1; while($row_data= mysqli_fetch_assoc($query_data)){ ?>
    <tbody>
                <tr>
                    <td><?php echo $no++; ?></td>
                            <td><?php echo $row_data['id_pasien']; ?>-<?php echo $row_data['nm_pasien']; ?></td>
                            <td><?php echo $row_data['jenkel']; ?></td>
                            <td><?php echo $row_data['tmpt_lahir']; ?>, <?php echo $row_data['tgl_lahir']; ?></td>
                            <td><?php echo $row_data['alamat']; ?></td>
                            <td><?php $ps1= $row_data['nm_poli'];
                if ($ps1 == 'Belum Ditentukan') {
                echo '<font color="red"><b>Poli Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps1. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php $ps2= $row_data['nm_dokter'];
                if ($ps2 == '') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps2. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php echo $row_data['tgl_berobat']; ?></td>
                            <td><?php echo $row_data['keluhan']; ?></td>
                            <td><?php echo $row_data['no_hp']; ?></td>
                            <td>
                <?php $ps= $row_data['nm_dokter'];
                if ($ps == '' or $ps1=='Belum Ditentukan') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="blue">Sudah Ditanggapi</font>';
                # code…
                } ?>
                 </td>
                        
         <td align="center" valign="top"> 
                 <a  href="?page=tanggapi_pendaftaran&id_pasien=<?php echo $row_data['id_pasien']; ?>"><button type="button" class="btn btn-warning btn-icon-text"><font color="white"><b><i class="mdi mdi-table-edit menu-icon"></i> Tanggapi Pendaftaran </b></font></button></a><p><p>
                  <a  href="h_pendaftaran.php?id_pasien=<?php echo $row_data['id_pasien']; ?>"><button type="button" class="btn btn-danger btn-icon-text"><font color="white"><b> <i class="mdi mdi-delete-forever menu-icon"></i>  Hapus Data</b></font></button></a>
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
