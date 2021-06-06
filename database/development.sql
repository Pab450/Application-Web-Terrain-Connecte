-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 06 juin 2021 à 13:23
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `development`
--

-- --------------------------------------------------------

--
-- Structure de la table `lands`
--

CREATE TABLE `lands` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `render` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lands`
--

INSERT INTO `lands` (`id`, `name`, `render`) VALUES
(1, 'Terrain des Champs Elysées', NULL),
(2, 'Parc d\'Isle', NULL),
(3, 'Stade Municipal de Gauchy', NULL),
(4, 'Parc du Milénaire', NULL),
(5, 'Terrain d\'aventure', NULL),
(6, 'Parc des marronniers', NULL),
(15, 'Terrain expérimental', '{\"40\":\"1 \\/ 1 \\/ 3 \\/ 3\",\"41\":\"9 \\/ 3 \\/ 11 \\/ 5\",\"42\":\"9 \\/ 5 \\/ 11 \\/ 7\",\"43\":\"9 \\/ 1 \\/ 11 \\/ 3\",\"45\":\"3 \\/ 1 \\/ 5 \\/ 4\",\"46\":\"3 \\/ 4 \\/ 5 \\/ 7\",\"47\":\"1 \\/ 3 \\/ 3 \\/ 7\",\"50\":\"5 \\/ 1 \\/ 7 \\/ 4\",\"51\":\"5 \\/ 4 \\/ 7 \\/ 7\",\"52\":\"7 \\/ 1 \\/ 9 \\/ 7\"}');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` text NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(3, '0001-01-01-000000', 'App\\Database\\Migrations\\Users', 'default', 'App', 1622811869, 1),
(6, '0001-01-01-000000', 'App\\Database\\Migrations\\Thresholds', 'default', 'App', 1622825645, 3),
(7, '0001-01-01-000000', 'App\\Database\\Migrations\\Sondes', 'default', 'App', 1622882060, 4),
(9, '0001-01-01-000000', 'App\\Database\\Migrations\\Lands', 'default', 'App', 1622904418, 5),
(10, '0001-01-01-000000', 'App\\Database\\Migrations\\Occupations', 'default', 'App', 1622967669, 6);

-- --------------------------------------------------------

--
-- Structure de la table `occupations`
--

CREATE TABLE `occupations` (
  `identifierLand` varchar(255) NOT NULL,
  `startDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `endDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wording` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `occupations`
--

INSERT INTO `occupations` (`identifierLand`, `startDateTime`, `endDateTime`, `wording`) VALUES
('Terrain expérimental', '2021-06-05 08:40:00', '2021-06-05 08:45:00', 'Passage du robot sur la pelouse, révision du concentrateur.'),
('Terrain expérimental', '2021-08-05 09:40:00', '2021-08-05 09:45:00', 'révision du concentrateur.'),
('Terrain expérimental', '2021-08-05 09:45:00', '2021-08-05 09:50:00', 'Passage du robot sur la pelouse.'),
('Terrain expérimental', '2021-08-05 10:40:00', '2021-08-05 11:45:00', 'révision du concentrateur.'),
('Terrain expérimental', '2021-08-05 10:45:00', '2021-08-05 11:50:00', 'Passage du robot sur la pelouse.'),
('Terrain expérimental', '2021-06-05 10:40:00', '2021-07-05 11:45:00', 'Nettoyage du terrain.'),
('Terrain expérimental', '2021-06-05 10:45:00', '2021-07-05 11:50:00', 'Nettoyage du terrain.'),
('Terrain expérimental', '2021-06-05 10:45:00', '2021-07-05 08:50:00', 'Nettoyage du concentrateur.');

-- --------------------------------------------------------

--
-- Structure de la table `sondes`
--

CREATE TABLE `sondes` (
  `identifierSonde` int(10) UNSIGNED NOT NULL,
  `humidity` decimal(10,2) NOT NULL,
  `temperature` decimal(10,2) NOT NULL,
  `tension` decimal(10,2) NOT NULL,
  `identifierLand` varchar(255) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sondes`
--

INSERT INTO `sondes` (`identifierSonde`, `humidity`, `temperature`, `tension`, `identifierLand`, `dateTime`) VALUES
(0, '37.87', '9.62', '7.06', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(1, '42.25', '10.69', '9.87', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(2, '43.59', '11.83', '11.82', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(3, '35.44', '12.12', '7.39', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(4, '39.40', '12.86', '5.45', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(5, '38.83', '10.08', '11.21', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(6, '41.33', '14.06', '6.69', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(7, '42.17', '9.65', '10.67', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(8, '37.95', '12.56', '7.42', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(9, '41.57', '12.15', '11.89', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(10, '43.86', '14.57', '10.05', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(11, '44.99', '16.77', '7.53', 'Terrain des Champs Elysées', '2021-06-05 08:44:19'),
(12, '40.43', '11.55', '8.38', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(13, '41.26', '15.87', '7.88', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(14, '43.70', '14.27', '9.53', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(15, '37.39', '14.53', '5.42', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(16, '37.37', '10.04', '8.78', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(17, '43.38', '10.54', '10.29', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(18, '42.58', '9.05', '7.89', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(19, '36.64', '9.87', '11.46', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(20, '42.36', '13.71', '9.90', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(21, '44.11', '11.95', '10.25', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(22, '43.72', '13.61', '10.07', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(23, '44.79', '11.36', '9.09', 'Parc d\'Isle', '2021-06-05 08:47:52'),
(0, '36.98', '10.83', '5.87', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(1, '39.71', '11.59', '10.77', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(2, '42.38', '14.23', '10.20', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(3, '39.40', '15.80', '7.74', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(4, '44.00', '11.75', '6.98', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(5, '41.31', '9.24', '8.22', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(6, '41.34', '16.91', '8.57', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(7, '36.90', '9.69', '7.45', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(8, '39.83', '11.71', '8.75', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(9, '42.44', '11.07', '11.38', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(10, '38.41', '15.43', '8.83', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(11, '44.36', '14.36', '10.78', 'Terrain des Champs Elysées', '2021-06-05 08:48:56'),
(40, '38.33', '16.70', '11.06', 'Terrain expérimental', '2021-06-05 15:10:24'),
(41, '35.42', '16.37', '9.57', 'Terrain expérimental', '2021-06-05 15:10:24'),
(42, '40.66', '10.60', '7.60', 'Terrain expérimental', '2021-06-05 15:10:24'),
(43, '42.80', '16.65', '9.50', 'Terrain expérimental', '2021-06-05 15:10:24'),
(44, '39.72', '11.09', '11.58', 'Terrain expérimental', '2021-06-05 15:10:24'),
(45, '35.31', '14.24', '11.40', 'Terrain expérimental', '2021-06-05 15:10:24'),
(46, '35.19', '10.70', '6.49', 'Terrain expérimental', '2021-06-05 15:10:24'),
(47, '39.22', '14.59', '8.89', 'Terrain expérimental', '2021-06-05 15:10:24'),
(48, '42.95', '11.70', '5.89', 'Terrain expérimental', '2021-06-05 15:10:24'),
(49, '36.02', '11.18', '7.18', 'Terrain expérimental', '2021-06-05 15:10:24'),
(50, '42.12', '11.71', '7.33', 'Terrain expérimental', '2021-06-05 15:10:24'),
(51, '41.36', '9.31', '5.19', 'Terrain expérimental', '2021-06-05 15:10:24'),
(52, '39.16', '10.19', '5.47', 'Terrain expérimental', '2021-06-05 15:10:24');

-- --------------------------------------------------------

--
-- Structure de la table `thresholds`
--

CREATE TABLE `thresholds` (
  `identifierLand` varchar(255) NOT NULL,
  `minimalHumidity` decimal(10,2) NOT NULL,
  `minimalTension` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thresholds`
--

INSERT INTO `thresholds` (`identifierLand`, `minimalHumidity`, `minimalTension`) VALUES
('Terrain des Champs Elysées', '12.12', '14.92'),
('Terrain expérimental', '36.34', '10.12');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

--
-- non quand même pas...
--

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lands`
--
ALTER TABLE `lands`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `thresholds`
--
ALTER TABLE `thresholds`
  ADD UNIQUE KEY `identifierLand` (`identifierLand`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lands`
--
ALTER TABLE `lands`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
