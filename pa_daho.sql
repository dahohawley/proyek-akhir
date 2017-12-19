-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2018 at 04:57 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pa_daho`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`) VALUES
('ketua', 'ketua'),
('bendahara', 'bendahara');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `no_anggota` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=pegawai,2=pensiun,3=mutasi,4=keluar',
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `keterangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`no_anggota`, `nama`, `alamat`, `status`, `username`, `password`, `keterangan`) VALUES
(36, 'Ramdhani Lukman', 'Jalan Jatinangor', '4', '123', '123', 1),
(37, 'Ahmad Dhani', 'Jakarta', '4', '123', '123', 1),
(38, 'Ayu Ting Ting', 'Jalan Cinta', '4', '123', '123', 1),
(39, 'Kim Tae Hae', 'Korea ', '1', '123', '123', 1),
(40, 'Ramdhani', ' Jatinangor', '1', '123', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `angsuran_penj`
--

CREATE TABLE `angsuran_penj` (
  `id_angsurpenj` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `id_penjualan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `angsuran_pinj`
--

CREATE TABLE `angsuran_pinj` (
  `id_angsuran` varchar(10) NOT NULL,
  `jml_angsur` int(11) DEFAULT NULL,
  `tgl_angsur` date DEFAULT NULL,
  `sisa_pinjaman` int(11) DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL,
  `id_pinjam` varchar(10) DEFAULT NULL,
  `periode` varchar(2) NOT NULL,
  `tahun` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angsuran_pinj`
--

INSERT INTO `angsuran_pinj` (`id_angsuran`, `jml_angsur`, `tgl_angsur`, `sisa_pinjaman`, `no_anggota`, `id_pinjam`, `periode`, `tahun`) VALUES
('API-39', 88000000, '2018-01-01', -8000000, 38, 'PIN-38', '2', '2018'),
('API-42', 27500000, '2018-01-01', -2500000, 39, 'PIN-41', '2', '2018'),
('API-48', 11000000, '2018-01-31', 9000000, 38, 'PIN-47', '2', '2018');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran_pmb`
--

CREATE TABLE `angsuran_pmb` (
  `id_angsuran_pmb` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_angsuran` int(11) NOT NULL,
  `id_pembelian` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(15) NOT NULL,
  `nama_barang` varchar(30) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `kategori` varchar(3) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_beli`, `harga_jual`, `kategori`, `stok`) VALUES
(5, 'Barang dummy 4', 1400, 1540, 'KSM', 1000),
(6, 'Barang dummy 5', 1300, 1430, 'KSM', 1000),
(7, 'Barang dummy 6', 10000, 11000, 'KSM', 1000),
(9, 'Barang dummy 8', 12000, 13200, 'KLT', 1000),
(10, 'Barang dummy 9', 12000, 13200, 'KLT', 1000),
(11, 'Barang dummy 10', 40000, 44000, 'KSM', 1000),
(12, 'Barang dummy 11', 1200, 1320, 'KSM', 1000),
(13, 'Barang dummy 12', 1200, 1320, 'KSM', 1000),
(14, 'Barang dummy 13', 10000, 11000, 'KSM', 1000),
(15, 'Barang dummy 14', 11000, 12100, 'KSM', 1000),
(16, 'Barang dummy 15', 40000, 44000, 'KLT', 1000),
(17, 'Barang dummy 16', 30000, 33000, 'KLT', 1000),
(18, 'Barang dummy 17', 1200, 1320, 'KSM', 1000),
(19, 'Barang dummy 18', 1200, 1320, 'KLT', 1000),
(20, 'Barang dummy 19', 1300, 1430, 'KSM', 1000),
(21, 'Barang dummy 20', 1400, 1540, 'KSM', 1000),
(22, 'Barang dummy 21', 1400, 1540, 'KSM', 1000),
(23, 'Barang dummy 22', 1200, 1320, 'KSM', 1000),
(24, 'Barang dummy 23', 11000, 12100, 'KSM', 1000),
(25, 'Barang dummy 24', 1400, 1540, 'KSM', 1000),
(26, 'Barang dummy 25', 30000, 33000, 'KSM', 1000),
(27, 'Barang dummy 26', 40000, 44000, 'KSM', 1000),
(28, 'Barang dummy 27', 40000, 44000, 'KSM', 1000),
(29, 'Barang dummy 28', 12000, 13200, 'KSM', 1000),
(30, 'Barang dummy 29', 30000, 33000, 'KSM', 1000),
(31, 'Barang dummy 30', 40000, 44000, 'KSM', 1000),
(32, 'Barang dummy 31', 10000, 11000, 'KSM', 1000),
(33, 'Barang dummy 32', 12000, 13200, 'KLT', 1000),
(34, 'Barang dummy 33', 1200, 1320, 'KLT', 1000),
(35, 'Barang dummy 34', 11000, 12100, 'KLT', 1000),
(36, 'Barang dummy 35', 40000, 44000, 'KLT', 1000),
(37, 'Barang dummy 36', 12000, 13200, 'KLT', 1000),
(38, 'Barang dummy 37', 12000, 13200, 'KSM', 1000),
(39, 'Barang dummy 38', 11000, 12100, 'KSM', 1000),
(40, 'Barang dummy 39', 10000, 11000, 'KLT', 1000),
(41, 'Barang dummy 40', 11000, 12100, 'KSM', 1000),
(42, 'Barang dummy 41', 40000, 44000, 'KSM', 1000),
(43, 'Barang dummy 42', 1400, 1540, 'KSM', 1000),
(44, 'Barang dummy 43', 1400, 1540, 'KLT', 1000),
(45, 'Barang dummy 44', 1200, 1320, 'KSM', 1000),
(46, 'Barang dummy 45', 11000, 12100, 'KSM', 1000),
(47, 'Barang dummy 46', 11000, 12100, 'KLT', 1000),
(48, 'Barang dummy 47', 10000, 11000, 'KSM', 1000),
(49, 'Barang dummy 48', 10000, 11000, 'KSM', 1000),
(50, 'Barang dummy 49', 1200, 1320, 'KSM', 1000),
(51, 'Barang dummy 50', 1400, 1540, 'KLT', 1000),
(52, 'Barang dummy 51', 40000, 44000, 'KLT', 1000),
(53, 'Barang dummy 52', 11000, 12100, 'KSM', 1000),
(54, 'Barang dummy 53', 1400, 1540, 'KSM', 1000),
(55, 'Barang dummy 54', 10000, 11000, 'KLT', 1000),
(56, 'Barang dummy 55', 10000, 11000, 'KSM', 1000),
(57, 'Barang dummy 56', 1300, 1430, 'KLT', 1000),
(58, 'Barang dummy 57', 10000, 11000, 'KSM', 1000),
(59, 'Barang dummy 58', 40000, 44000, 'KLT', 1000),
(60, 'Barang dummy 59', 30000, 33000, 'KLT', 1000),
(61, 'Barang dummy 60', 12000, 13200, 'KSM', 1000),
(62, 'Barang dummy 61', 10000, 11000, 'KSM', 1000),
(63, 'Barang dummy 62', 12000, 13200, 'KLT', 1000),
(64, 'Barang dummy 63', 11000, 12100, 'KLT', 1000),
(65, 'Barang dummy 64', 1400, 1540, 'KSM', 1000),
(66, 'Barang dummy 65', 12000, 13200, 'KSM', 1000),
(67, 'Barang dummy 66', 30000, 33000, 'KLT', 1000),
(68, 'Barang dummy 67', 12000, 13200, 'KLT', 1000),
(69, 'Barang dummy 68', 1300, 1430, 'KSM', 1000),
(70, 'Barang dummy 69', 10000, 11000, 'KSM', 1000),
(71, 'Barang dummy 70', 30000, 33000, 'KSM', 1000),
(72, 'Barang dummy 71', 40000, 44000, 'KLT', 1000),
(73, 'Barang dummy 72', 30000, 33000, 'KLT', 1000),
(74, 'Barang dummy 73', 30000, 33000, 'KSM', 1000),
(75, 'Barang dummy 74', 30000, 33000, 'KLT', 1000),
(76, 'Barang dummy 75', 1200, 1320, 'KLT', 1000),
(77, 'Barang dummy 76', 11000, 12100, 'KLT', 1000),
(78, 'Barang dummy 77', 30000, 33000, 'KSM', 1000),
(79, 'Barang dummy 78', 30000, 33000, 'KSM', 1000),
(80, 'Barang dummy 79', 1400, 1540, 'KSM', 1000),
(81, 'Barang dummy 80', 1300, 1430, 'KSM', 1000),
(82, 'Barang dummy 81', 1300, 1430, 'KSM', 1000),
(83, 'Barang dummy 82', 30000, 33000, 'KSM', 1000),
(84, 'Barang dummy 83', 12000, 13200, 'KSM', 1000),
(85, 'Barang dummy 84', 1400, 1540, 'KSM', 1000),
(86, 'Barang dummy 85', 10000, 11000, 'KLT', 1000),
(87, 'Barang dummy 86', 30000, 33000, 'KLT', 1000),
(88, 'Barang dummy 87', 30000, 33000, 'KSM', 1000),
(89, 'Barang dummy 88', 30000, 33000, 'KSM', 1000),
(90, 'Barang dummy 89', 40000, 44000, 'KSM', 1000),
(91, 'Barang dummy 90', 40000, 44000, 'KLT', 1000),
(92, 'Barang dummy 91', 30000, 33000, 'KSM', 1000),
(93, 'Barang dummy 92', 12000, 13200, 'KSM', 1000),
(94, 'Barang dummy 93', 10000, 11000, 'KLT', 1000),
(95, 'Barang dummy 94', 11000, 12100, 'KLT', 1000),
(96, 'Barang dummy 95', 12000, 13200, 'KSM', 1000),
(97, 'Barang dummy 96', 11000, 12100, 'KSM', 1000),
(98, 'Barang dummy 97', 1400, 1540, 'KSM', 1000),
(99, 'Barang dummy 98', 1300, 1430, 'KSM', 1000),
(100, 'Barang dummy 99', 1200, 1320, 'KSM', 1000),
(101, 'Barang dummy 100', 1300, 1430, 'KLT', 1000),
(102, 'Barang dummy 101', 11000, 12100, 'KLT', 1000),
(103, 'Barang dummy 102', 40000, 44000, 'KLT', 1000),
(104, 'Barang dummy 103', 1200, 1320, 'KSM', 1000),
(105, 'Barang dummy 104', 1400, 1540, 'KLT', 1000),
(106, 'Barang dummy 105', 1400, 1540, 'KLT', 1000),
(107, 'Barang dummy 106', 12000, 13200, 'KLT', 1000),
(108, 'Barang dummy 107', 1400, 1540, 'KLT', 1000),
(109, 'Barang dummy 108', 40000, 44000, 'KSM', 1000),
(110, 'Barang dummy 109', 11000, 12100, 'KLT', 1000),
(111, 'Barang dummy 110', 11000, 12100, 'KSM', 1000),
(112, 'Barang dummy 111', 10000, 11000, 'KSM', 1000),
(113, 'Barang dummy 112', 1300, 1430, 'KLT', 1000),
(114, 'Barang dummy 113', 30000, 33000, 'KSM', 1000),
(115, 'Barang dummy 114', 40000, 44000, 'KLT', 1000),
(116, 'Barang dummy 115', 1400, 1540, 'KSM', 1000),
(117, 'Barang dummy 116', 11000, 12100, 'KLT', 1000),
(118, 'Barang dummy 117', 1200, 1320, 'KSM', 1000),
(119, 'Barang dummy 118', 10000, 11000, 'KSM', 1000),
(120, 'Barang dummy 119', 12000, 13200, 'KSM', 1000),
(121, 'Barang dummy 120', 11000, 12100, 'KLT', 1000),
(122, 'Barang dummy 121', 12000, 13200, 'KLT', 1000),
(123, 'Barang dummy 122', 10000, 11000, 'KSM', 1000),
(124, 'Barang dummy 123', 30000, 33000, 'KSM', 1000),
(125, 'Barang dummy 124', 12000, 13200, 'KSM', 1000),
(126, 'Barang dummy 125', 12000, 13200, 'KSM', 1000),
(127, 'Barang dummy 126', 11000, 12100, 'KSM', 1000),
(128, 'Barang dummy 127', 1300, 1430, 'KSM', 1000),
(129, 'Barang dummy 128', 10000, 11000, 'KLT', 1000),
(130, 'Barang dummy 129', 1300, 1430, 'KSM', 1000),
(131, 'Barang dummy 130', 1400, 1540, 'KSM', 1000),
(132, 'Barang dummy 131', 40000, 44000, 'KLT', 1000),
(133, 'Barang dummy 132', 11000, 12100, 'KSM', 1000),
(134, 'Barang dummy 133', 10000, 11000, 'KLT', 1000),
(135, 'Barang dummy 134', 1300, 1430, 'KLT', 1000),
(136, 'Barang dummy 135', 10000, 11000, 'KSM', 1000),
(137, 'Barang dummy 136', 10000, 11000, 'KLT', 1000),
(138, 'Barang dummy 137', 40000, 44000, 'KLT', 1000),
(139, 'Barang dummy 138', 40000, 44000, 'KLT', 1000),
(140, 'Barang dummy 139', 12000, 13200, 'KSM', 1000),
(141, 'Barang dummy 140', 10000, 11000, 'KSM', 1000),
(142, 'Barang dummy 141', 1400, 1540, 'KSM', 1000),
(143, 'Barang dummy 142', 1200, 1320, 'KLT', 1000),
(144, 'Barang dummy 143', 11000, 12100, 'KLT', 1000),
(145, 'Barang dummy 144', 1200, 1320, 'KSM', 1000),
(146, 'Barang dummy 145', 1200, 1320, 'KSM', 1000),
(147, 'Barang dummy 146', 40000, 44000, 'KSM', 1000),
(148, 'Barang dummy 147', 10000, 11000, 'KLT', 1000),
(149, 'Barang dummy 148', 10000, 11000, 'KSM', 1000),
(150, 'Barang dummy 149', 11000, 12100, 'KSM', 1000),
(151, 'Barang dummy 150', 10000, 11000, 'KLT', 1000),
(152, 'Barang dummy 151', 1200, 1320, 'KLT', 1000),
(153, 'Barang dummy 152', 1400, 1540, 'KSM', 1000),
(154, 'Barang dummy 153', 1400, 1540, 'KLT', 1000),
(155, 'Barang dummy 154', 1200, 1320, 'KSM', 1000),
(156, 'Barang dummy 155', 10000, 11000, 'KSM', 1000),
(157, 'Barang dummy 156', 12000, 13200, 'KSM', 1000),
(158, 'Barang dummy 157', 1200, 1320, 'KSM', 1000),
(159, 'Barang dummy 158', 40000, 44000, 'KLT', 1000),
(160, 'Barang dummy 159', 1400, 1540, 'KLT', 1000),
(161, 'Barang dummy 160', 1400, 1540, 'KSM', 1000),
(162, 'Barang dummy 161', 40000, 44000, 'KSM', 1000),
(163, 'Barang dummy 162', 10000, 11000, 'KSM', 1000),
(164, 'Barang dummy 163', 12000, 13200, 'KLT', 1000),
(165, 'Barang dummy 164', 1200, 1320, 'KLT', 1000),
(166, 'Barang dummy 165', 1400, 1540, 'KSM', 1000),
(167, 'Barang dummy 166', 1400, 1540, 'KSM', 1000),
(168, 'Barang dummy 167', 12000, 13200, 'KSM', 1000),
(169, 'Barang dummy 168', 1400, 1540, 'KLT', 1000),
(170, 'Barang dummy 169', 10000, 11000, 'KSM', 1000),
(171, 'Barang dummy 170', 1300, 1430, 'KLT', 1000),
(172, 'Barang dummy 171', 10000, 11000, 'KSM', 1000),
(173, 'Barang dummy 172', 1400, 1540, 'KLT', 1000),
(174, 'Barang dummy 173', 1400, 1540, 'KLT', 1000),
(175, 'Barang dummy 174', 30000, 33000, 'KSM', 1000),
(176, 'Barang dummy 175', 11000, 12100, 'KSM', 1000),
(177, 'Barang dummy 176', 10000, 11000, 'KSM', 1000),
(178, 'Barang dummy 177', 10000, 11000, 'KLT', 1000),
(179, 'Barang dummy 178', 10000, 11000, 'KLT', 1000),
(180, 'Barang dummy 179', 1200, 1320, 'KSM', 1000),
(181, 'Barang dummy 180', 40000, 44000, 'KLT', 1000),
(182, 'Barang dummy 181', 12000, 13200, 'KLT', 1000),
(183, 'Barang dummy 182', 12000, 13200, 'KLT', 1000),
(184, 'Barang dummy 183', 10000, 11000, 'KLT', 1000),
(185, 'Barang dummy 184', 40000, 44000, 'KLT', 1000),
(186, 'Barang dummy 185', 10000, 11000, 'KLT', 1000),
(187, 'Barang dummy 186', 30000, 33000, 'KLT', 1000),
(188, 'Barang dummy 187', 12000, 13200, 'KLT', 1000),
(189, 'Barang dummy 188', 11000, 12100, 'KSM', 1000),
(190, 'Barang dummy 189', 12000, 13200, 'KLT', 1000),
(191, 'Barang dummy 190', 1200, 1320, 'KLT', 1000),
(192, 'Barang dummy 191', 30000, 33000, 'KSM', 1000),
(193, 'Barang dummy 192', 10000, 11000, 'KSM', 1000),
(194, 'Barang dummy 193', 1400, 1540, 'KSM', 1000),
(195, 'Barang dummy 194', 1200, 1320, 'KSM', 1000),
(196, 'Barang dummy 195', 12000, 13200, 'KSM', 1000),
(197, 'Barang dummy 196', 12000, 13200, 'KSM', 1000),
(198, 'Barang dummy 197', 12000, 13200, 'KSM', 1000),
(199, 'Barang dummy 198', 12000, 13200, 'KLT', 1000),
(200, 'Barang dummy 199', 40000, 44000, 'KSM', 1000),
(201, 'Barang dummy 200', 30000, 33000, 'KLT', 1000),
(202, 'Barang dummy 201', 30000, 33000, 'KLT', 1000),
(203, 'Barang dummy 202', 12000, 13200, 'KSM', 1000),
(204, 'Barang dummy 203', 11000, 12100, 'KSM', 1000),
(205, 'Barang dummy 204', 1300, 1430, 'KLT', 1000),
(206, 'Barang dummy 205', 1200, 1320, 'KSM', 1000),
(207, 'Barang dummy 206', 40000, 44000, 'KLT', 1000),
(208, 'Barang dummy 207', 40000, 44000, 'KSM', 1000),
(209, 'Barang dummy 208', 40000, 44000, 'KLT', 1000),
(210, 'Barang dummy 209', 40000, 44000, 'KLT', 1000),
(211, 'Barang dummy 210', 40000, 44000, 'KLT', 1000),
(212, 'Barang dummy 211', 1200, 1320, 'KSM', 1000),
(213, 'Barang dummy 212', 11000, 12100, 'KLT', 1000),
(214, 'Barang dummy 213', 40000, 44000, 'KSM', 1000),
(215, 'Barang dummy 214', 40000, 44000, 'KSM', 1000),
(216, 'Barang dummy 215', 11000, 12100, 'KSM', 1000),
(217, 'Barang dummy 216', 1400, 1540, 'KSM', 1000),
(218, 'Barang dummy 217', 12000, 13200, 'KSM', 1000),
(219, 'Barang dummy 218', 1200, 1320, 'KSM', 1000),
(220, 'Barang dummy 219', 30000, 33000, 'KSM', 1000),
(221, 'Barang dummy 220', 1400, 1540, 'KSM', 1000),
(222, 'Barang dummy 221', 11000, 12100, 'KSM', 1000),
(223, 'Barang dummy 222', 12000, 13200, 'KLT', 1000),
(224, 'Barang dummy 223', 1200, 1320, 'KLT', 1000),
(225, 'Barang dummy 224', 1400, 1540, 'KSM', 1000),
(226, 'Barang dummy 225', 11000, 12100, 'KLT', 1000),
(227, 'Barang dummy 226', 30000, 33000, 'KSM', 1000),
(228, 'Barang dummy 227', 1200, 1320, 'KSM', 1000),
(229, 'Barang dummy 228', 40000, 44000, 'KSM', 1000),
(230, 'Barang dummy 229', 30000, 33000, 'KLT', 1000),
(231, 'Barang dummy 230', 1300, 1430, 'KSM', 1000),
(232, 'Barang dummy 231', 1300, 1430, 'KSM', 1000),
(233, 'Barang dummy 232', 11000, 12100, 'KLT', 1000),
(234, 'Barang dummy 233', 30000, 33000, 'KLT', 1000),
(235, 'Barang dummy 234', 11000, 12100, 'KSM', 1000),
(236, 'Barang dummy 235', 10000, 11000, 'KSM', 1000),
(237, 'Barang dummy 236', 10000, 11000, 'KLT', 1000),
(238, 'Barang dummy 237', 12000, 13200, 'KSM', 1000),
(239, 'Barang dummy 238', 30000, 33000, 'KSM', 1000),
(240, 'Barang dummy 239', 12000, 13200, 'KLT', 1000),
(241, 'Barang dummy 240', 1200, 1320, 'KSM', 1000),
(242, 'Barang dummy 241', 40000, 44000, 'KSM', 1000),
(243, 'Barang dummy 242', 12000, 13200, 'KLT', 1000),
(244, 'Barang dummy 243', 12000, 13200, 'KLT', 1000),
(245, 'Barang dummy 244', 40000, 44000, 'KSM', 1000),
(246, 'Barang dummy 245', 1400, 1540, 'KSM', 1000),
(247, 'Barang dummy 246', 11000, 12100, 'KLT', 1000),
(248, 'Barang dummy 247', 10000, 11000, 'KSM', 1000),
(249, 'Barang dummy 248', 1300, 1430, 'KSM', 1000),
(250, 'Barang dummy 249', 1300, 1430, 'KSM', 1000),
(251, 'Barang dummy 250', 12000, 13200, 'KLT', 1000),
(252, 'Barang dummy 251', 30000, 33000, 'KSM', 1000),
(253, 'Barang dummy 252', 11000, 12100, 'KSM', 1000),
(254, 'Barang dummy 253', 1200, 1320, 'KLT', 1000),
(255, 'Barang dummy 254', 1400, 1540, 'KSM', 1000),
(256, 'Barang dummy 255', 10000, 11000, 'KLT', 1000),
(257, 'Barang dummy 256', 40000, 44000, 'KLT', 1000),
(258, 'Barang dummy 257', 1200, 1320, 'KLT', 1000),
(259, 'Barang dummy 258', 12000, 13200, 'KLT', 1000),
(260, 'Barang dummy 259', 1400, 1540, 'KSM', 1000),
(261, 'Barang dummy 260', 1400, 1540, 'KLT', 1000),
(262, 'Barang dummy 261', 12000, 13200, 'KSM', 1000),
(263, 'Barang dummy 262', 11000, 12100, 'KLT', 1000),
(264, 'Barang dummy 263', 30000, 33000, 'KLT', 1000),
(265, 'Barang dummy 264', 1400, 1540, 'KSM', 1000),
(266, 'Barang dummy 265', 12000, 13200, 'KLT', 1000),
(267, 'Barang dummy 266', 1400, 1540, 'KLT', 1000),
(268, 'Barang dummy 267', 1400, 1540, 'KSM', 1000),
(269, 'Barang dummy 268', 40000, 44000, 'KSM', 1000),
(270, 'Barang dummy 269', 11000, 12100, 'KSM', 1000),
(271, 'Barang dummy 270', 10000, 11000, 'KSM', 1000),
(272, 'Barang dummy 271', 1300, 1430, 'KSM', 1000),
(273, 'Barang dummy 272', 10000, 11000, 'KSM', 1000),
(274, 'Barang dummy 273', 1300, 1430, 'KSM', 1000),
(275, 'Barang dummy 274', 1400, 1540, 'KLT', 1000),
(276, 'Barang dummy 275', 12000, 13200, 'KSM', 1000),
(277, 'Barang dummy 276', 1300, 1430, 'KSM', 1000),
(278, 'Barang dummy 277', 1400, 1540, 'KSM', 1000),
(279, 'Barang dummy 278', 30000, 33000, 'KSM', 1000),
(280, 'Barang dummy 279', 1300, 1430, 'KLT', 1000),
(281, 'Barang dummy 280', 10000, 11000, 'KSM', 1000),
(282, 'Barang dummy 281', 30000, 33000, 'KSM', 1000),
(283, 'Barang dummy 282', 1300, 1430, 'KSM', 1000),
(284, 'Barang dummy 283', 11000, 12100, 'KSM', 1000),
(285, 'Barang dummy 284', 40000, 44000, 'KSM', 1000),
(286, 'Barang dummy 285', 40000, 44000, 'KLT', 1000),
(287, 'Barang dummy 286', 1300, 1430, 'KSM', 1000),
(288, 'Barang dummy 287', 1400, 1540, 'KLT', 1000),
(289, 'Barang dummy 288', 1400, 1540, 'KLT', 1000),
(290, 'Barang dummy 289', 1300, 1430, 'KSM', 1000),
(291, 'Barang dummy 290', 10000, 11000, 'KSM', 1000),
(292, 'Barang dummy 291', 11000, 12100, 'KSM', 1000),
(293, 'Barang dummy 292', 1400, 1540, 'KSM', 1000),
(294, 'Barang dummy 293', 11000, 12100, 'KSM', 1000),
(295, 'Barang dummy 294', 12000, 13200, 'KLT', 1000),
(296, 'Barang dummy 295', 12000, 13200, 'KSM', 1000),
(297, 'Barang dummy 296', 40000, 44000, 'KSM', 1000),
(298, 'Barang dummy 297', 12000, 13200, 'KLT', 1000),
(299, 'Barang dummy 298', 1200, 1320, 'KSM', 1000),
(300, 'Barang dummy 299', 30000, 33000, 'KLT', 1000),
(301, 'Barang dummy 300', 30000, 33000, 'KSM', 1000),
(302, '9999', 9999, 99999, 'KSM', 98098),
(303, 'notif test', 9098, 909090, 'KSM', 20),
(304, 'as123al', 123, 123, 'KSM', 123),
(305, 'sierra', 900, 1200, 'KLT', 20),
(306, 'SIERRA', 123123, 123123, 'KLT', 123123),
(307, 'sdgsdg', 123, 1233, 'KSM', 34),
(308, 'sdgsdg', 123, 1233, 'KSM', 34);

-- --------------------------------------------------------

--
-- Table structure for table `beban`
--

CREATE TABLE `beban` (
  `id_beban` int(11) NOT NULL,
  `nama_beban` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coa`
--

CREATE TABLE `coa` (
  `no_akun` char(5) NOT NULL,
  `nama_akun` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coa`
--

INSERT INTO `coa` (`no_akun`, `nama_akun`) VALUES
('1', 'Aktiva'),
('11', 'Aktiva Lancar'),
('111', 'Kas'),
('112', 'Piutang Anggota'),
('2', 'Utang'),
('21', 'Utang Lancar'),
('211', 'Utang Usaha'),
('212', 'Simpanan Manasuka'),
('213', 'Simpanan Pendidikan'),
('214', 'Simpanan Hari Raya'),
('3', 'Ekuitas'),
('31', 'Ekuitas Koperasi'),
('311', 'Simpanan Pokok'),
('312', 'Simpanan Wajib'),
('313', 'Modal Penyertaan'),
('314', 'Modal sumbangan/donasi'),
('315', 'Cadangan'),
('316', 'SHU yang belum dibagi'),
('4', 'Pendapatan'),
('41', 'Pendapatan Bunga'),
('5', 'Beban'),
('51', 'Beban Operasional'),
('511', 'Hr Karyawan'),
('512', 'Transport Pembantu Pengurus'),
('513', 'Transport Pengurus'),
('514', 'Transport Pengawas'),
('515', 'Transport Penasehat'),
('516', 'Beban ATK'),
('517', 'Beban Promosi'),
('52', 'Beban Non-Operasional'),
('521', 'Beban Rapat Pengurus dan BP'),
('522', 'Beban Kebersihan'),
('523', 'Beban Transport'),
('524', 'Beban Denda Pajak'),
('525', 'Beban RAT'),
('526', 'Beban Penyusutan'),
('527', 'Beban Pembinaan'),
('53', 'Pajak');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penarikan`
--

CREATE TABLE `detail_penarikan` (
  `id_penarikan` varchar(10) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penarikan`
--

INSERT INTO `detail_penarikan` (`id_penarikan`, `id_jenis`, `subtotal`) VALUES
('TRK-11', 2, 50000),
('TRK-11', 4, 10000),
('TRK-16', 5, 25000),
('TRK-45', 5, 30000),
('TRK-51', 1, 50000),
('TRK-51', 2, 100000),
('TRK-51', 5, 35000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` varchar(10) NOT NULL,
  `id_barang` int(15) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_penjualan`, `id_barang`, `jumlah`, `subtotal`) VALUES
('PNJ-3', 12, 1, 1320),
('PNJ-3', 22, 2, 3080),
('PNJ-3', 77, 1, 12100),
('PNJ-3', 99, 1, 1430),
('PNJ-3', 222, 3, 36300);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `id_jenis` int(11) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `kategori` varchar(30) DEFAULT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`id_jenis`, `keterangan`, `kategori`, `tarif`) VALUES
(1, 'Simpanan Pokok', '1', 50000),
(2, 'Simpanan Wajib', '1', 50000),
(3, 'Simpanan Manasuka', '2', 0),
(4, 'Simpanan Pendidikan', '2', 0),
(5, 'Simpanan Hari Raya', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `no_akun` char(5) NOT NULL,
  `posisi_dr_cr` varchar(6) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_trans` varchar(10) NOT NULL,
  `tgl_jurnal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`no_akun`, `posisi_dr_cr`, `nominal`, `id_trans`, `tgl_jurnal`) VALUES
('111', 'd', 88000000, 'API-39', '2018-01-01'),
('112', 'k', 80000000, 'API-39', '2018-01-01'),
('41', 'k', 8000000, 'API-39', '2018-01-01'),
('111', 'd', 27500000, 'API-42', '2018-01-01'),
('112', 'k', 25000000, 'API-42', '2018-01-01'),
('41', 'k', 2500000, 'API-42', '2018-01-01'),
('111', 'd', 11000000, 'API-48', '2018-01-31'),
('112', 'k', 10000000, 'API-48', '2018-01-31'),
('41', 'k', 1000000, 'API-48', '2018-01-31'),
('111', 'k', 20000, 'BYR-23', '0000-00-00'),
('511', 'd', 20000, 'BYR-23', '0000-00-00'),
('111', 'k', 15000, 'BYR-24', '0000-00-00'),
('512', 'd', 15000, 'BYR-24', '0000-00-00'),
('111', 'k', 12000, 'BYR-25', '0000-00-00'),
('513', 'd', 12000, 'BYR-25', '0000-00-00'),
('111', 'k', 30000, 'BYR-26', '0000-00-00'),
('514', 'd', 30000, 'BYR-26', '0000-00-00'),
('111', 'k', 10000, 'BYR-27', '0000-00-00'),
('515', 'd', 10000, 'BYR-27', '0000-00-00'),
('111', 'k', 25000, 'BYR-28', '0000-00-00'),
('516', 'd', 25000, 'BYR-28', '0000-00-00'),
('111', 'k', 20000, 'BYR-29', '0000-00-00'),
('517', 'd', 20000, 'BYR-29', '0000-00-00'),
('111', 'k', 15000, 'BYR-30', '0000-00-00'),
('521', 'd', 15000, 'BYR-30', '0000-00-00'),
('111', 'k', 25000, 'BYR-31', '0000-00-00'),
('522', 'd', 25000, 'BYR-31', '0000-00-00'),
('111', 'k', 15000, 'BYR-32', '0000-00-00'),
('523', 'd', 15000, 'BYR-32', '0000-00-00'),
('111', 'k', 25000, 'BYR-33', '0000-00-00'),
('524', 'd', 25000, 'BYR-33', '0000-00-00'),
('111', 'k', 50000, 'BYR-34', '0000-00-00'),
('525', 'd', 50000, 'BYR-34', '0000-00-00'),
('111', 'k', 10000, 'BYR-35', '0000-00-00'),
('526', 'd', 10000, 'BYR-35', '0000-00-00'),
('111', 'k', 45000, 'BYR-36', '0000-00-00'),
('527', 'd', 45000, 'BYR-36', '0000-00-00'),
('111', 'k', 80000000, 'PIN-38', '0000-00-00'),
('112', 'd', 80000000, 'PIN-38', '0000-00-00'),
('111', 'k', 25000000, 'PIN-41', '0000-00-00'),
('112', 'd', 25000000, 'PIN-41', '0000-00-00'),
('111', 'k', 20000000, 'PIN-47', '0000-00-00'),
('112', 'd', 20000000, 'PIN-47', '0000-00-00'),
('111', 'd', 50000, 'SIM-1', '2018-01-05'),
('311', 'k', 50000, 'SIM-1', '2018-01-05'),
('111', 'd', 10000, 'SIM-10', '2018-01-01'),
('213', 'k', 10000, 'SIM-10', '2018-01-01'),
('111', 'd', 50000, 'SIM-12', '2018-01-01'),
('311', 'k', 50000, 'SIM-12', '2018-01-01'),
('111', 'd', 50000, 'SIM-13', '2018-01-01'),
('312', 'k', 50000, 'SIM-13', '2018-01-01'),
('111', 'd', 30000, 'SIM-14', '2018-01-01'),
('214', 'k', 30000, 'SIM-14', '2018-01-01'),
('111', 'd', 30000, 'SIM-15', '2018-01-01'),
('214', 'k', 30000, 'SIM-15', '2018-01-01'),
('111', 'd', 50000, 'SIM-2', '2018-01-05'),
('312', 'k', 50000, 'SIM-2', '2018-01-05'),
('111', 'd', 50000, 'SIM-3', '2018-01-05'),
('312', 'k', 50000, 'SIM-3', '2018-01-05'),
('111', 'd', 50000, 'SIM-40', '0000-00-00'),
('311', 'k', 50000, 'SIM-40', '0000-00-00'),
('111', 'd', 50000, 'SIM-43', '0000-00-00'),
('312', 'k', 50000, 'SIM-43', '0000-00-00'),
('111', 'd', 30000, 'SIM-44', '0000-00-00'),
('214', 'k', 30000, 'SIM-44', '0000-00-00'),
('111', 'd', 50000, 'SIM-57', '0000-00-00'),
('312', 'k', 50000, 'SIM-57', '0000-00-00'),
('111', 'd', 50000, 'SIM-58', '0000-00-00'),
('312', 'k', 50000, 'SIM-58', '0000-00-00'),
('111', 'd', 50000, 'SIM-59', '0000-00-00'),
('311', 'k', 50000, 'SIM-59', '0000-00-00'),
('111', 'd', 50000, 'SIM-6', '2018-01-01'),
('311', 'k', 50000, 'SIM-6', '2018-01-01'),
('111', 'd', 50000, 'SIM-60', '0000-00-00'),
('312', 'k', 50000, 'SIM-60', '0000-00-00'),
('111', 'd', 50000, 'SIM-7', '2018-01-01'),
('312', 'k', 50000, 'SIM-7', '2018-01-01'),
('111', 'd', 25000, 'SIM-8', '2018-01-01'),
('212', 'k', 25000, 'SIM-8', '2018-01-01'),
('111', 'd', 50000, 'SIM-9', '2018-01-01'),
('312', 'k', 50000, 'SIM-9', '2018-01-01'),
('111', 'k', 60000, 'TRK-11', '2018-01-01'),
('213', 'd', 10000, 'TRK-11', '2018-01-01'),
('312', 'd', 50000, 'TRK-11', '2018-01-01'),
('111', 'k', 25000, 'TRK-16', '2018-01-01'),
('214', 'd', 25000, 'TRK-16', '2018-01-01'),
('111', 'k', 30000, 'TRK-45', '0000-00-00'),
('214', 'd', 30000, 'TRK-45', '0000-00-00'),
('111', 'k', 185000, 'TRK-51', '0000-00-00'),
('311', 'd', 50000, 'TRK-51', '0000-00-00'),
('312', 'd', 100000, 'TRK-51', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `nama_kasir` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nota_penjualan`
--

CREATE TABLE `nota_penjualan` (
  `id_penjualan` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL,
  `id_kasir` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_penjualan`
--

INSERT INTO `nota_penjualan` (`id_penjualan`, `tgl_trans`, `jml_trans`, `no_anggota`, `id_kasir`, `status`) VALUES
('PNJ-1', NULL, NULL, NULL, NULL, '1'),
('PNJ-2', NULL, NULL, NULL, NULL, '1'),
('PNJ-3', NULL, 0, NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `obyek_alokasi`
--

CREATE TABLE `obyek_alokasi` (
  `id_obyek` int(11) NOT NULL,
  `nama_obyek` varchar(50) DEFAULT NULL,
  `prosentase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obyek_alokasi`
--

INSERT INTO `obyek_alokasi` (`id_obyek`, `nama_obyek`, `prosentase`) VALUES
(4, 'Cadangan Modal', 7),
(5, 'Jasa Simpanan Pokok dan Wajib', 25),
(6, 'Jasa Simpanan Manasuka/Hari Raya', 23),
(7, 'Jasa Peminjam', 23),
(8, 'Dana Pengurus', 10),
(9, 'Dana Pendidikan', 4),
(10, 'Dana Sosial', 7),
(11, 'Dana Cadangan/Tujuan Resiko', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_bayar` varchar(10) NOT NULL,
  `no_bukti` varchar(30) NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int(11) DEFAULT NULL,
  `no_akun` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_bayar`, `no_bukti`, `tgl_bayar`, `jml_bayar`, `no_akun`) VALUES
('BYR-19', '', NULL, NULL, ''),
('BYR-20', '', NULL, NULL, ''),
('BYR-21', '', NULL, NULL, ''),
('BYR-22', '', NULL, NULL, ''),
('BYR-23', '12345678910', '2018-01-03', 20000, '511'),
('BYR-24', '1236712388828', '2018-01-04', 15000, '512'),
('BYR-25', '126152315381538', '2018-01-07', 12000, '513'),
('BYR-26', '8173289173182937', '2018-01-08', 30000, '514'),
('BYR-27', '897973917391723', '2018-01-09', 10000, '515'),
('BYR-28', '2732874QYY6777', '2018-01-11', 25000, '516'),
('BYR-29', 'QWYUQTWUYQWE812738917JHA', '2018-01-11', 20000, '517'),
('BYR-30', 'QUWYQIUW8127JHW', '2018-01-14', 15000, '521'),
('BYR-31', '187312837', '2018-01-16', 25000, '522'),
('BYR-32', '1827391739137', '2018-01-15', 15000, '523'),
('BYR-33', '1387182ABNBNA78', '2018-01-15', 25000, '524'),
('BYR-34', '1752YUQTEUQTW', '2018-01-16', 50000, '525'),
('BYR-35', '127391JSUUWY', '2018-01-17', 10000, '526'),
('BYR-36', 'QWUYQ71263871', '2018-01-28', 45000, '527');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penarikan`
--

CREATE TABLE `penarikan` (
  `id_penarikan` varchar(10) NOT NULL,
  `jml_penarikan` int(11) DEFAULT NULL,
  `tgl_penarikan` date DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penarikan`
--

INSERT INTO `penarikan` (`id_penarikan`, `jml_penarikan`, `tgl_penarikan`, `no_anggota`) VALUES
('TRK-11', 60000, '2018-01-01', 37),
('TRK-16', 25000, '2018-01-01', 38),
('TRK-45', 30000, '2018-01-31', 38),
('TRK-46', NULL, NULL, NULL),
('TRK-49', NULL, NULL, NULL),
('TRK-50', NULL, NULL, NULL),
('TRK-51', 185000, '2018-01-31', 38);

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id_pengurus` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `posisi` varchar(30) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id_pinjam` varchar(10) NOT NULL,
  `jml_pinjam` int(11) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_pencairan` date NOT NULL,
  `banyak_angsuran` int(11) DEFAULT NULL,
  `tarif_bunga` int(11) DEFAULT NULL,
  `tarif_angsur` int(11) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT '0=tggu,1=setuju,2=cair blm lunas,3=cair,4=ditolak',
  `no_anggota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjam`, `jml_pinjam`, `tgl_pengajuan`, `tgl_pencairan`, `banyak_angsuran`, `tarif_bunga`, `tarif_angsur`, `jatuh_tempo`, `status`, `no_anggota`) VALUES
('PIN-37', NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL),
('PIN-38', 80000000, '2018-01-01', '2018-01-01', 1, 10, 88000000, '2018-02-01', '3', 38),
('PIN-41', 25000000, '2018-01-01', '2018-01-01', 1, 10, 27500000, '2018-02-01', '3', 39),
('PIN-47', 20000000, '2018-01-31', '2018-01-31', 2, 10, 11000000, '2018-03-31', '2', 38),
('PIN-52', 900000, '2017-12-19', '0000-00-00', 2, 10, 495000, '0000-00-00', '1', 39),
('PIN-53', 9999999, '2017-12-19', '0000-00-00', 1, 10, 10999999, '0000-00-00', '1', 39);

-- --------------------------------------------------------

--
-- Table structure for table `rencana_pembagian`
--

CREATE TABLE `rencana_pembagian` (
  `id` int(11) NOT NULL,
  `periode` char(4) DEFAULT NULL,
  `prosentase` int(11) DEFAULT NULL,
  `hasil_pembagian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id_simpanan` varchar(10) NOT NULL,
  `jml_simpanan` int(11) DEFAULT NULL,
  `tgl_simpan` date DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL,
  `id_jenis` int(11) NOT NULL,
  `periode` varchar(2) NOT NULL,
  `tahun` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `jml_simpanan`, `tgl_simpan`, `no_anggota`, `id_jenis`, `periode`, `tahun`) VALUES
('SIM-1', 50000, '2018-01-05', 36, 1, '1', '2018'),
('SIM-10', 10000, '2018-01-01', 37, 4, '1', '2018'),
('SIM-12', 50000, '2018-01-01', 38, 1, '1', '2018'),
('SIM-13', 50000, '2018-01-01', 38, 2, '1', '2018'),
('SIM-14', 30000, '2018-01-01', 38, 5, '1', '2018'),
('SIM-15', 30000, '2018-01-01', 38, 5, '2', '2018'),
('SIM-2', 50000, '2018-01-05', 36, 2, '1', '2018'),
('SIM-3', 50000, '2018-01-05', 36, 2, '2', '2018'),
('SIM-40', 50000, '2018-01-01', 39, 1, '1', '2018'),
('SIM-43', 50000, '2018-01-31', 38, 2, '2', '2018'),
('SIM-44', 30000, '2018-01-31', 38, 5, '3', '2018'),
('SIM-54', NULL, NULL, NULL, 1, '', ''),
('SIM-55', NULL, NULL, NULL, 1, '', ''),
('SIM-56', NULL, NULL, NULL, 1, '', ''),
('SIM-57', 50000, '2018-01-04', 39, 2, '1', '2018'),
('SIM-58', 50000, '2018-01-04', 39, 2, '2', '2018'),
('SIM-59', 50000, '2018-01-04', 40, 1, '1', '2018'),
('SIM-6', 50000, '2018-01-01', 37, 1, '1', '2018'),
('SIM-60', 50000, '2018-01-04', 40, 2, '1', '2018'),
('SIM-7', 50000, '2018-01-01', 37, 2, '1', '2018'),
('SIM-8', 25000, '2018-01-01', 37, 3, '1', '2018'),
('SIM-9', 50000, '2018-01-01', 37, 2, '2', '2018');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_anggota`
--

CREATE TABLE `simpanan_anggota` (
  `no_anggota` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tarif` int(11) DEFAULT NULL,
  `jml_simpanan_dimiliki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan_anggota`
--

INSERT INTO `simpanan_anggota` (`no_anggota`, `id_jenis`, `tarif`, `jml_simpanan_dimiliki`) VALUES
(36, 1, 50000, 0),
(36, 2, 50000, 0),
(36, 3, 10000, 0),
(37, 1, 50000, 0),
(37, 2, 50000, 0),
(37, 3, 25000, 0),
(37, 4, 10000, 0),
(38, 1, 50000, 0),
(38, 2, 50000, 0),
(38, 5, 30000, 0),
(39, 1, 50000, 50000),
(39, 2, 50000, 100000),
(40, 1, 50000, 50000),
(40, 2, 50000, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(30) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp`) VALUES
(35, 'Supplier Dummy 23', 'Alamat 23', '23'),
(36, 'Supplier Dummy 24', 'Alamat 24', '24'),
(37, 'Supplier Dummy 25', 'Alamat 25', '25'),
(38, 'Supplier Dummy 26', 'Alamat 26', '26'),
(39, 'Supplier Dummy 27', 'Alamat 27', '27'),
(40, 'Supplier Dummy 28', 'Alamat 28', '28'),
(41, 'Supplier Dummy 29', 'Alamat 29', '29'),
(42, 'Supplier Dummy 30', 'Alamat 30', '30'),
(43, 'Supplier Dummy 31', 'Alamat 31', '31'),
(44, 'Supplier Dummy 32', 'Alamat 32', '32'),
(45, 'Supplier Dummy 33', 'Alamat 33', '33'),
(46, 'Supplier Dummy 34', 'Alamat 34', '34'),
(47, 'Supplier Dummy 35', 'Alamat 35', '35'),
(48, 'Supplier Dummy 36', 'Alamat 36', '36'),
(49, 'Supplier Dummy 37', 'Alamat 37', '37'),
(50, 'Supplier Dummy 38', 'Alamat 38', '38'),
(51, 'Supplier Dummy 39', 'Alamat 39', '39'),
(52, 'Supplier Dummy 40', 'Alamat 40', '40'),
(53, 'Supplier Dummy 41', 'Alamat 41', '41'),
(54, 'Supplier Dummy 42', 'Alamat 42', '42'),
(55, 'Supplier Dummy 43', 'Alamat 43', '43'),
(56, 'Supplier Dummy 44', 'Alamat 44', '44'),
(57, 'Supplier Dummy 45', 'Alamat 45', '45'),
(58, 'Supplier Dummy 46', 'Alamat 46', '46'),
(59, 'Supplier Dummy 47', 'Alamat 47', '47'),
(60, 'Supplier Dummy 48', 'Alamat 48', '48'),
(61, 'Supplier Dummy 49', 'Alamat 49', '49'),
(62, 'Supplier Dummy 50', 'Alamat 50', '50'),
(63, 'Supplier Dummy 51', 'Alamat 51', '51'),
(64, 'Supplier Dummy 52', 'Alamat 52', '52'),
(65, 'Supplier Dummy 53', 'Alamat 53', '53'),
(66, 'Supplier Dummy 54', 'Alamat 54', '54'),
(67, 'Supplier Dummy 55', 'Alamat 55', '55'),
(68, 'Supplier Dummy 56', 'Alamat 56', '56'),
(69, 'Supplier Dummy 57', 'Alamat 57', '57'),
(70, 'Supplier Dummy 58', 'Alamat 58', '58'),
(71, 'Supplier Dummy 59', 'Alamat 59', '59'),
(72, 'Supplier Dummy 60', 'Alamat 60', '60'),
(73, 'Supplier Dummy 61', 'Alamat 61', '61'),
(74, 'Supplier Dummy 62', 'Alamat 62', '62'),
(75, 'Supplier Dummy 63', 'Alamat 63', '63'),
(76, 'Supplier Dummy 64', 'Alamat 64', '64'),
(77, 'Supplier Dummy 65', 'Alamat 65', '65'),
(78, 'Supplier Dummy 66', 'Alamat 66', '66'),
(79, 'Supplier Dummy 67', 'Alamat 67', '67'),
(80, 'Supplier Dummy 68', 'Alamat 68', '68'),
(81, 'Supplier Dummy 69', 'Alamat 69', '69'),
(82, 'Supplier Dummy 70', 'Alamat 70', '70'),
(83, 'Supplier Dummy 71', 'Alamat 71', '71'),
(84, 'Supplier Dummy 72', 'Alamat 72', '72'),
(85, 'Supplier Dummy 73', 'Alamat 73', '73'),
(86, 'Supplier Dummy 74', 'Alamat 74', '74'),
(87, 'Supplier Dummy 75', 'Alamat 75', '75'),
(88, 'Supplier Dummy 76', 'Alamat 76', '76'),
(89, 'Supplier Dummy 77', 'Alamat 77', '77'),
(90, 'Supplier Dummy 78', 'Alamat 78', '78'),
(91, 'Supplier Dummy 79', 'Alamat 79', '79'),
(92, 'Supplier Dummy 80', 'Alamat 80', '80'),
(93, 'Supplier Dummy 81', 'Alamat 81', '81'),
(94, 'Supplier Dummy 82', 'Alamat 82', '82'),
(95, 'Supplier Dummy 83', 'Alamat 83', '83'),
(96, 'Supplier Dummy 84', 'Alamat 84', '84'),
(97, 'Supplier Dummy 85', 'Alamat 85', '85'),
(98, 'Supplier Dummy 86', 'Alamat 86', '86'),
(99, 'Supplier Dummy 87', 'Alamat 87', '87'),
(100, 'Supplier Dummy 88', 'Alamat 88', '88'),
(101, 'Supplier Dummy 89', 'Alamat 89', '89'),
(102, 'Supplier Dummy 90', 'Alamat 90', '90'),
(103, 'Supplier Dummy 91', 'Alamat 91', '91'),
(104, 'Supplier Dummy 92', 'Alamat 92', '92'),
(105, 'Supplier Dummy 93', 'Alamat 93', '93'),
(106, 'Supplier Dummy 94', 'Alamat 94', '94'),
(107, 'Supplier Dummy 95', 'Alamat 95', '95'),
(108, 'Supplier Dummy 96', 'Alamat 96', '96'),
(109, 'Supplier Dummy 97', 'Alamat 97', '97'),
(110, 'Supplier Dummy 98', 'Alamat 98', '98'),
(111, 'Supplier Dummy 99', 'Alamat 99', '99'),
(112, 'Supplier Dummy 100', 'Alamat 100', '100'),
(113, 'Supplier Dummy 0', 'Alamat 0', '0'),
(114, 'Supplier Dummy 1', 'Alamat 1', '1'),
(115, 'Supplier Dummy 2', 'Alamat 2', '2'),
(116, 'Supplier Dummy 3', 'Alamat 3', '3'),
(117, 'Supplier Dummy 4', 'Alamat 4', '4'),
(118, 'Supplier Dummy 5', 'Alamat 5', '5'),
(119, 'Supplier Dummy 6', 'Alamat 6', '6'),
(120, 'Supplier Dummy 7', 'Alamat 7', '7'),
(121, 'Supplier Dummy 8', 'Alamat 8', '8'),
(122, 'Supplier Dummy 9', 'Alamat 9', '9'),
(123, 'Supplier Dummy 10', 'Alamat 10', '10'),
(124, 'Supplier Dummy 11', 'Alamat 11', '11'),
(125, 'Supplier Dummy 12', 'Alamat 12', '12'),
(126, 'Supplier Dummy 13', 'Alamat 13', '13'),
(127, 'Supplier Dummy 14', 'Alamat 14', '14'),
(128, 'Supplier Dummy 15', 'Alamat 15', '15'),
(129, 'Supplier Dummy 16', 'Alamat 16', '16'),
(130, 'Supplier Dummy 17', 'Alamat 17', '17'),
(131, 'Supplier Dummy 18', 'Alamat 18', '18'),
(132, 'Supplier Dummy 19', 'Alamat 19', '19'),
(133, 'Supplier Dummy 20', 'Alamat 20', '20'),
(134, 'Supplier Dummy 21', 'Alamat 21', '21'),
(135, 'Supplier Dummy 22', 'Alamat 22', '22'),
(136, 'Supplier Dummy 23', 'Alamat 23', '23'),
(137, 'Supplier Dummy 24', 'Alamat 24', '24'),
(138, 'Supplier Dummy 25', 'Alamat 25', '25'),
(139, 'Supplier Dummy 26', 'Alamat 26', '26'),
(140, 'Supplier Dummy 27', 'Alamat 27', '27'),
(141, 'Supplier Dummy 28', 'Alamat 28', '28'),
(142, 'Supplier Dummy 29', 'Alamat 29', '29'),
(143, 'Supplier Dummy 30', 'Alamat 30', '30'),
(144, 'Supplier Dummy 31', 'Alamat 31', '31'),
(145, 'Supplier Dummy 32', 'Alamat 32', '32'),
(146, 'Supplier Dummy 33', 'Alamat 33', '33'),
(147, 'Supplier Dummy 34', 'Alamat 34', '34'),
(148, 'Supplier Dummy 35', 'Alamat 35', '35'),
(149, 'Supplier Dummy 36', 'Alamat 36', '36'),
(150, 'Supplier Dummy 37', 'Alamat 37', '37'),
(151, 'Supplier Dummy 38', 'Alamat 38', '38'),
(152, 'Supplier Dummy 39', 'Alamat 39', '39'),
(153, 'Supplier Dummy 40', 'Alamat 40', '40'),
(154, 'Supplier Dummy 41', 'Alamat 41', '41'),
(155, 'Supplier Dummy 42', 'Alamat 42', '42'),
(156, 'Supplier Dummy 43', 'Alamat 43', '43'),
(157, 'Supplier Dummy 44', 'Alamat 44', '44'),
(158, 'Supplier Dummy 45', 'Alamat 45', '45'),
(159, 'Supplier Dummy 46', 'Alamat 46', '46'),
(160, 'Supplier Dummy 47', 'Alamat 47', '47'),
(161, 'Supplier Dummy 48', 'Alamat 48', '48'),
(162, 'Supplier Dummy 49', 'Alamat 49', '49'),
(163, 'Supplier Dummy 50', 'Alamat 50', '50'),
(164, 'Supplier Dummy 51', 'Alamat 51', '51'),
(165, 'Supplier Dummy 52', 'Alamat 52', '52'),
(166, 'Supplier Dummy 53', 'Alamat 53', '53'),
(167, 'Supplier Dummy 54', 'Alamat 54', '54'),
(168, 'Supplier Dummy 55', 'Alamat 55', '55'),
(169, 'Supplier Dummy 56', 'Alamat 56', '56'),
(170, 'Supplier Dummy 57', 'Alamat 57', '57'),
(171, 'Supplier Dummy 58', 'Alamat 58', '58'),
(172, 'Supplier Dummy 59', 'Alamat 59', '59'),
(173, 'Supplier Dummy 60', 'Alamat 60', '60'),
(174, 'Supplier Dummy 61', 'Alamat 61', '61'),
(175, 'Supplier Dummy 62', 'Alamat 62', '62'),
(176, 'Supplier Dummy 63', 'Alamat 63', '63'),
(177, 'Supplier Dummy 64', 'Alamat 64', '64'),
(178, 'Supplier Dummy 65', 'Alamat 65', '65'),
(179, 'Supplier Dummy 66', 'Alamat 66', '66'),
(180, 'Supplier Dummy 67', 'Alamat 67', '67'),
(181, 'Supplier Dummy 68', 'Alamat 68', '68'),
(182, 'Supplier Dummy 69', 'Alamat 69', '69'),
(183, 'Supplier Dummy 70', 'Alamat 70', '70'),
(184, 'Supplier Dummy 71', 'Alamat 71', '71'),
(185, 'Supplier Dummy 72', 'Alamat 72', '72'),
(186, 'Supplier Dummy 73', 'Alamat 73', '73'),
(187, 'Supplier Dummy 74', 'Alamat 74', '74'),
(188, 'Supplier Dummy 75', 'Alamat 75', '75'),
(189, 'Supplier Dummy 76', 'Alamat 76', '76'),
(190, 'Supplier Dummy 77', 'Alamat 77', '77'),
(191, 'Supplier Dummy 78', 'Alamat 78', '78'),
(192, 'Supplier Dummy 79', 'Alamat 79', '79'),
(193, 'Supplier Dummy 80', 'Alamat 80', '80'),
(194, 'Supplier Dummy 81', 'Alamat 81', '81'),
(195, 'Supplier Dummy 82', 'Alamat 82', '82'),
(196, 'Supplier Dummy 83', 'Alamat 83', '83'),
(197, 'Supplier Dummy 84', 'Alamat 84', '84'),
(198, 'Supplier Dummy 85', 'Alamat 85', '85'),
(199, 'Supplier Dummy 86', 'Alamat 86', '86'),
(200, 'Supplier Dummy 87', 'Alamat 87', '87'),
(201, 'Supplier Dummy 88', 'Alamat 88', '88'),
(202, 'Supplier Dummy 89', 'Alamat 89', '89'),
(203, 'Supplier Dummy 90', 'Alamat 90', '90'),
(204, 'Supplier Dummy 91', 'Alamat 91', '91'),
(205, 'Supplier Dummy 92', 'Alamat 92', '92'),
(206, 'Supplier Dummy 93', 'Alamat 93', '93'),
(207, 'Supplier Dummy 94', 'Alamat 94', '94'),
(208, 'Supplier Dummy 95', 'Alamat 95', '95'),
(209, 'Supplier Dummy 96', 'Alamat 96', '96'),
(210, 'Supplier Dummy 97', 'Alamat 97', '97'),
(211, 'Supplier Dummy 98', 'Alamat 98', '98'),
(212, 'Supplier Dummy 99', 'Alamat 99', '99'),
(213, 'Supplier Dummy 100', 'Alamat 100', '100'),
(214, 'Supplier Dummy 0', 'Alamat 0', '0'),
(215, 'Supplier Dummy 1', 'Alamat 1', '1'),
(216, 'Supplier Dummy 2', 'Alamat 2', '2'),
(217, 'Supplier Dummy 3', 'Alamat 3', '3'),
(218, 'Supplier Dummy 4', 'Alamat 4', '4'),
(219, 'Supplier Dummy 5', 'Alamat 5', '5'),
(220, 'Supplier Dummy 6', 'Alamat 6', '6'),
(221, 'Supplier Dummy 7', 'Alamat 7', '7'),
(222, 'Supplier Dummy 8', 'Alamat 8', '8'),
(223, 'Supplier Dummy 9', 'Alamat 9', '9'),
(224, 'Supplier Dummy 10', 'Alamat 10', '10'),
(225, 'Supplier Dummy 11', 'Alamat 11', '11'),
(226, 'Supplier Dummy 12', 'Alamat 12', '12'),
(227, 'Supplier Dummy 13', 'Alamat 13', '13'),
(228, 'Supplier Dummy 14', 'Alamat 14', '14'),
(229, 'Supplier Dummy 15', 'Alamat 15', '15'),
(230, 'Supplier Dummy 16', 'Alamat 16', '16'),
(231, 'Supplier Dummy 17', 'Alamat 17', '17'),
(232, 'Supplier Dummy 18', 'Alamat 18', '18'),
(233, 'Supplier Dummy 19', 'Alamat 19', '19'),
(234, 'Supplier Dummy 20', 'Alamat 20', '20'),
(235, 'Supplier Dummy 21', 'Alamat 21', '21'),
(236, 'Supplier Dummy 22', 'Alamat 22', '22'),
(237, 'Supplier Dummy 23', 'Alamat 23', '23'),
(238, 'Supplier Dummy 24', 'Alamat 24', '24'),
(239, 'Supplier Dummy 25', 'Alamat 25', '25'),
(240, 'Supplier Dummy 26', 'Alamat 26', '26'),
(241, 'Supplier Dummy 27', 'Alamat 27', '27'),
(242, 'Supplier Dummy 28', 'Alamat 28', '28'),
(243, 'Supplier Dummy 29', 'Alamat 29', '29'),
(244, 'Supplier Dummy 30', 'Alamat 30', '30'),
(245, 'Supplier Dummy 31', 'Alamat 31', '31'),
(246, 'Supplier Dummy 32', 'Alamat 32', '32'),
(247, 'Supplier Dummy 33', 'Alamat 33', '33'),
(248, 'Supplier Dummy 34', 'Alamat 34', '34'),
(249, 'Supplier Dummy 35', 'Alamat 35', '35'),
(250, 'Supplier Dummy 36', 'Alamat 36', '36'),
(251, 'Supplier Dummy 37', 'Alamat 37', '37'),
(252, 'Supplier Dummy 38', 'Alamat 38', '38'),
(253, 'Supplier Dummy 39', 'Alamat 39', '39'),
(254, 'Supplier Dummy 40', 'Alamat 40', '40'),
(255, 'Supplier Dummy 41', 'Alamat 41', '41'),
(256, 'Supplier Dummy 42', 'Alamat 42', '42'),
(257, 'Supplier Dummy 43', 'Alamat 43', '43'),
(258, 'Supplier Dummy 44', 'Alamat 44', '44'),
(259, 'Supplier Dummy 45', 'Alamat 45', '45'),
(260, 'Supplier Dummy 46', 'Alamat 46', '46'),
(261, 'Supplier Dummy 47', 'Alamat 47', '47'),
(262, 'Supplier Dummy 48', 'Alamat 48', '48'),
(263, 'Supplier Dummy 49', 'Alamat 49', '49'),
(264, 'Supplier Dummy 50', 'Alamat 50', '50'),
(265, 'Supplier Dummy 51', 'Alamat 51', '51'),
(266, 'Supplier Dummy 52', 'Alamat 52', '52'),
(267, 'Supplier Dummy 53', 'Alamat 53', '53'),
(268, 'Supplier Dummy 54', 'Alamat 54', '54'),
(269, 'Supplier Dummy 55', 'Alamat 55', '55'),
(270, 'Supplier Dummy 56', 'Alamat 56', '56'),
(271, 'Supplier Dummy 57', 'Alamat 57', '57'),
(272, 'Supplier Dummy 58', 'Alamat 58', '58'),
(273, 'Supplier Dummy 59', 'Alamat 59', '59'),
(274, 'Supplier Dummy 60', 'Alamat 60', '60'),
(275, 'Supplier Dummy 61', 'Alamat 61', '61'),
(276, 'Supplier Dummy 62', 'Alamat 62', '62'),
(277, 'Supplier Dummy 63', 'Alamat 63', '63'),
(278, 'Supplier Dummy 64', 'Alamat 64', '64'),
(279, 'Supplier Dummy 65', 'Alamat 65', '65'),
(280, 'Supplier Dummy 66', 'Alamat 66', '66'),
(281, 'Supplier Dummy 67', 'Alamat 67', '67'),
(282, 'Supplier Dummy 68', 'Alamat 68', '68'),
(283, 'Supplier Dummy 69', 'Alamat 69', '69'),
(284, 'Supplier Dummy 70', 'Alamat 70', '70'),
(285, 'Supplier Dummy 71', 'Alamat 71', '71'),
(286, 'Supplier Dummy 72', 'Alamat 72', '72'),
(287, 'Supplier Dummy 73', 'Alamat 73', '73'),
(288, 'Supplier Dummy 74', 'Alamat 74', '74'),
(289, 'Supplier Dummy 75', 'Alamat 75', '75'),
(290, 'Supplier Dummy 76', 'Alamat 76', '76'),
(291, 'Supplier Dummy 77', 'Alamat 77', '77'),
(292, 'Supplier Dummy 78', 'Alamat 78', '78'),
(293, 'Supplier Dummy 79', 'Alamat 79', '79'),
(294, 'Supplier Dummy 80', 'Alamat 80', '80'),
(295, 'Supplier Dummy 81', 'Alamat 81', '81'),
(296, 'Supplier Dummy 82', 'Alamat 82', '82'),
(297, 'Supplier Dummy 83', 'Alamat 83', '83'),
(298, 'Supplier Dummy 84', 'Alamat 84', '84'),
(299, 'Supplier Dummy 85', 'Alamat 85', '85'),
(300, 'Supplier Dummy 86', 'Alamat 86', '86'),
(301, 'Supplier Dummy 87', 'Alamat 87', '87'),
(302, 'Supplier Dummy 88', 'Alamat 88', '88'),
(303, 'Supplier Dummy 89', 'Alamat 89', '89'),
(304, 'Supplier Dummy 90', 'Alamat 90', '90'),
(305, 'Supplier Dummy 91', 'Alamat 91', '91'),
(306, 'Supplier Dummy 92', 'Alamat 92', '92'),
(307, 'Supplier Dummy 93', 'Alamat 93', '93'),
(308, 'Supplier Dummy 94', 'Alamat 94', '94'),
(309, 'Supplier Dummy 95', 'Alamat 95', '95'),
(310, 'Supplier Dummy 96', 'Alamat 96', '96'),
(311, 'Supplier Dummy 97', 'Alamat 97', '97'),
(312, 'Supplier Dummy 98', 'Alamat 98', '98'),
(313, 'Supplier Dummy 99', 'Alamat 99', '99'),
(314, 'Supplier Dummy 100', 'Alamat 100', '100'),
(315, 'daho', 'daho', '12837981237'),
(316, 'indian', 'indian', '9019021921'),
(317, 'indian', 'indian', '9019021921'),
(318, 'idola', '000', '000'),
(319, 'eli sugigi', '1qqq', '09190219'),
(320, '123', '23', '23');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_trans`, `tgl_trans`, `jml_trans`) VALUES
('API-39', '2018-01-01', 88000000),
('API-42', '2018-01-01', 27500000),
('API-48', '2018-01-31', 11000000),
('BYR-17', NULL, 0),
('BYR-18', NULL, 0),
('BYR-19', NULL, 0),
('BYR-20', NULL, 0),
('BYR-21', NULL, 0),
('BYR-22', NULL, 0),
('BYR-23', '2018-01-03', 20000),
('BYR-24', '2018-01-04', 15000),
('BYR-25', '2018-01-07', 12000),
('BYR-26', '2018-01-08', 30000),
('BYR-27', '2018-01-09', 10000),
('BYR-28', '2018-01-11', 25000),
('BYR-29', '2018-01-11', 20000),
('BYR-30', '2018-01-14', 15000),
('BYR-31', '2018-01-16', 25000),
('BYR-32', '2018-01-15', 15000),
('BYR-33', '2018-01-15', 25000),
('BYR-34', '2018-01-16', 50000),
('BYR-35', '2018-01-17', 10000),
('BYR-36', '2018-01-28', 45000),
('PIN-37', NULL, 0),
('PIN-38', '2018-01-01', 80000000),
('PIN-41', '2018-01-01', 25000000),
('PIN-47', '2018-01-31', 20000000),
('PIN-52', '0000-00-00', 0),
('PIN-53', '0000-00-00', 0),
('SIM-1', '2018-01-05', 50000),
('SIM-10', '2018-01-01', 10000),
('SIM-12', '2018-01-01', 50000),
('SIM-13', '2018-01-01', 50000),
('SIM-14', '2018-01-01', 30000),
('SIM-15', '2018-01-01', 30000),
('SIM-2', '2018-01-05', 50000),
('SIM-3', '2018-01-05', 50000),
('SIM-40', '2018-01-01', 50000),
('SIM-43', '2018-01-31', 50000),
('SIM-44', '2018-01-31', 30000),
('SIM-54', NULL, 0),
('SIM-55', NULL, 0),
('SIM-56', NULL, 0),
('SIM-57', '2018-01-04', 50000),
('SIM-58', '2018-01-04', 50000),
('SIM-59', '2018-01-04', 50000),
('SIM-6', '2018-01-01', 50000),
('SIM-60', '2018-01-04', 50000),
('SIM-7', '2018-01-01', 50000),
('SIM-8', '2018-01-01', 25000),
('SIM-9', '2018-01-01', 50000),
('TRK-11', '2018-01-01', 60000),
('TRK-16', '2018-01-01', 25000),
('TRK-45', '2018-01-31', 30000),
('TRK-46', NULL, 0),
('TRK-49', NULL, 0),
('TRK-50', NULL, 0),
('TRK-51', '2018-01-31', 185000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`no_anggota`);

--
-- Indexes for table `angsuran_penj`
--
ALTER TABLE `angsuran_penj`
  ADD PRIMARY KEY (`id_angsurpenj`),
  ADD KEY `fk_id_penjualan` (`id_penjualan`);

--
-- Indexes for table `angsuran_pinj`
--
ALTER TABLE `angsuran_pinj`
  ADD PRIMARY KEY (`id_angsuran`),
  ADD KEY `fk_no_angg3` (`no_anggota`),
  ADD KEY `fk_id_pinjam` (`id_pinjam`);

--
-- Indexes for table `angsuran_pmb`
--
ALTER TABLE `angsuran_pmb`
  ADD PRIMARY KEY (`id_angsuran_pmb`),
  ADD KEY `fk_id_pembelian2` (`id_pembelian`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `beban`
--
ALTER TABLE `beban`
  ADD PRIMARY KEY (`id_beban`);

--
-- Indexes for table `coa`
--
ALTER TABLE `coa`
  ADD PRIMARY KEY (`no_akun`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_barang`,`id_pembelian`),
  ADD KEY `fk_id_barang2` (`id_barang`),
  ADD KEY `fk_id_pembelian` (`id_pembelian`);

--
-- Indexes for table `detail_penarikan`
--
ALTER TABLE `detail_penarikan`
  ADD PRIMARY KEY (`id_penarikan`,`id_jenis`),
  ADD KEY `fk_id_jenis3` (`id_jenis`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_barang`,`id_penjualan`),
  ADD KEY `fk_id_nota2` (`id_penjualan`);

--
-- Indexes for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_trans`,`no_akun`),
  ADD KEY `fk_no_akun` (`no_akun`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indexes for table `nota_penjualan`
--
ALTER TABLE `nota_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `fk_no_anggota` (`no_anggota`),
  ADD KEY `fk_id_kasir` (`id_kasir`);

--
-- Indexes for table `obyek_alokasi`
--
ALTER TABLE `obyek_alokasi`
  ADD PRIMARY KEY (`id_obyek`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_bayar`),
  ADD KEY `fk_no_akun2` (`no_akun`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `fk_id_supplier` (`id_supplier`);

--
-- Indexes for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id_penarikan`),
  ADD KEY `fk_no_angg4` (`no_anggota`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id_pengurus`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `fk_no_angg2` (`no_anggota`);

--
-- Indexes for table `rencana_pembagian`
--
ALTER TABLE `rencana_pembagian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id_simpanan`),
  ADD KEY `fk_no_angg` (`no_anggota`),
  ADD KEY `fk_id_jenis5` (`id_jenis`);

--
-- Indexes for table `simpanan_anggota`
--
ALTER TABLE `simpanan_anggota`
  ADD PRIMARY KEY (`no_anggota`,`id_jenis`),
  ADD KEY `fk_id_jenis4` (`id_jenis`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trans`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `no_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;
--
-- AUTO_INCREMENT for table `beban`
--
ALTER TABLE `beban`
  MODIFY `id_beban` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `obyek_alokasi`
--
ALTER TABLE `obyek_alokasi`
  MODIFY `id_obyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id_pengurus` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `angsuran_penj`
--
ALTER TABLE `angsuran_penj`
  ADD CONSTRAINT `fk_id_angsurpenj` FOREIGN KEY (`id_angsurpenj`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_penjualan3` FOREIGN KEY (`id_penjualan`) REFERENCES `nota_penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `angsuran_pinj`
--
ALTER TABLE `angsuran_pinj`
  ADD CONSTRAINT `fk_id_angsur` FOREIGN KEY (`id_angsuran`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_angsuran` FOREIGN KEY (`id_angsuran`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pinjam` FOREIGN KEY (`id_pinjam`) REFERENCES `pinjaman` (`id_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg3` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `angsuran_pmb`
--
ALTER TABLE `angsuran_pmb`
  ADD CONSTRAINT `fk_id_pembelian2` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_transaksi22` FOREIGN KEY (`id_angsuran_pmb`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `fk_id_barang2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penarikan`
--
ALTER TABLE `detail_penarikan`
  ADD CONSTRAINT `fk_id_jenis3` FOREIGN KEY (`id_jenis`) REFERENCES `simpanan_anggota` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_tarik2` FOREIGN KEY (`id_penarikan`) REFERENCES `penarikan` (`id_penarikan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `fk_id_barang3` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_nota2` FOREIGN KEY (`id_penjualan`) REFERENCES `nota_penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `fk_id_trans` FOREIGN KEY (`id_trans`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_akun` FOREIGN KEY (`no_akun`) REFERENCES `coa` (`no_akun`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nota_penjualan`
--
ALTER TABLE `nota_penjualan`
  ADD CONSTRAINT `fk_id_kasir` FOREIGN KEY (`id_kasir`) REFERENCES `kasir` (`id_kasir`),
  ADD CONSTRAINT `fk_no_anggota` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_id_byr` FOREIGN KEY (`id_bayar`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_id_pemb` FOREIGN KEY (`id_pembelian`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `fk_id_angsuran2` FOREIGN KEY (`id_penarikan`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg4` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `fk_id_pinjam2` FOREIGN KEY (`id_pinjam`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg2` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rencana_pembagian`
--
ALTER TABLE `rencana_pembagian`
  ADD CONSTRAINT `fk_id_obyek1` FOREIGN KEY (`id`) REFERENCES `obyek_alokasi` (`id_obyek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `fk_id_jenis5` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_simpanan` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_simpan` FOREIGN KEY (`id_simpanan`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_anggota5` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simpanan_anggota`
--
ALTER TABLE `simpanan_anggota`
  ADD CONSTRAINT `fk_id_anggota` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_jenis4` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_simpanan` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
