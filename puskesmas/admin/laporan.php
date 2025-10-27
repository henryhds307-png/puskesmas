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
                            
<form method="POST" action="">
 <center><h3><b>PILIH RENTANG </b></h3> 
 </center>
    <table width="100%">
                  <tr><td width="100%" bgcolor="black" height="10" colspan="4"></td></tr>
           <tr><td align="center"><b>Awal Periode</td><td><input type="date" name="waktu_uploadaw" class="form-control" id="datepicker" value="" size="32"></td>
   <td align="center"><b>Akhir Periode</td><td><input type="date" name="waktu_uploadak" class="form-control" id="datepicker" value="" size="32"></td></tr>
   <tr><td width="100%" bgcolor="black" height="10" colspan="4"></td></tr>
   <tr><td width="100%" bgcolor="" height="10" colspan="4"></td></tr>
<tr>        </td><td width="5"></td>
        <td colspan="4"><button class="btn btn-success" name="filter"><i class="fa fa-search"></i> Sortir Data</button> <a href="http://localhost/puskesmas/admin/index.php?page=laporan" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan Semua</a></td>
      </tr>
  </table>
  </form><br>
<button  class="btn btn-warning"  onclick="printContent('div1')"><i class="fa fa-file-pdf-o"></i>  Cetak PDF</button> 
    <br style="clear:both;"/></a>
    <script>
function printContent(el){
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script><br/><br/><div id="div1">
   <table width="100%"><tr><td align="center"><h3>LAPORAN PENDAFTARAN PASIEN PUSKESMAS PERUMNAS BATU 6</h3><p style="line-height: 0.01"></p>
<p style="line-height: 0.01"></p><h6><b>Alamat :</b> Jl. Akasia Raya No.36 Pantoan, Kec. Siantar, Kabupaten Simalungun, Sumatera Utara 21151</h6></td></tr></table> 
 <p>
 <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>No</th>
                          <th>Nama Pasien</th>
                          <th>Jenis Kelamin</th>
                          <th>Tpt/Tgl. Lahir</th>
                          <th>alamat</th>
                          <th>nm_poli</th>
                          <th>nm_dokter</th>
                          <th>tgl_berobat</th>
                          <th>keluhan</th>
                          <th>no_hp</th>
                          <th>Respon</th>
  </tr>
            </thead>
                   <?php include 'filter.php' ?>
            

 <p><p><br/>
 <table id="" width="100%"><tr><TD width="75%" ></TD><td align="center">Pematangsiantar, <?php

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

echo tgl_indo(date('Y-m-d'));  ?><p style="line-height: 0.01"></p>
<p></p><br/><p></p><br/><p><p><h4> Administrator Sistem</h4></td></tr></table> 
         
                </div>
            </div>
          </div>
            <?php
mysql_free_result($data);
?>
