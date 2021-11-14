-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jun 2021 pada 21.08
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
(2, 'TOLAK ANGIN'),
(3, 'MADUKULA'),
(4, 'FORMAKOL');

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
(3, 'JAMU', 'JAMU HERBAL'),
(4, 'VTMN', 'VITAMIN'),
(5, 'MADU', 'MADU HERBAL');

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
(22, 'TARA', 'TARA@GMAIL.COM', '08761291281', 'qwerty1234', 'ADMIN'),
(23, 'JHON12', 'JHON12@GMAIL.COM', '08784208999', 'qwerty1234', 'cust');

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
(38, 'BEKATUL BERAS MERAH 2', 2, 'BOX 2', 4, '2 SETIAP 1 KAPSUL VITAYANG BEKATUL BERAS MERAH MENGANDUNG EKSTRAK ORYZA SATIVA BRAN 350 MG.', '2 BPOM TR 162 396', '2 -MENURUNKAN KOLESTEROL DALAM DARAH.\r\n-MENURUNKAN KADAR TRIGLISERIDA DALAM DARAH.\r\n-MENCEGAH ARTERIOSKLEROSIS (PENYUMBATAN PEMBULUH DARAH)\r\n\r\nKEUNGGULAN : MERUPAKAN EKSTRAK ALAMI DARI BUBUK BEKATUL BERAS MERAH BUKAN MERUPAKAN OBAT KIMIA SINTESIS, YANG AMAN DIMINUM BAIK SEBAGAI TERAPI MAUPUN UNTUK PENCEGAHAN.', '2 BEKATUL ADALAH BAGIAN ANTARA BULIR BERAS DAN KULIT PADI (BAGIAN KULIT ARI). BEKATUL DARI BERAS MERAH KAYA AKAN BERBAGAI SENYAWA FITOKIMIA SEPERTI POLIFENOL, ANTOSIANIDIN DAN GAMMA ORYZANOL YANG TELAH TERBUKTI BERMANFAAT UNTUK MENCEGAH ARTERIOSKLEROSIS KARENA KADAR LEMAK DAN KOLESTEROL YANG TINGGI DALAM DARAH. ARTERIOSKLEROSIS ADALAH PENYEBAB UTAMA PENYAKIT JANTUNG KORONER, STROKE DAN BERBAGAI PENYAKIT AKIBAT PENYUMBATAN PEMBULUH DARAH ARTERI.', '2 DILETAKKAN DI SUHU RUANGAN', '2 DIMINUM 3X1 KAPSUL PER HARI', '2 DIMINUM 3X1 KAPSUL PER HARI', 'ABC', 1),
(39, 'MADUKULA', 2, 'BOX', 3, 'MADU HUTAN 100%', 'POM TI 044 511 731', 'UNTUK MENGATASI ASAM LAMBUNG HINGGA GERD', 'BAGUS DAN TERBUKTI BERKHASIAT', 'SUHU RUANGAN', '1 HARI 2 SENDOK MAKAN', '1 HARI 2 SENDOK MAKAN', 'UKURAN', 1),
(40, 'OMEGA 3', 1, 'DOS', 1, 'MINYAK IKAN', 'TA 1559099090', 'BGS UNTUK KOLESTEROL', '- 1000% MINYAK IKAN', 'TIDAK BOLEH KENA SINAR MATAHARI', '1 PIL SATU / HARI', '1 PIL SATU / HARI', 'NONE', 1);

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
(11, 39, '39-1314.JPG', 2),
(12, 39, '39-49984.WEBP', 3),
(13, 39, '39-58873.WEBP', 4),
(14, 39, '39-39040.WEBP', 1),
(18, 40, '40-21976.JPG', 3),
(22, 40, '40-90425.WEBP', 1),
(23, 40, '40-80789.JPG', 2),
(24, 40, '40-68052.JPG', 4),
(66, 38, '38-93391.PNG', 2),
(67, 38, '38-395.PNG', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `Id_product_sub_category` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_sub_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `product_sub_category`
--

INSERT INTO `product_sub_category` (`Id_product_sub_category`, `Id_product`, `Id_sub_category`) VALUES
(35, 40, 13),
(36, 40, 12),
(37, 39, 13),
(38, 39, 12),
(39, 38, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `No_detail` int(11) NOT NULL,
  `No_invoice` varchar(20) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `purchase_detail`
--

INSERT INTO `purchase_detail` (`No_detail`, `No_invoice`, `Id_product`, `Id_variation`, `Qty`) VALUES
(3, 'INV-P-090621-0001', 38, 57, 100),
(4, 'INV-P-090621-0001', 40, 40, 5),
(5, 'INV-P-090621-0001', 38, 57, 1),
(6, 'INV-P-270621-0001', 38, 57, 1),
(7, 'INV-P-270621-0001', 40, 40, 1),
(8, 'INV-P-210621-0001', 39, 52, 1),
(9, 'INV-P-080721-0001', 39, 52, 1),
(10, 'INV-P-140721-0001', 38, 57, 1),
(11, 'INV-P-160921-0001', 38, 57, 1),
(12, 'INV-P-270821-0001', 38, 57, 1),
(13, 'INV-P-080721-0002', 38, 57, 1),
(14, 'INV-P-300621-0001', 38, 57, 1),
(15, 'INV-P-230721-0001', 39, 52, 1),
(16, 'INV-P-310321-0001', 39, 52, 1),
(17, 'INV-P-310321-0001', 39, 52, 1),
(18, 'INV-P-280821-0001', 39, 52, 1),
(19, 'INV-P-280821-0001', 39, 52, 1),
(20, 'INV-P-280621-0001', 39, 52, 1),
(21, 'INV-P-280621-0001', 39, 52, 1),
(22, 'INV-P-280621-0002', 39, 52, 1),
(23, 'INV-P-280621-0002', 39, 52, 1),
(24, 'INV-P-280621-0003', 39, 52, 1),
(25, 'INV-P-280621-0003', 39, 52, 1),
(26, 'INV-P-280621-0004', 39, 52, 1),
(27, 'INV-P-280621-0004', 39, 52, 1),
(28, 'INV-P-280621-0005', 39, 52, 1),
(29, 'INV-P-280621-0005', 39, 52, 1),
(30, 'INV-P-280621-0006', 39, 52, 1),
(31, 'INV-P-280621-0006', 39, 52, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_expire`
--

CREATE TABLE `purchase_expire` (
  `Id_purchase_expire` int(11) NOT NULL,
  `Id_purchase_receive` varchar(20) NOT NULL,
  `Id_product` int(10) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Expire_date` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_header`
--

CREATE TABLE `purchase_header` (
  `No_invoice` varchar(20) NOT NULL,
  `Purchase_date` varchar(20) NOT NULL,
  `Id_supplier` int(11) NOT NULL,
  `Grand_total` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `purchase_header`
--

INSERT INTO `purchase_header` (`No_invoice`, `Purchase_date`, `Id_supplier`, `Grand_total`, `Status`) VALUES
('INV-P-080721-0001', '08/07/2021', 2, 1, 1),
('INV-P-080721-0002', '08/07/2021', 2, 200000, 1),
('INV-P-090621-0001', '09/06/2021', 3, 20650000, 1),
('INV-P-140721-0001', '14/07/2021', 3, 99, 1),
('INV-P-160921-0001', '16/09/2021', 2, 200000, 1),
('INV-P-210621-0001', '21/06/2021', 2, 1, 1),
('INV-P-230721-0001', '23/07/2021', 3, 1, 1),
('INV-P-270621-0001', '27/06/2021', 3, 290000, 1),
('INV-P-270821-0001', '27/08/2021', 4, 200000, 1),
('INV-P-280621-0001', '28/06/2021', 3, 2, 1),
('INV-P-280621-0002', '28/06/2021', 3, 2, 1),
('INV-P-280621-0003', '28/06/2021', 2, 2, 1),
('INV-P-280621-0004', '28/06/2021', 2, 2, 1),
('INV-P-280621-0005', '28/06/2021', 2, 2, 1),
('INV-P-280621-0006', '28/06/2021', 2, 2, 1),
('INV-P-280821-0001', '28/08/2021', 3, 2, 1),
('INV-P-300621-0001', '30/06/2021', 3, 200000, 1),
('INV-P-310321-0001', '31/03/2021', 3, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_receive`
--

CREATE TABLE `purchase_receive` (
  `No_receive` int(11) NOT NULL,
  `No_invoice` varchar(20) NOT NULL,
  `Receive_date` varchar(20) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Purchase_qty` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Remaining_qty` int(11) NOT NULL
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
(12, '4', 'VITC', 'VITAMIN C'),
(13, '5', 'MDKL', 'MADU KOLESTEROL'),
(14, '2', 'MTCH', 'MATCHA');

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
(3, 'PT. ABC 2', 'ADRIELEDGARD12345@GMAIL.COM', '0878420716343', '082187538222', 'JL.TERNATE 11 GH'),
(4, 'PT. MAJU MUNDUR', 'MM123@GMAIL.COM', '087842071634', '087842071634', 'JL. KH. AGUS SALIM NO.800');

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
(4, 'TABLET'),
(5, 'PUYER/BUBUK');

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
(26, 38, 'UKURAN', '', 66000, 179000, 150, '10X5X3', 100, 0),
(27, 38, 'UKURAN', '', 66000, 179000, 150, '10X5X3', 100, 0),
(30, 39, 'NONE', 'NONE', 50000, 120000, 100, '10X5X12', 100, 0),
(32, 39, 'UKURAN', '30 ML', 50000, 150000, 100, '12X11X15', 100, 0),
(33, 39, 'UKURAN', '50 ML', 75000, 175000, 250, '10X11X13', 200, 0),
(34, 39, 'UKURAN', '', 50000, 150000, 100, '12X11X15', 100, 0),
(35, 39, 'UKURAN', '', 50000, 150000, 100, '12X11X15', 100, 0),
(36, 39, 'UKURAN', '100 ML', 100000, 200000, 500, '1X5X9', 20, 0),
(37, 39, 'UKURAN', '', 50000, 150000, 100, '12X11X15', 100, 0),
(38, 39, 'UKURAN', '', 50000, 150000, 100, '12X11X15', 100, 0),
(39, 39, 'UKURAN', '', 50000, 150000, 100, '12X11X15', 100, 0),
(40, 40, 'NONE', 'NONE', 90000, 190000, 100, '5X6X9', 100, 1),
(41, 38, 'NONE', 'NONE', 66000, 179000, 150, '10X5X3', 500, 0),
(42, 38, 'TIPE', '1 BOX', 66000, 179000, 100, '5X3X2', 100, 0),
(43, 38, 'TIPE', '3 BOX', 198000, 350000, 300, '15X9X6', 250, 0),
(44, 38, 'NONE', 'NONE', 66000, 179000, 100, '5X3X2', 100, 0),
(45, 38, 'NONE', 'NONE', 66000, 179000, 100, '5X3X2', 100, 0),
(46, 38, 'TIPE', '1 BOX', 1, 1, 1, '1X1X1', 1, 0),
(47, 38, 'TIPE', '3 BOX', 2, 2, 2, '2X2X2', 2, 0),
(48, 38, 'TIPE', 'ADA', 3, 3, 3, '3X3X3', 3, 0),
(49, 38, 'TIPE', 'ADA2', 1, 1, 1, '1X1X1', 1, 0),
(50, 38, 'TIPE', 'ADA3', 50000, 60000, 10, '1X5X6', 10, 0),
(51, 39, 'UKURAN', 'ADA', 1, 1, 1, '1X1X1', 1, 0),
(52, 39, 'UKURAN', 'ADA', 1, 1, 1, '1X1X1', 1, 1),
(53, 38, 'TIPE', 'ADA', 60000, 160000, 50, '5X6X9', 500, 0),
(54, 38, 'TIPE', 'ADA2', 1, 1, 1, '1X1X1', 1, 0),
(55, 38, 'TIPE', 'ADA4', 70000, 170000, 300, '6X9X70', 600, 0),
(56, 38, 'NONE', 'NONE', 50000, 60000, 10, '1X5X6', 10, 0),
(57, 38, 'ABC', 'ADA', 200000, 1, 1, '1X1X1', 1, 1),
(58, 38, 'ABC', 'ADA2', 1000000, 1, 1, '1X1X1', 1, 1);

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
-- Indeks untuk tabel `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`No_detail`);

--
-- Indeks untuk tabel `purchase_expire`
--
ALTER TABLE `purchase_expire`
  ADD PRIMARY KEY (`Id_purchase_expire`);

--
-- Indeks untuk tabel `purchase_header`
--
ALTER TABLE `purchase_header`
  ADD PRIMARY KEY (`No_invoice`);

--
-- Indeks untuk tabel `purchase_receive`
--
ALTER TABLE `purchase_receive`
  ADD PRIMARY KEY (`No_receive`);

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
  MODIFY `Id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `Id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `Id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `Id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `product_affiliate`
--
ALTER TABLE `product_affiliate`
  MODIFY `Id_product_affiliate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `Id_product_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `No_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `purchase_expire`
--
ALTER TABLE `purchase_expire`
  MODIFY `Id_purchase_expire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `Id_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `type`
--
ALTER TABLE `type`
  MODIFY `Id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `variation_product`
--
ALTER TABLE `variation_product`
  MODIFY `Id_variation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
