<?php
require_once('../Connections/koneksi.php');

// Fungsi amankan input
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
        global $koneksi;
        $theValue = mysqli_real_escape_string($koneksi, trim($theValue));

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

// Ambil data pasien
$query_data = "SELECT * FROM pasien INNER JOIN poli ON pasien.kd_poli=poli.kd_poli";
$data = mysqli_query($koneksi, $query_data) or die(mysqli_error($koneksi));
$totalRows_data = mysqli_num_rows($data);
?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><b>Data Pendaftaran Pasien</b></h2>
                <form method="POST" action="">
                    <center><h3><b>PILIH RENTANG</b></h3></center>
                    <table width="100%">
                        <tr><td colspan="4" height="10" bgcolor="black"></td></tr>
                        <tr>
                            <td align="center"><b>Awal Periode</b></td>
                            <td><input type="date" name="waktu_uploadaw" class="form-control"></td>
                            <td align="center"><b>Akhir Periode</b></td>
                            <td><input type="date" name="waktu_uploadak" class="form-control"></td>
                        </tr>
                        <tr><td colspan="4" height="10" bgcolor="black"></td></tr>
                        <tr>
                            <td colspan="4" align="center">
                                <button class="btn btn-success" name="filter"><i class="fa fa-search"></i> Sortir Data</button>
                                <a href="index.php?page=laporan" class="btn btn-primary"><i class="fa fa-refresh"></i> Tampilkan Semua</a>
                            </td>
                        </tr>
                    </table>
                </form>
                <br>
                <button class="btn btn-warning" onclick="printContent('div1')"><i class="fa fa-file-pdf-o"></i> Cetak PDF</button>
                <br><br>

                <script>
                function printContent(el){
                    var restorepage = document.body.innerHTML;
                    var printcontent = document.getElementById(el).innerHTML;
                    document.body.innerHTML = printcontent;
                    window.print();
                    document.body.innerHTML = restorepage;
                }
                </script>

                <div id="div1">
                    <center>
                        <h3>LAPORAN PENDAFTARAN PASIEN PUSKESMAS PERUMNAS BATU 6</h3>
                        <h6><b>Alamat:</b> Jl. Akasia Raya No.36, Pantoan, Siantar, Simalungun, Sumatera Utara 21151</h6>
                    </center>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Tpt/Tgl. Lahir</th>
                                <th>Alamat</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tanggal Berobat</th>
                                <th>Keluhan</th>
                                <th>No HP</th>
                                <th>Respon</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['nm_pasien']); ?></td>
                                <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                <td><?php echo htmlspecialchars($row['tempat_lahir'] . ', ' . $row['tgl_lahir']); ?></td>
                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                <td><?php echo htmlspecialchars($row['nm_poli']); ?></td>
                                <td><?php echo htmlspecialchars($row['nm_dokter']); ?></td>
                                <td><?php echo htmlspecialchars($row['tgl_berobat']); ?></td>
                                <td><?php echo htmlspecialchars($row['keluhan']); ?></td>
                                <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                <td><?php echo htmlspecialchars($row['respon']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <br><br>
                    <table width="100%">
                        <tr>
                            <td width="75%"></td>
                            <td align="center">
                                Pematangsiantar, 
                                <?php
                                function tgl_indo($tanggal){
                                    $bulan = array (1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                    $pecahkan = explode('-', $tanggal);
                                    return $pecahkan[2].' '.$bulan[(int)$pecahkan[1]].' '.$pecahkan[0];
                                }
                                echo tgl_indo(date('Y-m-d'));
                                ?>
                                <br><br><h4>Administrator Sistem</h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php mysqli_free_result($data); ?>
