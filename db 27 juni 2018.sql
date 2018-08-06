-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 31 Des 2018 pada 16.59
-- Versi Server: 10.1.25-MariaDB
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
-- Database: `koperasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account`
--

CREATE TABLE `account` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `hak_akses` char(3) DEFAULT NULL COMMENT '1 = ketua , 2 = bendahara , 3 = kasir'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `account`
--

INSERT INTO `account` (`username`, `password`, `hak_akses`) VALUES
('elon_musk', 'spacex', '3'),
('griseldaayu', '123', '2'),
('kasir', '123', '3'),
('ramdhani', '123', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `no_anggota` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `status` char(1) DEFAULT NULL COMMENT '1=pegawai,2=pensiun,3=mutasi,4=keluar',
  `keterangan` int(11) NOT NULL COMMENT '1 = byr SP,0 = blm',
  `tahun_masuk` varchar(4) NOT NULL,
  `bln_masuk` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`no_anggota`, `nama`, `alamat`, `status`, `keterangan`, `tahun_masuk`, `bln_masuk`) VALUES
(0, 'Non Anggota', '', NULL, 0, '', ''),
(9, 'Dhaniel Purwoko', 'Jalan Rawa Pening Paten Jurang RT 5/RW 17, Magelang', '1', 1, '18', '01'),
(10, 'Griselda Ayu', 'Jalan Merak No.21 Bayeman, Magelang', '1', 1, '18', '01'),
(11, 'Ramdhani Lukman', 'Jalan Ciganitri I no.2 Terusan Buah Batu Dayeuhkolot, Kab. Bandung', '3', 1, '18', '01'),
(12, 'Roy Kiosi', 'Jalan Menteng, Magelang', '1', 1, '18', '11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsuran_penj`
--

CREATE TABLE `angsuran_penj` (
  `id_angsurpenj` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `id_penjualan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `angsuran_penj`
--

INSERT INTO `angsuran_penj` (`id_angsurpenj`, `tgl_trans`, `jml_trans`, `id_penjualan`) VALUES
('APJ-1', '2018-01-02', 90000, 'PNJ-1'),
('APJ-10', '2018-04-02', 27000, 'PNJ-8'),
('APJ-11', '2018-04-02', 37500, 'PNJ-9'),
('APJ-12', '2018-04-02', 300000, 'PNJ-10'),
('APJ-13', '2018-05-02', 50000, 'PNJ-10'),
('APJ-14', '2018-05-02', 35000, 'PNJ-11'),
('APJ-15', '2018-05-02', 50000, 'PNJ-12'),
('APJ-16', '2018-05-02', 350000, 'PNJ-13'),
('APJ-17', '2018-06-02', 165000, 'PNJ-14'),
('APJ-18', '2018-06-02', 42500, 'PNJ-12'),
('APJ-19', '2018-07-02', 100000, 'PNJ-15'),
('APJ-2', '2018-01-02', 130000, 'PNJ-2'),
('APJ-20', '2018-07-02', 175000, 'PNJ-16'),
('APJ-21', '2018-07-02', 305000, 'PNJ-17'),
('APJ-22', '2018-08-03', 36000, 'PNJ-18'),
('APJ-23', '2018-08-03', 277500, 'PNJ-19'),
('APJ-24', '2018-09-03', 27000, 'PNJ-20'),
('APJ-25', '2018-09-03', 166500, 'PNJ-21'),
('APJ-26', '2018-10-03', 30000, 'PNJ-22'),
('APJ-27', '2018-11-02', 350000, 'PNJ-23'),
('APJ-28', '2018-11-02', 177500, 'PNJ-24'),
('APJ-29', '2018-11-02', 75000, 'PNJ-25'),
('APJ-3', '2018-01-02', 75000, 'PNJ-3'),
('APJ-30', '2018-11-05', 100000, 'PNJ-24'),
('APJ-4', '2018-02-02', 27000, 'PNJ-4'),
('APJ-5', '2018-02-02', 37500, 'PNJ-5'),
('APJ-6', '2018-02-02', 100000, 'PNJ-6'),
('APJ-7', '2018-02-02', 55000, 'PNJ-2'),
('APJ-8', '2018-03-02', 18500, 'PNJ-7'),
('APJ-9', '2018-03-02', 75000, 'PNJ-6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsuran_pinj`
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
-- Dumping data untuk tabel `angsuran_pinj`
--

INSERT INTO `angsuran_pinj` (`id_angsuran`, `jml_angsur`, `tgl_angsur`, `sisa_pinjaman`, `no_anggota`, `id_pinjam`, `periode`, `tahun`) VALUES
('API-122', 1012000, '2018-11-01', 1000000, 9, 'PIN-85', '10', '2018'),
('API-123', 1012000, '2018-11-01', 0, 9, 'PIN-85', '10', '2018'),
('API-65', 1265000, '2018-04-01', 23750000, 9, 'PIN-54', '2', '2018'),
('API-66', 1265000, '2018-04-01', 22500000, 9, 'PIN-54', '3', '2018'),
('API-67', 1265000, '2018-04-01', 21250000, 9, 'PIN-54', '4', '2018'),
('API-68', 1265000, '2018-04-01', 20000000, 9, 'PIN-54', '5', '2018'),
('API-69', 1265000, '2018-04-01', 18750000, 9, 'PIN-54', '6', '2018'),
('API-70', 1265000, '2018-04-01', 17500000, 9, 'PIN-54', '7', '2018'),
('API-71', 1265000, '2018-04-01', 16250000, 9, 'PIN-54', '8', '2018'),
('API-72', 1265000, '2018-04-01', 15000000, 9, 'PIN-54', '9', '2018'),
('API-73', 1265000, '2018-04-01', 13750000, 9, 'PIN-54', '10', '2018'),
('API-74', 1012000, '2018-04-01', 9000000, 9, 'PIN-64', '5', '2018'),
('API-75', 1012000, '2018-04-01', 8000000, 9, 'PIN-64', '6', '2018'),
('API-76', 1012000, '2018-04-01', 7000000, 9, 'PIN-64', '7', '2018'),
('API-77', 1012000, '2018-04-01', 6000000, 9, 'PIN-64', '8', '2018'),
('API-78', 1012000, '2018-04-01', 5000000, 9, 'PIN-64', '9', '2018'),
('API-79', 1012000, '2018-04-01', 4000000, 9, 'PIN-64', '10', '2018'),
('API-83', 10120000, '2018-05-01', 40000000, 11, 'PIN-81', '6', '2018'),
('API-84', 10120000, '2018-05-01', 30000000, 11, 'PIN-81', '7', '2018'),
('API-86', 1012000, '2018-07-01', 4000000, 9, 'PIN-85', '8', '2018'),
('API-88', 1012000, '2018-07-01', 3000000, 9, 'PIN-85', '9', '2018'),
('API-89', 1012000, '2018-07-01', 2000000, 9, 'PIN-85', '10', '2018');

-- --------------------------------------------------------

--
-- Struktur dari tabel `angsuran_pmb`
--

CREATE TABLE `angsuran_pmb` (
  `id_angsuran_pmb` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_angsuran` int(11) NOT NULL,
  `id_pembelian` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `angsuran_pmb`
--

INSERT INTO `angsuran_pmb` (`id_angsuran_pmb`, `tanggal`, `jumlah_angsuran`, `id_pembelian`) VALUES
('ANG-1', '2018-01-02', 240000, 'PMB-91'),
('ANG-10', '2018-10-03', 18000, 'PMB-100'),
('ANG-11', '2018-11-02', 60000, 'PMB-132'),
('ANG-12', '2018-11-02', 100000, 'PMB-133'),
('ANG-135', '2018-11-05', 160000, 'PMB-133'),
('ANG-2', '2018-02-02', 720000, 'PMB-92'),
('ANG-3', '2018-03-02', 30000, 'PMB-93'),
('ANG-4', '2018-04-02', 146000, 'PMB-94'),
('ANG-5', '2018-05-02', 43000, 'PMB-95'),
('ANG-6', '2018-06-02', 240000, 'PMB-96'),
('ANG-7', '2018-07-02', 240000, 'PMB-97'),
('ANG-8', '2018-08-03', 480000, 'PMB-98'),
('ANG-9', '2018-09-03', 260000, 'PMB-99');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(30) NOT NULL,
  `nama_barang` varchar(30) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `kategori` varchar(3) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_beli`, `harga_jual`, `kategori`, `stok`) VALUES
('8992745560173', 'Tissue', 6000, 9000, 'KSM', 94),
('8992796011341', 'Viva Face tonic', 13000, 18500, 'KSM', 101),
('8993005123015', 'Caladine', 5000, 7500, 'KSM', 75);

-- --------------------------------------------------------

--
-- Struktur dari tabel `coa`
--

CREATE TABLE `coa` (
  `no_akun` char(5) NOT NULL,
  `nama_akun` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `coa`
--

INSERT INTO `coa` (`no_akun`, `nama_akun`) VALUES
('1', 'Aktiva'),
('11', 'Aktiva Lancar'),
('111', 'Kas'),
('112', 'Piutang Anggota'),
('113', 'Piutang Usaha'),
('114', 'Persediaan barang dagang'),
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
('315', 'Cadangan Modal'),
('316', 'SHU'),
('317', 'Jasa Simpanan Pokok dan Wajib'),
('318', 'Jasa Simpanan Mnsk/Hr Raya'),
('319', 'Jasa Peminjam'),
('320', 'Dana Pengurus dan Pengawas'),
('321', 'Dana Pendidikan'),
('322', 'Dana Sosial'),
('323', 'Dana Cadangan/Tujuan Resiko'),
('324', 'Cadangan Modal Toko'),
('325', 'Dana Anggota/Konsumen'),
('326', 'Dana Karyawan'),
('4', 'Pendapatan'),
('41', 'Penjualan'),
('411', 'Penjualan'),
('42', 'Pendapatan Bunga'),
('421', 'Pendapatan Bunga'),
('5', 'Pembelian'),
('511', 'Pembelian'),
('6', 'Beban'),
('61', 'Beban Operasional USP'),
('611', 'Hr Karyawan'),
('612', 'Transport Pembantu Pengurus'),
('613', 'Transport Pengurus'),
('614', 'Transport Pengawas'),
('615', 'Transport Penasehat'),
('616', 'Beban ATK'),
('617', 'Beban Promosi'),
('62', 'Beban Non-Operasional'),
('621', 'Beban Rapat Pengurus dan BP'),
('622', 'Beban Kebersihan'),
('623', 'Beban Transport'),
('624', 'Beban Denda Pajak'),
('625', 'Beban RAT'),
('626', 'Beban Penyusutan'),
('627', 'Beban Pembinaan'),
('63', 'Beban Operasional Toko'),
('631', 'Beban Belanja Toko'),
('632', 'Beban HUT'),
('633', 'Beban Penyusutan Aktiva Tetap'),
('634', 'Beban Kantor/ATK'),
('635', 'Cadangan Dana Pensiun'),
('641', 'Beban Pajak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `id_barang` varchar(30) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_pembelian`, `id_barang`, `jumlah`, `subtotal`) VALUES
('PMB-100', '8992745560173', 3, 18000),
('PMB-132', '8992745560173', 10, 60000),
('PMB-91', '8992745560173', 10, 60000),
('PMB-92', '8992745560173', 30, 180000),
('PMB-93', '8992745560173', 5, 30000),
('PMB-94', '8992745560173', 3, 18000),
('PMB-95', '8992745560173', 3, 18000),
('PMB-96', '8992745560173', 10, 60000),
('PMB-97', '8992745560173', 10, 60000),
('PMB-98', '8992745560173', 20, 120000),
('PMB-133', '8992796011341', 20, 260000),
('PMB-91', '8992796011341', 10, 130000),
('PMB-92', '8992796011341', 30, 390000),
('PMB-94', '8992796011341', 6, 78000),
('PMB-96', '8992796011341', 10, 130000),
('PMB-97', '8992796011341', 10, 130000),
('PMB-98', '8992796011341', 20, 260000),
('PMB-99', '8992796011341', 20, 260000),
('PMB-91', '8993005123015', 10, 50000),
('PMB-92', '8993005123015', 30, 150000),
('PMB-94', '8993005123015', 10, 50000),
('PMB-95', '8993005123015', 5, 25000),
('PMB-96', '8993005123015', 10, 50000),
('PMB-97', '8993005123015', 10, 50000),
('PMB-98', '8993005123015', 20, 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penarikan`
--

CREATE TABLE `detail_penarikan` (
  `id_penarikan` varchar(10) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_penarikan`
--

INSERT INTO `detail_penarikan` (`id_penarikan`, `id_jenis`, `subtotal`) VALUES
('TRK-126', 3, 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` varchar(10) NOT NULL,
  `id_barang` varchar(30) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_penjualan`, `id_barang`, `jumlah`, `subtotal`) VALUES
('PNJ-1', '8992745560173', 10, 90000),
('PNJ-10', '8992745560173', 10, 90000),
('PNJ-11', '8992745560173', 1, 9000),
('PNJ-13', '8992745560173', 10, 90000),
('PNJ-14', '8992745560173', 10, 90000),
('PNJ-15', '8992745560173', 5, 45000),
('PNJ-16', '8992745560173', 5, 45000),
('PNJ-17', '8992745560173', 5, 45000),
('PNJ-18', '8992745560173', 4, 36000),
('PNJ-20', '8992745560173', 3, 27000),
('PNJ-23', '8992745560173', 10, 90000),
('PNJ-4', '8992745560173', 3, 27000),
('PNJ-6', '8992745560173', 5, 45000),
('PNJ-8', '8992745560173', 3, 27000),
('PNJ-10', '8992796011341', 10, 185000),
('PNJ-11', '8992796011341', 1, 18500),
('PNJ-12', '8992796011341', 5, 92500),
('PNJ-13', '8992796011341', 10, 185000),
('PNJ-15', '8992796011341', 5, 92500),
('PNJ-16', '8992796011341', 5, 92500),
('PNJ-17', '8992796011341', 10, 185000),
('PNJ-19', '8992796011341', 15, 277500),
('PNJ-2', '8992796011341', 10, 185000),
('PNJ-21', '8992796011341', 9, 166500),
('PNJ-23', '8992796011341', 10, 185000),
('PNJ-24', '8992796011341', 15, 277500),
('PNJ-6', '8992796011341', 5, 92500),
('PNJ-7', '8992796011341', 1, 18500),
('PNJ-10', '8993005123015', 10, 75000),
('PNJ-11', '8993005123015', 1, 7500),
('PNJ-13', '8993005123015', 10, 75000),
('PNJ-14', '8993005123015', 10, 75000),
('PNJ-16', '8993005123015', 5, 37500),
('PNJ-17', '8993005123015', 10, 75000),
('PNJ-22', '8993005123015', 4, 30000),
('PNJ-23', '8993005123015', 10, 75000),
('PNJ-25', '8993005123015', 10, 75000),
('PNJ-3', '8993005123015', 10, 75000),
('PNJ-5', '8993005123015', 5, 37500),
('PNJ-6', '8993005123015', 5, 37500),
('PNJ-9', '8993005123015', 5, 37500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `id_jenis` int(11) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `kategori` varchar(30) DEFAULT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`id_jenis`, `keterangan`, `kategori`, `tarif`) VALUES
(1, 'Simpanan Pokok', '1', 50000),
(2, 'Simpanan Wajib', '1', 50000),
(3, 'Simpanan Manasuka', '2', 0),
(4, 'Simpanan Pendidikan', '2', 0),
(5, 'Simpanan Hari Raya', '2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `no_akun` char(5) NOT NULL,
  `posisi_dr_cr` varchar(6) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_trans` varchar(10) NOT NULL,
  `tipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id_jurnal`, `no_akun`, `posisi_dr_cr`, `nominal`, `id_trans`, `tipe`) VALUES
(1, '111', 'd', 100000000, 'MDL-1', 0),
(2, '314', 'k', 100000000, 'MDL-1', 0),
(29, '111', 'd', 50000, 'SIM-6', 0),
(30, '311', 'k', 50000, 'SIM-6', 0),
(31, '111', 'd', 50000, 'SIM-7', 0),
(32, '311', 'k', 50000, 'SIM-7', 0),
(35, '111', 'd', 50000, 'SIM-9', 0),
(36, '312', 'k', 50000, 'SIM-9', 0),
(37, '111', 'd', 50000, 'SIM-10', 0),
(38, '312', 'k', 50000, 'SIM-10', 0),
(39, '111', 'd', 50000, 'SIM-11', 0),
(40, '312', 'k', 50000, 'SIM-11', 0),
(41, '111', 'd', 50000, 'SIM-12', 0),
(42, '312', 'k', 50000, 'SIM-12', 0),
(43, '111', 'd', 50000, 'SIM-13', 0),
(44, '312', 'k', 50000, 'SIM-13', 0),
(45, '111', 'd', 50000, 'SIM-14', 0),
(46, '312', 'k', 50000, 'SIM-14', 0),
(47, '111', 'd', 50000, 'SIM-15', 0),
(48, '312', 'k', 50000, 'SIM-15', 0),
(49, '111', 'd', 50000, 'SIM-16', 0),
(50, '312', 'k', 50000, 'SIM-16', 0),
(51, '111', 'd', 50000, 'SIM-17', 0),
(52, '312', 'k', 50000, 'SIM-17', 0),
(53, '111', 'd', 50000, 'SIM-18', 0),
(54, '312', 'k', 50000, 'SIM-18', 0),
(55, '111', 'd', 50000, 'SIM-19', 0),
(56, '311', 'k', 50000, 'SIM-19', 0),
(57, '111', 'd', 50000, 'SIM-20', 0),
(58, '312', 'k', 50000, 'SIM-20', 0),
(59, '111', 'd', 50000, 'SIM-21', 0),
(60, '312', 'k', 50000, 'SIM-21', 0),
(61, '111', 'd', 50000, 'SIM-22', 0),
(62, '312', 'k', 50000, 'SIM-22', 0),
(63, '111', 'd', 50000, 'SIM-23', 0),
(64, '312', 'k', 50000, 'SIM-23', 0),
(65, '111', 'd', 50000, 'SIM-24', 0),
(66, '312', 'k', 50000, 'SIM-24', 0),
(67, '111', 'd', 50000, 'SIM-25', 0),
(68, '312', 'k', 50000, 'SIM-25', 0),
(69, '111', 'd', 50000, 'SIM-26', 0),
(70, '312', 'k', 50000, 'SIM-26', 0),
(71, '111', 'd', 50000, 'SIM-27', 0),
(72, '312', 'k', 50000, 'SIM-27', 0),
(73, '111', 'd', 50000, 'SIM-28', 0),
(74, '312', 'k', 50000, 'SIM-28', 0),
(75, '111', 'd', 50000, 'SIM-29', 0),
(76, '312', 'k', 50000, 'SIM-29', 0),
(78, '111', 'd', 50000, 'SIM-30', 0),
(79, '312', 'k', 50000, 'SIM-30', 0),
(80, '111', 'd', 50000, 'SIM-31', 0),
(81, '312', 'k', 50000, 'SIM-31', 0),
(82, '111', 'd', 50000, 'SIM-32', 0),
(83, '312', 'k', 50000, 'SIM-32', 0),
(84, '111', 'd', 50000, 'SIM-33', 0),
(85, '312', 'k', 50000, 'SIM-33', 0),
(86, '111', 'd', 35000, 'SIM-34', 0),
(87, '213', 'k', 35000, 'SIM-34', 0),
(88, '111', 'd', 35000, 'SIM-35', 0),
(89, '213', 'k', 35000, 'SIM-35', 0),
(90, '111', 'd', 35000, 'SIM-36', 0),
(91, '213', 'k', 35000, 'SIM-36', 0),
(92, '111', 'd', 35000, 'SIM-37', 0),
(93, '213', 'k', 35000, 'SIM-37', 0),
(94, '111', 'd', 35000, 'SIM-38', 0),
(95, '213', 'k', 35000, 'SIM-38', 0),
(96, '111', 'd', 35000, 'SIM-39', 0),
(97, '213', 'k', 35000, 'SIM-39', 0),
(98, '111', 'd', 35000, 'SIM-40', 0),
(99, '213', 'k', 35000, 'SIM-40', 0),
(100, '111', 'd', 35000, 'SIM-41', 0),
(101, '213', 'k', 35000, 'SIM-41', 0),
(102, '111', 'd', 35000, 'SIM-42', 0),
(103, '213', 'k', 35000, 'SIM-42', 0),
(104, '111', 'd', 35000, 'SIM-43', 0),
(105, '213', 'k', 35000, 'SIM-43', 0),
(106, '111', 'd', 15000, 'SIM-44', 0),
(107, '212', 'k', 15000, 'SIM-44', 0),
(108, '111', 'd', 15000, 'SIM-45', 0),
(109, '212', 'k', 15000, 'SIM-45', 0),
(110, '111', 'd', 15000, 'SIM-46', 0),
(111, '212', 'k', 15000, 'SIM-46', 0),
(112, '111', 'd', 15000, 'SIM-47', 0),
(113, '212', 'k', 15000, 'SIM-47', 0),
(114, '111', 'd', 15000, 'SIM-48', 0),
(115, '212', 'k', 15000, 'SIM-48', 0),
(116, '111', 'd', 15000, 'SIM-49', 0),
(117, '212', 'k', 15000, 'SIM-49', 0),
(118, '111', 'd', 15000, 'SIM-50', 0),
(119, '212', 'k', 15000, 'SIM-50', 0),
(120, '111', 'd', 15000, 'SIM-51', 0),
(121, '212', 'k', 15000, 'SIM-51', 0),
(122, '111', 'd', 15000, 'SIM-52', 0),
(123, '212', 'k', 15000, 'SIM-52', 0),
(124, '111', 'd', 15000, 'SIM-53', 0),
(125, '212', 'k', 15000, 'SIM-53', 0),
(126, '112', 'd', 25000000, 'PIN-54', 0),
(127, '111', 'k', 25000000, 'PIN-54', 0),
(155, '112', 'd', 10000000, 'PIN-64', 0),
(156, '111', 'k', 10000000, 'PIN-64', 0),
(163, '111', 'd', 1265000, 'API-65', 0),
(164, '112', 'k', 1250000, 'API-65', 0),
(165, '421', 'k', 15000, 'API-65', 0),
(169, '111', 'd', 1265000, 'API-66', 0),
(170, '112', 'k', 1250000, 'API-66', 0),
(171, '421', 'k', 15000, 'API-66', 0),
(172, '111', 'd', 1265000, 'API-67', 0),
(173, '112', 'k', 1250000, 'API-67', 0),
(174, '421', 'k', 15000, 'API-67', 0),
(175, '111', 'd', 1265000, 'API-68', 0),
(176, '112', 'k', 1250000, 'API-68', 0),
(177, '421', 'k', 15000, 'API-68', 0),
(178, '111', 'd', 1265000, 'API-69', 0),
(179, '112', 'k', 1250000, 'API-69', 0),
(180, '421', 'k', 15000, 'API-69', 0),
(181, '111', 'd', 1265000, 'API-70', 0),
(182, '112', 'k', 1250000, 'API-70', 0),
(183, '421', 'k', 15000, 'API-70', 0),
(184, '111', 'd', 1265000, 'API-71', 0),
(185, '112', 'k', 1250000, 'API-71', 0),
(186, '421', 'k', 15000, 'API-71', 0),
(187, '111', 'd', 1265000, 'API-72', 0),
(188, '112', 'k', 1250000, 'API-72', 0),
(189, '421', 'k', 15000, 'API-72', 0),
(190, '111', 'd', 1265000, 'API-73', 0),
(191, '112', 'k', 1250000, 'API-73', 0),
(192, '421', 'k', 15000, 'API-73', 0),
(193, '111', 'd', 1012000, 'API-74', 0),
(194, '112', 'k', 1000000, 'API-74', 0),
(195, '421', 'k', 12000, 'API-74', 0),
(196, '111', 'd', 1012000, 'API-75', 0),
(197, '112', 'k', 1000000, 'API-75', 0),
(198, '421', 'k', 12000, 'API-75', 0),
(199, '111', 'd', 1012000, 'API-76', 0),
(200, '112', 'k', 1000000, 'API-76', 0),
(201, '421', 'k', 12000, 'API-76', 0),
(202, '111', 'd', 1012000, 'API-77', 0),
(203, '112', 'k', 1000000, 'API-77', 0),
(204, '421', 'k', 12000, 'API-77', 0),
(205, '111', 'd', 1012000, 'API-78', 0),
(206, '112', 'k', 1000000, 'API-78', 0),
(207, '421', 'k', 12000, 'API-78', 0),
(208, '111', 'd', 1012000, 'API-79', 0),
(209, '112', 'k', 1000000, 'API-79', 0),
(210, '421', 'k', 12000, 'API-79', 0),
(219, '112', 'd', 50000000, 'PIN-81', 0),
(220, '111', 'k', 50000000, 'PIN-81', 0),
(221, '111', 'd', 10120000, 'API-83', 0),
(222, '112', 'k', 10000000, 'API-83', 0),
(223, '421', 'k', 120000, 'API-83', 0),
(224, '111', 'd', 10120000, 'API-84', 0),
(225, '112', 'k', 10000000, 'API-84', 0),
(226, '421', 'k', 120000, 'API-84', 0),
(227, '112', 'd', 5000000, 'PIN-85', 0),
(228, '111', 'k', 5000000, 'PIN-85', 0),
(229, '111', 'd', 1012000, 'API-86', 0),
(230, '112', 'k', 1000000, 'API-86', 0),
(231, '421', 'k', 12000, 'API-86', 0),
(232, '111', 'd', 1012000, 'API-88', 0),
(233, '112', 'k', 1000000, 'API-88', 0),
(234, '421', 'k', 12000, 'API-88', 0),
(235, '111', 'd', 1012000, 'API-89', 0),
(236, '112', 'k', 1000000, 'API-89', 0),
(237, '421', 'k', 12000, 'API-89', 0),
(335, '511', 'd', 240000, 'PMB-91', 0),
(336, '111', 'k', 240000, 'PMB-91', 0),
(337, '111', 'd', 90000, 'PNJ-1', 0),
(338, '411', 'k', 90000, 'PNJ-1', 0),
(339, '113', 'd', 55000, 'PNJ-2', 0),
(340, '111', 'd', 130000, 'PNJ-2', 0),
(341, '411', 'k', 185000, 'PNJ-2', 0),
(342, '111', 'd', 75000, 'PNJ-3', 0),
(343, '411', 'k', 75000, 'PNJ-3', 0),
(344, '511', 'd', 720000, 'PMB-92', 0),
(345, '111', 'k', 720000, 'PMB-92', 0),
(346, '111', 'd', 27000, 'PNJ-4', 0),
(347, '411', 'k', 27000, 'PNJ-4', 0),
(348, '111', 'd', 37500, 'PNJ-5', 0),
(349, '411', 'k', 37500, 'PNJ-5', 0),
(350, '113', 'd', 75000, 'PNJ-6', 0),
(351, '111', 'd', 100000, 'PNJ-6', 0),
(352, '411', 'k', 175000, 'PNJ-6', 0),
(353, '111', 'd', 55000, 'APJ-7', 0),
(354, '113', 'k', 55000, 'APJ-7', 0),
(355, '511', 'd', 30000, 'PMB-93', 0),
(356, '111', 'k', 30000, 'PMB-93', 0),
(357, '111', 'd', 18500, 'PNJ-7', 0),
(358, '411', 'k', 18500, 'PNJ-7', 0),
(359, '111', 'd', 75000, 'APJ-9', 0),
(360, '113', 'k', 75000, 'APJ-9', 0),
(361, '511', 'd', 146000, 'PMB-94', 0),
(362, '111', 'k', 146000, 'PMB-94', 0),
(363, '111', 'd', 27000, 'PNJ-8', 0),
(364, '411', 'k', 27000, 'PNJ-8', 0),
(365, '111', 'd', 37500, 'PNJ-9', 0),
(366, '411', 'k', 37500, 'PNJ-9', 0),
(367, '113', 'd', 50000, 'PNJ-10', 0),
(368, '111', 'd', 300000, 'PNJ-10', 0),
(369, '411', 'k', 350000, 'PNJ-10', 0),
(370, '511', 'd', 43000, 'PMB-95', 0),
(371, '111', 'k', 43000, 'PMB-95', 0),
(372, '111', 'd', 50000, 'APJ-13', 0),
(373, '113', 'k', 50000, 'APJ-13', 0),
(374, '111', 'd', 35000, 'PNJ-11', 0),
(375, '411', 'k', 35000, 'PNJ-11', 0),
(376, '113', 'd', 42500, 'PNJ-12', 0),
(377, '111', 'd', 50000, 'PNJ-12', 0),
(378, '411', 'k', 92500, 'PNJ-12', 0),
(379, '111', 'd', 350000, 'PNJ-13', 0),
(380, '411', 'k', 350000, 'PNJ-13', 0),
(381, '511', 'd', 240000, 'PMB-96', 0),
(382, '111', 'k', 240000, 'PMB-96', 0),
(383, '111', 'd', 165000, 'PNJ-14', 0),
(384, '411', 'k', 165000, 'PNJ-14', 0),
(385, '111', 'd', 42500, 'APJ-18', 0),
(386, '113', 'k', 42500, 'APJ-18', 0),
(387, '511', 'd', 240000, 'PMB-97', 0),
(388, '111', 'k', 240000, 'PMB-97', 0),
(389, '113', 'd', 37500, 'PNJ-15', 0),
(390, '111', 'd', 100000, 'PNJ-15', 0),
(391, '411', 'k', 137500, 'PNJ-15', 0),
(392, '111', 'd', 175000, 'PNJ-16', 0),
(393, '411', 'k', 175000, 'PNJ-16', 0),
(394, '111', 'd', 305000, 'PNJ-17', 0),
(395, '411', 'k', 305000, 'PNJ-17', 0),
(396, '511', 'd', 480000, 'PMB-98', 0),
(397, '111', 'k', 480000, 'PMB-98', 0),
(398, '111', 'd', 36000, 'PNJ-18', 0),
(399, '411', 'k', 36000, 'PNJ-18', 0),
(400, '111', 'd', 277500, 'PNJ-19', 0),
(401, '411', 'k', 277500, 'PNJ-19', 0),
(402, '511', 'd', 260000, 'PMB-99', 0),
(403, '111', 'k', 260000, 'PMB-99', 0),
(404, '111', 'd', 27000, 'PNJ-20', 0),
(405, '411', 'k', 27000, 'PNJ-20', 0),
(406, '111', 'd', 166500, 'PNJ-21', 0),
(407, '411', 'k', 166500, 'PNJ-21', 0),
(408, '511', 'd', 18000, 'PMB-100', 0),
(409, '111', 'k', 18000, 'PMB-100', 0),
(410, '111', 'd', 30000, 'PNJ-22', 0),
(411, '411', 'k', 30000, 'PNJ-22', 0),
(412, '111', 'd', 50000, 'SIM-116', 0),
(413, '311', 'k', 50000, 'SIM-116', 0),
(414, '112', 'd', 2000000, 'PIN-117', 0),
(415, '111', 'k', 2000000, 'PIN-117', 0),
(416, '111', 'd', 50000, 'SIM-118', 0),
(417, '312', 'k', 50000, 'SIM-118', 0),
(418, '111', 'd', 50000, 'SIM-119', 0),
(419, '312', 'k', 50000, 'SIM-119', 0),
(420, '111', 'd', 1012000, 'API-122', 0),
(421, '112', 'k', 1000000, 'API-122', 0),
(422, '421', 'k', 12000, 'API-122', 0),
(423, '111', 'd', 1012000, 'API-123', 0),
(424, '112', 'k', 1000000, 'API-123', 0),
(425, '421', 'k', 12000, 'API-123', 0),
(426, '112', 'd', 5000000, 'PIN-124', 0),
(427, '111', 'k', 5000000, 'PIN-124', 0),
(428, '212', 'd', 150000, 'TRK-126', 0),
(429, '111', 'k', 150000, 'TRK-126', 0),
(430, '111', 'd', 50000, 'SIM-127', 0),
(431, '312', 'k', 50000, 'SIM-127', 0),
(432, '111', 'd', 50000, 'SIM-128', 0),
(433, '312', 'k', 50000, 'SIM-128', 0),
(434, '111', 'd', 50000, 'SIM-129', 0),
(435, '312', 'k', 50000, 'SIM-129', 0),
(436, '111', 'd', 25000, 'SIM-131', 0),
(437, '214', 'k', 25000, 'SIM-131', 0),
(438, '511', 'd', 60000, 'PMB-132', 0),
(439, '111', 'k', 60000, 'PMB-132', 0),
(440, '511', 'd', 260000, 'PMB-133', 0),
(441, '211', 'k', 160000, 'PMB-133', 0),
(442, '111', 'k', 100000, 'PMB-133', 0),
(443, '111', 'd', 350000, 'PNJ-23', 0),
(444, '411', 'k', 350000, 'PNJ-23', 0),
(445, '113', 'd', 100000, 'PNJ-24', 0),
(446, '111', 'd', 177500, 'PNJ-24', 0),
(447, '411', 'k', 277500, 'PNJ-24', 0),
(448, '111', 'd', 75000, 'PNJ-25', 0),
(449, '411', 'k', 75000, 'PNJ-25', 0),
(450, '211', 'd', 160000, 'ANG-135', 0),
(451, '111', 'k', 160000, 'ANG-135', 0),
(452, '111', 'd', 100000, 'APJ-30', 0),
(453, '113', 'k', 100000, 'APJ-30', 0),
(454, '616', 'd', 50000, 'BYR-136', 0),
(455, '111', 'k', 50000, 'BYR-136', 0),
(456, '617', 'd', 100000, 'BYR-137', 0),
(457, '111', 'k', 100000, 'BYR-137', 0),
(458, '622', 'd', 25000, 'BYR-138', 0),
(459, '111', 'k', 25000, 'BYR-138', 0),
(460, '631', 'd', 10000, 'BYR-139', 0),
(461, '111', 'k', 10000, 'BYR-139', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `nama_kasir` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota_penjualan`
--

CREATE TABLE `nota_penjualan` (
  `id_penjualan` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL,
  `id_kasir` int(11) DEFAULT NULL,
  `keuntungan` int(11) NOT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nota_penjualan`
--

INSERT INTO `nota_penjualan` (`id_penjualan`, `tgl_trans`, `jml_trans`, `no_anggota`, `id_kasir`, `keuntungan`, `status`) VALUES
('PNJ-1', '2018-01-02', 90000, 9, NULL, 30000, '1'),
('PNJ-10', '2018-04-02', 350000, 11, NULL, 110000, '1'),
('PNJ-11', '2018-05-02', 35000, 9, NULL, 11000, '1'),
('PNJ-12', '2018-05-02', 92500, 10, NULL, 27500, '1'),
('PNJ-13', '2018-05-02', 350000, 11, NULL, 110000, '1'),
('PNJ-14', '2018-06-02', 165000, 11, NULL, 55000, '1'),
('PNJ-15', '2018-07-02', 137500, NULL, NULL, 42500, '1'),
('PNJ-16', '2018-07-02', 175000, 10, NULL, 55000, '1'),
('PNJ-17', '2018-07-02', 305000, 11, NULL, 95000, '1'),
('PNJ-18', '2018-08-03', 36000, 9, NULL, 12000, '1'),
('PNJ-19', '2018-08-03', 277500, 11, NULL, 82500, '1'),
('PNJ-2', '2018-01-02', 185000, 10, NULL, 55000, '1'),
('PNJ-20', '2018-09-03', 27000, 10, NULL, 9000, '1'),
('PNJ-21', '2018-09-03', 166500, 11, NULL, 49500, '1'),
('PNJ-22', '2018-10-03', 30000, 11, NULL, 10000, '1'),
('PNJ-23', '2018-11-02', 350000, 11, NULL, 110000, '1'),
('PNJ-24', '2018-11-02', 277500, 10, NULL, 82500, '1'),
('PNJ-25', '2018-11-02', 75000, 0, NULL, 25000, '1'),
('PNJ-3', '2018-01-02', 75000, 11, NULL, 25000, '1'),
('PNJ-4', '2018-02-02', 27000, 9, NULL, 9000, '1'),
('PNJ-5', '2018-02-02', 37500, 10, NULL, 12500, '1'),
('PNJ-6', '2018-02-02', 175000, 11, NULL, 55000, '1'),
('PNJ-7', '2018-03-02', 18500, 11, NULL, 5500, '1'),
('PNJ-8', '2018-04-02', 27000, 9, NULL, 9000, '1'),
('PNJ-9', '2018-04-02', 37500, 10, NULL, 12500, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obyek_alokasi`
--

CREATE TABLE `obyek_alokasi` (
  `id_obyek` int(11) NOT NULL,
  `nama_obyek` varchar(50) DEFAULT NULL,
  `prosentase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `obyek_alokasi`
--

INSERT INTO `obyek_alokasi` (`id_obyek`, `nama_obyek`, `prosentase`) VALUES
(4, 'Cadangan Modal', 7),
(5, 'Jasa Simpanan Pokok dan Wajib', 25),
(6, 'Jasa Simpanan Manasuka/Hari Raya', 23),
(7, 'Jasa Peminjam', 23),
(8, 'Dana Pengurus', 10),
(9, 'Dana Pendidikan', 4),
(10, 'Dana Sosial', 7),
(11, 'Dana Cadangan/Tujuan Resiko', 1),
(12, 'Cadangan Modal Toko', 15),
(13, 'Dana Anggota/Konsumen', 40),
(14, 'Dana Pengurus dan Pengawas', 10),
(15, 'Dana Karyawan', 10),
(16, 'Dana Pendidikan', 6),
(17, 'Dana Sosial', 9),
(18, 'Cadangan Resiko', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_bayar` varchar(10) NOT NULL,
  `no_bukti` varchar(30) NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int(11) DEFAULT NULL,
  `no_akun` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_bayar`, `no_bukti`, `tgl_bayar`, `jml_bayar`, `no_akun`) VALUES
('BYR-136', 'DD/TT/AA/12/27/2018', '2018-11-27', 50000, '616'),
('BYR-137', 'QQWWAA', '2018-11-27', 100000, '617'),
('BYR-138', 'DD/TT/AA/12/27/2018', '2018-11-27', 25000, '622'),
('BYR-139', 'DD/TT/AA/12/27/2018', '2018-06-01', 10000, '631');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `tgl_trans`, `jml_trans`, `id_supplier`, `status`) VALUES
('PMB-100', '2018-10-03', 18000, 43, '1'),
('PMB-132', '2018-11-02', 60000, 35, '1'),
('PMB-133', '2018-11-02', 260000, 43, '1'),
('PMB-134', NULL, NULL, NULL, '0'),
('PMB-91', '2018-01-02', 240000, 35, '1'),
('PMB-92', '2018-02-02', 720000, 44, '1'),
('PMB-93', '2018-03-02', 30000, 35, '1'),
('PMB-94', '2018-04-02', 146000, 35, '1'),
('PMB-95', '2018-05-02', 43000, 35, '1'),
('PMB-96', '2018-06-02', 240000, 35, '1'),
('PMB-97', '2018-07-02', 240000, 35, '1'),
('PMB-98', '2018-08-03', 480000, 35, '1'),
('PMB-99', '2018-09-03', 260000, 35, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan`
--

CREATE TABLE `penarikan` (
  `id_penarikan` varchar(10) NOT NULL,
  `jml_penarikan` int(11) DEFAULT NULL,
  `tgl_penarikan` date DEFAULT NULL,
  `no_anggota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penarikan`
--

INSERT INTO `penarikan` (`id_penarikan`, `jml_penarikan`, `tgl_penarikan`, `no_anggota`) VALUES
('TRK-108', NULL, NULL, NULL),
('TRK-113', NULL, NULL, NULL),
('TRK-125', NULL, NULL, NULL),
('TRK-126', 150000, '2018-11-02', 10),
('TRK-130', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengurus`
--

CREATE TABLE `pengurus` (
  `id_pengurus` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `username` varchar(15) DEFAULT NULL,
  `fp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengurus`
--

INSERT INTO `pengurus` (`id_pengurus`, `nama`, `alamat`, `username`, `fp`) VALUES
(1, 'Ramdhani Lukmans', 'Jalan Raya Jatinangor no.66', 'ramdhani', 'ramdhani_1804211146.png'),
(4, 'Griselda Ayu Ratnadewati', 'Paten Jurang', 'griseldaayu', 'griseldaayu_18052907361.jpg'),
(6, 'kasir', 'cibeusi', 'kasir', 'kasir_1805290734.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
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
-- Dumping data untuk tabel `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjam`, `jml_pinjam`, `tgl_pengajuan`, `tgl_pencairan`, `banyak_angsuran`, `tarif_bunga`, `tarif_angsur`, `jatuh_tempo`, `status`, `no_anggota`) VALUES
('PIN-117', 2000000, '2018-11-01', '2018-11-01', 1, 1, 2024000, '2018-12-01', '2', 12),
('PIN-120', NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL),
('PIN-121', NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL),
('PIN-124', 5000000, '2018-11-01', '2018-11-01', 1, 1, 5060000, '2018-12-01', '2', 9),
('PIN-54', 25000000, '2018-01-01', '2018-01-01', 20, 1, 1265000, '2019-09-01', '2', 9),
('PIN-64', 10000000, '2018-04-01', '2018-04-01', 10, 1, 1012000, '2019-02-01', '2', 9),
('PIN-81', 50000000, '2018-05-01', '2018-05-01', 5, 1, 10120000, '2018-10-01', '2', 11),
('PIN-85', 5000000, '2018-07-01', '2018-07-01', 5, 1, 1012000, '2018-12-01', '3', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rencana_pembagian`
--

CREATE TABLE `rencana_pembagian` (
  `id` int(11) NOT NULL,
  `periode` char(4) DEFAULT NULL,
  `hasil_pembagian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rencana_pembagian`
--

INSERT INTO `rencana_pembagian` (`id`, `periode`, `hasil_pembagian`) VALUES
(4, '2018', 23008),
(5, '2018', 82170),
(6, '2018', 75596),
(7, '2018', 75596),
(8, '2018', 32868),
(9, '2018', 13147),
(10, '2018', 23008),
(11, '2018', 3287),
(12, '2018', 115088),
(13, '2018', 306900),
(14, '2018', 76725),
(15, '2018', 76725),
(16, '2018', 46035),
(17, '2018', 69053),
(18, '2018', 76725);

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan`
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
-- Dumping data untuk tabel `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `jml_simpanan`, `tgl_simpan`, `no_anggota`, `id_jenis`, `periode`, `tahun`) VALUES
('SIM-10', 50000, '2018-01-01', 9, 2, '2', '2018'),
('SIM-11', 50000, '2018-01-01', 9, 2, '3', '2018'),
('SIM-114', NULL, NULL, NULL, 1, '', ''),
('SIM-115', NULL, NULL, NULL, 1, '', ''),
('SIM-116', 50000, '2018-11-01', 12, 1, '11', '2018'),
('SIM-118', 50000, '2018-11-01', 9, 2, '10', '2018'),
('SIM-119', 50000, '2018-11-01', 10, 2, '10', '2018'),
('SIM-12', 50000, '2018-01-01', 9, 2, '4', '2018'),
('SIM-127', 50000, '2018-11-02', 11, 2, '5', '2018'),
('SIM-128', 50000, '2018-11-02', 11, 2, '6', '2018'),
('SIM-129', 50000, '2018-11-02', 11, 2, '7', '2018'),
('SIM-13', 50000, '2018-01-01', 9, 2, '5', '2018'),
('SIM-131', 25000, '2018-11-02', 12, 5, '11', '2018'),
('SIM-14', 50000, '2018-01-01', 9, 2, '6', '2018'),
('SIM-141', NULL, NULL, NULL, 1, '', ''),
('SIM-143', NULL, NULL, NULL, 1, '', ''),
('SIM-15', 50000, '2018-01-01', 9, 2, '7', '2018'),
('SIM-16', 50000, '2018-01-01', 9, 2, '8', '2018'),
('SIM-17', 50000, '2018-01-01', 9, 2, '9', '2018'),
('SIM-18', 50000, '2018-01-01', 9, 2, '10', '2018'),
('SIM-19', 50000, '2018-01-01', 11, 1, '1', '2018'),
('SIM-20', 50000, '2018-01-01', 10, 2, '1', '2018'),
('SIM-21', 50000, '2018-01-01', 10, 2, '2', '2018'),
('SIM-22', 50000, '2018-01-01', 10, 2, '3', '2018'),
('SIM-23', 50000, '2018-01-01', 10, 2, '4', '2018'),
('SIM-24', 50000, '2018-01-01', 10, 2, '5', '2018'),
('SIM-25', 50000, '2018-01-01', 10, 2, '6', '2018'),
('SIM-26', 50000, '2018-01-01', 10, 2, '7', '2018'),
('SIM-27', 50000, '2018-01-01', 10, 2, '8', '2018'),
('SIM-28', 50000, '2018-01-01', 10, 2, '9', '2018'),
('SIM-29', 50000, '2018-01-01', 10, 2, '10', '2018'),
('SIM-30', 50000, '2018-01-01', 11, 2, '1', '2018'),
('SIM-31', 50000, '2018-01-01', 11, 2, '2', '2018'),
('SIM-32', 50000, '2018-01-01', 11, 2, '3', '2018'),
('SIM-33', 50000, '2018-01-01', 11, 2, '4', '2018'),
('SIM-34', 35000, '2018-01-01', 9, 4, '1', '2018'),
('SIM-35', 35000, '2018-01-01', 9, 4, '2', '2018'),
('SIM-36', 35000, '2018-01-01', 9, 4, '3', '2018'),
('SIM-37', 35000, '2018-01-01', 9, 4, '4', '2018'),
('SIM-38', 35000, '2018-01-01', 9, 4, '5', '2018'),
('SIM-39', 35000, '2018-01-01', 9, 4, '6', '2018'),
('SIM-40', 35000, '2018-01-01', 9, 4, '7', '2018'),
('SIM-41', 35000, '2018-01-01', 9, 4, '8', '2018'),
('SIM-42', 35000, '2018-01-01', 9, 4, '9', '2018'),
('SIM-43', 35000, '2018-01-01', 9, 4, '10', '2018'),
('SIM-44', 15000, '2018-01-01', 10, 3, '1', '2018'),
('SIM-45', 15000, '2018-01-01', 10, 3, '2', '2018'),
('SIM-46', 15000, '2018-01-01', 10, 3, '3', '2018'),
('SIM-47', 15000, '2018-01-01', 10, 3, '4', '2018'),
('SIM-48', 15000, '2018-01-01', 10, 3, '5', '2018'),
('SIM-49', 15000, '2018-01-01', 10, 3, '6', '2018'),
('SIM-50', 15000, '2018-01-01', 10, 3, '7', '2018'),
('SIM-51', 15000, '2018-01-01', 10, 3, '8', '2018'),
('SIM-52', 15000, '2018-01-01', 10, 3, '9', '2018'),
('SIM-53', 15000, '2018-01-01', 10, 3, '10', '2018'),
('SIM-6', 50000, '2018-01-01', 9, 1, '3', '2016'),
('SIM-7', 50000, '2018-01-01', 10, 1, '12', '2017'),
('SIM-9', 50000, '2018-01-01', 9, 2, '1', '2018');

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan_anggota`
--

CREATE TABLE `simpanan_anggota` (
  `no_anggota` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tarif` int(11) DEFAULT NULL,
  `jml_simpanan_dimiliki` int(11) NOT NULL,
  `tgl_ambil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `simpanan_anggota`
--

INSERT INTO `simpanan_anggota` (`no_anggota`, `id_jenis`, `tarif`, `jml_simpanan_dimiliki`, `tgl_ambil`) VALUES
(9, 1, 50000, 50000, '0000-00-00'),
(9, 2, 50000, 550000, '0000-00-00'),
(9, 4, 35000, 350000, '2019-05-30'),
(10, 1, 50000, 50000, '0000-00-00'),
(10, 2, 50000, 550000, '0000-00-00'),
(10, 3, 15000, 0, '0000-00-00'),
(11, 1, 50000, 50000, '0000-00-00'),
(11, 2, 50000, 350000, '0000-00-00'),
(12, 1, 50000, 50000, '0000-00-00'),
(12, 2, 50000, 0, '0000-00-00'),
(12, 5, 25000, 25000, '2019-06-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(30) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp`) VALUES
(35, 'Pemasok 1', 'Alamat 23', '23'),
(43, 'Pemasok 2', 'Alamat 31', '31'),
(44, 'Pemasok 3', 'Alamat 32', '32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans` varchar(10) NOT NULL,
  `tgl_trans` date DEFAULT NULL,
  `jml_trans` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_trans`, `tgl_trans`, `jml_trans`) VALUES
('ANG-1', '2018-01-02', 240000),
('ANG-10', '2018-10-03', 18000),
('ANG-11', '2018-11-02', 60000),
('ANG-12', '2018-11-02', 100000),
('ANG-135', '2018-11-05', 160000),
('ANG-2', '2018-02-02', 720000),
('ANG-3', '2018-03-02', 30000),
('ANG-4', '2018-04-02', 146000),
('ANG-5', '2018-05-02', 43000),
('ANG-6', '2018-06-02', 240000),
('ANG-7', '2018-07-02', 240000),
('ANG-8', '2018-08-03', 480000),
('ANG-9', '2018-09-03', 260000),
('API-122', '2018-11-01', 1012000),
('API-123', '2018-11-01', 1012000),
('API-65', '2018-04-01', 1265000),
('API-66', '2018-04-01', 1265000),
('API-67', '2018-04-01', 1265000),
('API-68', '2018-04-01', 1265000),
('API-69', '2018-04-01', 1265000),
('API-70', '2018-04-01', 1265000),
('API-71', '2018-04-01', 1265000),
('API-72', '2018-04-01', 1265000),
('API-73', '2018-04-01', 1265000),
('API-74', '2018-04-01', 1012000),
('API-75', '2018-04-01', 1012000),
('API-76', '2018-04-01', 1012000),
('API-77', '2018-04-01', 1012000),
('API-78', '2018-04-01', 1012000),
('API-79', '2018-04-01', 1012000),
('API-83', '2018-05-01', 10120000),
('API-84', '2018-05-01', 10120000),
('API-86', '2018-07-01', 1012000),
('API-88', '2018-07-01', 1012000),
('API-89', '2018-07-01', 1012000),
('APJ-1', '2018-01-02', 90000),
('APJ-10', '2018-04-02', 27000),
('APJ-11', '2018-04-02', 37500),
('APJ-12', '2018-04-02', 300000),
('APJ-13', '2018-05-02', 50000),
('APJ-14', '2018-05-02', 35000),
('APJ-15', '2018-05-02', 50000),
('APJ-16', '2018-05-02', 350000),
('APJ-17', '2018-06-02', 165000),
('APJ-18', '2018-06-02', 42500),
('APJ-19', '2018-07-02', 100000),
('APJ-2', '2018-01-02', 130000),
('APJ-20', '2018-07-02', 175000),
('APJ-21', '2018-07-02', 305000),
('APJ-22', '2018-08-03', 36000),
('APJ-23', '2018-08-03', 277500),
('APJ-24', '2018-09-03', 27000),
('APJ-25', '2018-09-03', 166500),
('APJ-26', '2018-10-03', 30000),
('APJ-27', '2018-11-02', 350000),
('APJ-28', '2018-11-02', 177500),
('APJ-29', '2018-11-02', 75000),
('APJ-3', '2018-01-02', 75000),
('APJ-30', '2018-11-05', 100000),
('APJ-4', '2018-02-02', 27000),
('APJ-5', '2018-02-02', 37500),
('APJ-6', '2018-02-02', 100000),
('APJ-7', '2018-02-02', 55000),
('APJ-8', '2018-03-02', 18500),
('APJ-9', '2018-03-02', 75000),
('BYR-136', '2018-11-27', 50000),
('BYR-137', '2018-11-27', 100000),
('BYR-138', '2018-11-27', 25000),
('BYR-139', '2018-06-01', 10000),
('MDL-1', '2018-01-01', 100000000),
('PIN-117', '2018-11-01', 2000000),
('PIN-120', NULL, 0),
('PIN-121', NULL, 0),
('PIN-124', '2018-11-01', 5000000),
('PIN-54', '2018-01-01', 25000000),
('PIN-64', '2018-04-01', 10000000),
('PIN-81', '2018-05-01', 50000000),
('PIN-85', '2018-07-01', 5000000),
('PMB-100', '2018-10-03', 18000),
('PMB-132', '2018-11-02', 60000),
('PMB-133', '2018-11-02', 260000),
('PMB-134', NULL, 0),
('PMB-91', '2018-01-02', 240000),
('PMB-92', '2018-02-02', 720000),
('PMB-93', '2018-03-02', 30000),
('PMB-94', '2018-04-02', 146000),
('PMB-95', '2018-05-02', 43000),
('PMB-96', '2018-06-02', 240000),
('PMB-97', '2018-07-02', 240000),
('PMB-98', '2018-08-03', 480000),
('PMB-99', '2018-09-03', 260000),
('PNJ-1', '2018-01-02', 90000),
('PNJ-10', '2018-04-02', 350000),
('PNJ-11', '2018-05-02', 35000),
('PNJ-12', '2018-05-02', 92500),
('PNJ-13', '2018-05-02', 350000),
('PNJ-14', '2018-06-02', 165000),
('PNJ-15', '2018-07-02', 137500),
('PNJ-16', '2018-07-02', 175000),
('PNJ-17', '2018-07-02', 305000),
('PNJ-18', '2018-08-03', 36000),
('PNJ-19', '2018-08-03', 277500),
('PNJ-2', '2018-01-02', 185000),
('PNJ-20', '2018-09-03', 27000),
('PNJ-21', '2018-09-03', 166500),
('PNJ-22', '2018-10-03', 30000),
('PNJ-23', '2018-11-02', 350000),
('PNJ-24', '2018-11-02', 277500),
('PNJ-25', '2018-11-02', 75000),
('PNJ-3', '2018-01-02', 75000),
('PNJ-4', '2018-02-02', 27000),
('PNJ-5', '2018-02-02', 37500),
('PNJ-6', '2018-02-02', 175000),
('PNJ-7', '2018-03-02', 18500),
('PNJ-8', '2018-04-02', 27000),
('PNJ-9', '2018-04-02', 37500),
('SIM-10', '2018-01-01', 50000),
('SIM-11', '2018-01-01', 50000),
('SIM-114', NULL, 0),
('SIM-115', NULL, 0),
('SIM-116', '2018-11-01', 50000),
('SIM-118', '2018-11-01', 50000),
('SIM-119', '2018-11-01', 50000),
('SIM-12', '2018-01-01', 50000),
('SIM-127', '2018-11-02', 50000),
('SIM-128', '2018-11-02', 50000),
('SIM-129', '2018-11-02', 50000),
('SIM-13', '2018-01-01', 50000),
('SIM-131', '2018-11-02', 25000),
('SIM-14', '2018-01-01', 50000),
('SIM-141', NULL, 0),
('SIM-143', NULL, 0),
('SIM-15', '2018-01-01', 50000),
('SIM-16', '2018-01-01', 50000),
('SIM-17', '2018-01-01', 50000),
('SIM-18', '2018-01-01', 50000),
('SIM-19', '2018-01-01', 50000),
('SIM-20', '2018-01-01', 50000),
('SIM-21', '2018-01-01', 50000),
('SIM-22', '2018-01-01', 50000),
('SIM-23', '2018-01-01', 50000),
('SIM-24', '2018-01-01', 50000),
('SIM-25', '2018-01-01', 50000),
('SIM-26', '2018-01-01', 50000),
('SIM-27', '2018-01-01', 50000),
('SIM-28', '2018-01-01', 50000),
('SIM-29', '2018-01-01', 50000),
('SIM-30', '2018-01-01', 50000),
('SIM-31', '2018-01-01', 50000),
('SIM-32', '2018-01-01', 50000),
('SIM-33', '2018-01-01', 50000),
('SIM-34', '2018-01-01', 35000),
('SIM-35', '2018-01-01', 35000),
('SIM-36', '2018-01-01', 35000),
('SIM-37', '2018-01-01', 35000),
('SIM-38', '2018-01-01', 35000),
('SIM-39', '2018-01-01', 35000),
('SIM-40', '2018-01-01', 35000),
('SIM-41', '2018-01-01', 35000),
('SIM-42', '2018-01-01', 35000),
('SIM-43', '2018-01-01', 35000),
('SIM-44', '2018-01-01', 15000),
('SIM-45', '2018-01-01', 15000),
('SIM-46', '2018-01-01', 15000),
('SIM-47', '2018-01-01', 15000),
('SIM-48', '2018-01-01', 15000),
('SIM-49', '2018-01-01', 15000),
('SIM-50', '2018-01-01', 15000),
('SIM-51', '2018-01-01', 15000),
('SIM-52', '2018-01-01', 15000),
('SIM-53', '2018-01-01', 15000),
('SIM-6', '2018-03-03', 50000),
('SIM-7', '2018-01-01', 50000),
('SIM-9', '2018-01-01', 50000),
('TRK-108', NULL, 0),
('TRK-113', NULL, 0),
('TRK-125', NULL, 0),
('TRK-126', '2018-11-02', 150000),
('TRK-130', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

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
  ADD PRIMARY KEY (`id_jurnal`,`no_akun`,`id_trans`),
  ADD KEY `fk_id_trans` (`id_trans`),
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
  ADD PRIMARY KEY (`id_pengurus`),
  ADD KEY `fk_username` (`username`);

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
  MODIFY `no_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;
--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `obyek_alokasi`
--
ALTER TABLE `obyek_alokasi`
  MODIFY `id_obyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id_pengurus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `angsuran_penj`
--
ALTER TABLE `angsuran_penj`
  ADD CONSTRAINT `fk_id_angsurpenj` FOREIGN KEY (`id_angsurpenj`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_penjualan3` FOREIGN KEY (`id_penjualan`) REFERENCES `nota_penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `angsuran_pinj`
--
ALTER TABLE `angsuran_pinj`
  ADD CONSTRAINT `fk_id_angsur` FOREIGN KEY (`id_angsuran`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_angsuran` FOREIGN KEY (`id_angsuran`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pinjam` FOREIGN KEY (`id_pinjam`) REFERENCES `pinjaman` (`id_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg3` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `angsuran_pmb`
--
ALTER TABLE `angsuran_pmb`
  ADD CONSTRAINT `fk_id_pembelian2` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_transaksi22` FOREIGN KEY (`id_angsuran_pmb`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `fk_id_barang2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_penarikan`
--
ALTER TABLE `detail_penarikan`
  ADD CONSTRAINT `fk_id_jenis3` FOREIGN KEY (`id_jenis`) REFERENCES `simpanan_anggota` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_tarik2` FOREIGN KEY (`id_penarikan`) REFERENCES `penarikan` (`id_penarikan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `fk_id_barang3` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_nota2` FOREIGN KEY (`id_penjualan`) REFERENCES `nota_penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `fk_id_trans` FOREIGN KEY (`id_trans`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_akun` FOREIGN KEY (`no_akun`) REFERENCES `coa` (`no_akun`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nota_penjualan`
--
ALTER TABLE `nota_penjualan`
  ADD CONSTRAINT `fk_id_kasir` FOREIGN KEY (`id_kasir`) REFERENCES `kasir` (`id_kasir`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_penjualan_np` FOREIGN KEY (`id_penjualan`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_anggota` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_id_byr` FOREIGN KEY (`id_bayar`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_id_pemb` FOREIGN KEY (`id_pembelian`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Ketidakleluasaan untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `fk_id_angsuran2` FOREIGN KEY (`id_penarikan`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg4` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengurus`
--
ALTER TABLE `pengurus`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `fk_id_pinjam2` FOREIGN KEY (`id_pinjam`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_angg2` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rencana_pembagian`
--
ALTER TABLE `rencana_pembagian`
  ADD CONSTRAINT `fk_id_obyek1` FOREIGN KEY (`id`) REFERENCES `obyek_alokasi` (`id_obyek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `fk_id_jenis5` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_simpanan` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_simpan` FOREIGN KEY (`id_simpanan`) REFERENCES `transaksi` (`id_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_anggota5` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `simpanan_anggota`
--
ALTER TABLE `simpanan_anggota`
  ADD CONSTRAINT `fk_id_anggota` FOREIGN KEY (`no_anggota`) REFERENCES `anggota` (`no_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_jenis4` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_simpanan` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
