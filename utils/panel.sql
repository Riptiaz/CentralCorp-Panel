-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 30 sep. 2024 à 22:29
-- Version du serveur : 11.4.3-MariaDB-ubu2204
-- Version de PHP : 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `panel2`
--

-- --------------------------------------------------------

--
-- Structure de la table `ignored_folders`
--

CREATE TABLE `ignored_folders` (
  `folder_name` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `ignored_folders`
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
-- Structure de la table `mods`
--

CREATE TABLE `mods` (
  `id` int(11) NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci DEFAULT NULL,
  `optional` tinyint(1) DEFAULT 0,
  `recommended` int(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `mods`
--

INSERT INTO `mods` (`id`, `file`, `name`, `description`, `icon`, `optional`, `recommended`, `created_at`, `updated_at`) VALUES
(1, './data/files/mods/jei-1.19.2-forge-11.6.0.1019.jar', 'jei-1.19.2-forge-11.6.0.1019.jar', '', '', 1, 0, '2024-09-28 13:03:30', '2024-09-28 13:03:30');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
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
  `alert_activation` int(1) DEFAULT 0,
  `alert_scroll` int(1) DEFAULT 0,
  `alert_msg` text DEFAULT NULL,
  `video_activation` int(11) DEFAULT 0,
  `video_url` varchar(255) DEFAULT NULL,
  `email_verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id`, `maintenance`, `maintenance_message`, `minecraft_version`, `mods_enabled`, `file_verification`, `embedded_java`, `game_folder_name`, `server_name`, `server_ip`, `server_port`, `loader_type`, `loader_build_version`, `loader_forge_version`, `loader_activation`, `changelog_version`, `changelog_message`, `role`, `money`, `server_img`, `splash`, `splash_author`, `azuriom`, `rpc_activation`, `rpc_id`, `rpc_details`, `rpc_state`, `rpc_large_text`, `rpc_small_text`, `rpc_button1`, `rpc_button1_url`, `rpc_button2`, `rpc_button2_url`, `whitelist_activation`, `alert_activation`, `alert_scroll`, `alert_msg`, `video_activation`, `video_url`, `email_verified`) VALUES
(1, 0, 'Le launcher est en maintenance, merci de relancer ultérieurement.', '1.19.3', 1, 1, 0, 'centralcorp', 'yourservername', 'yourservername.com', 25565, 'forge', '', '1.19.3-44.1.23', '1', '1.0.0', 'Derniere version du launcher', 1, 1, './uploads/66f94cd1b4409_pp_small.png', 'Ceci est du code', 'Riptiaz', 'https://conflictura.eu', 1, '1144257170561581097', 'Dans le launcher', 'En exploration', 'Minecraft', 'Multiplayer server', 'Discord', 'https://discord.gg/VCmNXHvf77', 'Site Web', 'https://conflictura.eu', 0, 1, 0, '<p><strong><u>Découvrez la nouvelle boutique!</u></strong></p>', 1, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 0);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_background` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_background`) VALUES
(1, 'Membre', ''),
(2, 'Fondateur', ''),
(3, 'Dev', ''),
(4, 'Modo', ''),
(5, 'VIP', ''),
(6, 'VIP+', ''),
(7, 'VIP++', ''),
(8, 'Co fonda', '');

-- --------------------------------------------------------

--
-- Structure de la table `test_db`
--

CREATE TABLE `test_db` (
  `id` int(11) NOT NULL,
  `testdb` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `whitelist`
--

CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL,
  `users` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `whitelist`
--

INSERT INTO `whitelist` (`id`, `users`) VALUES
(116, 'Riptiaz');

-- --------------------------------------------------------

--
-- Structure de la table `whitelist_roles`
--

CREATE TABLE `whitelist_roles` (
  `id` int(11) NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `whitelist_roles`
--

INSERT INTO `whitelist_roles` (`id`, `role`) VALUES
(23, 'Admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ignored_folders`
--
ALTER TABLE `ignored_folders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mods`
--
ALTER TABLE `mods`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `test_db`
--
ALTER TABLE `test_db`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `whitelist_roles`
--
ALTER TABLE `whitelist_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ignored_folders`
--
ALTER TABLE `ignored_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `mods`
--
ALTER TABLE `mods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `test_db`
--
ALTER TABLE `test_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT pour la table `whitelist_roles`
--
ALTER TABLE `whitelist_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
