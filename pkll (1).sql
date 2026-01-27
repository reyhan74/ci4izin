-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jan 2026 pada 23.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkll`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '114.5.241.242', 'adminsmkcb@gmail.com', 1, '2025-07-31 14:39:46', 1),
(2, '114.5.241.242', 'adminrendra@gmail.com', 2, '2025-07-31 14:41:20', 1),
(3, '114.5.241.242', 'adminsmkcb@gmail.com', 1, '2025-07-31 14:43:59', 1),
(4, '114.5.241.242', 'adminsmkcb@gmail.com', 1, '2025-07-31 17:50:25', 1),
(5, '114.5.241.242', 'adminsmkcb@gmail.com', 1, '2025-07-31 18:39:36', 1),
(6, '114.5.241.242', 'adminsmkcb', NULL, '2025-07-31 18:41:27', 0),
(7, '114.5.241.242', 'adminsmkcb@gmail.com', 1, '2025-07-31 18:41:36', 1),
(8, '36.90.186.92', 'adminsmkcb@gmail.com', 1, '2025-07-31 18:59:47', 1),
(9, '36.90.186.92', 'adminsmkcb@gmail.com', 1, '2025-07-31 19:37:06', 1),
(10, '103.105.76.114', 'adminsmkcb', NULL, '2025-07-31 22:19:59', 0),
(11, '103.105.76.114', 'adminsmkcb', NULL, '2025-07-31 22:20:05', 0),
(12, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-07-31 22:20:09', 1),
(13, '114.5.246.182', 'adminsmkcb@gmail.com', 1, '2025-08-01 09:12:36', 1),
(14, '114.5.246.182', 'adminsmkcb@gmail.com', 1, '2025-08-01 09:12:49', 1),
(15, '114.5.246.182', 'adminsmkcb@gmail.com', 1, '2025-08-01 09:12:49', 1),
(16, '103.105.76.114', 'gurupembimbing@mail.com', 3, '2025-08-01 19:28:08', 1),
(17, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-01 20:34:43', 1),
(18, '36.90.186.50', 'adminsmkcb@gmail.com', 1, '2025-08-02 15:16:14', 1),
(19, '120.188.72.211', 'adminsmkcb', NULL, '2025-08-07 12:47:12', 0),
(20, '120.188.72.211', 'adminsmkcb@gmail.com', 1, '2025-08-07 12:47:33', 1),
(21, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-10 11:14:41', 1),
(22, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-17 19:54:53', 1),
(23, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-17 19:55:08', 1),
(24, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-17 19:56:16', 1),
(25, '36.77.38.196', 'adminsmkcb', NULL, '2025-08-22 14:07:19', 0),
(26, '36.77.38.196', 'adminsmkcb@gmail.com', 1, '2025-08-22 14:07:31', 1),
(27, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-08-25 20:59:51', 1),
(28, '110.136.29.67', 'adminsmkcb@gmail.com', 1, '2025-10-16 11:54:45', 1),
(29, '182.5.199.48', 'admin', NULL, '2025-11-06 17:00:45', 0),
(30, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-11-11 21:23:57', 1),
(31, '180.246.231.226', 'adminsmkcb', NULL, '2025-11-13 18:07:19', 0),
(32, '114.5.245.84', 'adminrendra', NULL, '2025-11-13 18:08:22', 0),
(33, '114.5.245.84', 'adminrendra', NULL, '2025-11-13 18:11:23', 0),
(34, '114.5.245.84', 'adminrendra', NULL, '2025-11-13 18:11:48', 0),
(35, '114.5.245.84', 'adminsmkcb@gmail.com', 1, '2025-11-13 18:14:21', 1),
(36, '36.73.212.205', 'adminsmkcb@gmail.com', 1, '2025-11-13 18:18:18', 1),
(37, '114.5.245.84', 'adminsmkcb@gmail.com', 1, '2025-11-13 18:23:44', 1),
(38, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-11-13 19:46:54', 1),
(39, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-11-13 19:49:12', 1),
(40, '36.77.45.152', 'adminsmkcb@gmail.com', 1, '2025-11-20 13:35:39', 1),
(41, '36.77.45.152', 'adminsmkcb@gmail.com', 1, '2025-11-20 13:35:57', 1),
(42, '36.77.45.152', 'adminsmkcb@gmail.com', 1, '2025-11-20 13:35:57', 1),
(43, '110.136.26.166', 'adminsmkcb@gmail.com', 1, '2025-12-16 10:38:23', 1),
(44, '110.136.26.166', 'adminsmkcb@gmail.com', 1, '2025-12-16 10:38:35', 1),
(45, '103.105.76.114', 'adminsmkcb@gmail.com', 1, '2025-12-28 02:37:29', 1),
(46, '::1', 'adminsmkcb@gmail.com', 1, '2025-12-31 16:44:10', 1),
(47, '::1', 'adminsmkcb@gmail.com', 1, '2025-12-31 23:09:03', 1),
(48, '::1', 'admincb', NULL, '2026-01-05 09:52:45', 0),
(49, '::1', 'admincb', NULL, '2026-01-05 09:52:57', 0),
(50, '::1', 'adminsmkcb@gmail.com', 1, '2026-01-05 09:53:14', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(225) DEFAULT NULL,
  `school_name` varchar(225) DEFAULT 'SMK CANDA BHIRAWA PARE',
  `school_year` varchar(225) DEFAULT '2025/2026',
  `copyright` varchar(225) DEFAULT '© 2025 All rights reserved.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `school_name`, `school_year`, `copyright`) VALUES
(1, NULL, 'SMK CANDA BHIRAWA PARE', '2025/2026', '© 2025 All rights reserved.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(40, '2023-08-18-000001', 'App\\Database\\Migrations\\CreateJurusanTable', 'default', 'App', 1753348549, 1),
(41, '2023-08-18-000002', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1753348549, 1),
(42, '2023-08-18-000003', 'App\\Database\\Migrations\\CreateDB', 'default', 'App', 1753348549, 1),
(43, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1753348551, 2),
(44, '2023-08-18-000004', 'App\\Database\\Migrations\\AddSuperadmin', 'default', 'App', 1753348551, 2),
(45, '2024-07-24-083011', 'App\\Database\\Migrations\\GeneralSettings', 'default', 'App', 1753348551, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `nuptk` varchar(24) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_izin_siswa`
--

CREATE TABLE `tb_izin_siswa` (
  `id_izin` int(10) UNSIGNED NOT NULL,
  `id_siswa` int(10) UNSIGNED NOT NULL,
  `jenis_izin` enum('Kembali','Keluar') NOT NULL,
  `waktu` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_izin_siswa`
--

INSERT INTO `tb_izin_siswa` (`id_izin`, `id_siswa`, `jenis_izin`, `waktu`, `keterangan`, `status`) VALUES
(1, 1, '', '2025-12-30 16:53:42', 'kjl;\'', 1),
(2, 1, 'Keluar', '2025-12-30 16:56:25', 'fff', 1),
(3, 1, 'Keluar', '2025-12-31 23:27:38', 'jhjh', 1),
(4, 1, '', '2025-12-31 23:28:06', 'klk', 1),
(5, 1, '', '2025-12-31 23:29:15', 'kjkj', 1),
(6, 1, '', '2025-12-31 23:30:21', 'giu', 1),
(7, 1, '', '2025-12-31 23:32:03', 'Kembali ke sekolah', 1),
(8, 1, '', '2025-12-31 23:34:58', 'giu', 1),
(9, 1, '', '2025-12-31 23:36:44', 'rgg4g', 1),
(10, 1, 'Keluar', '2025-12-31 23:37:00', 'giu', 1),
(11, 1, '', '2025-12-31 23:38:03', 'yutretyu', 1),
(12, 1, 'Kembali', '2025-12-31 23:44:20', 'giu', 1),
(13, 1, 'Keluar', '2026-01-05 10:12:45', 'klk', 1),
(14, 1, 'Kembali', '2026-01-05 10:13:02', 'dcf', 1),
(15, 6, 'Keluar', '2026-01-05 10:44:43', 'trtt', 1),
(16, 6, 'Kembali', '2026-01-05 10:45:25', 'sudah', 1),
(17, 6, 'Keluar', '2026-01-05 17:31:47', 'Coba', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id` int(10) UNSIGNED NOT NULL,
  `jurusan` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TKJ 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(2, 'TKJ 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(3, 'TKJ 3', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(4, 'TPM 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(5, 'TPM 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(6, 'TPM 3', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(7, 'TPM 4', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(8, 'TPM 5', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(9, 'TITL 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(10, 'TITL 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(11, 'TITL 3', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(12, 'TKRO 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(13, 'TKRO 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(14, 'TKRO 3', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(15, 'DPIB 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(16, 'DPIB 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(17, 'TOI 1', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(18, 'TOI 2', '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kehadiran`
--

CREATE TABLE `tb_kehadiran` (
  `id_kehadiran` int(11) NOT NULL,
  `kehadiran` enum('Hadir','Sakit','Izin','Tanpa keterangan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kehadiran`
--

INSERT INTO `tb_kehadiran` (`id_kehadiran`, `kehadiran`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin'),
(4, 'Tanpa keterangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `kelas` varchar(32) NOT NULL,
  `id_jurusan` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `kelas`, `id_jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(37, 'XII', 1, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(38, 'XII', 2, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(39, 'XII', 3, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(40, 'XII', 4, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(41, 'XII', 5, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(42, 'XII', 6, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(43, 'XII', 7, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(44, 'XII', 8, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(45, 'XII', 9, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(46, 'XII', 10, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(47, 'XII', 11, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(48, 'XII', 12, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(49, 'XII', 13, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(50, 'XII', 14, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(51, 'XII', 15, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(52, 'XII', 16, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(53, 'XII', 17, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(54, 'XII', 18, '2025-07-24 09:15:49', '2025-07-24 09:15:49', NULL),
(55, 'X', 5, '2025-12-16 03:39:47', '2025-12-16 03:39:47', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lokasi_sekolah`
--

CREATE TABLE `tb_lokasi_sekolah` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_lokasi_sekolah`
--

INSERT INTO `tb_lokasi_sekolah` (`id`, `nama_lokasi`, `latitude`, `longitude`, `created_at`, `status`) VALUES
(1, 'coba lokasi', -7.7683570595559805, 112.19637393951417, '2025-07-30 10:21:02', 1),
(2, 'KAMPUS 3', -7.766126668355578, 112.18188397586346, '2025-07-30 10:44:56', 1),
(7, 'Kampus 1', -7.765903356388059, 112.19121252861639, '2025-07-31 19:08:39', 1),
(8, 'Rumah', -7.767141689729205, 112.24400354422131, '2025-08-17 19:55:28', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_presensi_guru`
--

CREATE TABLE `tb_presensi_guru` (
  `id_presensi` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_presensi_siswa`
--

CREATE TABLE `tb_presensi_siswa` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(10) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `ketlok` varchar(50) DEFAULT NULL,
  `bukti_surat` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `laporan_harian` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_presensi_siswa`
--

INSERT INTO `tb_presensi_siswa` (`id_presensi`, `id_siswa`, `id_kelas`, `tanggal`, `jam_masuk`, `jam_keluar`, `id_kehadiran`, `keterangan`, `latitude`, `longitude`, `ketlok`, `bukti_surat`, `bukti`, `laporan_harian`) VALUES
(1, 1, 38, '2025-08-17', '19:59:58', '20:01:23', 1, '', '-7.7671026', '112.2439942', 'Rumah', NULL, NULL, 'maintenance jalur hippi'),
(2, 1, 38, '2025-08-18', '17:39:32', '17:40:20', 1, '', '-7.7671802', '112.2441072', 'Rumah', NULL, NULL, 'pasang hippi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(16) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama_siswa`, `id_kelas`, `jenis_kelamin`, `no_hp`, `unique_code`, `foto`) VALUES
(1, '12345', 'ALDI', 38, 'Laki-laki', '123456789012', '68a1d214e96a48-85944919-47382854', '1755435540_e3f7af5ee7f8a30aa310.jpeg'),
(6, '20260105018', 'REYHAN DWIANDIKA', 39, 'Laki-laki', '081805256116', '6886185e966607-68473623-80656881', '1767583591_a4ba9379ea74cfc20067.png'),
(7, '202601050', 'REVI MARISKA', 39, 'Perempuan', '09043876543245678', '695b31489fc225-68635723-58330970', '1767584072_cf019beadbb2e8cba2ad.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `userizin`
--

CREATE TABLE `userizin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','wali') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `userizin`
--

INSERT INTO `userizin` (`id`, `nama`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@izin.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-12-30 17:05:08', NULL),
(2, 'Guru BK', 'guru@izin.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', '2025-12-30 17:05:08', NULL),
(3, 'Wali Murid', 'wali@izin.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali', '2025-12-30 17:05:08', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `is_superadmin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adminsmkcb@gmail.com', 'adminsmkcb', 1, '$2y$10$/zvtVSFjB5KkhObh39r8mOdQpqdnfWsbRx1Lg3JdyU/XDWuMq7FB2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(2, 'adminrendra@gmail.com', 'adminrendra', 1, '$2y$10$1TUrUrR7mgfbAAkcLxDl1.0qFWe/QoJXr.NNTkALlufyebtvfTYxe', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-07-31 14:40:54', '2025-07-31 14:40:54', NULL),
(3, 'gurupembimbing@mail.com', 'gurupembimbing', 0, '$2y$10$GJHckZ4oUk5AGvxD.tAb4.eaf6c9uymYXxFyNelieu4U8GC6Cfufy', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-07-31 14:41:52', '2025-07-31 14:41:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indeks untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indeks untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indeks untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indeks untuk tabel `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `unique_code` (`unique_code`);

--
-- Indeks untuk tabel `tb_izin_siswa`
--
ALTER TABLE `tb_izin_siswa`
  ADD PRIMARY KEY (`id_izin`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurusan` (`jurusan`);

--
-- Indeks untuk tabel `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `tb_kelas_id_jurusan_foreign` (`id_jurusan`);

--
-- Indeks untuk tabel `tb_lokasi_sekolah`
--
ALTER TABLE `tb_lokasi_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_kehadiran` (`id_kehadiran`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kehadiran` (`id_kehadiran`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `unique_code` (`unique_code`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `userizin`
--
ALTER TABLE `userizin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_izin_siswa`
--
ALTER TABLE `tb_izin_siswa`
  MODIFY `id_izin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `tb_lokasi_sekolah`
--
ALTER TABLE `tb_lokasi_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `userizin`
--
ALTER TABLE `userizin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_id_jurusan_foreign` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  ADD CONSTRAINT `tb_presensi_guru_ibfk_2` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`),
  ADD CONSTRAINT `tb_presensi_guru_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD CONSTRAINT `tb_presensi_siswa_ibfk_2` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`),
  ADD CONSTRAINT `tb_presensi_siswa_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_presensi_siswa_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
