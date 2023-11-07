-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 03:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi_karyawan`
--

CREATE TABLE `absensi_karyawan` (
  `id_karyawan` varchar(100) NOT NULL,
  `hadir` int(11) NOT NULL,
  `izin` int(11) NOT NULL,
  `sakit` int(11) NOT NULL,
  `cuti` int(11) NOT NULL,
  `tanpa_keterangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi_karyawan`
--

INSERT INTO `absensi_karyawan` (`id_karyawan`, `hadir`, `izin`, `sakit`, `cuti`, `tanpa_keterangan`) VALUES
('Gtq4-KHAN-kDyL-slNB', 2, 0, 2, 0, 0),
('ItyU-c2Dj-AXU1-a6K1', 4, 0, 0, 0, 0),
('J6eb-ryyA-pbkN-qFQk', 1, 0, 0, 0, 2),
('qLXl-HYEV-aR14-dICG', 0, 0, 0, 0, 0),
('tzKt-xTAS-Jwhj-7i8R', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `akun_admin`
--

CREATE TABLE `akun_admin` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun_admin`
--

INSERT INTO `akun_admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'adm1', 'admin@mail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_karyawan`
--

CREATE TABLE `daftar_karyawan` (
  `id_karyawan` varchar(100) NOT NULL,
  `no_ktp` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_karyawan`
--

INSERT INTO `daftar_karyawan` (`id_karyawan`, `no_ktp`, `nama`, `alamat`, `telp`, `email`, `jenis_kelamin`) VALUES
('Gtq4-KHAN-kDyL-slNB', '123457', 'aprina', 'Jl Kelapa 77 Wage', '082133464', 'aprinarisma15@gmail.com', 'Perempuan'),
('ItyU-c2Dj-AXU1-a6K1', '`123456', 'Rayhan Furqoni', 'JL wiyung ', '0821078', 'rayhanfurqoni2@gmail.com', 'Laki-laki'),
('J6eb-ryyA-pbkN-qFQk', '123453', 'Zidan ahmad', 'JL bawal ', '0821765', 'zidan@gmail.com', 'Laki-laki'),
('qLXl-HYEV-aR14-dICG', '123452', 'Kahil Akbar', 'JL senggol', '0821435', 'kahil.akbarr@gmail.com', 'Laki-laki'),
('tzKt-xTAS-Jwhj-7i8R', '123451', 'Tita Arum', 'JL ketintang ', '0821123', 'tita@gmail.com', 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `insentif_karyawan`
--

CREATE TABLE `insentif_karyawan` (
  `id_karyawan` varchar(100) NOT NULL,
  `status_insentif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insentif_karyawan`
--

INSERT INTO `insentif_karyawan` (`id_karyawan`, `status_insentif`) VALUES
('Gtq4-KHAN-kDyL-slNB', 'YA'),
('ItyU-c2Dj-AXU1-a6K1', 'YA'),
('J6eb-ryyA-pbkN-qFQk', 'TIDAK'),
('qLXl-HYEV-aR14-dICG', 'TIDAK'),
('tzKt-xTAS-Jwhj-7i8R', 'TIDAK');

-- --------------------------------------------------------

--
-- Table structure for table `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `id_jam_kerja` int(11) NOT NULL,
  `nama_shift` varchar(100) NOT NULL,
  `jumlah_shift` int(11) NOT NULL,
  `jam_shift` varchar(200) NOT NULL,
  `pembagian_karyawan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jam_kerja`
--

INSERT INTO `jam_kerja` (`id_jam_kerja`, `nama_shift`, `jumlah_shift`, `jam_shift`, `pembagian_karyawan`) VALUES
(2, 'Selasa', 1, '12:00-20:00', '(Rayhan Furqoni,aprina)'),
(3, 'Rabu', 1, '08:00-13:00', '(Rayhan Furqoni)');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_insentif`
--

CREATE TABLE `kriteria_insentif` (
  `hadir` int(11) NOT NULL,
  `izin` int(11) NOT NULL,
  `sakit` int(11) NOT NULL,
  `cuti` int(11) NOT NULL,
  `tanpa_keterangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria_insentif`
--

INSERT INTO `kriteria_insentif` (`hadir`, `izin`, `sakit`, `cuti`, `tanpa_keterangan`) VALUES
(2, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rekap_absensi`
--

CREATE TABLE `rekap_absensi` (
  `id_jam_kerja_fix` varchar(50) NOT NULL,
  `nama_shift` varchar(50) NOT NULL,
  `shift_ke` int(5) NOT NULL,
  `jam_shift` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `statuss` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rekap_absensi`
--

INSERT INTO `rekap_absensi` (`id_jam_kerja_fix`, `nama_shift`, `shift_ke`, `jam_shift`, `tanggal`, `nama_karyawan`, `statuss`) VALUES
('ncWvH3YYosFQ159u', 'Senin', 1, '10:00-15:00', '2023-08-04', 'Rayhan Furqoni', 'hadir'),
('ncWvH3YYosFQ159u', 'Senin', 1, '10:00-15:00', '2023-08-04', 'aprina', 'hadir'),
('ncWvH3YYosFQ159u', 'Senin', 1, '10:00-15:00', '2023-08-04', 'Zidan ahmad', 'hadir'),
('UTVF5oLqW37tRIcn', 'Selasa', 1, '12:00-20:00', '2023-08-03', 'Rayhan Furqoni', 'hadir'),
('UTVF5oLqW37tRIcn', 'Selasa', 1, '12:00-20:00', '2023-08-03', 'aprina', 'hadir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi_karyawan`
--
ALTER TABLE `absensi_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `akun_admin`
--
ALTER TABLE `akun_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_karyawan`
--
ALTER TABLE `daftar_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `insentif_karyawan`
--
ALTER TABLE `insentif_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD PRIMARY KEY (`id_jam_kerja`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi_karyawan`
--
ALTER TABLE `absensi_karyawan`
  ADD CONSTRAINT `absensi_karyawan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `daftar_karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insentif_karyawan`
--
ALTER TABLE `insentif_karyawan`
  ADD CONSTRAINT `insentif_karyawan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `daftar_karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
