-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 05:05 PM
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
('DK07', 'Dr.Ica Hayati', '175342', 'KANDUNGAN', 'P003', '08607');

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
('admin', '$2y$10$D6Y'),
('Zura', '$2y$10$6Fx');

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
  `kd_dokter` varchar(5) DEFAULT NULL,
  `nm_dokter` varchar(20) DEFAULT NULL,
  `tgl_berobat` date DEFAULT NULL,
  `keluhan` text NOT NULL,
  `no_hp` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nm_pasien`, `jenkel`, `tmpt_lahir`, `tgl_lahir`, `alamat`, `kd_poli`, `kd_dokter`, `nm_dokter`, `tgl_berobat`, `keluhan`, `no_hp`) VALUES
('PS2025001', 'jono', 'laki-laki', 'perumnas batu 6', '1989-12-31', 'perumnas batu anam', NULL, NULL, NULL, '2025-10-30', 'sakit gigi', '08967'),
('PS2025003', 'Juminten', 'perempuan', 'medan', '1967-10-14', 'perm batu 6', 'P002', 'DK06', 'Dr.Septi', '2025-10-20', 'pusing ', '08967'),
('PS2025004', 'salaludin', 'laki-laki', 'siantar', '1989-10-23', 'perum batu 6', NULL, NULL, NULL, '2025-10-25', 'sakit perut', '08119'),
('PS2025005', 'lala', 'perempuan', 'perumnas batu 6', '1987-01-15', 'perumnas batu 6', 'P003', 'Dr.Br', 'Dr.Brades Nasution', '2025-11-06', 'hamil', '08123'),
('PS2025006', 'Jojo', 'laki-laki', 'medan', '1999-07-06', 'medan', NULL, NULL, NULL, '1999-01-25', 'sakit perut', '08119');

--
-- Triggers `pasien`
--
DELIMITER //
CREATE TRIGGER `before_insert_pasien` BEFORE INSERT ON `pasien`
 FOR EACH ROW BEGIN
    DECLARE last_id VARCHAR(10);
    DECLARE last_num INT;
    DECLARE new_num INT;
    DECLARE year_str VARCHAR(4);

    -- Ambil tahun saat ini (misal 2025)
    SET year_str = YEAR(CURDATE());

    -- Ambil ID terakhir di tahun yang sama
    SELECT id_pasien
    INTO last_id
    FROM pasien
    WHERE id_pasien LIKE CONCAT('PS', year_str, '%')
    ORDER BY id_pasien DESC
    LIMIT 1;

    -- Jika belum ada data tahun ini, mulai dari 1
    IF last_id IS NULL THEN
        SET new_num = 1;
    ELSE
        SET last_num = CAST(SUBSTRING(last_id, 8, 3) AS UNSIGNED);
        SET new_num = last_num + 1;
    END IF;

    -- Format ID baru → PS2025001
    SET NEW.id_pasien = CONCAT('PS', year_str, LPAD(new_num, 3, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE IF NOT EXISTS `pendaftaran` (
`kd_pendaftaran` int(11) NOT NULL,
  `id_pasien` varchar(10) NOT NULL,
  `kd_poli` varchar(10) DEFAULT NULL,
  `kd_dokter` varchar(10) DEFAULT NULL,
  `nm_pasien` varchar(25) NOT NULL,
  `nm_dokter` varchar(20) DEFAULT NULL,
  `tgl_berobat` date DEFAULT NULL,
  `keluhan` text NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`kd_pendaftaran`, `id_pasien`, `kd_poli`, `kd_dokter`, `nm_pasien`, `nm_dokter`, `tgl_berobat`, `keluhan`, `no_hp`) VALUES
(4, 'PS2025005', 'P003', 'DK03', 'lala', 'Dr.Brades Nasution', '2025-10-25', 'hamil', '08123'),
(7, 'PS2025003', 'P002', 'DK06', 'Juminten', 'Dr.Septi', '2025-10-20', 'pusing', '08967');

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
('P004', 'GIZI'),
('P005', 'KIA/KB');

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
MODIFY `kd_pendaftaran` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
