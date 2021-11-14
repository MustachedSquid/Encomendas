-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 28, 2021 at 12:59 PM
-- Server version: 10.3.29-MariaDB-0+deb10u1
-- PHP Version: 7.3.29-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Encomendas`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bolos`
--

CREATE TABLE `Bolos` (
  `id` int(11) NOT NULL,
  `bolo` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `comentario` varchar(1000) NOT NULL,
  `id_enc` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `estado` int(11) NOT NULL,
  `total` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Encomendas`
--

CREATE TABLE `Encomendas` (
  `id` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `nome_cliente` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Precos`
--

CREATE TABLE `Precos` (
  `bolo` varchar(100) NOT NULL,
  `preco` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Precos`
--

INSERT INTO `Precos` (`bolo`, `preco`) VALUES
('Doce Fino', 0.80),
('Queijinhos', 0.90),
('Animais', 1.00),
('D. Rodrigo', 0.90),
('Morgadinho', 1.00),
('Papo-seco', 0.80),
('Almendrado', 0.50),
('KG Doce Fino', 29.00),
('KG Morgado', 35.00),
('KG Torta Doce Fino', 27.00),
('KG Massa', 18.50),
('KG Fios de Ovos', 17.00);

-- --------------------------------------------------------

--
-- Table structure for table `Utilizadores`
--

CREATE TABLE `Utilizadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Utilizadores`
--

INSERT INTO `Utilizadores` (`id`, `nome`, `password`) VALUES
(1, 'user', 'b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bolos`
--
ALTER TABLE `Bolos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Encomendas`
--
ALTER TABLE `Encomendas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Utilizadores`
--
ALTER TABLE `Utilizadores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bolos`
--
ALTER TABLE `Bolos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Encomendas`
--
ALTER TABLE `Encomendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Utilizadores`
--
ALTER TABLE `Utilizadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
