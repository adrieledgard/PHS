-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2021 pada 05.59
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
(10, 'DINA', 'DINA@GMAIL.COM', '08718808', 'qwerty1234', 'ADMIN'),
(13, 'POPPY', 'POPPY@GMAIL.COM', '087845990074', 'qwerty1234', 'CUSTOMER SERVICE'),
(14, 'OPPA', 'OPPA@GMAIL.COM', '08721113111', 'qwerty1234', 'SHIPPER'),
(15, 'TITO', 'TITO123@GMAIL.COM', '08756166311', 'qwerty1234', 'CUSTOMER SERVICE'),
(16, 'SITI_NURBAYA', 'SITINURBAYA@GMAIL.COM', '08785099420', 'qwerty1234', 'ADMIN'),
(17, 'LISA_AYU', 'LISA@GMAIL.COM', '0878422025', 'qwerty1234', 'ADMIN'),
(18, 'FUJANG', 'FUJANG123@GMAIL.COM', '08126717171', 'qwerty1234', 'CUSTOMER SERVICE'),
(19, 'IDAFAM', 'IDAFAM123@GMAIL.COM', '08712345', 'ABCD1234', 'ADMIN'),
(20, 'FIKA', 'FIKA123@GMAIL.COM', '08451508408', 'qwerty1234', 'CUSTOMER SERVICE'),
(21, 'VAGI', 'VAGI@GMAIL.COM', '08712812811', 'qwerty1234', 'ADMIN'),
(22, 'TARA', 'TARA@GMAIL.COM', '08761291281', 'qwerty1234', 'ADMIN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `Id_product` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Id_category` varchar(10) NOT NULL,
  `Id_sub_category` varchar(10) NOT NULL,
  `Unit` varchar(100) NOT NULL,
  `Purchase_price` int(11) NOT NULL,
  `Sell_price` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  `How_to_use` varchar(300) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Status` int(11) NOT NULL,
  `Picture` varchar(500) NOT NULL
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
(3, '3', 'LMBG', 'LAMBUNG');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id_category`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Id_member`);

--
-- Indeks untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`Id_sub_category`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `Id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `Id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `Id_sub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
