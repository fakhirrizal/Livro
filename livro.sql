-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 31 Des 2019 pada 16.34
-- Versi Server: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `livro`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `activity_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `activity_type` varchar(64) NOT NULL,
  `activity_data` text,
  `activity_time` datetime NOT NULL,
  `activity_ip_address` varchar(15) DEFAULT NULL,
  `activity_device` varchar(32) DEFAULT NULL,
  `activity_os` varchar(16) DEFAULT NULL,
  `activity_browser` varchar(16) DEFAULT NULL,
  `activity_location` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(9) NOT NULL,
  `kode_barang` varchar(200) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `stok` int(9) NOT NULL,
  `limit_stok` int(9) NOT NULL,
  `created_by` int(9) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `user_id` int(9) NOT NULL,
  `alamat` text,
  `no_hp` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`user_id`, `alamat`, `no_hp`) VALUES
(2, 'Jln. Kaligarang 12 A, Petompon, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50237', '082325620666');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_infus`
--

CREATE TABLE `stok_infus` (
  `id_stok_infus` int(9) NOT NULL,
  `total_barang` int(9) NOT NULL,
  `total_item` int(9) NOT NULL,
  `total_harga` int(9) NOT NULL,
  `created_by` int(9) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('0','1','9') NOT NULL COMMENT '0 = Pending; 1 = Approved; 9 = Rejected',
  `approval` datetime DEFAULT NULL,
  `verificator` int(9) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_infus_detail`
--

CREATE TABLE `stok_infus_detail` (
  `id_stok_infus_detail` int(9) NOT NULL,
  `id_stok_infus_request` int(9) DEFAULT NULL,
  `id_stok_infus` int(9) NOT NULL,
  `id_barang` int(9) NOT NULL,
  `qty` int(9) NOT NULL,
  `harga_satuan` int(9) NOT NULL,
  `total_harga` int(9) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_infus_request`
--

CREATE TABLE `stok_infus_request` (
  `id_stok_infus_request` int(9) NOT NULL,
  `id_stok_infus` int(9) NOT NULL,
  `id_barang` int(9) NOT NULL,
  `qty` int(9) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id_stok_opname` int(9) NOT NULL,
  `total_barang` int(9) NOT NULL,
  `total_item` int(9) NOT NULL,
  `created_by` int(9) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('0','1','9') NOT NULL,
  `approval` datetime DEFAULT NULL,
  `verificator` int(9) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_opname_detail`
--

CREATE TABLE `stok_opname_detail` (
  `id_stok_opname_detail` int(9) NOT NULL,
  `id_stok_opname` int(9) NOT NULL,
  `id_barang` int(9) NOT NULL,
  `qty` int(9) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(9) UNSIGNED NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `pass` varchar(64) DEFAULT NULL,
  `total_login` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `login_attempts` int(9) UNSIGNED DEFAULT '0',
  `last_login_attempt` datetime DEFAULT NULL,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text,
  `ip_address` text,
  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `verification_token` varchar(128) DEFAULT NULL,
  `recovery_token` varchar(128) DEFAULT NULL,
  `unlock_token` varchar(128) DEFAULT NULL,
  `created_by` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(9) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(9) UNSIGNED DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `pass`, `total_login`, `last_login`, `last_activity`, `login_attempts`, `last_login_attempt`, `remember_time`, `remember_exp`, `ip_address`, `is_active`, `verification_token`, `recovery_token`, `unlock_token`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `deleted`) VALUES
(1, 'admin', '1', 20, '2019-12-31 14:03:03', '2019-12-31 14:03:03', 20, '2019-12-31 14:03:03', NULL, NULL, '::1', 1, NULL, NULL, NULL, 0, '2019-12-17 12:17:39', NULL, NULL, NULL, NULL, 0),
(2, 'livro', '1234', 19, '2019-12-31 22:31:59', '2019-12-31 22:31:59', 19, '2019-12-31 22:31:59', NULL, NULL, '::1', 1, NULL, NULL, NULL, 1, '2019-12-18 17:15:46', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `fullname` text,
  `photo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `fullname`, `photo`) VALUES
(1, 1, 'Administrator', 'file_1562515936.jpg'),
(2, 2, 'Cahyo', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `definition` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `route` varchar(32) DEFAULT NULL,
  `created_by` int(9) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(9) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(9) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `company_id`, `name`, `definition`, `description`, `route`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `deleted`) VALUES
(0, 0, 'Super Admin', 'Super Administrator', NULL, 'admin_side/menu', 0, '2018-10-27 17:52:08', NULL, NULL, NULL, NULL, 0),
(1, 0, 'Admin', 'Administrator (Owner)', NULL, 'admin_side/beranda', 0, '2017-03-06 01:19:26', 2, '2018-10-27 18:55:37', NULL, NULL, 0),
(2, 0, 'Head Store', 'Karyawan', NULL, 'spv_side/beranda', 0, '2019-12-18 11:25:44', NULL, NULL, NULL, NULL, 0),
(3, 0, 'Head Bar', 'Karyawan', 'Bar & Kitchen', 'member_side/beranda', 0, '2019-12-28 17:47:09', NULL, NULL, NULL, NULL, 0),
(4, 0, 'Head Kitchen', 'Karyawan', 'Bar & Kitchen', 'member_side/beranda', 0, '2019-12-31 20:36:16', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_to_role`
--

CREATE TABLE `user_to_role` (
  `user_id` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `role_id` int(9) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_to_role`
--

INSERT INTO `user_to_role` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `user_id` (`created_by`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `kode_barang` (`kode_barang`),
  ADD KEY `nama_barang` (`nama_barang`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stok_infus`
--
ALTER TABLE `stok_infus`
  ADD PRIMARY KEY (`id_stok_infus`),
  ADD KEY `user_id` (`created_by`),
  ADD KEY `id_stok_infus` (`id_stok_infus`),
  ADD KEY `verificator` (`verificator`);

--
-- Indexes for table `stok_infus_detail`
--
ALTER TABLE `stok_infus_detail`
  ADD PRIMARY KEY (`id_stok_infus_detail`),
  ADD KEY `id_stok_infus` (`id_stok_infus`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_stok_infus_request` (`id_stok_infus_request`);

--
-- Indexes for table `stok_infus_request`
--
ALTER TABLE `stok_infus_request`
  ADD PRIMARY KEY (`id_stok_infus_request`),
  ADD KEY `id_stok_infus` (`id_stok_infus`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`),
  ADD KEY `user_id` (`created_by`),
  ADD KEY `verificator` (`verificator`);

--
-- Indexes for table `stok_opname_detail`
--
ALTER TABLE `stok_opname_detail`
  ADD PRIMARY KEY (`id_stok_opname_detail`),
  ADD KEY `id_stok_opname` (`id_stok_opname`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_index` (`username`),
  ADD KEY `is_active_index` (`is_active`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_index` (`name`),
  ADD KEY `company_id_index` (`company_id`) USING BTREE;

--
-- Indexes for table `user_to_role`
--
ALTER TABLE `user_to_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id_index` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok_infus`
--
ALTER TABLE `stok_infus`
  MODIFY `id_stok_infus` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok_infus_detail`
--
ALTER TABLE `stok_infus_detail`
  MODIFY `id_stok_infus_detail` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok_infus_request`
--
ALTER TABLE `stok_infus_request`
  MODIFY `id_stok_infus_request` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id_stok_opname` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok_opname_detail`
--
ALTER TABLE `stok_opname_detail`
  MODIFY `id_stok_opname_detail` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
