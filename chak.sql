-- phpMyAdmin SQL Dump
-- version 5.2.1deb1ubuntu0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 13/04/2026 às 00:29
-- Versão do servidor: 8.0.45-0ubuntu0.24.04.1
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `chak`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

CREATE TABLE `acessos` (
  `id` int NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `povedor` varchar(100) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `hora` datetime DEFAULT NULL,
  `cont` int DEFAULT '0',
  `identity` varchar(100) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `id_usuario` varchar(50) DEFAULT NULL,
  `device` varchar(100) DEFAULT NULL,
  `RedeBlocked` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `acessos`
--

INSERT INTO `acessos` (`id`, `ip`, `povedor`, `pais`, `hora`, `cont`, `identity`, `page`, `id_usuario`, `device`, `RedeBlocked`) VALUES
(1, '2804:214:9063:5149:acbf:8b33:1a2d:1d61', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:21:06', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(2, '177.18.69.64', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:24:17', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(3, '170.247.38.155', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:25:11', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(4, '177.23.180.244', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:26:03', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(5, '200.50.155.86', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:26:15', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(6, '192.144.148.122', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:26:25', 1, 'chakal', 'veiculosmg', '1', 'mobile', ''),
(7, '66.249.92.193', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:34:59', 1, 'profesor', 'IPSP', '21', 'desktop', ''),
(8, '2804:14c:a2:8313:534a:2873:135f:a984', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:39:46', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(9, '45.230.128.126', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:45:27', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(10, '2804:5e44:21cb:a200:c908:7f22:1376:2ef3', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:43:56', 5, 'profesor', 'IPSP', '21', 'mobile', ''),
(11, '2804:2540:8967:4f00:7039:245c:a8e1:1585', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:49:04', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(12, '2804:38a:a00a:c734:0:27:f7d9:5e01', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:04:00', 7, 'profesor', 'IPSP', '21', 'mobile', ''),
(13, '131.196.104.119', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:53:25', 5, 'profesor', 'IPSP', '21', 'mobile', ''),
(14, '2804:389:c2b9:43c1:a0dc:78af:d621:b287', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:54:03', 1, 'careca1', 'lPVAPR', '18', 'bot', '1'),
(15, '2804:1b3:a381:12ec:a96b:c21d:4c64:2e09', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:54:31', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(16, '189.98.248.156', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:55:37', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(17, '2804:18:147:3138:7944:f562:15ba:1186', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:55:40', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(18, '2804:7f0:b242:a5b2:5dc7:a38f:5865:aca3', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:59:01', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(19, '66.249.92.133', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:58:59', 1, 'profesor', 'IPSP', '21', 'desktop', ''),
(20, '2804:1b3:aac1:3510:f08e:cfe5:4923:59b6', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:02:16', 6, 'profesor', 'IPSP', '21', 'mobile', ''),
(21, '191.242.44.107', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 19:59:10', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(22, '179.146.55.10', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:02:25', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(23, '2804:460c:862c:4500:9e6e:6622:a42d:297a', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:01:06', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(24, '2804:4e28:8160:3800:1e3f:cfc4:d039:4bbd', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:01:28', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(25, '170.247.38.206', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:04:24', 6, 'profesor', 'IPSP', '21', 'mobile', ''),
(26, '2804:18:909:21a1:6cfe:5993:f09a:463', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:02:39', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(27, '2804:7f0:18:3d83:b2cf:6570:e170:4f8', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:03:40', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(28, '45.234.109.183', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:04:10', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(29, '187.94.205.181', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:04:10', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(30, '2804:3454:700:be4f:bb57:39f2:4f6f:5687', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:04:49', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(31, '2804:214:92e6:3189:985:8926:e98f:140e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:10:15', 6, 'profesor', 'IPSP', '21', 'mobile', ''),
(32, '2804:14c:126:4485:d162:63f4:68e2:5378', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:09:08', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(33, '170.78.248.120', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:12', 7, 'profesor', 'IPSP', '21', 'mobile', ''),
(34, '177.143.5.103', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:09:27', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(35, '2804:1ec4:90:7100:381e:aef4:b0e9:a344', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:14:23', 9, 'profesor', 'IPSP', '21', 'mobile', ''),
(36, '2804:389:108d:30ea:5863:52ff:fed3:6445', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:11:57', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(37, '131.72.70.158', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:11:22', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(38, '2804:523c:fffe:d6e0:c1d1:7cd:bab:951e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:21:54', 8, 'profesor', 'IPSP', '21', 'mobile', ''),
(39, '2804:4f60:7ef6:ef00:2561:89bb:eae4:2c32', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:15:31', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(40, '200.185.239.39', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:13:07', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(41, '2804:47e4:8844:3000:e4f7:b4ec:cffb:8b43', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:13:37', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(42, '2804:4390:2004:9800:e5c2:e47e:1b7b:5925', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:14:33', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(43, '2804:2d60:d007:b100:199f:a16:88d6:a15c', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:31:26', 5, 'profesor', 'IPSP', '21', 'mobile', ''),
(44, '181.191.46.20', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:15:04', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(45, '2804:388:c2e9:c04e:d042:49ff:fe34:7003', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:16:41', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(46, '2804:214:82bb:ba9b:303c:80ff:fe15:71f0', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:17:12', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(47, '2804:7f0:45d:8d5:6c7c:698d:1f66:5217', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:17:12', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(48, '2804:38a:a08d:8162:295e:3bf8:4fac:850f', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:17:33', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(49, '2804:108c:d9a2:2701:302d:59f8:ca24:6aa8', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:17:50', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(50, '179.246.208.141', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:21:01', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(51, '143.208.179.14', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:18:27', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(52, '168.227.103.32', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:18:15', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(53, '2804:1b1:f9c0:b420:8de0:597d:7474:19c', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:18:15', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(54, '177.129.212.115', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:28:15', 9, 'profesor', 'IPSP', '21', 'mobile', ''),
(55, '2804:2d60:d007:b100:6cb4:f57e:bd31:6ccc', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:20:23', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(56, '2804:388:c35d:bf12:2423:896:1aa:324e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:19:00', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(57, '2804:868:d053:f3f1:3b33:4e06:2ea2:ce39', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:19:41', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(58, '187.49.211.73', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:22:03', 3, 'profesor', 'IPSP', '21', 'desktop', ''),
(59, '189.91.54.126', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:20:01', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(60, '187.115.242.101', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:20:25', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(61, '2804:38a:a0a0:693b:25e1:2396:84:2b0a', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:21:58', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(62, '177.188.24.162', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:21:44', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(63, '2804:23c:e6b:6800:2751:ac7e:ae1e:70ff', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:22:22', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(64, '2804:7f0:d81e:1753:3c9b:8da7:8a3:5c7f', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:30:31', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(65, '2804:14c:1c5:80df:f4f2:a302:cc74:e1c9', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:09', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(66, '2804:14c:bf50:8de5:682b:77a2:d422:c520', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:55', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(67, '187.101.80.132', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:21', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(68, '2804:1e78:e000:4830:966a:a43a:4395:3f85', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:40', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(69, '2804:14d:1c79:8372:a20d:4141:289a:597e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:23:41', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(70, '2804:214:9a86:2e3d:18a5:bb70:bc12:b938', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:31:45', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(71, '177.170.97.3', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:24:33', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(72, '45.180.96.243', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:24:32', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(73, '190.83.87.100', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:24:38', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(74, '2804:18:5041:7cd5:1:0:8bb3:71c6', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:25:08', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(75, '45.232.231.119', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:25:21', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(76, '186.194.152.86', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:33:50', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(77, '2804:10c4:f7a2:a28c:77ff:51fa:e734:94a6', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:26:40', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(78, '43.130.228.73', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:26:46', 1, 'profesor', 'lPVAPR', '21', 'mobile', ''),
(79, '168.181.51.143', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:30:13', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(80, '131.72.95.122', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:28:19', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(81, '2804:6798:c0f4:b700:139c:c2a9:b517:6dc5', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:28:30', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(82, '177.37.22.201', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:29:07', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(83, '2804:14d:32d3:8d16:70c2:61ff:fd90:9bd1', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:29:47', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(84, '2804:7f0:9a81:8e57:3649:445e:dc01:3af7', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:29:47', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(85, '2804:388:c3ff:856d:9e90:3a46:20a5:a416', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:30:19', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(86, '2804:214:82dd:c93f:1:1:6c26:d38a', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:55', 5, 'profesor', 'IPSP', '21', 'mobile', ''),
(87, '2804:fec:d495:a800:5d35:c8c4:d2a3:6a07', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:31:05', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(88, '2804:2e8:8009:3900:4442:3ba9:b86a:b153', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:30:35', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(89, '2804:14c:90:9b78:4479:338d:6416:fb28', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:30:38', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(90, '177.21.78.250', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:24', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(91, '2804:38a:a137:ee06:1129:b431:2f2e:acbe', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:31:15', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(92, '2804:868:d042:af2c:83f6:d27b:908c:145d', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:31:32', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(93, '152.250.139.42', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:32', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(94, '2804:71d4:a087:6fe0:78ea:46a4:11df:efc5', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:15', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(95, '45.230.106.1', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:10', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(96, '189.39.180.60', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:21', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(97, '2804:5f0c:12ad:1500:19f4:9165:5464:db6c', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:32:22', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(98, '179.125.132.153', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:24', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(99, '2804:30c:2f7b:a901:2d9a:b67f:3ad0:4e9f', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:35:37', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(100, '2804:214:8112:8bbc:8962:7bcd:426c:3591', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:33:42', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(101, '201.182.169.74', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:37:12', 10, 'profesor', 'IPSP', '21', 'mobile', ''),
(102, '2804:14d:3289:8038:4603:b933:9992:2b68', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:04', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(103, '2804:30c:870:cf00:cd5b:da86:4f84:9fc2', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:13', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(104, '2804:14c:97:a034:5c5f:8018:a7af:6f98', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:06', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(105, '179.109.95.238', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:13', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(106, '2804:14d:785f:a47d:84cf:203e:fdfa:8250', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:22', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(107, '2804:53d4:820:5300:1fd2:8385:8264:2143', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:34:50', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(108, '2804:214:992b:9a2:f9e0:c85d:53bf:b5f3', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:40:27', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(109, '2804:389:f2b4:563:81ec:6ee4:8a07:469a', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:13', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(110, '2804:14d:8ca3:8482:59d2:5fc9:4e2f:8e06', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 21:25:18', 11, 'profesor', 'IPSP', '21', 'desktop', ''),
(111, '2804:e54:2000:b479:5219:1db8:7c86:1fb1', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:37:44', 4, 'profesor', 'IPSP', '21', 'mobile', ''),
(112, '2804:7f0:9e40:10f7:eddd:9bce:6075:5553', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:44', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(113, '2804:7f0:9e40:10f7:eddd:9bce:6075:5553', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:44', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(114, '2804:56c:c27e:d000:d4cc:1c74:d226:ed17', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:40', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(115, '177.195.153.181', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:48', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(116, '2804:389:e179:a209:4957:3ed9:bf16:e346', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:36:50', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(117, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 21:23:50', 2, 'profesor', 'IPSP', '21', 'desktop', ''),
(118, '191.254.209.99', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:38:40', 5, 'profesor', 'IPSP', '21', 'desktop', ''),
(119, '177.37.165.70', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:37:57', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(120, '2804:8cc:1102:6400:bc56:38bb:115e:ef1e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:38:26', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(121, '2804:f44:636:9e00:113e:f3be:d38a:2946', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:40:25', 3, 'profesor', 'IPSP', '21', 'mobile', ''),
(122, '2804:3810:3e5:7f00:9055:fdab:d49:a388', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:41:12', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(123, '200.53.205.156', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:41:36', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(125, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:51:26', 2, 'profesor', 'lPVAPR', '21', 'desktop', ''),
(126, '2804:59a0:18ce:4000:c936:ce3:58ae:f61e', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:51:43', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(127, '2804:18:15e:56ce:18a5:c001:389b:86a3', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:52:38', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(128, '2804:18:860:cf90:1:0:ff37:bd75', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:55:02', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(129, '2804:e54:200d:80ea:6d6a:4e07:471a:3cad', 'Desconhecido', 'No - No - Desconhecido', '2026-04-12 20:58:38', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(131, '138.97.197.67', 'AS264195 VAMO TELECOM', 'São José da Laje - Alagoas - BR', '2026-04-12 21:04:38', 1, 'profesor', 'IPSP', '21', 'mobile', ''),
(132, '200.173.172.172', 'AS4230 CLARO S.A.', 'São Paulo - São Paulo - BR', '2026-04-12 21:04:48', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(133, '74.125.210.7', 'AS15169 Google LLC', 'Moncks Corner - South Carolina - US', '2026-04-12 21:04:46', 1, 'profesor', 'IPSP', '21', 'mobile', '1'),
(134, '66.249.85.38', 'AS15169 Google LLC', 'Santiago - Santiago Metropolitan - CL', '2026-04-12 21:04:49', 1, 'profesor', 'IPSP', '21', 'mobile', '1'),
(136, '2804:6194:1f52:c900:1a61:46f:36e4:d7a0', 'AS269243 REDEVISTA TELECOMUNICACOES LTDA', 'Corumbá - Mato Grosso do Sul - BR', '2026-04-12 21:06:19', 2, 'profesor', 'IPSP', '21', 'mobile', ''),
(137, '190.12.129.166', 'AS271281 Ainet internet eamp;informatica ltda', 'Imperatriz - Maranhão - BR', '2026-04-12 21:19:34', 2, 'Detran', 'lPVAPR', '22', 'desktop', ''),
(138, '66.249.66.193', 'AS15169 Google LLC', 'Charlotte - North Carolina - US', '2026-04-12 21:18:44', 1, 'profesor', 'IPSP', '21', 'bot', '1'),
(139, '177.173.208.156', 'AS26599 TELEFÔNICA BRASIL S.A', 'Curitiba - Paraná - BR', '2026-04-12 21:22:53', 1, 'Detran', 'lPVAPR', '22', 'mobile', ''),
(140, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'AS28191 Jupiter Telecomunicacoes e Informatica Ltda', 'Imperatriz - Maranhão - BR', '2026-04-12 21:22:56', 1, 'profesor', 'veiculosmg', '21', 'desktop', ''),
(141, '2804:18:1905:3896:101f:5428:ef24:7784', 'AS26599 TELEFÔNICA BRASIL S.A', 'Campinas - São Paulo - BR', '2026-04-12 21:24:22', 1, 'Detran', 'lPVAPR', '22', 'mobile', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id` int NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `public_key` varchar(255) NOT NULL,
  `web_router_url` varchar(255) NOT NULL,
  `api_endpoint` varchar(255) DEFAULT NULL,
  `webhook_url` varchar(255) DEFAULT NULL,
  `last_saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` varchar(50) DEFAULT NULL,
  `Plataforma` varchar(50) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `chave` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `secret_key`, `public_key`, `web_router_url`, `api_endpoint`, `webhook_url`, `last_saved`, `id_usuario`, `Plataforma`, `nome`, `cidade`, `chave`) VALUES
(1, '', '', '', '', 'https://mago.ctrix.shop/webhooks/amorapay.php?id=16', '2026-02-07 18:55:24', '16', 'chavepix', 'A', 'B', '05c1c27e-a419-4b31-8041-3dd9e27d99be'),
(8, '0', '0', '', '', '0', NULL, '15', 'chavepix', 'A', 'B', '483dbc02-28db-42a8-8e41-c16f0150cbc5'),
(9, 'A', 'B', '', '', 'C', NULL, '17', 'chavepix', 'A', 'B', '6d6f2c6e-ca04-407a-90b7-b647ce373c58'),
(10, '', '', '', '', 'https://app.podpay.app/', '2026-04-09 14:08:56', '18', 'chavepix', 'PR', 'PARANA', '9220bf05-4a47-46e8-888b-12da1b2237a4'),
(11, '', '', '', '', 'https://777.base-painel.online/webhooks/nuviapay.php?id=1', '2026-02-06 21:12:20', '1', 'chavepix', 'EXER2025', 'GOIAS', 'a4abcbaa-9491-47e2-a8f1-1fcdf861a49c'),
(12, '', '', '', '', 'https://app.nuviapay.com/auth/login', NULL, '19', 'chavepix', 'Detran PR', 'Brasil', 'b3a8c118-4021-46da-bf3f-c091307d7ddb'),
(13, '', '', '', '', 'https://app.nuviapay.com/docs/intro/first-steps', '2026-04-13 00:12:08', '21', 'chavepix', 'Detran SP', 'SAO PALO', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(14, '', '', '', '', '', NULL, '20', 'chavepix', 'PGMEI', 'Brasil', '2f1d57f8-4340-4d60-81a9-dbb92c534e84'),
(15, '', '', '', '', 'https://777.base-painel.online/painel/', NULL, '22', 'chavepix', 'PR', 'PARANA', '1017baa2-19c1-4b0e-8ac3-543df83a16ea'),
(16, '', '', '', '', '', NULL, '23', 'chavepix', 'ELEKTRO', 'Brasil', 'c113bcb3-ee5b-4efa-9ebd-80203b36c220'),
(17, '', '', '', '', '', '2026-03-26 20:48:01', '24', 'chavepix', 'PGMEI', 'Brasil', '9fc829ad-0a4a-4235-91db-d808b18a9945'),
(18, '', '', '', '', '', NULL, '26', 'chavepix', 'PGMEI', 'Brasil', '4a677007-a9ee-4383-9c5e-763015b50a7f');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dominios`
--

CREATE TABLE `dominios` (
  `id_dominio` int UNSIGNED NOT NULL,
  `id_usuario` int UNSIGNED NOT NULL,
  `nome_dominio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretorio_raiz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ativo','inativo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `dominios`
--

INSERT INTO `dominios` (`id_dominio`, `id_usuario`, `nome_dominio`, `diretorio_raiz`, `status`, `criado_em`, `atualizado_em`, `page`, `tp`) VALUES
(28, 18, 'pgmeii.pag-mei.online', 'pages/pgmei', 'ativo', '2025-10-13 14:28:46', '2026-03-23 13:36:54', 'pgmei', NULL),
(29, 1, 'expresso-goias.licenciamentos.online', 'pages/IpGo', 'ativo', '2025-10-16 20:59:35', '2026-02-06 05:50:58', 'Detran Go', NULL),
(30, 1, 'neoenergia.das-simples.online', 'pages/neoenergia', 'ativo', '2025-10-24 15:25:36', '2026-02-27 12:35:02', 'pgmei', NULL),
(31, 18, 'detran-pr.licenciamentos.online', 'pages/lPVAPR', 'ativo', '2026-01-18 17:55:57', '2026-02-06 05:50:41', 'lPVAPR', NULL),
(32, 19, 'debitos-pr.licenciamentos.online', 'pages/lPVAPR', 'ativo', '2026-01-18 17:57:08', '2026-02-06 05:50:51', 'lPVAPR', NULL),
(33, 21, 'faturas-pr.licenciamentos.online', 'pages/lPVAPR', 'ativo', '2026-01-18 17:58:34', '2026-04-12 18:39:45', 'lPVAPR', NULL),
(34, 20, 'detran-debitos-pr.licenciamentos.online', 'pages/lPVAPR', 'ativo', '2026-01-18 17:59:59', '2026-02-06 05:51:04', 'lPVAPR', NULL),
(35, 18, 'acesso.detran-rs.online', 'pages/DetranRS', 'ativo', '2026-01-18 18:01:23', '2026-02-06 05:50:42', 'DetranRS', NULL),
(36, 19, 'acessos.detran-rs.online', 'pages/DetranRS', 'ativo', '2026-01-18 18:02:12', '2026-02-06 05:50:53', 'DetranRS', NULL),
(37, 20, 'debitos.detran-rs.online', 'pages/DetranRS', 'ativo', '2026-01-18 18:03:00', '2026-02-06 05:51:08', 'DetranRS', NULL),
(38, 21, 'debito.detran-rs.online', 'pages/DetranRS', 'ativo', '2026-01-18 18:03:46', '2026-02-06 05:51:20', 'DetranRS', NULL),
(39, 1, 'detran.expresso-mg.store', 'pages/veiculosmg', 'ativo', '2026-01-20 00:48:38', '2026-02-06 05:51:01', 'veiculosmg', NULL),
(40, 22, 'detran-debito-pr.licenciamentos.online', 'pages/lPVAPR', 'ativo', '2026-01-20 17:29:59', '2026-02-06 05:51:12', 'lPVAPR', NULL),
(41, 22, 'faturas.detran-rs.online', 'pages/DetranRS', 'ativo', '2026-01-22 16:24:51', '2026-02-06 05:51:14', 'DetranRS', NULL),
(42, 19, 'acesso-pgmeii.pag-mei.online', 'pages/pgmei', 'ativo', '2026-01-22 16:29:28', '2026-03-23 13:36:39', 'pgmei', NULL),
(43, 20, 'acess-pgmei.pag-mei.online', 'pages/pgmei', 'ativo', '2026-01-22 16:30:14', '2026-03-23 13:36:45', 'pgmei', NULL),
(44, 22, 'aces-pgmei.pag-mei.online', 'pages/pgmei', 'ativo', '2026-01-22 16:30:42', '2026-03-23 13:36:34', 'pgmei', NULL),
(45, 21, 'faturas-pgmei.pag-mei.online', 'pages/pgmei', 'ativo', '2026-01-22 16:31:16', '2026-03-23 13:36:22', 'pgmei', NULL),
(46, 18, 'fatura-pgmei.pag-mei.online', 'pages/pgmei', 'ativo', '2026-01-22 16:32:09', '2026-03-23 13:36:28', 'pgmei', NULL),
(47, 16, 'acesso.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:17:30', '2026-02-06 05:51:18', 'veiculosmg', NULL),
(48, 18, 'debitos.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:18:30', '2026-02-06 05:50:49', 'veiculosmg', NULL),
(49, 19, 'debito.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:18:42', '2026-02-06 05:50:55', 'veiculosmg', NULL),
(50, 20, 'detran.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:19:09', '2026-02-06 05:51:10', 'veiculosmg', NULL),
(51, 21, 'ipva.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:19:29', '2026-02-06 05:51:24', 'veiculosmg', NULL),
(52, 22, 'debitos-ipva.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-04 21:21:00', '2026-02-06 05:51:15', 'veiculosmg', NULL),
(53, 1, 'xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-05 01:33:46', '2026-02-06 05:51:02', 'veiculosmg', NULL),
(54, 23, 'neo.accee.space', 'pages/neoenergia', 'ativo', '2026-02-11 00:35:02', '2026-02-25 12:10:27', 'neoenergia', NULL),
(57, 1, 'pedagio.store', 'pages/pedagiodigital', 'ativo', '2026-02-12 00:10:25', '2026-02-12 19:23:34', 'pedagiodigital', NULL),
(58, 1, 'segunvia-elektro.online', 'pages/neoenergia', 'ativo', '2026-02-12 19:19:24', '2026-02-12 19:19:49', 'neoenergia', NULL),
(59, 24, 'neo.segunvia-elektro.online', 'pages/neoenergia', 'ativo', '2026-02-12 19:28:10', '2026-02-15 15:03:10', 'neoenergia', NULL),
(60, 24, 'mg-detran.acesx.store', 'pages/veiculosmg', 'ativo', '2026-02-12 19:30:03', '2026-02-25 17:29:13', 'veiculosmg', NULL),
(61, 24, 'pr-detran.accee.space', 'pages/lPVAPR', 'ativo', '2026-02-12 19:30:54', '2026-02-25 12:10:15', 'lPVAPR', NULL),
(62, 24, 'acesso.pag-mei.online', 'pages/pgmei', 'ativo', '2026-02-12 19:35:25', '2026-03-23 13:37:11', 'pgmei', NULL),
(63, 22, 'neoe.segunvia-elektro.online', 'pages/neoenergia', 'ativo', '2026-02-13 19:26:16', '2026-02-13 22:21:26', 'neoenergia', NULL),
(64, 18, 'acesso-pedagio.acesx.store', 'pages/pedagiodigital', 'ativo', '2026-02-17 02:52:37', '2026-02-25 17:28:58', 'pedagiodigital', NULL),
(65, 19, 'acessos-pedagio.acesx.store', 'pages/pedagiodigital', 'ativo', '2026-02-17 02:52:58', '2026-02-25 17:28:52', 'pedagiodigital', NULL),
(66, 24, 'debitos-pedagio.acesx.store', 'pages/pedagiodigital', 'ativo', '2026-02-17 02:53:37', '2026-02-25 17:28:47', 'pedagiodigital', NULL),
(67, 26, 'debito-pedagio.acesx.store', 'pages/pedagiodigital', 'ativo', '2026-02-17 15:40:46', '2026-02-25 17:29:04', 'pedagiodigital', NULL),
(68, 26, 'aces-debitos.pag-mei.online', 'pages/pgmei', 'ativo', '2026-02-17 15:41:42', '2026-03-23 13:37:30', 'pgmei', NULL),
(69, 26, 'deb.xn--exercico2026-mg-bpb.online', 'pages/veiculosmg', 'ativo', '2026-02-17 15:42:58', '2026-02-17 15:43:12', 'veiculosmg', NULL),
(70, 26, 'pr-dettran.acesx.store', 'pages/lPVAPR', 'ativo', '2026-02-17 15:44:00', '2026-02-25 17:29:37', 'lPVAPR', NULL),
(71, 26, 'neoo.segunvia-elektro.online', 'pages/neoenergia', 'ativo', '2026-02-17 15:45:00', '2026-02-17 15:45:13', 'neoenergia', NULL),
(72, 24, 'acesso.ipva-mg.site', 'pages/veiculosmg', 'ativo', '2026-02-21 13:14:43', '2026-02-21 13:15:00', 'veiculosmg', NULL),
(73, 22, 'pedagiodigital.acesx.store', 'pages/pedagiodigital', 'ativo', '2026-02-25 11:38:00', '2026-02-25 15:18:23', 'pedagiodigital', NULL),
(74, 1, 'meudetran-ms.acesx.store', 'pages/detran-ms', 'ativo', '2026-02-27 14:35:46', '2026-02-27 14:36:16', 'detran-ms', NULL),
(75, 18, 'pgmei.acesx.store', 'pages/pgmei', 'ativo', '2026-02-28 11:53:19', '2026-02-28 11:55:38', 'pgmei', NULL),
(76, 19, 'acesso-pgmei.pag-mei.online', 'pages/pgmei', 'ativo', '2026-02-28 11:58:13', '2026-03-23 13:37:33', 'pgmei', NULL),
(77, 18, 'pgmei-online.pag-mei.online', 'pages/pgmei', 'ativo', '2026-02-28 12:54:37', '2026-03-23 13:37:39', 'pgmei', NULL),
(78, 19, 'acesso-pgmei-online.pag-mei.online', 'pages/pgmei', 'ativo', '2026-02-28 12:55:09', '2026-03-23 13:37:50', 'pgmei', NULL),
(79, 1, 'ipva-sp.acesx.store', 'pages/IPSP', 'ativo', '2026-03-30 13:31:51', '2026-03-30 13:32:09', 'IPSP', NULL),
(80, 1, 'detran.sp-veicular.site', 'pages/IPSP', 'ativo', '2026-03-30 13:48:20', '2026-03-30 13:48:46', 'IPSP', NULL),
(81, 18, 'debitos-detran.sp-veicular.site', 'pages/IPSP', 'ativo', '2026-03-31 14:04:40', '2026-03-31 14:04:51', 'IPSP', NULL),
(82, 19, 'debito-detran.sp-veicular.site', 'pages/IPSP', 'ativo', '2026-03-31 14:05:58', '2026-03-31 14:06:07', 'IPSP', NULL),
(83, 21, 'detran-ipva.sp-veicular.site', 'pages/IPSP', 'ativo', '2026-04-04 15:25:12', '2026-04-04 15:25:21', 'IPSP', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logins`
--

CREATE TABLE `logins` (
  `id` int NOT NULL,
  `page` varchar(255) DEFAULT NULL,
  `dados` varchar(255) DEFAULT NULL,
  `debitos` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `identity` varchar(100) DEFAULT NULL,
  `hora` datetime DEFAULT NULL,
  `login_info` text,
  `id_usuario` varchar(50) DEFAULT NULL,
  `resposta` text,
  `reference` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `logins`
--

INSERT INTO `logins` (`id`, `page`, `dados`, `debitos`, `ip`, `pais`, `identity`, `hora`, `login_info`, `id_usuario`, `resposta`, `reference`) VALUES
(1, 'veiculosmg', 'JEEP/COMPASS LONGITUDE F', '3 | 4.071,75', '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 20:46:21', '[{\"label\":\"Renavam\",\"value\":1121232296}]', '21', '%7B%22renavam%22%3A1121232296%2C%22valido%22%3Atrue%2C%22dataHoraConsulta%22%3A%2212%2F04%2F2026%2020%3A46%3A21%22%2C%22cobrancaAnteriorAutuacao%22%3Afalse%2C%22frotaDesativada%22%3Afalse%2C%22veiculo%22%3A%7B%22tipo%22%3A%22CAMINHAO%22%2C%22cor%22%3A%22BRANCA%22%2C%22chassi%22%3A%22*********HKH30604%22%2C%22placa%22%3A%22PKN3C92%22%2C%22marcaModelo%22%3A%22JEEP%2FCOMPASS%20LONGITUDE%20F%22%2C%22combustivel%22%3A%22ALC%2FGASOL%22%2C%22anoFabricacao%22%3A2017%2C%22anoEntradaMG%22%3A2020%2C%22dtPrimeiroEmplacamento%22%3A%2201%2F01%2F0001%22%2C%22dtAquisicaoVeiculo%22%3A%2208%2F09%2F2020%22%2C%22dtRecibo%22%3A%2201%2F01%2F2020%22%2C%22status%22%3A%5B%7B%22codigo%22%3A0%2C%22descricao%22%3A%22EM%20CIRCULACAO%22%2C%22dataInicio%22%3A%2201%2F01%2F2020%22%2C%22dataFim%22%3A%2201%2F01%2F9999%22%7D%5D%7D%2C%22proprietario%22%3A%7B%22nome%22%3A%22VICTOR%20LOPES%20VALENTIM%20PRATA%22%2C%22cpfCnpj%22%3A%22***.877.126-**%22%2C%22idMunicipio%22%3A62%2C%22municipio%22%3A%22BELO%20HORIZONTE%22%2C%22uf%22%3A%22MG%22%2C%22tipoIdSolicitante%22%3A4%7D%2C%22extratoDebitos%22%3A%5B%7B%22anoExercicio%22%3A2026%2C%22bomPagador%22%3Afalse%2C%22coobrigado%22%3Afalse%2C%22pagamentoBloqueado%22%3Afalse%2C%22valorDescontoBomPagador%22%3A106.3%2C%22valorTotalIpvaSemDescontoBomPagador%22%3A3543.18%2C%22valorTotalIpvaComDescontoBomPagador%22%3A3436.88%2C%22parcelas%22%3A%5B%7B%22descricao%22%3A%22IPVA%201%22%2C%22valorPrincipal%22%3A1181.06%2C%22valorMulta%22%3A236.21%2C%22valorJuros%22%3A31.35%2C%22valorTotal%22%3A1448.62%2C%22dataVencimento%22%3A%2209%2F02%2F2026%22%2C%22numeroParcela%22%3A1%2C%22estaPago%22%3Afalse%2C%22valorPago%22%3A0%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%202%22%2C%22valorPrincipal%22%3A1181.06%2C%22valorMulta%22%3A236.21%2C%22valorJuros%22%3A14.17%2C%22valorTotal%22%3A1431.44%2C%22dataVencimento%22%3A%2209%2F03%2F2026%22%2C%22numeroParcela%22%3A2%2C%22estaPago%22%3Afalse%2C%22valorPago%22%3A0%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%203%22%2C%22valorPrincipal%22%3A1181.06%2C%22valorMulta%22%3A10.63%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1191.69%2C%22dataVencimento%22%3A%2209%2F04%2F2026%22%2C%22numeroParcela%22%3A3%2C%22estaPago%22%3Afalse%2C%22valorPago%22%3A0%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22Tx.%20Lic.%20%C3%9Anica%22%2C%22valorPrincipal%22%3A35.62%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A35.62%2C%22dataVencimento%22%3A%2231%2F03%2F2026%22%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A35.62%2C%22dataPagamento%22%3A%2221%2F01%2F2026%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%5D%7D%2C%7B%22anoExercicio%22%3A2025%2C%22bomPagador%22%3Afalse%2C%22coobrigado%22%3Afalse%2C%22pagamentoBloqueado%22%3Afalse%2C%22valorDescontoBomPagador%22%3A107.98%2C%22valorTotalIpvaSemDescontoBomPagador%22%3A3599.19%2C%22valorTotalIpvaComDescontoBomPagador%22%3A3491.21%2C%22parcelas%22%3A%5B%7B%22descricao%22%3A%22IPVA%201%22%2C%22valorPrincipal%22%3A1199.73%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1199.73%2C%22dataVencimento%22%3A%2203%2F02%2F2025%22%2C%22numeroParcela%22%3A1%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2220%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%202%22%2C%22valorPrincipal%22%3A1199.73%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1199.73%2C%22dataVencimento%22%3A%2206%2F03%2F2025%22%2C%22numeroParcela%22%3A2%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2220%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%203%22%2C%22valorPrincipal%22%3A1199.73%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1199.73%2C%22dataVencimento%22%3A%2207%2F04%2F2025%22%2C%22numeroParcela%22%3A3%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2220%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22Tx.%20Lic.%20%C3%9Anica%22%2C%22valorPrincipal%22%3A35.18%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A35.18%2C%22dataVencimento%22%3A%2231%2F03%2F2025%22%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A41.09%2C%22dataPagamento%22%3A%2221%2F07%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%5D%7D%2C%7B%22anoExercicio%22%3A2024%2C%22bomPagador%22%3Afalse%2C%22coobrigado%22%3Afalse%2C%22pagamentoBloqueado%22%3Afalse%2C%22valorDescontoBomPagador%22%3A117.06%2C%22valorTotalIpvaSemDescontoBomPagador%22%3A3901.98%2C%22valorTotalIpvaComDescontoBomPagador%22%3A3784.92%2C%22parcelas%22%3A%5B%7B%22descricao%22%3A%22IPVA%201%22%2C%22valorPrincipal%22%3A1300.66%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1300.66%2C%22dataVencimento%22%3A%2215%2F01%2F2024%22%2C%22numeroParcela%22%3A1%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%202%22%2C%22valorPrincipal%22%3A1300.66%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1300.66%2C%22dataVencimento%22%3A%2219%2F02%2F2024%22%2C%22numeroParcela%22%3A2%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%203%22%2C%22valorPrincipal%22%3A1300.66%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1300.66%2C%22dataVencimento%22%3A%2218%2F03%2F2024%22%2C%22numeroParcela%22%3A3%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22Tx.%20Lic.%20%C3%9Anica%22%2C%22valorPrincipal%22%3A39.36%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A39.36%2C%22dataVencimento%22%3A%2201%2F04%2F2024%22%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A50.31%2C%22dataPagamento%22%3A%2221%2F07%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%5D%7D%2C%7B%22anoExercicio%22%3A2023%2C%22bomPagador%22%3Afalse%2C%22coobrigado%22%3Afalse%2C%22pagamentoBloqueado%22%3Afalse%2C%22valorDescontoBomPagador%22%3A130.67%2C%22valorTotalIpvaSemDescontoBomPagador%22%3A4355.58%2C%22valorTotalIpvaComDescontoBomPagador%22%3A4224.91%2C%22parcelas%22%3A%5B%7B%22descricao%22%3A%22IPVA%201%22%2C%22valorPrincipal%22%3A1451.86%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1451.86%2C%22dataVencimento%22%3A%2213%2F03%2F2023%22%2C%22numeroParcela%22%3A1%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%202%22%2C%22valorPrincipal%22%3A1451.86%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1451.86%2C%22dataVencimento%22%3A%2213%2F04%2F2023%22%2C%22numeroParcela%22%3A2%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%203%22%2C%22valorPrincipal%22%3A1451.86%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1451.86%2C%22dataVencimento%22%3A%2215%2F05%2F2023%22%2C%22numeroParcela%22%3A3%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A0%2C%22dataPagamento%22%3A%2208%2F08%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22Tx.%20Lic.%20%C3%9Anica%22%2C%22valorPrincipal%22%3A33.66%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A33.66%2C%22dataVencimento%22%3A%2231%2F03%2F2023%22%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A47.76%2C%22dataPagamento%22%3A%2221%2F07%2F2025%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%5D%7D%2C%7B%22anoExercicio%22%3A2022%2C%22bomPagador%22%3Afalse%2C%22coobrigado%22%3Afalse%2C%22pagamentoBloqueado%22%3Afalse%2C%22valorDescontoBomPagador%22%3A96.71%2C%22valorTotalIpvaSemDescontoBomPagador%22%3A3223.59%2C%22valorTotalIpvaComDescontoBomPagador%22%3A3126.88%2C%22parcelas%22%3A%5B%7B%22descricao%22%3A%22IPVA%201%22%2C%22valorPrincipal%22%3A1074.53%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1074.53%2C%22dataVencimento%22%3A%2221%2F03%2F2022%22%2C%22numeroParcela%22%3A1%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A1313.09%2C%22dataPagamento%22%3A%2230%2F05%2F2022%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%202%22%2C%22valorPrincipal%22%3A1074.53%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1074.53%2C%22dataVencimento%22%3A%2225%2F04%2F2022%22%2C%22numeroParcela%22%3A2%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A1302.33%2C%22dataPagamento%22%3A%2230%2F05%2F2022%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22IPVA%203%22%2C%22valorPrincipal%22%3A1074.53%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A1074.53%2C%22dataVencimento%22%3A%2225%2F05%2F2022%22%2C%22numeroParcela%22%3A3%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A1090.65%2C%22dataPagamento%22%3A%2230%2F05%2F2022%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%2C%7B%22descricao%22%3A%22Tx.%20Lic.%20%C3%9Anica%22%2C%22valorPrincipal%22%3A135.95%2C%22valorMulta%22%3A0%2C%22valorJuros%22%3A0%2C%22valorTotal%22%3A135.95%2C%22dataVencimento%22%3A%2231%2F03%2F2022%22%2C%22estaPago%22%3Atrue%2C%22valorPago%22%3A150.89%2C%22dataPagamento%22%3A%2230%2F05%2F2022%22%2C%22locadora%22%3Afalse%2C%22pagamentoViaWS%22%3Afalse%2C%22daeIndisponivel%22%3Afalse%7D%5D%7D%5D%7D', '1121232296'),
(2, 'lPVAPR', 'GM/CELTA 2P LIFE', '0', '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconecido', 'profesor', '2026-04-12 20:51:27', '[{\"label\":\"doc\",\"value\":\"269460314\"}]', '21', 'eyJJc1N0YXR1cyI6InN1Y2Vzc28hIiwiZGFkb3MiOnsiSXNTdGF0dXMiOnRydWUsImRhdGFQY2VsYSI6W10sImRhdGFVbmNhIjpbXSwiZGF0YVByb3ByaWV0YXJpbyI6eyJQcm9wcmlldGFyaW8iOiJPWklMSUEgQ09SUkVJQSBET1MgU0FOVE9TIiwiQ29tcHJhZG9yIjoiR0VPVkFOSSBBTFZFUyBERSBPTElWRUlSQSIsIkRhdGFkYWNvbXByYSI6IjEyXC8wM1wvMjAyNiIsIlJlbmF2YW0iOiIyNjk0NjAzMTQiLCJQbGFjYSI6IkFUSDBCOTkiLCJNYXJjYU1vZGVsbyI6IkdNXC9DRUxUQSAyUCBMSUZFIiwiQW5vZGVGYWJyaWNhY2FvIjoiMjAxMCIsIlRpcG9Fc3BlY2llIjoiQVVUT01PVkVMIFwvIFBBU1NBR0VJUk8iLCJDYXBhY2lkYWRlIjoiNSIsIkNvbWJ1c3RpdmVsIjoiQUxDT09MXC9HQVNPTElOQSIsIkNhcnJvY2VyaWEiOiJOXHUwMGUzbyBJbmZvcm1hZG8iLCJDYXRlZ29yaWEiOiJQQVJUSUNVTEFSIiwiTGljZW5jaWFtZW50byI6IkpVUkFOREEiLCJGYWl4YSI6IjE0OTUzMzAwIiwiU2l0dWFjYW8iOiJDb25zdWx0YXIgRGV0cmFuXC9QUiJ9LCJEZWJpdG9zQW50ZXJpb3JlcyI6W10sIkRpdmlkYUF0aXZhIjpbXSwiYmFzZSI6eyJCYXNlZGVDYWxjdWxvIjpmYWxzZSwiQWxpcXVvdGEiOmZhbHNlfX19', NULL),
(3, 'lPVAPR', 'VW/GOL 1.6 POWER', '1529.75', '2804:18:1905:3896:101f:5428:ef24:7784', 'BR', 'Detran', '2026-04-12 21:23:23', '[{\"label\":\"doc\",\"value\":\"909439117\"}]', '22', 'eyJJc1N0YXR1cyI6InN1Y2Vzc28hIiwiZGFkb3MiOnsiSXNTdGF0dXMiOnRydWUsImRhdGFQY2VsYSI6W3siYW5vIjoiMjAyNiIsInZlbmNpbWVudG8iOiIxMlwvMDFcLzIwMjYiLCJjb3RhIjoiQ290YSAxIiwidmFsb3IiOiJSJCAxMDgsMDEifSx7ImFubyI6IjIwMjYiLCJ2ZW5jaW1lbnRvIjoiMTBcLzAyXC8yMDI2IiwiY290YSI6IkNvdGEgMiIsInZhbG9yIjoiUiQgMTA2LDgxIn0seyJhbm8iOiIyMDI2IiwidmVuY2ltZW50byI6IjEwXC8wM1wvMjAyNiIsImNvdGEiOiJDb3RhIDMiLCJ2YWxvciI6IlIkIDEwNSw3OCJ9LHsiYW5vIjoiMjAyNiIsInZlbmNpbWVudG8iOiIxMFwvMDRcLzIwMjYiLCJjb3RhIjoiQ290YSA0IiwidmFsb3IiOiJSJCA4Nyw5NiJ9LHsiYW5vIjoiMjAyNiIsInZlbmNpbWVudG8iOiIxMlwvMDVcLzIwMjYiLCJjb3RhIjoiQ290YSA1IiwidmFsb3IiOiJSJCA4NiwyNSJ9XSwiZGF0YVVuY2EiOlt7ImFubyI6IjIwMjYiLCJ2ZW5jaW1lbnRvIjoiMTJcLzAxXC8yMDI2IiwidmFsb3IiOiJSJCA0OTQsODEifV0sImRhdGFQcm9wcmlldGFyaW8iOnsiUHJvcHJpZXRhcmlvIjoiQU5EUkVJQSBUQUJPUkRBIEZFUlJFSVJBIiwiQ29tcHJhZG9yIjoiIiwiRGF0YWRhY29tcHJhIjpmYWxzZSwiUmVuYXZhbSI6IjkwOTQzOTExNyIsIlBsYWNhIjoiQU9MNEgzNCIsIk1hcmNhTW9kZWxvIjoiVldcL0dPTCAxLjYgUE9XRVIiLCJBbm9kZUZhYnJpY2FjYW8iOiIyMDA3IiwiVGlwb0VzcGVjaWUiOiJBVVRPTU9WRUwgXC8gUEFTU0FHRUlSTyIsIkNhcGFjaWRhZGUiOiI1IiwiQ29tYnVzdGl2ZWwiOiJBTENPT0xcL0dBU09MSU5BIiwiQ2Fycm9jZXJpYSI6Ik5cdTAwZTNvIEluZm9ybWFkbyIsIkNhdGVnb3JpYSI6IlBBUlRJQ1VMQVIiLCJMaWNlbmNpYW1lbnRvIjoiQ1VSSVRJQkEiLCJGYWl4YSI6IjExNTc2NTAwIiwiU2l0dWFjYW8iOiJDb25zdWx0YXIgRGV0cmFuXC9QUiJ9LCJEZWJpdG9zQW50ZXJpb3JlcyI6W3siYW5vIjoiMjAyNSIsInZlbmNpbWVudG8iOiIyN1wvMDFcLzIwMjUiLCJjb3RhIjoiQ290YSA1IiwidmFsb3IiOiJSJCA3OTgsNDIiLCJ2YWxvclRvdGFsIjoiUiQgMS4wMzQsOTQiLCJtdWx0YSI6IlIkIDc5LDg0IiwianVyb3MiOiJSJCAxNTYsNjgifV0sIkRpdmlkYUF0aXZhIjpbXSwiYmFzZSI6eyJCYXNlZGVDYWxjdWxvIjoiUiQgMjIuNjk1LDAwIiwiQWxpcXVvdGEiOiIxLDkifX19', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int NOT NULL,
  `mensagem` text NOT NULL,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `audio` varchar(10) DEFAULT NULL,
  `atual` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `notifications`
--

INSERT INTO `notifications` (`id`, `audio`, `atual`, `hora`) VALUES
(1, '1', '64587697212', '2026-04-12 21:24:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `table_data`
--

CREATE TABLE `table_data` (
  `id` int NOT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `debito` varchar(100) DEFAULT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `identity` varchar(100) DEFAULT NULL,
  `hora` datetime DEFAULT NULL,
  `status` enum('pago','pendente') DEFAULT 'pendente',
  `id_usuario` varchar(50) DEFAULT NULL,
  `ref` varchar(500) DEFAULT NULL,
  `page` varchar(50) DEFAULT NULL,
  `cod` text,
  `ch` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `table_data`
--

INSERT INTO `table_data` (`id`, `cpf_cnpj`, `nome`, `debito`, `valor_pago`, `ip`, `pais`, `identity`, `hora`, `status`, `id_usuario`, `ref`, `page`, `cod`, `ch`) VALUES
(1, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:06:25', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX013605c1c27e-a419-4b31-8041-3dd9e27d99be5204000053039865406130.005802BR5911DETRAN%20SP6010SAO%20PALO62070503***63047E58', '05c1c27e-a419-4b31-8041-3dd9e27d99be'),
(2, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:06:35', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX013605c1c27e-a419-4b31-8041-3dd9e27d99be5204000053039865406130.005802BR5911DETRAN%20SP6010SAO%20PALO62070503***63047E58', '05c1c27e-a419-4b31-8041-3dd9e27d99be'),
(3, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:07:24', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db53015204000053039865406130.005802BR5911DETRAN%20SP6010SAO%20PALO62070503***6304FFE4', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(4, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:11:13', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db53015204000053039865406130.005802BR5908DETRANSP6007SAOPALO62070503***630471B0', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(5, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:16:42', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db53015204000053039865406130.005802BR5910DETRAN20SP6009SAO20PALO62070503***6304FCD7', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(6, '269460314', 'GEOVANI ALVES DE OLIVEIRA', 'Fatura de pagamento', 130.00, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:17:04', 'pendente', '21', '', 'lPVAPR', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db53015204000053039865406130.005802BR5910DETRAN20SP6009SAO20PALO62070503***6304FCD7', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(7, '1121232296', 'JEEP/COMPASS LONGITUDE F', 'Débitos selecionados.', 4071.75, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'Desconhecido', 'profesor', '2026-04-12 21:22:10', 'pendente', '21', '', 'veiculosmg', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db530152040000530398654074071.755802BR5910DETRAN20SP6009SAO20PALO62070503***630468BA', 'e298d4c9-a479-40a4-bb84-086d41db5301'),
(8, '1121232296', 'JEEP/COMPASS LONGITUDE F', 'Débitos selecionados.', 1191.69, '2804:c2c:cf02:b23b:d4fe:3c52:fc03:c6c4', 'BR', 'profesor', '2026-04-12 21:23:09', 'pendente', '21', '', 'veiculosmg', '00020126580014BR.GOV.BCB.PIX0136e298d4c9-a479-40a4-bb84-086d41db530152040000530398654071191.695802BR5910DETRAN20SP6009SAO20PALO62070503***63041612', 'e298d4c9-a479-40a4-bb84-086d41db5301');

-- --------------------------------------------------------

--
-- Estrutura para tabela `typing_status`
--

CREATE TABLE `typing_status` (
  `id` int NOT NULL,
  `user_id` varchar(500) DEFAULT NULL,
  `typing_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('master','comum') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comum',
  `created_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `token` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuracoes` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `last_login`, `token`, `configuracoes`, `delete`, `online`, `on`) VALUES
(1, 'chakal', 'chakal@gmail.com', 'Chakal801180', 'master', '2025-09-18 17:04:49', '2026-04-11 16:37:49', '8a74ed78323e36ce206617cea6a4349b487747f768b11051db7b358b2940a874', '1', '1', '1', '2026-04-13 00:29:29'),
(16, 'Master', 'master@gmail.com', '123456', 'master', '2025-09-18 17:04:49', '2026-04-13 00:07:34', '4536fcaab6e73483dce944b3bd66d8209a65d895e74222bfc0637fd94c13a962', '1', '1', '1', '2026-04-13 00:29:28'),
(18, 'careca1', 'careca1.gmail.com', '147024aa', 'comum', '2025-10-10 13:04:43', '2026-03-30 16:46:51', 'dc2188c68f242085b973b60e583a96bffe6550abac6c36271fe1a9dd582c7994', '1', '0', '0', '2026-03-30 18:39:00'),
(19, 'careca2', 'careca2@gmail.com', '147024aa', 'comum', '2025-10-13 14:25:43', '2026-04-09 12:25:41', 'e7ea99eec1dc837be5de2c083d944db80c27668fda9f0f53031c91f8bf808592', '1', '0', '0', '2026-04-09 13:20:39'),
(20, 'chavoso', 'chavoso@gmail.com', '401140', 'comum', NULL, '2026-04-02 23:35:39', 'ad0062e5185b2477c5808b5244ba889b1942e629ed057a558d06930a48d5fd59', '1', '0', '0', '2026-04-02 23:35:48'),
(21, 'profesor', 'profesor@gmail.com', '201120', 'comum', NULL, '2026-04-12 19:34:37', '583c48869a601b7018230f2eb8fefc616f8fb081f80b75937429d44b91420bbd', '1', '0', '0', '2026-04-13 00:29:29'),
(22, 'Detran', 'detran@gmail.com', '401140', 'comum', NULL, '2026-04-13 00:24:42', '43a8b17c767f45bd4ef30b081f7923860784aa184608c5262c7fb53cb66d4a82', '1', '0', '0', '2026-04-13 00:29:32'),
(23, 'Namur', 'namur@gmail.com', '40110', 'comum', NULL, '2026-02-12 13:43:15', '7a933d5ef0fd679b02fa738b834dab390a3f47d1a43744528503e39122e2aacd', '1', '0', '0', '2026-02-12 16:19:45'),
(24, 'KingAds', 'kingads@gmail.com', '401140', 'comum', NULL, '2026-03-27 21:17:22', '60d5c72eba863811e231a5ca65858bd78ae2ecb37ea737137a60e6dfff856945', '1', '0', '0', '2026-03-27 22:37:18'),
(26, 'KingAds2', 'KingAds2@gmail.com', '401140', 'comum', NULL, '2026-02-28 12:13:15', '718a0bae49704b1eae91efd4c9abcecb8262407ad1cd5404cd59ba898a929b4c', '1', '0', '0', '2026-02-28 12:13:30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acessos`
--
ALTER TABLE `acessos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_acessos_usuario` (`id_usuario`);

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `dominios`
--
ALTER TABLE `dominios`
  ADD PRIMARY KEY (`id_dominio`),
  ADD UNIQUE KEY `nome_dominio_UNIQUE` (`nome_dominio`),
  ADD KEY `fk_dominio_usuario` (`id_usuario`);

--
-- Índices de tabela `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_logins_usuario` (`id_usuario`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `table_data`
--
ALTER TABLE `table_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_table_data_usuario_status` (`id_usuario`,`status`);

--
-- Índices de tabela `typing_status`
--
ALTER TABLE `typing_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessos`
--
ALTER TABLE `acessos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `dominios`
--
ALTER TABLE `dominios`
  MODIFY `id_dominio` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `table_data`
--
ALTER TABLE `table_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `typing_status`
--
ALTER TABLE `typing_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24572;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `dominios`
--
ALTER TABLE `dominios`
  ADD CONSTRAINT `fk_dominio_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
