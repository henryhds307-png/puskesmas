-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 06:01 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_puskesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE IF NOT EXISTS `dokter` (
  `kd_dokter` varchar(5) NOT NULL,
  `nm_dokter` varchar(20) NOT NULL,
  `nip_dokter` varchar(7) NOT NULL,
  `spesialis` varchar(30) NOT NULL,
  `kd_poli` varchar(5) DEFAULT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`kd_dokter`, `nm_dokter`, `nip_dokter`, `spesialis`, `kd_poli`, `no_hp`) VALUES
('DK01', 'Dr.Isyana', '125678', 'GIGI', 'P001', '04321'),
('DK02', 'Dr.Bagas', '103025', 'UMUM', 'P002', '08527'),
('DK03', 'Dr.Brades Nasution', '152019', 'KANDUNGAN', 'P003', '09256'),
('DK04', 'Dr.Susan', '187501', 'GIZI', 'P004', '09259'),
('DK05', 'Dr.Laras', '115374', 'GIGI', 'P001', '08237'),
('DK06', 'Dr.Septi', '101654', 'UMUM', 'P002', '08228'),
('DK07', 'Dr.Ica Hayati', '175342', 'KANDUNGAN', 'P003', '08607'),
('DK08', 'Dr.Len Napitupulu', '142618', 'GIZI', 'P004', '08556');

-- --------------------------------------------------------

--
-- Table structure for table `jdwl_dokter`
--

CREATE TABLE IF NOT EXISTS `jdwl_dokter` (
  `id_jadwal` varchar(10) NOT NULL,
  `kd_dokter` varchar(5) NOT NULL,
  `spesialis` varchar(10) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `jam_awal` time NOT NULL,
  `jam_akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jdwl_dokter`
--

INSERT INTO `jdwl_dokter` (`id_jadwal`, `kd_dokter`, `spesialis`, `hari`, `jam_awal`, `jam_akhir`) VALUES
('J001', 'DK01', 'GIGI', 'Senin-Rabu', '09:33:00', '15:34:00'),
('J002', 'DK02', 'UMUM', 'Senin-Rabu', '10:08:00', '22:08:00'),
('J003', 'DK03', 'KANDUNGAN', 'Senin-Rabu', '07:34:00', '18:34:00'),
('J004', 'DK04', 'GIZI', 'Senin-Rabu', '08:00:00', '12:00:00'),
('J005', 'DK05', 'GIGI', 'Kamis-Jumat', '08:00:00', '14:00:00'),
('J006', 'DK06', 'UMUM', 'Kamis-Jumat', '08:00:00', '12:00:00'),
('J007', 'DK07', 'Kandungan', 'Kamis-Jumat', '08:00:00', '14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE IF NOT EXISTS `pasien` (
  `id_pasien` varchar(10) NOT NULL,
  `nm_pasien` text NOT NULL,
  `jenkel` varchar(10) NOT NULL,
  `tmpt_lahir` varchar(55) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kd_poli` varchar(50) DEFAULT NULL,
  `nm_dokter` varchar(20) DEFAULT NULL,
  `tgl_berobat` date DEFAULT NULL,
  `keluhan` text NOT NULL,
  `no_hp` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nm_pasien`, `jenkel`, `tmpt_lahir`, `tgl_lahir`, `alamat`, `kd_poli`, `nm_dokter`, `tgl_berobat`, `keluhan`, `no_hp`) VALUES
('PS002', 'Riani', 'perempuan', 'Bukit maradja', '2006-06-04', 'Bukit maradja', 'P001', 'Dr.Laras', '2024-06-10', 'gigi berdarah', '08502'),
('PS003', 'Liana', 'perempuan', 'Rambung Merah', '2005-02-24', 'Rambung merah', 'P003', 'Dr.Brades', '2024-05-10', 'perut keram karena hamil', '08524'),
('PS004', 'Juanda', 'laki-laki', 'Berastagi', '2002-02-08', 'Berastagi', 'P002', 'Dr.Bagas', '2024-08-07', 'badan panas 1 minggu', '08789'),
('PS005', 'Moli', 'perempuan', 'Pematang Siantar', '2005-12-14', 'Pematang Siantar', 'P004', 'Dr.Susan', '2024-04-24', 'badan kurus kekurangan gizi', '08667');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE IF NOT EXISTS `pendaftaran` (
`kd_pendaftaran` int(11) NOT NULL,
  `id_pasien` varchar(10) NOT NULL,
  `nm_poli` varchar(10) DEFAULT NULL,
  `nm_pasien` varchar(25) NOT NULL,
  `nm_dokter` varchar(20) DEFAULT NULL,
  `tgl_berobat` date DEFAULT NULL,
  `keluhan` text NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`kd_pendaftaran`, `id_pasien`, `nm_poli`, `nm_pasien`, `nm_dokter`, `tgl_berobat`, `keluhan`, `no_hp`) VALUES
(6, 'PS002', 'GIGI', 'Riani', 'Dr.Laras', '2024-06-10', 'gigi berdarah', '08502'),
(10, 'PS003', 'Kandungan', 'Liana', 'Dr.Brades Nasution', '2024-05-10', 'perut keram karena hamil', '08524'),
(11, 'PS004', 'Umum', 'Juanda', 'Dr.Bagas', '2024-08-07', 'badan panas 1 minggu', '08789'),
(12, 'PS005', 'Gizi', 'Moli', 'Dr.Susan', '2024-04-24', 'badan kurus kekurangan gizi', '08667');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE IF NOT EXISTS `poli` (
  `kd_poli` varchar(5) NOT NULL DEFAULT '',
  `nm_poli` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`kd_poli`, `nm_poli`) VALUES
('P001', 'GIGI'),
('P002', 'UMUM'),
('P003', 'KANDUNGAN'),
('P004', 'GIZI');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dokter`
--
CREATE TABLE IF NOT EXISTS `v_dokter` (
`kd_dokter` varchar(5)
,`kd_poli` varchar(5)
,`nip_dokter` varchar(7)
,`nm_dokter` varchar(20)
,`no_hp` varchar(15)
,`spesialis` varchar(30)
,`nm_poli` varchar(50)
);
-- --------------------------------------------------------

--
-- Structure for view `v_dokter`
--
DROP TABLE IF EXISTS `v_dokter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dokter` AS select `dokter`.`kd_dokter` AS `kd_dokter`,`dokter`.`kd_poli` AS `kd_poli`,`dokter`.`nip_dokter` AS `nip_dokter`,`dokter`.`nm_dokter` AS `nm_dokter`,`dokter`.`no_hp` AS `no_hp`,`dokter`.`spesialis` AS `spesialis`,`poli`.`nm_poli` AS `nm_poli` from (`dokter` join `poli` on((`dokter`.`kd_poli` = `poli`.`kd_poli`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
 ADD PRIMARY KEY (`kd_dokter`);

--
-- Indexes for table `jdwl_dokter`
--
ALTER TABLE `jdwl_dokter`
 ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
 ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
 ADD PRIMARY KEY (`kd_pendaftaran`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
 ADD PRIMARY KEY (`kd_poli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
MODIFY `kd_pendaftaran` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
