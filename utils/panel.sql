-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2023 at 07:46 PM
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
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ignored_folders`
--

CREATE TABLE `ignored_folders` (
  `folder_name` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ignored_folders`
--

INSERT INTO `ignored_folders` (`folder_name`, `id`) VALUES
('crash-reports', 56),
('logs', 57),
('resourcepacks', 58),
('resources', 59),
('saves', 60),
('shaderspacks', 61),
('options.txt', 62),
('optionsof.txt', 63);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `maintenance` tinyint(1) NOT NULL,
  `maintenance_message` text DEFAULT NULL,
  `minecraft_version` varchar(50) DEFAULT NULL,
  `mods_enabled` tinyint(1) NOT NULL,
  `file_verification` tinyint(1) NOT NULL,
  `embedded_java` tinyint(1) NOT NULL,
  `game_folder_name` varchar(100) DEFAULT NULL,
  `server_name` varchar(100) DEFAULT NULL,
  `server_ip` varchar(50) DEFAULT NULL,
  `server_port` int(11) DEFAULT NULL,
  `loader_type` varchar(50) DEFAULT NULL,
  `loader_build_version` varchar(50) DEFAULT NULL,
  `loader_activation` varchar(10) DEFAULT NULL,
  `changelog_version` varchar(20) DEFAULT NULL,
  `changelog_message` text DEFAULT NULL,
  `role` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `server_img` text NOT NULL,
  `splash` text NOT NULL,
  `splash_author` text NOT NULL,
  `azuriom` text NOT NULL,
  `rpc_activation` int(11) NOT NULL,
  `rpc_id` varchar(100) NOT NULL,
  `rpc_details` text NOT NULL,
  `rpc_state` text NOT NULL,
  `rpc_large_text` text NOT NULL,
  `rpc_small_text` text NOT NULL,
  `rpc_button1` text NOT NULL,
  `rpc_button1_url` text NOT NULL,
  `rpc_button2` text NOT NULL,
  `rpc_button2_url` text NOT NULL,
  `whitelist_activation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `maintenance`, `maintenance_message`, `minecraft_version`, `mods_enabled`, `file_verification`, `embedded_java`, `game_folder_name`, `server_name`, `server_ip`, `server_port`, `loader_type`, `loader_build_version`, `loader_activation`, `changelog_version`, `changelog_message`, `role`, `money`, `server_img`, `splash`, `splash_author`, `azuriom`, `rpc_activation`, `rpc_id`, `rpc_details`, `rpc_state`, `rpc_large_text`, `rpc_small_text`, `rpc_button1`, `rpc_button1_url`, `rpc_button2`, `rpc_button2_url`, `whitelist_activation`) VALUES
(1, 0, 'Le launcher est en maintenance, merci de relancer ultérieurement.', '1.19.3', 1, 1, 1, 'centralcorp', 'yourservername', 'yourservername.com', 25565, 'forge', '1.19.3-44.1.0', '1', '1.0.0', 'Derniere version du launcher', 0, 0, 'https://conflictura.site/storage/img/logo2.png', 'Ceci est du code', 'Riptiaz', 'https://conflictura.site', 1, '1144257170561581097', 'Dans le launcher', 'En exploration', 'Minecraft', 'Multiplayer server', 'Discord', 'https://discord.gg/VCmNXHvf77', 'Site Web', 'https://conflictura.site', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_background` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_background`) VALUES
(1, 'Membre', 'your image url'),
(2, 'Fondateur', 'your image url'),
(3, 'Dev', 'your image url'),
(4, 'Modo', 'your image url'),
(5, 'VIP', 'your image url'),
(6, 'VIP+', 'your image url'),
(7, 'VIP++', 'your image url'),
(8, 'Co fonda', 'your image url');

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

-- --------------------------------------------------------

--
-- Table structure for table `whitelist`
--

CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL,
  `users` text NOT NULL
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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ignored_folders`
--
ALTER TABLE `ignored_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
