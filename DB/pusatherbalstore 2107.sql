-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2021 pada 21.23
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
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `Id_bank` int(11) NOT NULL,
  `Bank_name` varchar(30) NOT NULL,
  `Account_number` varchar(20) NOT NULL,
  `Account_name` varchar(50) NOT NULL,
  `Bank_branch` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`Id_bank`, `Bank_name`, `Account_number`, `Account_name`, `Bank_branch`, `Status`) VALUES
(1, 'BCA', '1580061521', 'ADRIEL EDGARD HARJONO', 'MAKASSAR', 1),
(2, 'BCA', '1580061521', 'ADRIEL EDGARD HARJONO', 'MAKASSAR', 0),
(3, 'BRI', '1530908940805', 'ADRIEL EDGARD HARJONO', 'MAKASSAR', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `brand`
--

CREATE TABLE `brand` (
  `Id_brand` int(11) NOT NULL,
  `Brand_name` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `brand`
--

INSERT INTO `brand` (`Id_brand`, `Brand_name`, `Status`) VALUES
(1, 'VITAYANG', 1),
(2, 'TOLAK ANGIN', 1),
(3, 'MADUKULA', 0),
(4, 'FORMAKOL', 0),
(5, 'MADUKULA', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `Id_category` int(11) NOT NULL,
  `Category_code` varchar(4) NOT NULL,
  `Category_name` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`Id_category`, `Category_code`, `Category_name`, `Status`) VALUES
(1, 'SUPP', 'SUPPLEMENT', 0),
(2, 'MNMN', 'MINUMAN', 0),
(3, 'JAMU', 'JAMU HERBAL', 0),
(4, 'VTMN', 'VITAMIN', 0),
(5, 'MADU', 'MADU HERBAL', 0),
(6, 'KCMT', 'KACAMATA', 1),
(7, 'JAMU', 'JAMU HERBAL', 0),
(8, 'SUPP', 'SUPPLEMENT', 1),
(9, 'JAMU', 'JAMU HERBAL', 0),
(10, 'MNMN', 'MINUMAN', 1),
(11, 'VITA', 'VITAMIN', 1),
(12, 'MKAN', 'MAKANAN', 1),
(13, 'ALMD', 'ALAT MANDI', 1),
(14, 'JAMU', 'JAMU HERBAL', 0),
(15, 'JAMU', 'JAMU HERBAL', 0),
(16, 'JAMU', 'JAMU HERBAL', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dummy`
--

CREATE TABLE `dummy` (
  `tesint` int(11) NOT NULL,
  `tesstring` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `Role` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`Id_member`, `Username`, `Email`, `Phone`, `Password`, `Role`, `Status`) VALUES
(5, 'ADRIEL', 'ADRIELEDGARD12345@GMAIL.COM', '0878612121', 'qwerty1234', 'CUST', 1),
(6, 'ADMIN', 'ADMIN@GMAIL.COM', '087851211189', 'qwerty1234', 'ADMIN', 1),
(7, 'UDIN', 'UDIN@GMAIL.COM', '0878452269', 'qwerty1234', 'SHIPPER', 1),
(8, 'BASO', 'BASO111@GMAIL.COM', '08795292', 'qwerty1234', 'CUSTOMER SERVICE', 1),
(9, 'CIKA', 'CIKAQEQEQE@GMAIL.COM', '087469090', 'qwerty1234', 'CUSTOMER SERVICE', 0),
(10, 'DINA', 'DINA@GMAIL.COM', '087188085565', 'qwerty1234', 'ADMIN', 0),
(13, 'POPPY', 'POPPY@GMAIL.COM', '087845990074', 'qwerty1234', 'CUSTOMER SERVICE', 0),
(14, 'OPPA', 'OPPA@GMAIL.COM', '08721113111', 'qwerty1234', 'SHIPPER', 1),
(15, 'TITO', 'TITO123@GMAIL.COM', '08756166311', 'qwerty1234', 'CUSTOMER SERVICE', 0),
(16, 'SITI_NURBAYA', 'SITINURBAYA@GMAIL.COM', '08785099420', 'qwerty1234', 'ADMIN', 0),
(17, 'LISA_AYU', 'LISA@GMAIL.COM', '0878422025', 'qwerty1234', 'ADMIN', 0),
(18, 'FUJANG', 'FUJANG123@GMAIL.COM', '08126717171', 'qwerty1234', 'CUSTOMER SERVICE', 0),
(19, 'IDA', 'IDAFAM123@GMAIL.COM', '08712345', 'ABCD1234', 'ADMIN', 0),
(20, 'FIKA', 'FIKA123@GMAIL.COM', '08451508408', 'qwerty1234', 'CUSTOMER SERVICE', 0),
(21, 'VAGI', 'VAGI@GMAIL.COM', '08712812811', 'qwerty1234', 'ADMIN', 0),
(22, 'TARA', 'TARA@GMAIL.COM', '08761291281', 'qwerty1234', 'ADMIN', 0),
(23, 'JHON12', 'JHON12@GMAIL.COM', '08784208999', 'qwerty1234', 'cust', 0),
(24, 'AKBAR', 'AKBAR@GMAIL.COM', '0878450800999', 'qwerty1234', 'SHIPPER', 1),
(25, 'BUDI', 'BUDI@GMAIL.COM', '08784090909971', 'qwerty1234', 'SHIPPER', 1);

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
(38, 'BEKATUL BERAS MERAH 2', 2, 'BOX', 1, '2 SETIAP 1 KAPSUL VITAYANG BEKATUL BERAS MERAH MENGANDUNG EKSTRAK ORYZA SATIVA BRAN 350 MG....', '2 BPOM TR 162 396', '2 -MENURUNKAN KOLESTEROL DALAM DARAH.\r\n-MENURUNKAN KADAR TRIGLISERIDA DALAM DARAH.\r\n-MENCEGAH ARTERIOSKLEROSIS (PENYUMBATAN PEMBULUH DARAH)\r\n\r\nKEUNGGULAN : MERUPAKAN EKSTRAK ALAMI DARI BUBUK BEKATUL BERAS MERAH BUKAN MERUPAKAN OBAT KIMIA SINTESIS, YANG AMAN DIMINUM BAIK SEBAGAI TERAPI MAUPUN UNTUK PENCEGAHAN.', '2 BEKATUL ADALAH BAGIAN ANTARA BULIR BERAS DAN KULIT PADI (BAGIAN KULIT ARI). BEKATUL DARI BERAS MERAH KAYA AKAN BERBAGAI SENYAWA FITOKIMIA SEPERTI POLIFENOL, ANTOSIANIDIN DAN GAMMA ORYZANOL YANG TELAH TERBUKTI BERMANFAAT UNTUK MENCEGAH ARTERIOSKLEROSIS KARENA KADAR LEMAK DAN KOLESTEROL YANG TINGGI DALAM DARAH. ARTERIOSKLEROSIS ADALAH PENYEBAB UTAMA PENYAKIT JANTUNG KORONER, STROKE DAN BERBAGAI PENYAKIT AKIBAT PENYUMBATAN PEMBULUH DARAH ARTERI.', '2 DILETAKKAN DI SUHU RUANGAN', '2 DIMINUM 3X1 KAPSUL PER HARI', '2 DIMINUM 3X1 KAPSUL PER HARI', 'ABC', 1),
(39, 'MADUKULA', 2, 'BOX', 3, 'MADU HUTAN 100%', 'POM TI 044 511 731', 'UNTUK MENGATASI ASAM LAMBUNG HINGGA GERD', 'BAGUS DAN TERBUKTI BERKHASIAT', 'SUHU RUANGAN', '1 HARI 2 SENDOK MAKAN', '1 HARI 2 SENDOK MAKAN', 'UKURAN', 1),
(40, 'OMEGA 3', 1, 'DOS', 1, 'MINYAK IKAN', 'TA 1559099090', 'BGS UNTUK KOLESTEROL', '- 1000% MINYAK IKAN', 'TIDAK BOLEH KENA SINAR MATAHARI', '1 PIL SATU / HARI', '1 PIL SATU / HARI', 'NONE', 1),
(41, 'VIT C', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'UKURAN', 1),
(42, 'VIT D', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'UKURAN', 0);

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
(66, 38, '38-93391.PNG', 1),
(67, 38, '38-395.PNG', 2),
(68, 41, '41-16773.JPG', 4),
(70, 41, '41-33965.JPG', 1),
(71, 41, '41-99166.PNG', 3),
(72, 41, '41-72309.PNG', 2),
(73, 38, '38-74459.JPG', 3);

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
(58, 41, 14),
(59, 41, 12),
(62, 42, 12),
(63, 42, 13),
(65, 38, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `No_detail` int(11) NOT NULL,
  `No_invoice` varchar(20) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Purchase_price` int(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `purchase_detail`
--

INSERT INTO `purchase_detail` (`No_detail`, `No_invoice`, `Id_product`, `Id_variation`, `Qty`, `Purchase_price`) VALUES
(107, 'INV-P-180721-0001', 38, 58, 15, 50000),
(108, 'INV-P-180721-0001', 41, 59, 100, 50000),
(109, 'INV-P-180721-0002', 41, 59, 1000, 50000),
(110, 'INV-P-180721-0003', 39, 52, 15, 15000),
(111, 'INV-P-180721-0004', 38, 57, 1000, 8000),
(112, 'INV-P-190721-0001', 38, 57, 100, 8000),
(113, 'INV-P-190721-0001', 39, 52, 1500, 15000),
(114, 'INV-P-190721-0002', 38, 57, 100, 8000),
(115, 'INV-P-190721-0002', 41, 59, 100, 50000),
(116, 'INV-P-190721-0003', 38, 57, 100, 8000),
(117, 'INV-P-190721-0003', 41, 59, 100, 50000),
(118, 'INV-P-200721-0001', 41, 59, 1000, 50000),
(119, 'INV-P-200721-0002', 38, 57, 10, 8000),
(120, 'INV-P-200721-0002', 40, 40, 10, 25000),
(121, 'INV-P-200721-0003', 38, 57, 888, 8000),
(122, 'INV-P-200721-0004', 38, 57, 888, 8000),
(123, 'INV-P-200721-0005', 41, 59, 100, 50000),
(124, 'INV-P-200721-0005', 39, 52, 100, 15000),
(125, 'INV-P-200721-0006', 38, 57, 100, 8000),
(126, 'INV-P-200721-0007', 38, 57, 150, 8000),
(127, 'INV-P-200721-0008', 38, 57, 150, 8000),
(128, 'INV-P-200721-0009', 40, 40, 100, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_header`
--

CREATE TABLE `purchase_header` (
  `No_invoice` varchar(20) NOT NULL,
  `Purchase_date` date NOT NULL,
  `Id_supplier` int(11) NOT NULL,
  `Grand_total` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `purchase_header`
--

INSERT INTO `purchase_header` (`No_invoice`, `Purchase_date`, `Id_supplier`, `Grand_total`, `Status`) VALUES
('INV-P-180721-0001', '2021-07-18', 17, 5750000, 4),
('INV-P-180721-0002', '2021-07-18', 3, 50000000, 4),
('INV-P-180721-0003', '2021-07-18', 17, 225000, 4),
('INV-P-180721-0004', '2021-07-18', 20, 8000000, 3),
('INV-P-190721-0001', '2021-07-19', 9, 23300000, 0),
('INV-P-190721-0002', '2021-07-19', 15, 1300000, 0),
('INV-P-190721-0003', '2021-07-19', 15, 1300000, 4),
('INV-P-200721-0001', '2021-07-20', 18, 50000000, 4),
('INV-P-200721-0002', '2021-07-20', 15, 330000, 4),
('INV-P-200721-0003', '2021-07-20', 13, 704000, 0),
('INV-P-200721-0004', '2021-07-20', 13, 7104000, 4),
('INV-P-200721-0005', '2021-07-20', 16, 6500000, 4),
('INV-P-200721-0006', '2021-07-20', 20, 80000, 0),
('INV-P-200721-0007', '2021-07-20', 20, 1200000, 4),
('INV-P-200721-0008', '2021-07-20', 20, 1200000, 4),
('INV-P-200721-0009', '2021-07-20', 11, 2500000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_payment`
--

CREATE TABLE `purchase_payment` (
  `Id_purchase_payment` varchar(20) NOT NULL,
  `Payment_date` date NOT NULL,
  `No_receive` varchar(20) NOT NULL,
  `No_invoice` varchar(20) NOT NULL,
  `Id_member` int(11) NOT NULL,
  `Payment_method` varchar(20) NOT NULL,
  `Id_bank` int(11) NOT NULL,
  `Payment_image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `receive_detail`
--

CREATE TABLE `receive_detail` (
  `No_receive_detail` int(11) NOT NULL,
  `No_receive` varchar(20) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `No_purchase_detail` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Purchase_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `receive_detail`
--

INSERT INTO `receive_detail` (`No_receive_detail`, `No_receive`, `Id_product`, `Id_variation`, `No_purchase_detail`, `Qty`, `Purchase_price`) VALUES
(133, 'INV-RO-190721-0001', 38, 58, 107, 1, 50000),
(134, 'INV-RO-190721-0002', 38, 58, 107, 14, 50000),
(135, 'INV-RO-190721-0002', 41, 59, 108, 100, 50000),
(136, 'INV-RO-190721-0003', 39, 52, 110, 15, 15000),
(137, 'INV-RO-190721-0004', 41, 59, 109, 500, 50000),
(138, 'INV-RO-190721-0005', 41, 59, 109, 500, 50000),
(139, 'INV-RO-190721-0006', 38, 57, 111, 1, 8000),
(140, 'INV-RO-190721-0007', 38, 57, 114, 50, 8000),
(141, 'INV-RO-190721-0007', 41, 59, 115, 50, 50000),
(142, 'INV-RO-200721-0001', 38, 57, 116, 5, 8000),
(143, 'INV-RO-200721-0001', 41, 59, 117, 5, 50000),
(144, 'INV-RO-200721-0002', 41, 59, 118, 100, 50000),
(145, 'INV-RO-200721-0003', 38, 57, 119, 5, 8000),
(146, 'INV-RO-200721-0003', 40, 40, 120, 5, 25000),
(147, 'INV-RO-200721-0004', 38, 57, 122, 88, 8000),
(148, 'INV-RO-200721-0005', 41, 59, 118, 200, 50000),
(149, 'INV-RO-200721-0006', 41, 59, 118, 200, 50000),
(150, 'INV-RO-200721-0007', 41, 59, 118, 700, 50000),
(151, 'INV-RO-200721-0008', 38, 57, 119, 5, 8000),
(152, 'INV-RO-200721-0008', 40, 40, 120, 5, 25000),
(153, 'INV-RO-200721-0009', 38, 57, 116, 40, 8000),
(154, 'INV-RO-200721-00010', 38, 57, 116, 10, 8000),
(155, 'INV-RO-200721-0011', 38, 57, 116, 50, 8000),
(156, 'INV-RO-200721-0012', 41, 59, 117, 100, 50000),
(157, 'INV-RO-200721-0013', 41, 59, 123, 50, 50000),
(158, 'INV-RO-200721-0014', 41, 59, 123, 50, 50000),
(159, 'INV-RO-200721-0015', 39, 52, 124, 50, 15000),
(160, 'INV-RO-200721-0016', 39, 52, 124, 25, 15000),
(161, 'INV-RO-200721-0017', 39, 52, 124, 25, 15000),
(162, 'INV-RO-200721-0018', 39, 52, 124, 10, 15000),
(163, 'INV-RO-200721-0019', 39, 52, 124, 25, 15000),
(164, 'INV-RO-200721-0020', 38, 57, 122, 100, 8000),
(165, 'INV-RO-200721-0021', 38, 57, 122, 500, 8000),
(166, 'INV-RO-200721-0022', 38, 57, 122, 100, 8000),
(167, 'INV-RO-200721-0023', 38, 57, 122, 50, 8000),
(168, 'INV-RO-200721-0024', 38, 57, 122, 100, 8000),
(169, 'INV-RO-200721-0025', 38, 57, 127, 150, 8000),
(170, 'INV-RO-200721-0026', 38, 57, 126, 100, 8000),
(171, 'INV-RO-200721-0027', 38, 57, 126, 50, 8000),
(172, 'INV-RO-200721-0028', 40, 40, 128, 50, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `receive_expire`
--

CREATE TABLE `receive_expire` (
  `No_receive_expire` int(11) NOT NULL,
  `No_receive_detail` int(11) NOT NULL,
  `Id_product` int(10) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Expire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `receive_expire`
--

INSERT INTO `receive_expire` (`No_receive_expire`, `No_receive_detail`, `Id_product`, `Id_variation`, `Qty`, `Expire_date`) VALUES
(112, 133, 38, 58, 1, '2021-07-19'),
(113, 134, 38, 58, 14, '2021-07-19'),
(114, 135, 41, 59, 100, '2021-07-19'),
(115, 136, 39, 52, 15, '2021-07-19'),
(116, 137, 41, 59, 500, '2021-07-19'),
(117, 138, 41, 59, 100, '2023-08-10'),
(118, 138, 41, 59, 100, '2024-03-30'),
(119, 138, 41, 59, 100, '2024-09-20'),
(120, 138, 41, 59, 100, '2024-09-26'),
(121, 138, 41, 59, 100, '2024-09-26'),
(122, 139, 38, 57, 1, '2021-07-19'),
(123, 140, 38, 57, 50, '2025-06-11'),
(124, 141, 41, 59, 50, '2025-06-11'),
(125, 142, 38, 57, 5, '2021-07-20'),
(126, 143, 41, 59, 5, '2021-07-20'),
(127, 144, 41, 59, 100, '2021-07-20'),
(128, 145, 38, 57, 5, '2021-07-20'),
(129, 146, 40, 40, 5, '2021-07-20'),
(130, 147, 38, 57, 88, '2021-07-20'),
(131, 148, 41, 59, 200, '2021-07-20'),
(132, 149, 41, 59, 200, '2021-07-20'),
(133, 150, 41, 59, 700, '2021-07-20'),
(134, 151, 38, 57, 5, '2021-07-20'),
(135, 152, 40, 40, 5, '2021-07-20'),
(136, 153, 38, 57, 40, '2021-07-20'),
(137, 154, 38, 57, 10, '2021-07-20'),
(138, 155, 38, 57, 50, '2021-07-20'),
(139, 156, 41, 59, 100, '2021-07-20'),
(140, 157, 41, 59, 50, '2021-07-20'),
(141, 158, 41, 59, 25, '2021-07-23'),
(142, 158, 41, 59, 25, '2024-09-10'),
(143, 159, 39, 52, 50, '2021-07-20'),
(144, 160, 39, 52, 25, '2021-07-20'),
(145, 161, 39, 52, 25, '2021-07-20'),
(146, 162, 39, 52, 10, '2021-07-20'),
(147, 163, 39, 52, 25, '2021-07-20'),
(148, 164, 38, 57, 100, '2021-07-20'),
(149, 165, 38, 57, 500, '2021-07-20'),
(150, 166, 38, 57, 100, '2021-07-20'),
(151, 167, 38, 57, 50, '2021-07-20'),
(152, 168, 38, 57, 100, '2021-07-20'),
(153, 169, 38, 57, 150, '2021-07-20'),
(154, 170, 38, 57, 100, '2021-07-20'),
(155, 171, 38, 57, 50, '2021-07-20'),
(156, 172, 40, 40, 50, '2021-07-20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `receive_header`
--

CREATE TABLE `receive_header` (
  `No_receive` varchar(20) NOT NULL,
  `No_invoice` varchar(20) NOT NULL,
  `Receive_date` date NOT NULL,
  `Id_member` int(11) NOT NULL,
  `No_reff_supplier` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL,
  `Payment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `receive_header`
--

INSERT INTO `receive_header` (`No_receive`, `No_invoice`, `Receive_date`, `Id_member`, `No_reff_supplier`, `Status`, `Payment`) VALUES
('INV-RO-190721-0001', 'INV-P-180721-0001', '2021-07-19', 7, 'INV 67212121', 2, 0),
('INV-RO-190721-0002', 'INV-P-180721-0001', '2021-07-19', 14, 'INV 67212121', 2, 0),
('INV-RO-190721-0003', 'INV-P-180721-0003', '2021-07-19', 7, 'INV 67212121', 2, 0),
('INV-RO-190721-0004', 'INV-P-180721-0002', '2021-07-19', 25, 'INV 67212121', 2, 0),
('INV-RO-190721-0005', 'INV-P-180721-0002', '2021-07-19', 24, 'INV 67212121', 2, 0),
('INV-RO-190721-0006', 'INV-P-180721-0004', '2021-07-19', 7, 'INV 67212121', 2, 0),
('INV-RO-190721-0007', 'INV-P-190721-0002', '2021-07-19', 7, 'INV 1019291121', 2, 0),
('INV-RO-200721-0001', 'INV-P-190721-0003', '2021-07-20', 7, 'INV 102121021', 3, 0),
('INV-RO-200721-00010', 'INV-P-190721-0003', '2021-07-20', 7, 'INV 13535', 2, 0),
('INV-RO-200721-0002', 'INV-P-200721-0001', '2021-07-20', 7, 'INV 182182012121', 2, 0),
('INV-RO-200721-0003', 'INV-P-200721-0002', '2021-07-20', 7, 'INV 121212', 2, 0),
('INV-RO-200721-0004', 'INV-P-200721-0004', '2021-07-20', 7, 'INV 13121', 2, 0),
('INV-RO-200721-0005', 'INV-P-200721-0001', '2021-07-20', 7, 'INV 6112112', 3, 0),
('INV-RO-200721-0006', 'INV-P-200721-0001', '2021-07-20', 7, 'INV 232323', 2, 0),
('INV-RO-200721-0007', 'INV-P-200721-0001', '2021-07-20', 7, 'INV 12345', 2, 0),
('INV-RO-200721-0008', 'INV-P-200721-0002', '2021-07-20', 7, 'INV 5252525', 2, 0),
('INV-RO-200721-0009', 'INV-P-190721-0003', '2021-07-20', 7, 'INV 1213223', 2, 0),
('INV-RO-200721-0011', 'INV-P-190721-0003', '2021-07-20', 7, 'INV 12121212', 2, 0),
('INV-RO-200721-0012', 'INV-P-190721-0003', '2021-07-20', 7, 'INV 12113131', 2, 0),
('INV-RO-200721-0013', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 535334', 2, 0),
('INV-RO-200721-0014', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 1381949811', 2, 0),
('INV-RO-200721-0015', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 42424', 2, 0),
('INV-RO-200721-0016', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 121212', 3, 0),
('INV-RO-200721-0017', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 2121212', 2, 0),
('INV-RO-200721-0018', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 121212', 3, 0),
('INV-RO-200721-0019', 'INV-P-200721-0005', '2021-07-20', 7, 'INV 12121212', 2, 0),
('INV-RO-200721-0020', 'INV-P-200721-0004', '2021-07-20', 24, 'INV 67212121', 2, 0),
('INV-RO-200721-0021', 'INV-P-200721-0004', '2021-07-20', 7, 'INV 5253522', 2, 0),
('INV-RO-200721-0022', 'INV-P-200721-0004', '2021-07-20', 25, 'INV 67212121', 2, 0),
('INV-RO-200721-0023', 'INV-P-200721-0004', '2021-07-20', 7, 'INV 1381949811', 3, 0),
('INV-RO-200721-0024', 'INV-P-200721-0004', '2021-07-20', 7, 'INV 1381949811', 2, 0),
('INV-RO-200721-0025', 'INV-P-200721-0008', '2021-07-20', 14, 'INV 67212121', 2, 0),
('INV-RO-200721-0026', 'INV-P-200721-0007', '2021-07-20', 7, 'INV 67212121', 2, 0),
('INV-RO-200721-0027', 'INV-P-200721-0007', '2021-07-20', 7, 'INV 1381949811', 2, 0),
('INV-RO-200721-0028', 'INV-P-200721-0009', '2021-07-20', 24, 'INV 67212121', 2, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_card`
--

CREATE TABLE `stock_card` (
  `Id_stock_card` int(11) NOT NULL,
  `Date_card` varchar(15) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Expire_date` varchar(15) NOT NULL,
  `Type_card` varchar(100) NOT NULL,
  `No_reference` varchar(100) NOT NULL,
  `First_stock` int(11) NOT NULL,
  `Debet` int(11) NOT NULL,
  `Credit` int(11) NOT NULL,
  `Last_stock` int(11) NOT NULL,
  `Transaction_price` int(11) NOT NULL,
  `Capital` int(11) NOT NULL,
  `Fifo_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_category`
--

CREATE TABLE `sub_category` (
  `Id_sub_category` int(11) NOT NULL,
  `Id_category` varchar(4) NOT NULL,
  `Sub_category_code` varchar(4) NOT NULL,
  `Sub_category_name` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_category`
--

INSERT INTO `sub_category` (`Id_sub_category`, `Id_category`, `Sub_category_code`, `Sub_category_name`, `Status`) VALUES
(12, '4', 'VITC', 'VITAMIN C', 0),
(13, '5', 'MDKL', 'MADU KOLESTEROL', 0),
(14, '2', 'MTCH', 'MATCHA', 0),
(15, '10', 'MTCH', 'MATCHA', 1),
(16, '8', 'VITC', 'VITAMIN C', 1),
(17, '8', 'VITD', 'VITAMIN D', 1),
(18, '10', 'KOGI', 'KOPI GINSENG', 0),
(19, '10', 'KOGI', 'KOPI GINSENG', 1),
(20, '8', 'VITE', 'VITAMIN E', 1);

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
  `Supplier_address` varchar(100) NOT NULL,
  `Credit_due_date` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`Id_supplier`, `Supplier_name`, `Supplier_email`, `Supplier_phone1`, `Supplier_phone2`, `Supplier_address`, `Credit_due_date`, `Status`) VALUES
(2, 'PT. ABC3', 'ABC@GMAIL.COM', '08748458441', '087855222', 'JL. KH. AGUS SALIM NO.80 (1)', 0, 1),
(3, 'PT. ABC 2', 'ADRIELEDGARD12345@GMAIL.COM', '0878420716343', '082187538222', 'JL.TERNATE 11 GH', 15, 1),
(4, 'PT. MAJU MUNDUR', 'MM123@GMAIL.COM', '087842071634', '087842071634', 'JL. KH. AGUS SALIM NO.800', 0, 1),
(5, 'PT. MAJU KARYA ABADI', 'MKA@GMAIL.COM', '08784560844', '087560990', 'JALAN MAJAPAHI NO 10', 60, 1),
(6, 'TES', 'TS@GMAIL.COM', '08784207154', '08123569', 'JALAN PEMUDA', 15, 1),
(7, 'PT. SATU DUA TIGA', 'YES123@GMAIL.COM', '087842071634', '08112369949', 'JALAN RAYA KLATEN', 10, 1),
(8, 'PT. SARI AYU', 'SARIAYU@GMAIL.COM', '08784569443', '081234569842', 'JALAN PEMUDA NO 200A', 15, 1),
(9, 'PT. KOSMETIK 03', 'KOSMETIK03@GMAIL.COM', '08784561235', '0812187596423', 'JALAN HAJI AGUS SALIM NO 12', 12, 1),
(10, 'PT. KINO', 'KINO@GMAIL.COM', '087845698213', '087549220990', 'JALAN KYAI NO 123', 12, 1),
(11, 'PT. REJEKI JAYA', 'ADMIN@REJEKIJAYA.COM', '087845900080', '081122334455', 'JALAN TERNATE NO 11', 16, 1),
(12, 'PT. TITOP', 'ADMIN@TIPTOP.COM', '081235490909', '081248499', 'JALAN SATANGGA NO 123', 30, 1),
(13, 'PT. JAYA 123', 'JAYA123@GMAIL.COM', '08784080837', '08112255446637', 'JALAN HAHA HIHI HEHE37', 37, 1),
(14, 'PT. YAYA', 'YAYA@GMAIL.COM', '0878456070', '08780909009', 'HAHA HEHE', 12, 1),
(15, 'PT. GANTENG', 'GANTENG@GMAIL.COM', '08512345995', '089611224488', 'JALAN KINA NO 12', 30, 1),
(16, 'PT. LIMA', 'LIMA@GMAIL.COM', '08123349848', '0878099', 'JALA HAHA', 20, 1),
(17, 'PT. ABADI MAKMUR', 'ABDMKMR@GMAIL.COM', '0854509099', '08512350909', 'JALAN YOS SUDARSO NO 123', 30, 1),
(18, 'PT. AYU KINO', 'AYUKINO@GMAIL.COM', '084560808090', '08754605090', 'JALAN JENDRAL SUDIRMAN NO 45', 50, 1),
(19, 'PT. SAPUTRA ABADI', 'SAUTRABADI@GMAIL.COM', '081235557899', '08123694949', 'KINANO 11', 11, 1),
(20, 'PT. ADRIEL SUKSES JAYA', 'ADRIELSUKSES@GMAIL.COM', '0870840809', '08008988', 'JL.TERNATE', 10, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_product`
--

CREATE TABLE `supplier_product` (
  `Id_supplier_product` int(11) NOT NULL,
  `Id_supplier` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier_product`
--

INSERT INTO `supplier_product` (`Id_supplier_product`, `Id_supplier`, `Id_product`, `Status`) VALUES
(1, 11, 38, 1),
(2, 11, 39, 1),
(3, 11, 40, 1),
(4, 12, 38, 1),
(5, 12, 39, 1),
(6, 12, 42, 1),
(31, 20, 38, 1),
(32, 20, 41, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `type`
--

CREATE TABLE `type` (
  `Id_type` int(11) NOT NULL,
  `Type_name` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `type`
--

INSERT INTO `type` (`Id_type`, `Type_name`, `Status`) VALUES
(1, 'KAPSUL', 1),
(2, 'CAIR (SIRUP)', 1),
(3, 'PIL', 0),
(4, 'TABLET', 0),
(5, 'PUYER/BUBUK', 1),
(6, 'PIL', 0),
(7, 'PILL', 0);

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
(26, 38, 'UKURAN', '', 3333, 179000, 150, '10X5X3', 100, 0),
(27, 38, 'UKURAN', '', 3333, 179000, 150, '10X5X3', 100, 0),
(30, 39, 'NONE', 'NONE', 3333, 120000, 100, '10X5X12', 100, 0),
(32, 39, 'UKURAN', '30 ML', 3333, 150000, 100, '12X11X15', 100, 0),
(33, 39, 'UKURAN', '50 ML', 3333, 175000, 250, '10X11X13', 200, 0),
(34, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0),
(35, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0),
(36, 39, 'UKURAN', '100 ML', 3333, 200000, 500, '1X5X9', 20, 0),
(37, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0),
(38, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0),
(39, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0),
(40, 40, 'NONE', 'NONE', 25000, 190000, 100, '5X6X9', 554, 1),
(41, 38, 'NONE', 'NONE', 3333, 179000, 150, '10X5X3', 500, 0),
(42, 38, 'TIPE', '1 BOX', 3333, 179000, 100, '5X3X2', 100, 0),
(43, 38, 'TIPE', '3 BOX', 3333, 350000, 300, '15X9X6', 250, 0),
(44, 38, 'NONE', 'NONE', 3333, 179000, 100, '5X3X2', 100, 0),
(45, 38, 'NONE', 'NONE', 3333, 179000, 100, '5X3X2', 100, 0),
(46, 38, 'TIPE', '1 BOX', 3333, 1, 1, '1X1X1', 1, 0),
(47, 38, 'TIPE', '3 BOX', 3333, 2, 2, '2X2X2', 2, 0),
(48, 38, 'TIPE', 'ADA', 3333, 3, 3, '3X3X3', 3, 0),
(49, 38, 'TIPE', 'ADA2', 3333, 1, 1, '1X1X1', 1, 0),
(50, 38, 'TIPE', 'ADA3', 3333, 60000, 10, '1X5X6', 10, 0),
(51, 39, 'UKURAN', 'ADA', 3333, 1, 1, '1X1X1', 1, 0),
(52, 39, 'UKURAN', 'ADA', 15000, 1, 1, '1X1X1', 607, 1),
(53, 38, 'TIPE', 'ADA', 3333, 160000, 50, '5X6X9', 500, 0),
(54, 38, 'TIPE', 'ADA2', 3333, 1, 1, '1X1X1', 1, 0),
(55, 38, 'TIPE', 'ADA4', 3333, 170000, 300, '6X9X70', 600, 0),
(56, 38, 'NONE', 'NONE', 3333, 60000, 10, '1X5X6', 10, 0),
(57, 38, 'ABC', 'ADA', 8000, 1, 1, '1X1X1', 829, 1),
(58, 38, 'ABC', 'ADA2', 50000, 1, 1, '1X1X1', 201, 1),
(59, 41, 'UKURAN', '50GR', 50000, 150000, 100, '10X5X9', 100, 1),
(60, 41, 'UKURAN', '100 GR', 70000, 170000, 150, '12X7X11', 500, 0),
(61, 42, 'NONE', 'NONE', 80000, 180000, 100, '5X6X9', 100, 0),
(62, 42, 'UKURAN', '50GR', 15000, 180000, 100, '5X6X9', 500, 1),
(63, 42, 'UKURAN', '100GR', 20000, 200000, 150, '6X9X10', 500, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`Id_bank`);

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
-- Indeks untuk tabel `purchase_header`
--
ALTER TABLE `purchase_header`
  ADD PRIMARY KEY (`No_invoice`);

--
-- Indeks untuk tabel `receive_detail`
--
ALTER TABLE `receive_detail`
  ADD PRIMARY KEY (`No_receive_detail`);

--
-- Indeks untuk tabel `receive_expire`
--
ALTER TABLE `receive_expire`
  ADD PRIMARY KEY (`No_receive_expire`);

--
-- Indeks untuk tabel `receive_header`
--
ALTER TABLE `receive_header`
  ADD PRIMARY KEY (`No_receive`);

--
-- Indeks untuk tabel `stock_card`
--
ALTER TABLE `stock_card`
  ADD PRIMARY KEY (`Id_stock_card`);

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
-- Indeks untuk tabel `supplier_product`
--
ALTER TABLE `supplier_product`
  ADD PRIMARY KEY (`Id_supplier_product`);

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
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `Id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `brand`
--
ALTER TABLE `brand`
  MODIFY `Id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `Id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `Id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `Id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `product_affiliate`
--
ALTER TABLE `product_affiliate`
  MODIFY `Id_product_affiliate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `Id_product_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `No_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT untuk tabel `receive_detail`
--
ALTER TABLE `receive_detail`
  MODIFY `No_receive_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT untuk tabel `receive_expire`
--
ALTER TABLE `receive_expire`
  MODIFY `No_receive_expire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT untuk tabel `stock_card`
--
ALTER TABLE `stock_card`
  MODIFY `Id_stock_card` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `Id_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `supplier_product`
--
ALTER TABLE `supplier_product`
  MODIFY `Id_supplier_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `type`
--
ALTER TABLE `type`
  MODIFY `Id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `variation_product`
--
ALTER TABLE `variation_product`
  MODIFY `Id_variation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
