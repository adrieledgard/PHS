-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jun 2021 pada 05.09
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pusatherbalstore`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `brand`
--

CREATE TABLE `brand` (
  `Id_brand` int(11) NOT NULL,
  `Brand_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `brand`
--

INSERT INTO `brand` (`Id_brand`, `Brand_name`) VALUES
(1, 'VITAYANG'),
(2, 'TOLAK ANGIN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `Id_category` int(11) NOT NULL,
  `Category_code` varchar(4) NOT NULL,
  `Category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`Id_category`, `Category_code`, `Category_name`) VALUES
(1, 'SUPP', 'SUPPLEMENT'),
(2, 'MNMN', 'MINUMAN'),
(3, 'JAMU', 'JAMU HERBAL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `Id_member` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`Id_member`, `Username`, `Email`, `Phone`, `Password`, `Role`) VALUES
(5, 'ADRIEL', 'ADRIELEDGARD12345@GMAIL.COM', '0878612121', 'qwerty1234', 'CUST'),
(6, 'ADMIN', 'ADMIN@GMAIL.COM', '087851211189', 'qwerty1234', 'ADMIN'),
(7, 'UDIN', 'UDIN@GMAIL.COM', '0878452269', 'qwerty1234', 'SHIPPER'),
(8, 'BASO', 'BASO111@GMAIL.COM', '08795292', 'qwerty1234', 'CUSTOMER SERVICE'),
(9, 'CIKA', 'CIKAQEQEQE@GMAIL.COM', '087469090', 'qwerty1234', 'CUSTOMER SERVICE'),
(10, 'DINA', 'DINA@GMAIL.COM', '087188085565', 'qwerty1234', 'ADMIN'),
(13, 'POPPY', 'POPPY@GMAIL.COM', '087845990074', 'qwerty1234', 'CUSTOMER SERVICE'),
(14, 'OPPA', 'OPPA@GMAIL.COM', '08721113111', 'qwerty1234', 'SHIPPER'),
(15, 'TITO', 'TITO123@GMAIL.COM', '08756166311', 'qwerty1234', 'CUSTOMER SERVICE'),
(16, 'SITI_NURBAYA', 'SITINURBAYA@GMAIL.COM', '08785099420', 'qwerty1234', 'ADMIN'),
(17, 'LISA_AYU', 'LISA@GMAIL.COM', '0878422025', 'qwerty1234', 'ADMIN'),
(18, 'FUJANG', 'FUJANG123@GMAIL.COM', '08126717171', 'qwerty1234', 'CUSTOMER SERVICE'),
(19, 'IDA', 'IDAFAM123@GMAIL.COM', '08712345', 'ABCD1234', 'ADMIN'),
(20, 'FIKA', 'FIKA123@GMAIL.COM', '08451508408', 'qwerty1234', 'CUSTOMER SERVICE'),
(21, 'VAGI', 'VAGI@GMAIL.COM', '08712812811', 'qwerty1234', 'ADMIN'),
(22, 'TARA', 'TARA@GMAIL.COM', '08761291281', 'qwerty1234', 'ADMIN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `Id_product` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Id_type` int(11) NOT NULL,
  `Packaging` varchar(20) NOT NULL,
  `Id_brand` int(11) NOT NULL,
  `Composition` varchar(500) NOT NULL,
  `Bpom` varchar(20) NOT NULL,
  `Efficacy` varchar(500) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Storage` varchar(50) NOT NULL,
  `Dose` varchar(100) NOT NULL,
  `Disclaimer` varchar(50) NOT NULL,
  `Variation` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`Id_product`, `Name`, `Id_type`, `Packaging`, `Id_brand`, `Composition`, `Bpom`, `Efficacy`, `Description`, `Storage`, `Dose`, `Disclaimer`, `Variation`, `Status`) VALUES
(24, 'BBM', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'UKKURAN', 1),
(25, 'SGF', 3, 'BOTOL', 1, 'CHORELLA\r\nSPIRULINA', 'HAHAH', 'BGS ASAM LAMBUNF', 'KEREN\r\n\r\nLUAR BIASA', 'HIHI', 'HEHE', 'HEHE', 'NONE', 1),
(26, 'TES', 4, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'NONE', 1),
(27, 'TES2', 2, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'NONE', 1),
(28, 'TES3', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'NONE', 1),
(29, 'TES4', 2, 'DOS', 2, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'NONE', 1),
(30, 'BBM35', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'NONE', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_affiliate`
--

CREATE TABLE `product_affiliate` (
  `Id_product_affiliate` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_image`
--

CREATE TABLE `product_image` (
  `Id_image` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Image_name` varchar(50) NOT NULL,
  `Image_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `product_image`
--

INSERT INTO `product_image` (`Id_image`, `Id_product`, `Image_name`, `Image_order`) VALUES
(1, 24, '24-33105.JPEG', 1),
(3, 24, '24-36921.JPEG', 2),
(4, 24, '24-23165.PNG', 3),
(5, 25, '25-19682.JPG', 1),
(6, 25, '25-20761.PNG', 2),
(7, 25, '25-64483.JPG', 3),
(8, 25, '25-68885.JPG', 4),
(9, 25, '25-92580.PNG', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `Id_product_sub_category` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_sub_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_category`
--

CREATE TABLE `sub_category` (
  `Id_sub_category` int(11) NOT NULL,
  `Id_category` varchar(4) NOT NULL,
  `Sub_category_code` varchar(4) NOT NULL,
  `Sub_category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_category`
--

INSERT INTO `sub_category` (`Id_sub_category`, `Id_category`, `Sub_category_code`, `Sub_category_name`) VALUES
(1, '1', 'KOLL', 'KOLESTEROL'),
(2, '2', 'MTCH', 'MATCHA'),
(3, '3', 'LMBG', 'LAMBUNG'),
(4, '1', 'AURT', 'ASAM URAT'),
(5, '1', 'HATI', 'SUPPLEMENT HATI'),
(6, '1', 'JTG', 'SUPPLEMENT JANTUNG'),
(7, '1', 'PARU', 'SUPPLEMENT PARU'),
(8, '1', 'MATA', 'SUPPLEMENT MATA'),
(9, '1', 'TLG', 'SUPPLEMENT TULANG'),
(10, '1', 'KLT', 'SUPPLEMENT KULIT'),
(11, '1', 'KUKU', 'SUPPLEMENT KUKU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `Id_supplier` int(11) NOT NULL,
  `Supplier_name` varchar(50) NOT NULL,
  `Supplier_email` varchar(50) NOT NULL,
  `Supplier_phone1` varchar(20) NOT NULL,
  `Supplier_phone2` varchar(20) NOT NULL,
  `Supplier_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`Id_supplier`, `Supplier_name`, `Supplier_email`, `Supplier_phone1`, `Supplier_phone2`, `Supplier_address`) VALUES
(2, 'PT. ABC3', 'ABC@GMAIL.COM', '08748458441', '087855222', 'JL. KH. AGUS SALIM NO.80 (1)'),
(3, 'PT. ABC 2', 'ADRIELEDGARD12345@GMAIL.COM', '0878420716343', '0', 'JL.TERNATE 11 GH'),
(4, 'PT. MAJU MUNDUR', 'MM123@GMAIL.COM', '087842071634', '087842071634', 'JL. KH. AGUS SALIM NO.80');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type`
--

CREATE TABLE `type` (
  `Id_type` int(11) NOT NULL,
  `Type_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `type`
--

INSERT INTO `type` (`Id_type`, `Type_name`) VALUES
(1, 'KAPSUL'),
(2, 'CAIR (SIRUP)'),
(3, 'PIL'),
(4, 'TABLET');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `variation_product`
--

CREATE TABLE `variation_product` (
  `Id_variation` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Variation_name` varchar(50) NOT NULL,
  `Option_name` varchar(50) NOT NULL,
  `Purchase_price` int(11) NOT NULL,
  `Sell_price` int(11) NOT NULL,
  `Weight` int(11) NOT NULL,
  `Dimension` varchar(25) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `variation_product`
--

INSERT INTO `variation_product` (`Id_variation`, `Id_product`, `Variation_name`, `Option_name`, `Purchase_price`, `Sell_price`, `Weight`, `Dimension`, `Stock`, `Status`) VALUES
(8, 24, 'UKKURAN', 'ADA', 1, 1, 1, '1X1X1', 1, 1),
(9, 24, 'UKKURAN', 'ADA2', 1, 1, 1, '1X1X1', 1, 1),
(10, 24, 'UKKURAN', 'ADA23', 1, 1, 1, '1X1X1', 1, 1),
(11, 25, 'NONE', 'NONE', 70000, 19000, 10, '0X0X0', 100, 1),
(12, 26, 'NONE', 'NONE', 60000, 120000, 150, '5X3X1', 1500, 1),
(13, 27, 'NONE', 'NONE', 50000, 150000, 130, '3X6X4', 50, 1),
(14, 28, 'NONE', 'NONE', 25000, 80000, 1100, '1X5X6', 45, 1),
(15, 29, 'NONE', 'NONE', 25000, 60000, 100, '5X6X4', 10, 1),
(16, 30, 'NONE', 'NONE', 90000, 900000, 80, '10X8X9', 150, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`Id_brand`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id_category`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Id_member`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Id_product`);

--
-- Indeks untuk tabel `product_affiliate`
--
ALTER TABLE `product_affiliate`
  ADD PRIMARY KEY (`Id_product_affiliate`);

--
-- Indeks untuk tabel `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`Id_image`);

--
-- Indeks untuk tabel `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`Id_product_sub_category`);

--
-- Indeks untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`Id_sub_category`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Id_supplier`);

--
-- Indeks untuk tabel `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`Id_type`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `variation_product`
--
ALTER TABLE `variation_product`
  ADD PRIMARY KEY (`Id_variation`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `brand`
--
ALTER TABLE `brand`
  MODIFY `Id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `Id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `Id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `Id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `product_affiliate`
--
ALTER TABLE `product_affiliate`
  MODIFY `Id_product_affiliate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `Id_product_sub_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `Id_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `type`
--
ALTER TABLE `type`
  MODIFY `Id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `variation_product`
--
ALTER TABLE `variation_product`
  MODIFY `Id_variation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
