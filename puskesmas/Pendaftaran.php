<?php require_once('Connections/koneksi.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pasien (nm_pasien, jenkel, tmpt_lahir, tgl_lahir, alamat, kd_poli, nm_dokter, tgl_berobat, keluhan, no_hp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
//                       GetSQLValueString($_POST['id_pasien'], "text"),
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

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }

  ?>
  <script>
        alert('data berhasil ditambahkan!');
        document.location.href = 'jadwal_penanganan.php';
      </script>

?>
<?php 
}
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>PUSKESMAS PERUMNAS BT.6 - Form Pendaftaran Pasien.</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
		
 <script type='text/javascript' src='https://code.jquery.com/jquery-3.5.1.js'></script>
<script type='text/javascript' src='https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js'></script>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'/>
    </head>
    <body>
	
		<!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <!-- End Preloader -->
		
		<!-- Get Pro Button -->
		<ul class="pro-features">
			
			<li class="big-title">Pro Version Available on Themeforest</li>
			<li class="title">Pro Version Features</li>
			<li>2+ premade home pages</li>
			<li>20+ html pages</li>
			<li>Color Plate With 12+ Colors</li>
			<li>Sticky Header / Sticky Filters</li>
			<li>Working Contact Form With Google Map</li>
			<div class="button">
				<a href="http://preview.themeforest.net/item/mediplus-medical-and-doctor-html-template/full_screen_preview/26665910?_ga=2.145092285.888558928.1591971968-344530658.1588061879" target="_blank" class="btn">Pro Version Demo</a>
				<a href="https://themeforest.net/item/mediplus-medical-and-doctor-html-template/26665910" target="_blank" class="btn">Buy Pro Version</a>
			</div>
		</ul>
	
		<!-- Header Area -->
		<header class="header" >
			<!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-5 col-12">
							<!-- Contact -->
							<ul class="top-link">
								<li><a href="#">About</a></li>
								<li><a href="#">Doctors</a></li>
								<li><a href="#">Contact</a></li>
								<li><a href="#">FAQ</a></li>
							</ul>
							<!-- End Contact -->
						</div>
						<div class="col-lg-6 col-md-7 col-12">
							<!-- Top Contact -->
							<ul class="top-contact">
								<li><i class="fa fa-phone"></i>0831-1078-8872</li>
								<li><i class="fa fa-envelope"></i><a href="uptd_puskesmas-bt6@gmail.com">uptd_puskesmas-bt6@gmail.com</a></li>
							</ul>
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar -->
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="index.php"><img src="img/puskesmas.png" alt="#"></a>
								</div>
								<!-- End Logo -->
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li><a href="index.php">Home </a></li>
											<li><a href="jadwal_penanganan.php">Jadwal Penanganan </a></li>
											<li><a href="poliklinik.php">Poliklinik </a></li>
											<li><a href="dokter.php">Dokter </a></li>
											<li><a href="pendaftaran.php">Pendaftaran Pasien </a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="login.php" class="btn">LOGIN</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
		<!-- Slider Area -->
		<section class="slider">
			<div class="hero-slider">
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('img/video-bg.jpg')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<h1>UPTD <span>Puskesmas</span> Perumnas <span>Batu 6</span></h1>
									<p>Melayani Masyarakat Dengan Sepenuh Hati </p>
									<div class="button">
										<a href="pendaftaran.php" class="btn">Pendaftaran Pasien</a>
										<a href="jadwal_penanganan.php" class="btn primary">Jadwal Pelayanan</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Single Slider -->
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('img/download.jpg')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<h1>UPTD <span>Puskesmas</span> Perumnas <span>Batu 6</span></h1>
									<p>Prioritaskan Kesehatan Masyarakat </p>
									<div class="button">
										<div class="button">
										<a href="pendaftaran.php" class="btn">Pendaftaran Pasien</a>
										<a href="jadwal_penanganan.php" class="btn primary">Jadwal Pelayanan</a>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Start End Slider -->
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('img/call-bg.jpg')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<h1>UPTD <span>Puskesmas</span> Perumnas <span>Batu 6</span></h1>
									<p>Sigap Dalam Pelayanan Kesehatan</p>
									<div class="button">
										<div class="button">
										<a href="pendaftaran.php" class="btn">Pendaftaran Pasien</a>
										<a href="jadwal_penanganan.php" class="btn primary">Jadwal Pelayanan</a>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Single Slider -->
			</div>
		</section>
		<!--/ End Slider Area -->
		
		<!-- Start Schedule Area -->
		<section class="schedule">
			<div class="container">
				<div class="schedule-inner">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12 ">
							<!-- single-schedule -->
							<div class="single-schedule first">
								<div class="inner">
									<div class="icon">
										<i class="fa fa-ambulance"></i>
									</div>
									<div class="single-content">
										<span>Pelayanan Darurat</span>
										<h4>Unit Gawat Darurat</h4>
										<p>Penyediaan Unit Gawat Darurat (UGD) sebagai pelayanan awal pada pasien yang membutuhkan perawatan intensif sebelum dirujuk ke Rumah Sakit</p>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-12">
							<!-- single-schedule -->
							<div class="single-schedule middle">
								<div class="inner">
									<div class="icon">
										<i class="icofont-prescription"></i>
									</div>
									<div class="single-content">
										<span>Jadwal</span>
										<h4>Jadwal Dokter</h4>
										<p>Dokter yang bertugas secara penuh pada pukul 07.30 WIB hingga pukul 15.00 WIB berdasarkan jadwal yang telah ditentukan</p>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-12">
							<!-- single-schedule -->
							<div class="single-schedule last">
								<div class="inner">
									<div class="icon">
										<i class="icofont-ui-clock"></i>
									</div>
									<div class="single-content">
										<span>Jam Operasional</span>
										<h4>Jam Operasional Pelayanan</h4>
										<ul class="time-sidual">
											<li class="day">Senin - Sabtu <span>07.30-20.00</span></li>
											<li class="day">Kesediaan Dokter <span>07.30-15.00</span></li>
											<li class="day">Tanggal Merah<span>Libur</span></li>
										</ul>
										<a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/End Start schedule Area -->
		
		<?php
 include 'config.php';
                      //memulai mengambil datanya
 //                     $sql = mysql_query("select * from pasien");
 //                     
 //                     $num = mysql_num_rows($sql);
 //                     
 //                     if($num <> 0)
 //                     {
 //                     $kode = $num + 1;
 //                     }else
 //                     {
 //                     $kode = 1;
 //                     }
 //                     
 //                     //mulai bikin kode
 //                     $bikin_kode = str_pad($kode, 3, "0", STR_PAD_LEFT);
 //                     $tahun = date('d.m.21');
 //                     $month = date('m');
 //                     $year = date('Y');
 //                     $kode_jadi = "PS$bikin_kode";

                      
?>
		<!-- Start Appointment -->
		
		<section id="pendaftaran" class="Feautes section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">
							<h2>FORMULIR PENDAFTARAN CALON PASIEN</h2>
							<img src="img/section-img.png" alt="#">
							<p>Calon Pasien Harus Melakukan Pendaftaran Terlebih Dahulu Melalui Form ini</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <table id="example1" class="table table-bordered table-striped">
                          <!-- <tr valign="baseline">
                          //  <td nowrap align="right">ID. Registrasi Pasien:</td>
                          //  <td bgcolor="yellow"><input type="text" name="id_pasien" value="" readonly class="form-control size="32"></td>
                          //</tr> -->
                          <tr valign="baseline">
                            <td nowrap align="right">Nama Pasien:</td>
                            <td><input type="text" name="nm_pasien" value="" class="form-control size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Jenis Kelamin:</td>
                            <td><div class="form-group has-feedback">
        <select class="form-control select" name="jenkel" style="width: 100%;">
          <option selected="selected">Pilih Jenis Kelamin</option>
          <option value="laki-laki">Laki-laki</option>
          <option value="perempuan">Perempuan</option>
          </select><span class="glyphicon glyphicon-check form-control-feedback"></span>
        </div></td>
                          
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Tempat Lahir:</td>
                            <td><input type="text" name="kd_poli" value="" hidden size="32">
                            <input type="text" name="nm_dokter" value="" hidden size="32">
                            <input type="text" name="tmpt_lahir" value="" class="form-control" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Tanggal Lahir:</td>
                            <td><input type="date" name="tgl_lahir" class="form-control" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Alamat:</td>
                            <td><textarea name="alamat" placeholder="Tulis Alamat Pasien....."></textarea></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Tanggal Penanganan:</td>
                            <td><input type="date" class="form-control" name="tgl_berobat" value=""  size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Keluhan:</td>
                            <td> <textarea name="keluhan" placeholder="Tulis Keluhan Pasien....."></textarea></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">No. HP/WA:</td>
                            <td><input type="text" name="no_hp" value="" class="form-control" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" class="btn btn-success" value="DAFTARKAN PASIEN"></td>
                          </tr>
                        </table>
                        <input type="hidden" name="MM_insert" value="form1">
                      </form>
                      
                      <p>&nbsp;</p>
			 
					</div>
					<div class="col-lg-6 col-md-12 ">
						<div class="appointment-image">
							<img src="img/contact-img.png" alt="#">
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Appointment -->
				
		<!-- Start Fun-facts -->
		<div id="fun-facts" class="fun-facts section overlay">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-home"></i>
							<div class="content">
								<span class="counter">5</span>
								<p>Jumlah Poliklinik</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-user-alt-3"></i>
							<div class="content">
								<span class="counter">7</span>
								<p>Dokter Spesialis</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont-simple-smile"></i>
							<div class="content">
								<span class="counter">43</span>
								<p>Pasien Terdaftar Hari ini</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Start Single Fun -->
						<div class="single-fun">
							<i class="icofont icofont-table"></i>
							<div class="content">
								<span class="counter">12896</span>
								<p>Jumlah Keseluruhan Pasien</p>
							</div>
						</div>
						<!-- End Single Fun -->
					</div>
				</div>
			</div>
		</div>
		<!--/ End Fun-facts -->
		


		<!-- Start Feautes -->
		<section class="Feautes section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="section-title">		<p></p>
							<h2>PROSESDUR PENDAFTARAN DAN PELAYANAN PASIEN</h2>
							<img src="img/section-img.png" alt="#">
							<p>Melalui Sistem Informasi Pendaftaran Pasien UPTD Puskesmas Perumnas Batu 6</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features">
							<div class="signle-icon">
								<i class="icofont icofont-ambulance-cross"></i>
							</div>
							<h3>Pendafataran Melalui Sistem</h3>
							<p>Data Calon Pasien yang akan berobat di daftarkan melalui Formulir Pendaftaran Pasien baik secara langsung di Puskesmas maupun melalui sistem</p>
						</div>
						<!-- End Single features -->
					</div>
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features">
							<div class="signle-icon">
								<i class="icofont icofont-medical-sign-alt"></i>
							</div>
							<h3>Penentuan Jadwal Penanganan</h3>
							<p>Pihak Administrator Puskesmas akan memberitahu waktu penanganan Pasien baik diumumkan melalui sistem dan juga di Puskesmas (melalui nomor antrian)</p>
						</div>
						<!-- End Single features -->
					</div>
					<div class="col-lg-4 col-12">
						<!-- Start Single features -->
						<div class="single-features last">
							<div class="signle-icon">
								<i class="icofont icofont-stethoscope"></i>
							</div>
							<h3>Penanganan Pasien</h3>
							<p>Penanganan terhadap Pasien dilakukan</p>
						</div>
						<!-- End Single features -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Feautes -->
				<!-- Footer Area -->
				<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>About Us</h2>
								<p>Puskesmas Batu 6 Simalungun adalah fasilitas pelayanan kesehatan tingkat pertama yang berada di Kabupaten Simalungun, Sumatera Utara, yang melayani masyarakat di wilayahnya. Sebagai unit pelaksana teknis dinas kesehatan, puskesmas ini memiliki tugas untuk menyelenggarakan upaya kesehatan masyarakat dan kesehatan perseorangan, dengan fokus utama pada upaya promotif dan preventif. 
								</p>
								<!-- Social -->
								<ul class="social">
									<li><a href="#"><i class="icofont-facebook"></i></a></li>
									<li><a href="#"><i class="icofont-google-plus"></i></a></li>
									<li><a href="#"><i class="icofont-twitter"></i></a></li>
									<li><a href="#"><i class="icofont-vimeo"></i></a></li>
									<li><a href="#"><i class="icofont-pinterest"></i></a></li>
								</ul>
								<!-- End Social -->
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Quick Links</h2>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Our Cases</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Other Links</a></li>	
										</ul>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Consuling</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Finance</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Testimonials</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQ</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a></li>	
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>Open Hours</h2>
								<p>Jam buka Puskesmas Batu 6 Simalungun umumnya mengikuti jam kerja standar, yaitu pada hari kerja (Senin-Kamis) mulai pukul 07.30-11.30 dan hari Jumat-Sabtu mulai pukul 07.30-10.30, namun untuk layanan UGD biasanya tersedia 24 jam. Untuk jam pasti, sebaiknya menghubungi Puskesmas secara langsung. </p>
								<ul class="time-sidual">
									<li class="day">Monday - Fridayp <span>8.00-20.00</span></li>
									<li class="day">Saturday <span>9.00-18.30</span></li>
									<li class="day">Monday - Thusday <span>9.00-15.00</span></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>Newsletter</h2>
								<p>Mengenai langganan di Puskesmas Batu 6, Simalungun, hal tersebut berkaitan dengan layanan BPJS Kesehatan. Secara umum, pasien dapat terdaftar secara tetap atau menjadi peserta BPJS di suatu Puskesmas (Fasilitas Kesehatan Tingkat Pertama/FKTP). </p>
								<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
									<input name="email" placeholder="Email Address" class="common-input" onfocus="this.placeholder = ''"
										onblur="this.placeholder = 'Your email address'" required type="email">
									<button class="button"><i class="icofont icofont-paper-plane"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>© Copyright 2018  |  All Rights Reserved by <a href="https://www.wpthemesgrid.com" target="_blank">wpthemesgrid.com</a> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>

<script src="template_olah_data/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="template_olah_data/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="template_olah_data/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="template_olah_data/dist/js/demo.js"></script>
<!-- DataTables  & Plugins -->
<script src="template_olah_data/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="template_olah_data/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="template_olah_data/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="template_olah_data/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="template_olah_data/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="template_olah_data/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="template_olah_data/plugins/jszip/jszip.min.js"></script>
<script src="template_olah_data/plugins/pdfmake/pdfmake.min.js"></script>
<script src="template_olah_data/plugins/pdfmake/vfs_fonts.js"></script>
<script src="template_olah_data/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="template_olah_data/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="template_olah_data/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
    </body>
</html>