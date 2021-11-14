-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2021 pada 20.26
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.3.29

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

--
-- Dumping data untuk tabel `dummy`
--

INSERT INTO `dummy` (`tesint`, `tesstring`) VALUES
(0, '2021-07-22'),
(0, '2021-07-22'),
(0, '2021-07-22'),
(0, '2021-07-22'),
(5, '2021-07-22'),
(10, '2021-07-22'),
(14, '2021-07-22'),
(18, '2021-07-22'),
(22, '2021-07-22'),
(26, '2021-07-22'),
(0, '2021-07-22'),
(25, '2021-07-22'),
(250, '2021-07-22'),
(500, '2021-07-22'),
(525, '2021-07-22'),
(200, '2021-07-22'),
(225, '2021-07-22'),
(400, '2021-07-22'),
(425, '2021-07-22'),
(1, 'jjj'),
(1, 'jjj'),
(1, 'jjj'),
(1, 'stock'),
(440, '2021-07-30'),
(990, '2021-07-30'),
(1040, '2021-07-30'),
(990, '2021-07-30'),
(1015, '2021-07-30'),
(25, 'testes'),
(990, '2021-07-30'),
(1015, '2021-07-30'),
(990, '2021-07-30'),
(1015, '2021-07-30'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(20, 'Var2_Fifo_stock'),
(20, 'Var_Debet_2'),
(20, 'Var2_Fifo_stock'),
(20, 'Var_Debet_2'),
(20, 'Var2_Fifo_stock'),
(20, 'Var_Debet_2'),
(20, 'Var2_Fifo_stock'),
(20, 'Var_Debet_2'),
(20, 'Var2_Fifo_stock'),
(20, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(50, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(50, 'Var2_Fifo_stock'),
(50, 'Var_Debet_2'),
(50, 'Var2_Fifo_stock'),
(50, 'Var_Debet_2'),
(100, 'Var2_Fifo_stock'),
(100, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(40, 'Var2_Fifo_stock'),
(50, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(10, 'Var2_Fifo_stock'),
(10, 'Var_Debet_2'),
(40, 'Var2_Fifo_stock'),
(40, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2'),
(25, 'Var2_Fifo_stock'),
(25, 'Var_Debet_2');

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
(42, 'VIT D', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'UKURAN', 1),
(43, 'VIT E', 1, 'DOS', 1, 'BAGUS', 'HAHAH', 'MANTAP', 'KEREN', 'HIHI', 'HEHE', 'HEHE', 'UKURAN', 1);

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
(37, 39, 13),
(38, 39, 12),
(58, 41, 14),
(59, 41, 12),
(65, 38, 12),
(66, 40, 13),
(67, 40, 12),
(70, 42, 12),
(71, 42, 13),
(73, 43, 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo_detail`
--

CREATE TABLE `promo_detail` (
  `Id_promo_detail` int(11) NOT NULL,
  `Id_promo` int(11) NOT NULL,
  `Mininum_qty` int(11) NOT NULL,
  `Discount` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo_header`
--

CREATE TABLE `promo_header` (
  `Id_promo` int(11) NOT NULL,
  `Id_product` int(11) NOT NULL,
  `Id_variation` int(11) NOT NULL,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Model` varchar(5) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `promo_header`
--

INSERT INTO `promo_header` (`Id_promo`, `Id_product`, `Id_variation`, `Start_date`, `End_date`, `Model`, `Status`) VALUES
(1, 38, 57, '2021-08-09', '2021-08-21', '%', 1),
(2, 39, 52, '2021-08-09', '2021-08-28', 'RP', 1);

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
(144, 'INV-P-040821-0001', 40, 40, 100, 25000);

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
('INV-P-040821-0001', '2021-08-04', 20, 2500000, 2);

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
(227, 'INV-RO-040821-0001', 40, 40, 144, 50, 25000),
(228, 'INV-RO-040821-0002', 40, 40, 144, 50, 25000),
(229, 'INV-RO-050821-0001', 40, 40, 144, 50, 25000);

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
(261, 227, 40, 40, 25, '2021-08-20'),
(262, 227, 40, 40, 25, '2021-08-26'),
(263, 228, 40, 40, 25, '2021-08-28'),
(264, 228, 40, 40, 25, '2021-10-22'),
(265, 229, 40, 40, 25, '2021-08-28'),
(266, 229, 40, 40, 25, '2021-08-31');

--
-- Trigger `receive_expire`
--
DELIMITER $$
CREATE TRIGGER `trgreceiveheader_2` AFTER INSERT ON `receive_expire` FOR EACH ROW begin
 declare done   int(2); 
 declare Var_No_receive varchar(20);
 declare Var_tgl date; 
 declare Var_Id_product int(11); 
 declare Var_Id_variation int(11); 
 declare Var_Expire_date date; 
 declare Var_No_reference varchar(20); 
 declare Var_First_stock int(11); 
 declare Var_Debet int(11); 
 declare Var_Last_stock int(11); 
 declare Var_Transaction_price int(11); 
 declare Var_Capital int(11); 
 declare Var_Fifo_stock int(11); 
 declare Var_Stokawal int(11);
 declare Var_Stokakhir int(11);
  declare Var_Status int(11);
 

 set Var_Status = (SELECT Status FROM receive_header WHERE No_receive = (SELECT No_receive FROM receive_detail WHERE No_receive_detail= new.No_receive_detail));



 if Var_Status = 2 then 
	
 set Var_tgl = (SELECT receive_date FROM receive_header WHERE No_receive = (SELECT No_receive FROM receive_detail WHERE No_receive_detail= new.No_receive_detail));
 set Var_Id_product   = new.Id_product;
 set Var_Id_variation   = new.Id_variation;
 set Var_Expire_date    = new.Expire_date;
 set Var_Debet     = new.Qty;
 
 
 
 set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
  set Var_Stokakhir  = Var_Stokawal + Var_Debet;
  
  
  
 set Var_No_reference = new.No_receive_expire;
  set Var_First_stock  = (SELECT IFNULL(Last_stock,Var_Stokawal) FROM stock_card WHERE Id_variation = Var_Id_variation order by Id_stock_card desc limit 1); 
 set Var_Last_stock = ifnull(Var_First_stock,Var_Stokawal) + Var_Debet;
 set Var_Transaction_price = (SELECT purchase_price FROM receive_detail WHERE No_receive_detail = new.No_receive_detail);
 set Var_Capital = Var_Transaction_price;
 set Var_Fifo_stock= Var_Debet;
 
 update variation_product set Purchase_price = Var_Transaction_price where Id_variation = Var_Id_variation;
  
  
  update variation_product set stock =  Var_Stokakhir where id_variation = Var_Id_variation;
  
  
   insert into stock_card
    (Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
    values
  (null, Var_tgl, Var_Id_product, Var_Id_variation , Var_Expire_date, 'Purchase', Var_No_reference, ifnull(Var_First_stock,Var_Stokawal), Var_Debet, 0, ifnull(Var_Last_stock,0), Var_Transaction_price, Var_Capital, Var_Fifo_stock);
   
 end if;
end
$$
DELIMITER ;

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
('INV-RO-040821-0001', 'INV-P-040821-0001', '2021-08-04', 14, 'INV 67212121', 0, 0),
('INV-RO-040821-0002', 'INV-P-040821-0001', '2021-08-04', 25, 'INV 67212121', 0, 0),
('INV-RO-050821-0001', 'INV-P-040821-0001', '2021-08-05', 7, 'INV 67212121', 2, 0);

--
-- Trigger `receive_header`
--
DELIMITER $$
CREATE TRIGGER `trgreceiveheader` AFTER UPDATE ON `receive_header` FOR EACH ROW begin
 declare done   int(2); 
 declare done2 int(2); 
 declare Var_No_receive varchar(20);
 declare Var_tgl date; 
 declare Var_Id_product int(11); 
 declare Var_Id_variation int(11); 
 declare Var_Expire_date date; 
 declare Var_No_reference varchar(20); 
 declare Var_First_stock int(11); 
 declare Var_Debet int(11); 
 declare Var_Debet_2 int(11); 
 declare Var_Last_stock int(11); 
 declare Var_Transaction_price int(11); 
 declare Var_Capital int(11); 
 declare Var_Fifo_stock int(11); 
 declare Var_Stokawal int(11);
 declare Var_Stokakhir int(11);
 
declare Var2_Id_stock_card int(11);
declare Var2_Id_product int(11);
declare Var2_Id_variation int(11);
declare Var2_Expire_date date;
declare Var2_Fifo_stock int(11);
declare Var2_Temp_Debet int(11);
 declare Var2_First_stock int(11); 
declare pengurangan int(11);
 
   declare receive_expire cursor for 
   select 
   receive_detail.No_receive, 
   receive_detail.Purchase_price, 
   receive_expire.No_receive_expire,
   receive_expire.Id_product, 
   receive_expire.Id_variation, 
   receive_expire.Qty, 
   receive_expire.Expire_date 
   from receive_expire, receive_detail where receive_expire.No_receive_detail = receive_detail.No_receive_detail and receive_detail.No_receive = old.No_receive;
   declare continue HANDLER for not found set done = 1;
   
 if old.Status = 1 and new.Status = 2 then 
   set done   = 0;
   
   open receive_expire;
   read_loop: loop
     Fetch receive_expire into Var_No_receive,Var_Transaction_price,Var_No_reference, Var_Id_product, Var_Id_variation, Var_Debet, Var_Expire_date;
     if done = 1 then
      leave read_loop;
     else 
  
  update variation_product set Purchase_price = Var_Transaction_price where Id_variation = Var_Id_variation;
  
  set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
  set Var_Stokakhir  = Var_Stokawal + Var_Debet;
  update variation_product set Stock =  Var_Stokakhir where Id_variation = Var_Id_variation;
  
  
  
  set Var_tgl = (SELECT receive_date FROM receive_header WHERE No_receive = Var_No_receive);
  set Var_First_stock  = (SELECT IFNULL(Last_stock,Var_Stokawal) FROM stock_card WHERE Id_variation = Var_Id_variation order by Id_stock_card desc limit 1); 
  set Var_Last_stock = ifnull(Var_First_stock,Var_Stokawal) + Var_Debet;
  set Var_Capital = Var_Transaction_price;
  set Var_Fifo_stock= Var_Debet;
  
  
  
  
   insert into stock_card
    (Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
    values
  (null, Var_tgl, Var_Id_product, Var_Id_variation , Var_Expire_date, 'Purchase', Var_No_reference, ifnull(Var_First_stock,Var_Stokawal), Var_Debet, 0, ifnull(Var_Last_stock,0), Var_Transaction_price, Var_Capital, Var_Fifo_stock);
   
 
     
     end if;
   end loop; 
   close receive_expire;
   
   
 elseif old.Status = 2 and new.Status = 0 then 
 
 BLOCK1: BEGIN
 
   set done   = 0;  
   open receive_expire;
 
	read_loop: loop
     Fetch receive_expire into Var_No_receive,Var_Transaction_price,Var_No_reference, Var_Id_product, Var_Id_variation, Var_Debet, Var_Expire_date;

     if done = 1 then
      leave read_loop;
     else   
		 
  
		  BLOCK2: BEGIN
				declare stock_card cursor for 
				  select 
				  stock_card.Id_stock_card,
				  stock_card.Id_product,
				  stock_card.Id_variation,
				  stock_card.Expire_date,
				  stock_card.Fifo_stock
				  from stock_card where stock_card.Id_variation = Var_Id_variation and stock_card.Fifo_stock>0 and Var_Expire_date <= stock_card.Expire_date order by stock_card.Expire_date asc;
				declare continue HANDLER for not found set done2 = 1;
				set Var_Debet_2 = Var_Debet;
			   
			   set done2 = 0;
				open stock_card;
				 read_loop2: loop
				Fetch stock_card into Var2_Id_stock_card ,Var2_Id_product,Var2_Id_variation,Var2_Expire_date, Var2_Fifo_stock;
				if done2 = 1 then
				 leave read_loop2;
				else 
					  insert into dummy values(Var2_Fifo_stock,'Var2_Fifo_stock');
					  insert into dummy values(Var_Debet_2,'Var_Debet_2');
					if Var2_Fifo_stock >= Var_Debet_2 then 
					  update stock_card set Fifo_stock = Fifo_stock - Var_Debet_2 where Id_stock_card = Var2_Id_stock_card;
					
					  set pengurangan = Var_Debet_2;
					  set done2 = 1;
					  
					else 
					  update stock_card set Fifo_stock = 0 where Id_stock_card = Var2_Id_stock_card;
					  set Var_Debet_2 = Var_Debet_2 - Var2_Fifo_stock;
					  set pengurangan = Var2_Fifo_stock;
					end if;
					
				set Var2_First_stock  = (SELECT Last_stock FROM stock_card WHERE Id_variation = Var2_Id_variation order by Id_stock_card desc limit 1); 
				
				set Var_tgl = now();
				
				insert into stock_card
				(Id_stock_card, Date_card, Id_product, Id_variation, Expire_date, Type_card, No_reference, First_stock, Debet, Credit, Last_stock, Transaction_price, Capital, Fifo_stock)
				values
			  (null, Var_tgl, Var2_Id_product, Var2_Id_variation , Var2_Expire_date, 'Receive Void', Var_No_reference, Var2_First_stock, 0, pengurangan, ifnull(Var2_First_stock-pengurangan,0), 0, 0, 0);
			   
				   -- set Var_Stokawal = (select stock from variation_product where Id_variation = Var_Id_variation);
				   -- set Var_Stokakhir  = Var_Stokawal - Var_Debet;
				   update variation_product set Stock =  Var2_First_stock-pengurangan where Id_variation = Var2_Id_variation;
				
				end if;
				 end loop read_loop2; 
				 close stock_card;    			  
		  END BLOCK2;
     end if;
   end loop read_loop; 
   close receive_expire;
   
   END BLOCK1;
 
 end if; 
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_card`
--

CREATE TABLE `stock_card` (
  `Id_stock_card` int(11) NOT NULL,
  `Date_card` date NOT NULL,
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

--
-- Dumping data untuk tabel `stock_card`
--

INSERT INTO `stock_card` (`Id_stock_card`, `Date_card`, `Id_product`, `Id_variation`, `Expire_date`, `Type_card`, `No_reference`, `First_stock`, `Debet`, `Credit`, `Last_stock`, `Transaction_price`, `Capital`, `Fifo_stock`) VALUES
(55, '2021-08-04', 42, 62, '2021-08-14', 'Purchase', '236', 0, 20, 0, 20, 15000, 15000, 0),
(56, '2021-08-04', 42, 62, '2021-08-05', 'Purchase', '237', 20, 20, 0, 40, 15000, 15000, 0),
(57, '2021-08-04', 42, 62, '2021-08-27', 'Purchase', '238', 40, 20, 0, 60, 15000, 15000, 0),
(58, '2021-08-04', 42, 62, '2021-11-06', 'Purchase', '239', 60, 20, 0, 80, 15000, 15000, 0),
(59, '2021-08-04', 42, 62, '2021-11-16', 'Purchase', '240', 80, 20, 0, 100, 15000, 15000, 0),
(60, '2021-08-04', 40, 40, '2021-11-24', 'Purchase', '241', 0, 25, 0, 25, 25000, 25000, 0),
(61, '2021-08-04', 40, 40, '2021-12-24', 'Purchase', '242', 25, 25, 0, 50, 25000, 25000, 0),
(62, '2021-08-04', 40, 40, '2021-12-29', 'Purchase', '243', 50, 25, 0, 75, 25000, 25000, 0),
(63, '2021-08-04', 40, 40, '2021-12-04', 'Purchase', '244', 75, 25, 0, 100, 25000, 25000, 0),
(64, '2021-08-04', 42, 62, '2021-08-14', 'Receive Void', '236', 100, 0, 20, 80, 0, 0, 0),
(65, '2021-08-04', 42, 62, '2021-08-05', 'Receive Void', '237', 80, 0, 20, 60, 0, 0, 0),
(66, '2021-08-04', 42, 62, '2021-08-27', 'Receive Void', '238', 60, 0, 20, 40, 0, 0, 0),
(67, '2021-08-04', 42, 62, '2021-11-06', 'Receive Void', '239', 40, 0, 20, 20, 0, 0, 0),
(68, '2021-08-04', 42, 62, '2021-11-16', 'Receive Void', '240', 20, 0, 20, 0, 0, 0, 0),
(69, '2021-08-04', 40, 40, '2021-11-24', 'Receive Void', '241', 100, 0, 25, 75, 0, 0, 0),
(70, '2021-08-04', 40, 40, '2021-12-24', 'Receive Void', '242', 75, 0, 25, 50, 0, 0, 0),
(71, '2021-08-04', 40, 40, '2021-12-29', 'Receive Void', '243', 50, 0, 25, 25, 0, 0, 0),
(72, '2021-08-04', 40, 40, '2021-12-04', 'Receive Void', '244', 25, 0, 25, 0, 0, 0, 0),
(73, '2021-08-04', 42, 62, '2021-08-26', 'Purchase', '245', 0, 50, 0, 50, 15000, 15000, 0),
(74, '2021-08-04', 42, 62, '2021-08-28', 'Purchase', '246', 50, 10, 0, 60, 15000, 15000, 0),
(75, '2021-08-04', 42, 62, '2021-10-15', 'Purchase', '247', 60, 40, 0, 100, 15000, 15000, 0),
(76, '2021-08-04', 42, 62, '2021-08-25', 'Purchase', '248', 100, 10, 0, 110, 15000, 15000, 0),
(77, '2021-08-04', 42, 62, '2021-08-26', 'Purchase', '249', 110, 10, 0, 120, 15000, 15000, 0),
(78, '2021-08-04', 42, 62, '2021-08-28', 'Purchase', '250', 120, 10, 0, 130, 15000, 15000, 0),
(79, '2021-08-04', 42, 62, '2021-08-25', 'Receive Void', '248', 130, 0, 10, 120, 0, 0, 0),
(80, '2021-08-04', 42, 62, '2021-08-26', 'Receive Void', '249', 120, 0, 10, 110, 0, 0, 0),
(81, '2021-08-04', 42, 62, '2021-08-28', 'Receive Void', '250', 110, 0, 10, 100, 0, 0, 0),
(82, '2021-08-04', 42, 62, '2022-10-22', 'Purchase', '251', 100, 10, 0, 110, 15000, 15000, 0),
(83, '2021-08-04', 42, 62, '2022-10-22', 'Purchase', '252', 110, 10, 0, 120, 15000, 15000, 0),
(84, '2021-08-04', 42, 62, '2022-11-17', 'Purchase', '253', 120, 10, 0, 130, 15000, 15000, 0),
(85, '2021-08-04', 42, 62, '2022-11-21', 'Purchase', '254', 130, 10, 0, 140, 15000, 15000, 0),
(86, '2021-08-04', 42, 62, '2022-11-24', 'Purchase', '255', 140, 10, 0, 150, 15000, 15000, 0),
(87, '2021-08-04', 42, 62, '2021-08-21', 'Purchase', '256', 150, 10, 0, 160, 15000, 15000, 0),
(88, '2021-08-04', 42, 62, '2021-08-30', 'Purchase', '257', 160, 10, 0, 170, 15000, 15000, 0),
(89, '2021-08-04', 42, 62, '2022-10-22', 'Receive Void', '251', 170, 0, 10, 160, 0, 0, 0),
(90, '2021-08-04', 42, 62, '2022-10-22', 'Receive Void', '252', 160, 0, 10, 150, 0, 0, 0),
(91, '2021-08-04', 42, 62, '2022-11-17', 'Receive Void', '253', 150, 0, 10, 140, 0, 0, 0),
(92, '2021-08-04', 42, 62, '2022-11-21', 'Receive Void', '254', 140, 0, 10, 130, 0, 0, 0),
(93, '2021-08-04', 42, 62, '2022-11-24', 'Receive Void', '255', 130, 0, 10, 120, 0, 0, 0),
(94, '2021-08-04', 42, 62, '2021-08-25', 'Purchase', '258', 120, 50, 0, 170, 15000, 15000, 0),
(95, '2021-08-04', 42, 62, '2021-08-20', 'Purchase', '259', 170, 50, 0, 220, 15000, 15000, 0),
(96, '2021-08-04', 40, 40, '2021-09-23', 'Purchase', '260', 0, 100, 0, 100, 25000, 25000, 0),
(97, '2021-08-04', 42, 62, '2021-08-25', 'Receive Void', '258', 220, 0, 50, 170, 0, 0, 0),
(98, '2021-08-04', 42, 62, '2021-08-20', 'Receive Void', '259', 170, 0, 50, 120, 0, 0, 0),
(99, '2021-08-04', 40, 40, '2021-09-23', 'Receive Void', '260', 100, 0, 100, 0, 0, 0, 0),
(100, '2021-08-04', 42, 62, '2021-08-21', 'Receive Void', '256', 120, 0, 10, 110, 0, 0, 0),
(101, '2021-08-04', 42, 62, '2021-08-30', 'Receive Void', '257', 110, 0, 10, 100, 0, 0, 0),
(102, '2021-08-04', 42, 62, '2021-08-26', 'Receive Void', '245', 100, 0, 40, 60, 0, 0, 0),
(103, '2021-08-04', 42, 62, '2021-08-26', 'Receive Void', '245', 60, 0, 10, 50, 0, 0, 0),
(104, '2021-08-04', 42, 62, '2021-08-28', 'Receive Void', '246', 50, 0, 10, 40, 0, 0, 0),
(105, '2021-08-04', 42, 62, '2021-10-15', 'Receive Void', '247', 40, 0, 40, 0, 0, 0, 0),
(106, '2021-08-04', 40, 40, '2021-08-20', 'Purchase', '261', 0, 25, 0, 25, 25000, 25000, 0),
(107, '2021-08-04', 40, 40, '2021-08-26', 'Purchase', '262', 25, 25, 0, 50, 25000, 25000, 0),
(108, '2021-08-04', 40, 40, '2021-08-28', 'Purchase', '263', 50, 25, 0, 75, 25000, 25000, 0),
(109, '2021-08-04', 40, 40, '2021-10-22', 'Purchase', '264', 75, 25, 0, 100, 25000, 25000, 0),
(110, '2021-08-04', 40, 40, '2021-08-28', 'Receive Void', '263', 100, 0, 25, 75, 0, 0, 0),
(111, '2021-08-04', 40, 40, '2021-10-22', 'Receive Void', '264', 75, 0, 25, 50, 0, 0, 0),
(112, '2021-08-04', 40, 40, '2021-08-20', 'Receive Void', '261', 50, 0, 25, 25, 0, 0, 0),
(113, '2021-08-04', 40, 40, '2021-08-26', 'Receive Void', '262', 25, 0, 25, 0, 0, 0, 0),
(114, '2021-08-05', 40, 40, '2021-08-28', 'Purchase', '265', 0, 25, 0, 25, 25000, 25000, 25),
(115, '2021-08-05', 40, 40, '2021-08-31', 'Purchase', '266', 25, 25, 0, 50, 25000, 25000, 25);

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
(36, 20, 42, 1),
(37, 20, 40, 1);

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
  `Stock_atc` int(11) NOT NULL,
  `Stock_pay` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `variation_product`
--

INSERT INTO `variation_product` (`Id_variation`, `Id_product`, `Variation_name`, `Option_name`, `Purchase_price`, `Sell_price`, `Weight`, `Dimension`, `Stock`, `Stock_atc`, `Stock_pay`, `Status`) VALUES
(26, 38, 'UKURAN', '', 3333, 179000, 150, '10X5X3', 100, 0, 0, 0),
(27, 38, 'UKURAN', '', 3333, 179000, 150, '10X5X3', 100, 0, 0, 0),
(30, 39, 'NONE', 'NONE', 3333, 120000, 100, '10X5X12', 100, 0, 0, 0),
(32, 39, 'UKURAN', '30 ML', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(33, 39, 'UKURAN', '50 ML', 3333, 175000, 250, '10X11X13', 200, 0, 0, 0),
(34, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(35, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(36, 39, 'UKURAN', '100 ML', 3333, 200000, 500, '1X5X9', 20, 0, 0, 0),
(37, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(38, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(39, 39, 'UKURAN', '', 3333, 150000, 100, '12X11X15', 100, 0, 0, 0),
(40, 40, 'NONE', 'NONE', 25000, 190000, 100, '5X6X9', 50, 0, 0, 1),
(41, 38, 'NONE', 'NONE', 3333, 179000, 150, '10X5X3', 500, 0, 0, 0),
(42, 38, 'TIPE', '1 BOX', 3333, 179000, 100, '5X3X2', 100, 0, 0, 0),
(43, 38, 'TIPE', '3 BOX', 3333, 350000, 300, '15X9X6', 250, 0, 0, 0),
(44, 38, 'NONE', 'NONE', 3333, 179000, 100, '5X3X2', 100, 0, 0, 0),
(45, 38, 'NONE', 'NONE', 3333, 179000, 100, '5X3X2', 100, 0, 0, 0),
(46, 38, 'TIPE', '1 BOX', 3333, 1, 1, '1X1X1', 1, 0, 0, 0),
(47, 38, 'TIPE', '3 BOX', 3333, 2, 2, '2X2X2', 2, 0, 0, 0),
(48, 38, 'TIPE', 'ADA', 3333, 3, 3, '3X3X3', 3, 0, 0, 0),
(49, 38, 'TIPE', 'ADA2', 3333, 1, 1, '1X1X1', 1, 0, 0, 0),
(50, 38, 'TIPE', 'ADA3', 3333, 60000, 10, '1X5X6', 10, 0, 0, 0),
(51, 39, 'UKURAN', 'ADA', 3333, 1, 1, '1X1X1', 1, 0, 0, 0),
(52, 39, 'UKURAN', 'ADA', 15000, 1, 1, '1X1X1', 0, 0, 0, 1),
(53, 38, 'TIPE', 'ADA', 3333, 160000, 50, '5X6X9', 500, 0, 0, 0),
(54, 38, 'TIPE', 'ADA2', 3333, 1, 1, '1X1X1', 1, 0, 0, 0),
(55, 38, 'TIPE', 'ADA4', 3333, 170000, 300, '6X9X70', 600, 0, 0, 0),
(56, 38, 'NONE', 'NONE', 3333, 60000, 10, '1X5X6', 10, 0, 0, 0),
(57, 38, 'ABC', 'ADA', 8000, 1, 1, '1X1X1', 0, 0, 0, 1),
(58, 38, 'ABC', 'ADA2', 50000, 1, 1, '1X1X1', 0, 0, 0, 1),
(59, 41, 'UKURAN', '50GR', 50000, 150000, 100, '10X5X9', 0, 0, 0, 1),
(60, 41, 'UKURAN', '100 GR', 70000, 170000, 150, '12X7X11', 500, 0, 0, 0),
(61, 42, 'NONE', 'NONE', 80000, 180000, 100, '5X6X9', 100, 0, 0, 0),
(62, 42, 'UKURAN', '50GR', 15000, 180000, 100, '5X6X9', 0, 0, 0, 1),
(63, 42, 'UKURAN', '100GR', 20000, 200000, 150, '6X9X10', 500, 0, 0, 0),
(64, 43, 'NONE', 'NONE', 150000, 250000, 300, '20X15X6', 500, 0, 0, 0),
(65, 43, 'UKURAN', '150 BIJI', 50000, 150000, 100, '15X4X3', 0, 0, 0, 1),
(66, 43, 'UKURAN', '350 BIJI', 200000, 400000, 200, '30X8X6', 0, 0, 0, 1);

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
-- Indeks untuk tabel `promo_detail`
--
ALTER TABLE `promo_detail`
  ADD PRIMARY KEY (`Id_promo_detail`);

--
-- Indeks untuk tabel `promo_header`
--
ALTER TABLE `promo_header`
  ADD PRIMARY KEY (`Id_promo`);

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
-- Indeks untuk tabel `purchase_payment`
--
ALTER TABLE `purchase_payment`
  ADD PRIMARY KEY (`Id_purchase_payment`);

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
  MODIFY `Id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `product_affiliate`
--
ALTER TABLE `product_affiliate`
  MODIFY `Id_product_affiliate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `Id_product_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `promo_detail`
--
ALTER TABLE `promo_detail`
  MODIFY `Id_promo_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `promo_header`
--
ALTER TABLE `promo_header`
  MODIFY `Id_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `No_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT untuk tabel `receive_detail`
--
ALTER TABLE `receive_detail`
  MODIFY `No_receive_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT untuk tabel `receive_expire`
--
ALTER TABLE `receive_expire`
  MODIFY `No_receive_expire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT untuk tabel `stock_card`
--
ALTER TABLE `stock_card`
  MODIFY `Id_stock_card` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

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
  MODIFY `Id_supplier_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `Id_variation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
