-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 29, 2018 at 01:52 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-idm`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id-order` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id-book` int(11) NOT NULL,
  `date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `order-no` int(11) NOT NULL,
  `flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id-order`, `username`, `id-book`, `date`, `quantity`, `order-no`, `flag`) VALUES
(1108, '@tayotayo', 11102, '2018-07-21', 0, 0, 0),
(1120, '@ivanf', 11102, '2018-09-01', 0, 0, 0),
(1145, '@ivanf', 1114, '2018-08-17', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id-review` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id-book` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `id-order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id-review`, `content`, `id-book`, `username`, `rating`, `id-order`) VALUES
(12340, 'wah, gile deh ... penuh hikmah banget nih buku. bahwa kita -manusia- saling berhubungan satu dengan yang lainnya. kita menjadi sebab dan akibat dari perjalanan atau siklus hidup seseorang. ', 1114, '@ivanf', 4, 1108),
(12342, 'Jujur ini buku pertama Tere Liye yang saya baca :)\r\n', 11122, '@tayotayo', 3, 0),
(12343, 'Ini buku penulis ini yg pertama gw baca. Setelah sebelumnya banyak yg recommend Hafalan Delisa. Luar biasa.', 1118, '@ivanf', 5, 1145),
(12345, 'Seperti ada scene di Film India Mohabbatein... Pas Ray dirumah sakit melukai tangannya dengan pecahan kaca biar di obati sama si cewe...', 11102, '@tayotayo', 5, 1108),
(12349, 'Ceritanya menyentuh perasaan namun banyak manfaat yang dapat saya ambil.', 11102, '@tayotayo', 4, 1120);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone-number` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rekening` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `name`, `email`, `password`, `address`, `phone-number`, `avatar`, `rekening`) VALUES
('@dandyR', 'Dandy', 'dandi@itb.com', 'dandan', 'goreng', '0298082803808', 'avatar15.jpg', 1),
('@ivanf', 'Aiven Fadillah', 'ifadillah90@gmail.com', 'goreng', 'Jl. Ganesha No. 7', '085261100940', 'ivan.jpg', 2),
('@tayotayo', 'Tayo the Little  Bus', 'tayo@littlebus.com', 'goreng', '120 garage street ', '081234567988', 'tayo.jpg', 3),
('alghi', 'Mochamad Alghifari', 'alghi@gmail.com', 'qwerty', 'Bandung', '08888888888', 'avatar9.jpg', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id-order`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id-review`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `rekening` (`rekening`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id-order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1146;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id-review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12350;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
