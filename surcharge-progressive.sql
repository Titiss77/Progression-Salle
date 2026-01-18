-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 19 jan. 2026 à 00:39
-- Version du serveur : 8.0.39
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `surcharge-progressive`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(1, 'Upper'),
(2, 'Lower');

-- --------------------------------------------------------

--
-- Structure de la table `exercice`
--

CREATE TABLE `exercice` (
  `id` int UNSIGNED NOT NULL,
  `idCategorie` int UNSIGNED DEFAULT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `charge` float DEFAULT NULL,
  `nbSeries` int DEFAULT NULL,
  `estActif` int NOT NULL DEFAULT '1',
  `ordre` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `exercice`
--

INSERT INTO `exercice` (`id`, `idCategorie`, `libelle`, `charge`, `nbSeries`, `estActif`, `ordre`) VALUES
(1, 1, 'Développé couché', 65, 3, 1, 1),
(2, 1, 'Tirage vertical', 65, 3, 1, 2),
(3, 1, 'Développé incliné', 42.5, 3, 1, 3),
(4, 1, 'Extensions lombaires', 32.5, 3, 1, 4),
(5, 1, 'Elévations frontales', 12, 3, 1, 5),
(6, 1, 'Développé militaire', 12, 3, 1, 6),
(7, 1, 'Elévations penchées', 10, 3, 1, 7),
(8, 1, 'Extensions bras droits', 27.5, 3, 1, 8),
(9, 1, 'Curls biceps assis', 12, 3, 1, 9),
(10, 1, 'Curls marteau assis', 14, 3, 1, 10),
(11, 1, 'Extensions triceps bas', 22.5, 3, 1, 11),
(12, 1, 'Extensions triceps haut', 17.5, 3, 1, 12),
(13, 2, 'Squats à la barre', 65, 3, 1, 1),
(14, 2, 'Leg extensions', 60, 3, 1, 2),
(15, 2, 'RDL', 67.5, 3, 1, 3),
(16, 2, 'Extensions mollets', 130, 3, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(88, '2026-01-18-000001', 'App\\Database\\Migrations\\CreateBase', 'default', 'App', 1768779572, 1),
(89, '2026-01-18-000002', 'App\\Database\\Migrations\\CreateSeances', 'default', 'App', 1768779572, 1),
(90, '2026-01-18-000003', 'App\\Database\\Migrations\\CreatePerformances', 'default', 'App', 1768779572, 1);

-- --------------------------------------------------------

--
-- Structure de la table `performances`
--

CREATE TABLE `performances` (
  `id` int UNSIGNED NOT NULL,
  `idSeance` int UNSIGNED NOT NULL,
  `idExercice` int UNSIGNED NOT NULL,
  `numero_serie` int NOT NULL,
  `reps` int NOT NULL,
  `poids_effectif` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `performances`
--

INSERT INTO `performances` (`id`, `idSeance`, `idExercice`, `numero_serie`, `reps`, `poids_effectif`) VALUES
(1, 1, 1, 1, 12, 65),
(2, 1, 1, 2, 9, 65),
(3, 1, 1, 3, 10, 65),
(4, 1, 2, 1, 9, 65),
(5, 1, 2, 2, 9, 65),
(6, 1, 2, 3, 6, 65),
(7, 1, 3, 1, 9, 42.5),
(8, 1, 3, 2, 9, 42.5),
(9, 1, 3, 3, 7, 42.5),
(10, 1, 4, 1, 8, 32.5),
(11, 1, 4, 2, 9, 32.5),
(12, 1, 4, 3, 6, 32.5),
(13, 1, 5, 1, 11, 12),
(14, 1, 5, 2, 8, 12),
(15, 1, 5, 3, 8, 12),
(16, 1, 6, 1, 11, 12),
(17, 1, 6, 2, 9, 12),
(18, 1, 6, 3, 6, 12),
(19, 1, 7, 1, 9, 10),
(20, 1, 7, 2, 10, 10),
(21, 1, 7, 3, 9, 10),
(22, 1, 8, 1, 8, 27.5),
(23, 1, 8, 2, 12, 27.5),
(24, 1, 8, 3, 6, 27.5),
(25, 1, 9, 1, 9, 12),
(26, 1, 9, 2, 12, 12),
(27, 1, 9, 3, 7, 12),
(28, 1, 10, 1, 10, 14),
(29, 1, 10, 2, 8, 14),
(30, 1, 10, 3, 6, 14),
(31, 1, 11, 1, 12, 22.5),
(32, 1, 11, 2, 12, 22.5),
(33, 1, 11, 3, 9, 22.5),
(34, 1, 12, 1, 9, 17.5),
(35, 1, 12, 2, 12, 17.5),
(36, 1, 12, 3, 7, 17.5),
(37, 2, 13, 1, 12, 65),
(38, 2, 13, 2, 10, 65),
(39, 2, 13, 3, 7, 65),
(40, 2, 14, 1, 10, 60),
(41, 2, 14, 2, 11, 60),
(42, 2, 14, 3, 10, 60),
(43, 2, 15, 1, 10, 67.5),
(44, 2, 15, 2, 9, 67.5),
(45, 2, 15, 3, 6, 67.5),
(46, 2, 16, 1, 11, 130),
(47, 2, 16, 2, 12, 130),
(48, 2, 16, 3, 8, 130);

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` int UNSIGNED NOT NULL,
  `idCategorie` int UNSIGNED DEFAULT NULL,
  `date_seance` date NOT NULL,
  `status` enum('en_cours','fini') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en_cours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `seances`
--

INSERT INTO `seances` (`id`, `idCategorie`, `date_seance`, `status`) VALUES
(1, 1, '2026-01-17', 'fini'),
(2, 2, '2026-01-15', 'fini');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercice_idCategorie_foreign` (`idCategorie`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performances_idSeance_foreign` (`idSeance`),
  ADD KEY `performances_idExercice_foreign` (`idExercice`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seances_idCategorie_foreign` (`idCategorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `exercice`
--
ALTER TABLE `exercice`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD CONSTRAINT `exercice_idCategorie_foreign` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_idExercice_foreign` FOREIGN KEY (`idExercice`) REFERENCES `exercice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `performances_idSeance_foreign` FOREIGN KEY (`idSeance`) REFERENCES `seances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `seances`
--
ALTER TABLE `seances`
  ADD CONSTRAINT `seances_idCategorie_foreign` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
