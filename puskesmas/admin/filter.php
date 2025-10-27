<?php error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
if(!ISSET($_POST['filter'])){
	?><tbody>
	<?php
	require 'config.php';
	$batas_tgl ='1996-11-11';
	$today =date('Y-m-d');
	$query = mysqli_query($koneksi, "SELECT*FROM pasien inner join poli where pasien.kd_poli=poli.kd_poli  ORDER BY `tgl_berobat` ASC") or die(mysqli_error());

	$no=1;
	while($fetch = mysqli_fetch_array($query)){

		?>
		<tr>
  <td><?php echo $no++; ?></td>
                            <td><?php echo $fetch['id_pasien']; ?>-<?php echo $fetch['nm_pasien']; ?></td>
                            <td><?php echo $fetch['jenkel']; ?></td>
                            <td><?php echo $fetch['tmpt_lahir']; ?>, <?php echo $fetch['tgl_lahir']; ?></td>
                            <td><?php echo $fetch['alamat']; ?></td>
                            <td><?php $ps1= $fetch['nm_poli'];
                if ($ps1 == 'Belum Ditentukan') {
                echo '<font color="red"><b>Poli Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps1. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php $ps2= $fetch['nm_dokter'];
                if ($ps2 == '') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps2. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php echo $fetch['tgl_berobat']; ?></td>
                            <td><?php echo $fetch['keluhan']; ?></td>
                            <td><?php echo $fetch['no_hp']; ?></td>
                            <td>
                <?php $ps= $fetch['nm_dokter'];
                if ($ps == '' or $ps1=='Belum Ditentukan') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="blue">Sudah Ditanggapi</font>';
                # code…
                } ?>
                 </td>
</tr>
</tbody>
<?php       
    } 
?>
          </table>
          <?php     
    } 
?>
<tbody>
<?php error_reporting(0);
if(ISSET($_POST['filter'])){
	require 'config.php';
	$waktu_uploadaw = $_POST['waktu_uploadaw'];
	$waktu_uploadak = $_POST['waktu_uploadak'];
	$query = mysqli_query($koneksi, "SELECT * FROM pasien inner join poli where pasien.kd_poli=poli.kd_poli AND tgl_berobat BETWEEN  '$_POST[waktu_uploadaw]' AND  '$_POST[waktu_uploadak]' order BY `tgl_berobat` ASC") or die(mysqli_error($koneksi));
	$no=1;
	while($fetch = mysqli_fetch_array($query)) {
		

		?>
	<tr> <td><?php echo $no++; ?></td>
                            <td><?php echo $fetch['id_pasien']; ?>-<?php echo $fetch['nm_pasien']; ?></td>
                            <td><?php echo $fetch['jenkel']; ?></td>
                            <td><?php echo $fetch['tmpt_lahir']; ?>, <?php echo $fetch['tgl_lahir']; ?></td>
                            <td><?php echo $fetch['alamat']; ?></td>
                            <td><?php $ps1= $fetch['nm_poli'];
                if ($ps1 == 'Belum Ditentukan') {
                echo '<font color="red"><b>Poli Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps1. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php $ps2= $fetch['nm_dokter'];
                if ($ps2 == '') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="black">' .$ps2. '</font>';
                # code…
                } ?>
                </td>
                            <td><?php echo $fetch['tgl_berobat']; ?></td>
                            <td><?php echo $fetch['keluhan']; ?></td>
                            <td><?php echo $fetch['no_hp']; ?></td>
                            <td>
                <?php $ps= $fetch['nm_dokter'];
                if ($ps == '' or $ps1=='Belum Ditentukan') {
                echo '<font color="red"><b>Dokter Belum Ditentukan</font>'; 
                }
                else {
                echo '<b><font color="blue">Sudah Ditanggapi</font>';
                # code…
                } ?>
                 </td>
       </tr>
</tbody><?php		
	}
?>
     </table>
  	<?php		
	} 
?>