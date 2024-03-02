-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Jan 2024 pada 13.54
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_cuti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_cuti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` int NOT NULL,
  `alamat_cuti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_admin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id`, `nip`, `name`, `email`, `bagian`, `pangkat`, `jabatan`, `jenis_cuti`, `tgl_cuti`, `hari`, `alamat_cuti`, `status`, `status_admin`, `approve_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Tahunan', '2023-12-17 to 2023-12-22', 0, 'DS. Kaladawa', 'Batal', '', '-', '2023-12-16 06:24:43', '2023-12-16 07:14:05', '2023-12-16 07:14:05'),
(2, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Sakit', '2023-12-17 to 2023-12-20', 0, 'DS. Kaladawa', 'Batal', '', '-', '2023-12-16 07:28:59', '2023-12-16 07:31:34', '2023-12-16 07:31:34'),
(3, '13456789', 'Dimas', 'dimas@gmail.com', 'Keperawatan', 'Wijaya Kusuma Atas', 'Perawat', 'Cuti Tahunan', '2023-12-18 to 2023-12-22', 0, 'DS. Pacul', 'Ditolak', '', '-', '2023-12-16 20:02:32', '2023-12-24 09:49:37', '2023-12-24 09:49:37'),
(4, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Tahunan', '2023-12-18 to 2023-12-23', 5, 'DS. Kaladawa', 'Batal', '', '-', '2023-12-16 20:38:11', '2023-12-16 21:07:04', '2023-12-16 21:07:04'),
(5, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Sakit', '2023-12-18 to 2023-12-23', 6, 'DS. Kaladawa', 'Ditolak', '', '-', '2023-12-16 20:41:42', '2023-12-16 21:53:50', '2023-12-16 21:53:50'),
(6, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Karena Alasan Penting', '2023-12-18 to 2023-12-20', 3, 'DS. Kaladawa', 'Batal', '', '-', '2023-12-16 20:47:58', '2023-12-16 21:07:42', '2023-12-16 21:07:42'),
(7, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Sakit', '2023-12-18 to 2023-12-23', 6, 'DS. Kaladawa', 'Disetujui', '', 'Mufasirin', '2023-12-16 21:12:56', '2023-12-16 21:53:19', NULL),
(8, '21041003', 'Ego Winasis', 'egowinasis22@gmail.com', 'Pelayanan Umum dan Kepegawaian', 'NOC', 'Staf IT', 'Cuti Tahunan', '2023-12-25', 1, 'DS. Kaladawa', 'Pending', 'Ditolak', '-', '2023-12-24 07:32:42', '2023-12-24 09:50:49', '2023-12-24 09:50:49'),
(9, '21041048', 'Luluatun Khasanah', 'lulu@gmail.com', 'Keperawatan', '-', 'Perawat', 'Cuti Tahunan', '2023-12-24 to 2023-12-25', 2, 'DS. Pacul', 'Disetujui', 'Disetujui', 'Dimas', '2023-12-24 09:58:23', '2023-12-24 10:04:54', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2023_12_16_121646_create_cuti_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dokter','apoteker','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `bagian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `pangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user.png',
  `ttd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'qrcode.png',
  `isActive` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `name`, `email`, `email_verified_at`, `password`, `role`, `bagian`, `pangkat`, `jabatan`, `image`, `ttd`, `isActive`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '-', 'Tri Wahyudi P', 'triwahyudiamungkas@gmail.com', NULL, '$2y$12$bPUt9L1jwcLPNEyxKBxEkexKiqsJO57LJf4UpzVqEau/7JXQnr/5i', 'admin', '-', '-', '-', 'user.png', 'qrcode.png', 1, NULL, '2024-01-14 16:38:19', '2024-01-14 16:38:19', NULL),
(7, '-', 'Ego Winasis', 'egowinasis22@gmail.com', NULL, '$2y$12$F/TJ2N7J7GdNyc5IX2maOuc3A0/nVg6yq9rO5tiVwdNyQ55c24Qzy', 'dokter', '-', '-', '-', 'user.png', 'qrcode.png', 1, NULL, '2024-01-14 16:57:20', '2024-01-14 16:57:20', NULL),
(8, '-', 'Retno Intan', 'retno@gmail.com', NULL, '$2y$12$Ce/NmH9m0uwefVFxHWjqZeS4hRZ4BmkrRIzCojka6d7KzXFug3wTy', 'apoteker', '-', '-', '-', 'user.png', 'qrcode.png', 1, NULL, '2024-01-14 17:10:37', '2024-01-14 17:10:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
