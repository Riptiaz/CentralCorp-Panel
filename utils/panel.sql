-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 28 sep. 2024 à 12:51
-- Version du serveur : 11.4.3-MariaDB-ubu2204
-- Version de PHP : 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE `ignored_folders` (
  `folder_name` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `ignored_folders` (`folder_name`, `id`) VALUES
('crash-reports', 56),
('logs', 57),
('resourcepacks', 58),
('resources', 59),
('saves', 60),
('shaderspacks', 61),
('options.txt', 62),
('optionsof.txt', 63);

CREATE TABLE `mods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `optional` tinyint(1) DEFAULT 0,
  `recommended` int(1) DEFAULT 0, -- Modifié de NULL à 0 pour éviter NULL
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_message` text DEFAULT NULL,
  `minecraft_version` varchar(50) DEFAULT NULL,
  `mods_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `file_verification` tinyint(1) NOT NULL DEFAULT 1,
  `embedded_java` tinyint(1) NOT NULL DEFAULT 0,
  `game_folder_name` varchar(100) DEFAULT NULL,
  `server_name` varchar(100) DEFAULT NULL,
  `server_ip` varchar(50) DEFAULT NULL,
  `server_port` int(11) DEFAULT NULL,
  `loader_type` varchar(50) DEFAULT NULL,
  `loader_build_version` varchar(50) DEFAULT NULL,
  `loader_forge_version` varchar(50) DEFAULT NULL,
  `loader_activation` varchar(10) DEFAULT NULL,
  `changelog_version` varchar(20) DEFAULT NULL,
  `changelog_message` text DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `money` int(11) NOT NULL DEFAULT 0,
  `server_img` text NOT NULL,
  `splash` text NOT NULL,
  `splash_author` text NOT NULL,
  `azuriom` text NOT NULL,
  `rpc_activation` int(11) NOT NULL DEFAULT 1,
  `rpc_id` varchar(100) NOT NULL,
  `rpc_details` text NOT NULL,
  `rpc_state` text NOT NULL,
  `rpc_large_text` text NOT NULL,
  `rpc_small_text` text NOT NULL,
  `rpc_button1` text NOT NULL,
  `rpc_button1_url` text NOT NULL,
  `rpc_button2` text NOT NULL,
  `rpc_button2_url` text NOT NULL,
  `whitelist_activation` int(11) NOT NULL DEFAULT 0,
  `alert_activation` int(1) DEFAULT 0, -- Modifié de NULL à 0 pour éviter NULL
  `alert_scroll` int(1) DEFAULT 0, -- Modifié de NULL à 0 pour éviter NULL
  `alert_msg` text DEFAULT NULL,
  `video_activation` int(11) DEFAULT 0, -- Modifié de NULL à 0 pour éviter NULL
  `video_url` varchar(255) DEFAULT NULL,
  `email_verified` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `options` (`id`, `maintenance`, `maintenance_message`, `minecraft_version`, `mods_enabled`, `file_verification`, `embedded_java`, `game_folder_name`, `server_name`, `server_ip`, `server_port`, `loader_type`, `loader_build_version`, `loader_forge_version`, `loader_activation`, `changelog_version`, `changelog_message`, `role`, `money`, `server_img`, `splash`, `splash_author`, `azuriom`, `rpc_activation`, `rpc_id`, `rpc_details`, `rpc_state`, `rpc_large_text`, `rpc_small_text`, `rpc_button1`, `rpc_button1_url`, `rpc_button2`, `rpc_button2_url`, `whitelist_activation`, `alert_activation`, `alert_scroll`, `alert_msg`, `video_activation`, `video_url`, `email_verified`) VALUES
(1, 0, 'Le launcher est en maintenance, merci de relancer ultérieurement.', '1.19.3', 1, 1, 0, 'centralcorp', 'yourservername', 'yourservername.com', 25565, 'forge', '', '1.19.3-44.1.23', '1', '1.0.0', 'Derniere version du launcher', 1, 1, '', 'Ceci est du code', 'Riptiaz', 'https://conflictura.eu', 1, '1144257170561581097', 'Dans le launcher', 'En exploration', 'Minecraft', 'Multiplayer server', 'Discord', 'https://discord.gg/VCmNXHvf77', 'Site Web', 'https://conflictura.eu', 0, 1, 0, '<p><strong><u>Découvrez la nouvelle boutique!</u></strong></p>', 1, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 0);

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` text NOT NULL,
  `role_background` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `roles` (`id`, `role_name`, `role_background`) VALUES
(1, 'Membre', ''),
(2, 'Fondateur', ''),
(3, 'Dev', ''),
(4, 'Modo', ''),
(5, 'VIP', ''),
(6, 'VIP+', ''),
(7, 'VIP++', ''),
(8, 'Co fonda', '');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `whitelist` (`id`, `users`) VALUES
(116, 'Riptiaz');

CREATE TABLE `whitelist_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `whitelist_roles` (`id`, `role`) VALUES
(23, 'Admin');

CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `test` (`id`, `name`, `value`) VALUES
(1, 'Test Entry 1', 100),
(2, 'Test Entry 2', 200),
(3, 'Test Entry 3', 300);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;