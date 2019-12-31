-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 31 Des 2019 pada 05.27
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

--
-- Dumping data untuk tabel `activity_logs`
--

INSERT INTO `activity_logs` (`activity_id`, `user_id`, `company_id`, `activity_type`, `activity_data`, `activity_time`, `activity_ip_address`, `activity_device`, `activity_os`, `activity_browser`, `activity_location`) VALUES
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-03 13:18:57', '::1', 'PC', 'Windows 10', 'Chrome 78.0.3904', '-7.150975,110.14025939999999'),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-03 20:20:42', '::1', 'PC', 'Windows 10', 'Chrome 78.0.3904', '-7.0051453,110.43812539999999'),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-17 12:19:19', '::1', 'PC', 'Windows 10', 'Chrome 78.0.3904', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-18 10:43:04', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-18 17:15:29', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Update admin''s data', 'Reset password admin''s account (Fakhir Rizal)', '2019-12-18 17:16:09', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Update employee''s data', 'Reset password employee''s account (M. Fakhir Rizal)', '2019-12-18 17:47:56', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Update employee''s data', 'Deactivate employee account (M. Fakhir Rizal)', '2019-12-18 17:48:52', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting admin''s data', 'Delete admin''s data ()', '2019-12-18 17:50:33', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting employee''s data', 'Delete employee''s data ()', '2019-12-18 17:52:35', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-18 20:16:20', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-18 20:17:24', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting data', 'Delete barang data', '2019-12-18 20:28:28', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Update barang data', '2019-12-18 20:37:12', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-18 23:02:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-19 10:46:37', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-23 17:11:09', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-23 22:31:25', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-23 23:32:05', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-23 23:39:47', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting stok infus''s report', 'Delete stok infus''s report', '2019-12-23 23:40:30', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-24 17:05:22', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui status data stok infus (1)', '2019-12-24 20:08:54', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting data', 'Menghapus barang dari laporan stok infus', '2019-12-24 20:13:07', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-24 22:49:12', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui laporan data stok infus (1)', '2019-12-24 22:57:39', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-24 22:58:49', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting data', 'Menghapus barang dari laporan stok infus', '2019-12-24 23:05:11', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-25 12:40:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-25 20:28:44', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok opname', '2019-12-25 20:40:41', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Deleting data', 'Menghapus barang dari laporan stok opname', '2019-12-25 20:44:53', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui status data stok opname (1)', '2019-12-25 20:47:05', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-25 21:11:28', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-25 21:12:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-25 21:13:37', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-25 22:16:42', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok opname', '2019-12-25 22:18:00', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Updating data', 'Memperbarui laporan data stok infus ()', '2019-12-25 22:44:36', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Updating data', 'Memperbarui laporan data stok infus ()', '2019-12-25 22:46:24', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-26 00:01:32', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok opname', '2019-12-26 00:08:07', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-27 14:33:06', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-27 14:36:55', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok opname', '2019-12-27 15:26:26', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-28 17:20:50', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-28 18:05:16', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-28 21:22:47', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-28 21:22:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-28 21:23:17', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-28 21:23:40', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-28 22:24:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-28 22:25:05', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-28 22:26:37', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-29 09:46:33', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-29 10:22:39', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-29 17:24:42', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Updating data', 'Memperbarui status data stok infus ()', '2019-12-29 17:31:18', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-29 17:40:21', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-29 17:40:35', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Deleting stok infus''s report', 'Delete stok infus''s report', '2019-12-29 17:50:48', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-29 17:54:47', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Deleting stok infus''s report', 'Delete stok infus''s report', '2019-12-29 17:55:11', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-29 17:55:34', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Deleting stok infus''s report', 'Delete stok infus''s report', '2019-12-29 17:58:08', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-29 17:59:27', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Updating data', 'Memperbarui status data stok infus ()', '2019-12-29 17:59:49', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Deleting data', 'Menghapus barang dari laporan stok infus', '2019-12-29 17:59:54', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Deleting data', 'Menghapus barang dari laporan stok infus', '2019-12-29 18:02:40', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Deleting stok infus''s report', 'Delete stok infus''s report', '2019-12-29 18:03:04', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-29 18:03:24', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 00:25:34', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 09:35:51', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Approval request', 'Menyetujui permintaan stok infus', '2019-12-30 10:49:13', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Approval request', 'Menyetujui permintaan stok infus', '2019-12-30 10:49:43', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Approval request', 'Menyetujui permintaan stok infus', '2019-12-30 10:52:47', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-30 10:54:45', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 11:47:12', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-30 11:54:58', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-30 12:20:32', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-30 12:21:08', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-30 12:25:37', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-30 13:26:05', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Adding data', 'Add barang data', '2019-12-30 13:26:23', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 4, 0, 'Login to system', 'Login via web browser', '2019-12-30 13:32:33', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 4, 0, 'Adding data', 'Menambahkan stok infus', '2019-12-30 13:48:59', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 4, 0, 'Deleting data', 'Menghapus barang dari laporan stok infus', '2019-12-30 14:02:13', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-30 14:49:23', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui status data stok infus (1)', '2019-12-30 15:43:10', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Approval request', 'Menyetujui permintaan stok infus', '2019-12-30 15:53:09', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-30 15:53:30', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 15:57:02', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Adding data', 'Menambahkan stok opname', '2019-12-30 16:07:43', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-30 16:20:14', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 17:08:21', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui status data stok infus (1)', '2019-12-30 17:23:54', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Login to system', 'Login via web browser', '2019-12-30 17:24:49', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 3, 0, 'Login to system', 'Login via web browser', '2019-12-30 17:28:48', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 2, 0, 'Deleting data', 'Menghapus barang dari laporan stok opname', '2019-12-30 17:31:11', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Updating data', 'Memperbarui status data stok opname (1)', '2019-12-30 17:42:35', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-30 20:02:19', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL),
(0, 1, 0, 'Login to system', 'Login via web browser', '2019-12-31 10:02:43', '::1', 'PC', 'Windows 10', 'Chrome 79.0.3945', NULL);

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

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `stok`, `limit_stok`, `created_by`, `created_at`, `deleted`) VALUES
(1, 'XXXY', 'Plastik kresek ireng', 12, 10, 1, '2019-12-18 20:16:20', '0'),
(2, 'YYY', 'Kipas angin duduk', 2, 2, 1, '2019-12-18 20:17:24', '0'),
(3, 'XYZ', 'Sendok', 24, 12, 1, '2019-12-28 18:05:16', '0'),
(4, 'G-001', 'Garpu makan', 6, 12, 1, '2019-12-30 12:21:08', '0'),
(5, 'S-001', 'Sedotan', 12, 24, 1, '2019-12-30 13:26:05', '0'),
(6, 'G-001', 'Gelas kaca', 7, 12, 1, '2019-12-30 13:26:23', '0');

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
(2, 'Jln. dr. Cipto 61, Proyonanggan Tengah, Batang', '08976526501'),
(3, 'Pasekaran', '085696303627'),
(4, 'Bekasi', '085696303627');

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

--
-- Dumping data untuk tabel `stok_infus`
--

INSERT INTO `stok_infus` (`id_stok_infus`, `total_barang`, `total_item`, `total_harga`, `created_by`, `created_at`, `status`, `approval`, `verificator`, `keterangan`) VALUES
(1, 2, 13, 256000, 3, '2019-12-29 18:03:24', '1', '2019-12-29 18:52:47', 2, 'Saya setuju'),
(2, 1, 1, 350000, 3, '2019-12-30 11:54:58', '1', '2019-12-30 15:53:09', 1, 'Uang kembaliannya buat kamu'),
(3, 1, 6, 18000, 2, '2019-12-30 12:25:37', '1', '2019-12-30 17:23:54', 1, 'Beli di Indomaret'),
(4, 1, 2, 20000, 4, '2019-12-30 13:48:59', '0', NULL, NULL, 'Beli di Superindo');

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

--
-- Dumping data untuk tabel `stok_infus_detail`
--

INSERT INTO `stok_infus_detail` (`id_stok_infus_detail`, `id_stok_infus_request`, `id_stok_infus`, `id_barang`, `qty`, `harga_satuan`, `total_harga`, `keterangan`) VALUES
(5, 3, 1, 1, 12, 500, 6000, '-'),
(6, 4, 1, 2, 1, 250000, 250000, 'Maspion'),
(7, NULL, 3, 4, 6, 3000, 18000, 'Garpu plastik'),
(9, NULL, 4, 6, 2, 10000, 20000, 'Ukuran 200ml'),
(10, 5, 2, 2, 1, 350000, 350000, 'Merk Miyako');

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

--
-- Dumping data untuk tabel `stok_infus_request`
--

INSERT INTO `stok_infus_request` (`id_stok_infus_request`, `id_stok_infus`, `id_barang`, `qty`, `keterangan`) VALUES
(3, 1, 1, 12, '-'),
(4, 1, 2, 1, 'Merk Maspion'),
(5, 2, 2, 1, 'Merk Miyako');

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

--
-- Dumping data untuk tabel `stok_opname`
--

INSERT INTO `stok_opname` (`id_stok_opname`, `total_barang`, `total_item`, `created_by`, `created_at`, `status`, `approval`, `verificator`, `keterangan`) VALUES
(1, 1, 5, 2, '2019-12-15 00:00:00', '0', NULL, NULL, 'Tebok'),
(2, 1, 1, 3, '2019-12-18 00:00:00', '0', NULL, NULL, 'Kipas dinding'),
(3, 1, 1, 2, '2019-12-26 00:08:07', '1', '2019-12-30 17:42:35', 1, 'Merk Sharp'),
(4, 2, 2, 3, '2019-12-18 00:00:00', '0', NULL, NULL, '-'),
(5, 1, 6, 2, '2019-12-30 16:07:43', '0', NULL, NULL, 'Segera saya beli');

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

--
-- Dumping data untuk tabel `stok_opname_detail`
--

INSERT INTO `stok_opname_detail` (`id_stok_opname_detail`, `id_stok_opname`, `id_barang`, `qty`, `keterangan`) VALUES
(1, 1, 1, 5, '-'),
(3, 2, 2, 1, 'Merk Maspion'),
(4, 3, 2, 1, 'Merk Daikin'),
(5, 4, 1, 1, '-'),
(6, 4, 2, 1, '-'),
(7, 5, 1, 6, 'Dipake');

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
(1, 'admin', '1', 19, '2019-12-31 10:02:42', '2019-12-31 10:02:42', 19, '2019-12-31 10:02:42', NULL, NULL, '::1', 1, NULL, NULL, NULL, 0, '2019-12-17 12:17:39', NULL, NULL, NULL, NULL, 0),
(2, 'k', 'k', 16, '2019-12-30 17:24:49', '2019-12-30 17:24:49', 16, '2019-12-30 17:24:49', NULL, NULL, '::1', 1, NULL, NULL, NULL, 1, '2019-12-18 17:15:46', NULL, NULL, NULL, NULL, 0),
(3, 's', 's', 8, '2019-12-30 17:28:48', '2019-12-30 17:28:48', 8, '2019-12-30 17:28:48', NULL, NULL, '::1', 1, NULL, NULL, NULL, 1, '2019-12-25 22:17:18', NULL, NULL, NULL, NULL, 0),
(4, 'e', 'e', 1, '2019-12-30 13:32:33', '2019-12-30 13:32:33', 1, '2019-12-30 13:32:33', NULL, NULL, '::1', 1, NULL, NULL, NULL, 1, '2019-12-30 13:32:19', NULL, NULL, NULL, NULL, 0);

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
(2, 2, 'M. Fakhir Rizal', NULL),
(4, 3, 'Sharfina Aulia Puspasari', NULL),
(6, 4, 'Estio Nurcahyanto', NULL);

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
(3, 0, 'Bar & Kitchen', 'Karyawan', NULL, 'member_side/beranda', 0, '2019-12-28 17:47:09', NULL, NULL, NULL, NULL, 0);

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
(2, 2),
(3, 3),
(4, 2);

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
  MODIFY `id_barang` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `stok_infus`
--
ALTER TABLE `stok_infus`
  MODIFY `id_stok_infus` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stok_infus_detail`
--
ALTER TABLE `stok_infus_detail`
  MODIFY `id_stok_infus_detail` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `stok_infus_request`
--
ALTER TABLE `stok_infus_request`
  MODIFY `id_stok_infus_request` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id_stok_opname` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `stok_opname_detail`
--
ALTER TABLE `stok_opname_detail`
  MODIFY `id_stok_opname_detail` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
