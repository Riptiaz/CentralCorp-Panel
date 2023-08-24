-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2023 at 03:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ignored_folders`
--

CREATE TABLE `ignored_folders` (
  `folder_name` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT 1,
  `maintenance_message` text DEFAULT 'Le launcher est en maintenance, merci de relancer ultérieurement.',
  `minecraft_version` varchar(50) DEFAULT '1.16.5',
  `mods_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `file_verification` tinyint(1) NOT NULL DEFAULT 1,
  `embedded_java` tinyint(1) NOT NULL DEFAULT 1,
  `game_folder_name` varchar(100) DEFAULT 'centralcorp',
  `server_name` varchar(100) DEFAULT 'yourservername',
  `server_ip` varchar(50) DEFAULT 'yourservername.com',
  `server_port` int(11) DEFAULT 25565,
  `loader_type` varchar(50) DEFAULT 'forge',
  `loader_build_version` varchar(50) DEFAULT '1.12.2-14.23.5.2860',
  `loader_activation` varchar(10) DEFAULT '0',
  `changelog_version` varchar(20) DEFAULT '1.0.0',
  `changelog_message` text DEFAULT 'Ceci est la dernière version',
  `role` int(11) NOT NULL DEFAULT 1,
  `money` int(11) NOT NULL DEFAULT 1,
  `server_img` text NOT NULL,
  `splash` text NOT NULL,
  `splash_author` text NOT NULL,
  `azuriom` text NOT NULL,
  `ftp_url` text NOT NULL,
  `rpc_activation` int(11) NOT NULL,
  `rpc_id` varchar(100) NOT NULL,
  `rpc_details` text NOT NULL,
  `rpc_state` text NOT NULL,
  `rpc_large_text` text NOT NULL,
  `rpc_small_text` text NOT NULL,
  `rpc_button1` text NOT NULL,
  `rpc_button1_url` text NOT NULL,
  `rpc_button2` text NOT NULL,
  `rpc_button2_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `maintenance`, `maintenance_message`, `minecraft_version`, `mods_enabled`, `file_verification`, `embedded_java`, `game_folder_name`, `server_name`, `server_ip`, `server_port`, `loader_type`, `loader_build_version`, `loader_activation`, `changelog_version`, `changelog_message`, `role`, `money`, `server_img`, `splash`, `splash_author`, `azuriom`, `ftp_url`, `rpc_activation`, `rpc_id`, `rpc_details`, `rpc_state`, `rpc_large_text`, `rpc_small_text`, `rpc_button1`, `rpc_button1_url`, `rpc_button2`, `rpc_button2_url`) VALUES
(1, 0, 'Le launcher est en maintenance, merci de relancer ultérieurement.', '1.19.3', 1, 1, 1, 'centralcorp', 'yourservername', 'yourservername.com', 25565, 'forge', '1.19.3-44.1.0', '1', '1.0.0', 'Derniere version du launcher', 0, 0, 'https://conflictura.site/storage/img/logo2.png', 'Ceci est du code', 'Riptiaz', 'https://conflictura.site', 'http://129.151.251.180', 0, '1144257170561581097', 'Dans le launcher', 'En exploration', 'Minecraft', 'Multiplayer server', 'Discord', 'https://discord.gg/VCmNXHvf77', 'Site Web', 'https://conflictura.site');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ignored_folders`
--
ALTER TABLE `ignored_folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ignored_folders`
--
ALTER TABLE `ignored_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
