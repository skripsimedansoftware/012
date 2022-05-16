-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2022 at 04:37 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi-rekam-medis`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_confirm`
--

CREATE TABLE `email_confirm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_uid` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_code` int(6) NOT NULL,
  `expire_date` datetime NOT NULL,
  `status` enum('unconfirmed','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(4) NOT NULL,
  `pasien` int(4) NOT NULL,
  `dokter` int(4) NOT NULL,
  `waktu` datetime NOT NULL,
  `status` enum('dijadwalkan','selesai') NOT NULL,
  `catatan` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rekam-medis`
--

CREATE TABLE `rekam-medis` (
  `id` int(4) NOT NULL,
  `pasien` int(4) NOT NULL,
  `jadwal` int(4) NOT NULL,
  `tekanan_darah` varchar(100) NOT NULL,
  `nadi` varchar(100) NOT NULL,
  `pernafasan` varchar(100) NOT NULL,
  `suhu` varchar(100) NOT NULL,
  `sistem_pencernaan` varchar(100) NOT NULL,
  `jantung_pembuluh_darah` varchar(100) NOT NULL,
  `sistem_saraf_pusat` varchar(100) NOT NULL,
  `tht_dan_kulit` varchar(100) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `pemeriksaan_urin` varchar(100) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `saran` text DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) UNSIGNED NOT NULL,
  `role` enum('admin','dokter','pasien') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity_type` enum('KTP','SIM') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_number` char(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` enum('islam','kristen','khatolik','hindu','budha') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `birthplace` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ethnic_group` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` enum('NONE','SD','SLTP','SLTA','D3','S1','S2','S3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` tinyint(1) DEFAULT NULL,
  `police_case` tinyint(1) DEFAULT NULL,
  `profession_type` enum('none','student','employee','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `blood` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_notif` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non-active',
  `registration_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `email`, `username`, `password`, `identity_type`, `identity_number`, `religion`, `full_name`, `birthday`, `birthplace`, `father_name`, `mother_name`, `ethnic_group`, `education`, `marital_status`, `police_case`, `profession_type`, `profession_name`, `gender`, `age`, `blood`, `phone`, `address`, `sender`, `sender_name`, `photo`, `push_notif`, `status`, `registration_time`) VALUES
(1, 'admin', 'admin@rekammedis.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, NULL, NULL, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL),
(2, 'dokter', 'dokter@rekammedis.com', 'dokter', '9d2878abdd504d16fe6262f17c80dae5cec34440', NULL, NULL, NULL, 'Dokter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL),
(3, 'pasien', 'pasien@rekammedis.com', 'pasien', '2d64647e07ad6d7fdc36818a3f93a0c8a054bd18', NULL, NULL, NULL, 'Pasien', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', '2022-02-20 21:56:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekam-medis`
--
ALTER TABLE `rekam-medis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekam-medis`
--
ALTER TABLE `rekam-medis`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
