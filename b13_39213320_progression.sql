-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 jan. 2026 à 16:19
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
-- Base de données : `b13_39213320_progression`
--

-- --------------------------------------------------------

--
-- Structure de la table `exercice`
--

CREATE TABLE `exercice` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `charge` float DEFAULT NULL,
  `nbSeries` int DEFAULT NULL,
  `estActif` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `exercice`
--

INSERT INTO `exercice` (`id`, `libelle`, `charge`, `nbSeries`, `estActif`) VALUES
(1, 'Développé couché', 65, 3, 1),
(2, 'Tirage vertical', 65, 3, 1),
(3, 'Développé incliné', 42.5, 3, 1),
(4, 'Extensions lombaires', 32.5, 3, 1),
(5, 'Elévations frontales', 12, 3, 1),
(6, 'Développé militaire', 12, 3, 1),
(7, 'Elévations penchées', 10, 3, 1),
(8, 'Extensions bras droits', 27.5, 3, 1),
(9, 'Curls biceps assis', 12, 4, 1),
(10, 'Curls marteau assis', 14, 4, 1),
(11, 'Extensions triceps bas', 22.5, 4, 1),
(12, 'Extensions triceps haut', 17.5, 4, 1),
(13, 'Squats à la barre', 65, 4, 1),
(14, 'Leg extensions', 60, 4, 1),
(15, 'RDL', 67.5, 4, 1),
(16, 'Extensions mollets', 130, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jointure`
--

CREATE TABLE `jointure` (
  `id` int UNSIGNED NOT NULL,
  `idProgramme` int UNSIGNED DEFAULT NULL,
  `idExercice` int UNSIGNED DEFAULT NULL,
  `ordre` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `jointure`
--

INSERT INTO `jointure` (`id`, `idProgramme`, `idExercice`, `ordre`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 3),
(3, 1, 3, 2),
(4, 1, 4, 4),
(5, 1, 5, 5),
(6, 1, 6, 6),
(7, 1, 7, 7),
(8, 1, 8, 8),
(9, 1, 9, 9),
(10, 1, 10, 10),
(11, 1, 11, 11),
(12, 1, 12, 12),
(13, 2, 13, 1),
(14, 2, 14, 2),
(15, 2, 15, 3),
(16, 2, 16, 4);

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
(25, '2026-01-18-000001', 'App\\Database\\Migrations\\CreateBase', 'default', 'App', 1768922364, 1),
(26, '2026-01-18-000002', 'App\\Database\\Migrations\\CreateSeances', 'default', 'App', 1768922364, 1),
(27, '2026-01-18-000003', 'App\\Database\\Migrations\\CreatePerformances', 'default', 'App', 1768922364, 1);

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
(1, 1, 1, 1, 11, 65),
(2, 1, 1, 2, 9, 65),
(3, 1, 1, 3, 7, 65),
(4, 1, 2, 1, 11, 65),
(5, 1, 2, 2, 10, 65),
(6, 1, 2, 3, 6, 65),
(7, 1, 3, 1, 10, 42.5),
(8, 1, 3, 2, 11, 42.5),
(9, 1, 3, 3, 9, 42.5),
(10, 1, 4, 1, 11, 32.5),
(11, 1, 4, 2, 11, 32.5),
(12, 1, 4, 3, 7, 32.5),
(13, 1, 5, 1, 10, 12),
(14, 1, 5, 2, 9, 12),
(15, 1, 5, 3, 6, 12),
(16, 1, 6, 1, 9, 12),
(17, 1, 6, 2, 9, 12),
(18, 1, 6, 3, 9, 12),
(19, 1, 7, 1, 11, 10),
(20, 1, 7, 2, 12, 10),
(21, 1, 7, 3, 8, 10),
(22, 1, 8, 1, 9, 27.5),
(23, 1, 8, 2, 8, 27.5),
(24, 1, 8, 3, 7, 27.5),
(25, 1, 9, 1, 12, 12),
(26, 1, 9, 2, 11, 12),
(27, 1, 9, 3, 9, 12),
(28, 1, 9, 4, 9, 12),
(29, 1, 10, 1, 12, 14),
(30, 1, 10, 2, 11, 14),
(31, 1, 10, 3, 6, 14),
(32, 1, 10, 4, 6, 14),
(33, 1, 11, 1, 8, 22.5),
(34, 1, 11, 2, 10, 22.5),
(35, 1, 11, 3, 9, 22.5),
(36, 1, 11, 4, 8, 22.5),
(37, 1, 12, 1, 11, 17.5),
(38, 1, 12, 2, 10, 17.5),
(39, 1, 12, 3, 8, 17.5),
(40, 1, 12, 4, 9, 17.5),
(41, 2, 13, 1, 10, 65),
(42, 2, 13, 2, 10, 65),
(43, 2, 13, 3, 6, 65),
(44, 2, 13, 4, 8, 65),
(45, 2, 14, 1, 10, 60),
(46, 2, 14, 2, 10, 60),
(47, 2, 14, 3, 7, 60),
(48, 2, 14, 4, 8, 60),
(49, 2, 15, 1, 12, 67.5),
(50, 2, 15, 2, 8, 67.5),
(51, 2, 15, 3, 8, 67.5),
(52, 2, 15, 4, 6, 67.5),
(53, 2, 16, 1, 8, 130),
(54, 2, 16, 2, 10, 130),
(55, 2, 16, 3, 7, 130),
(56, 2, 16, 4, 8, 130);

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

CREATE TABLE `programme` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `estActif` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `programme`
--

INSERT INTO `programme` (`id`, `libelle`, `estActif`) VALUES
(1, 'Upper', 1),
(2, 'Lower', 1);

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` int UNSIGNED NOT NULL,
  `idProgramme` int UNSIGNED DEFAULT NULL,
  `date_seance` date NOT NULL,
  `status` enum('en_cours','fini') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en_cours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `seances`
--

INSERT INTO `seances` (`id`, `idProgramme`, `date_seance`, `status`) VALUES
(1, 1, '2026-01-17', 'fini'),
(2, 2, '2026-01-15', 'fini');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jointure`
--
ALTER TABLE `jointure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jointure_idProgramme_foreign` (`idProgramme`),
  ADD KEY `jointure_idExercice_foreign` (`idExercice`);

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
-- Index pour la table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seances_idProgramme_foreign` (`idProgramme`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `exercice`
--
ALTER TABLE `exercice`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `jointure`
--
ALTER TABLE `jointure`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `programme`
--
ALTER TABLE `programme`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `jointure`
--
ALTER TABLE `jointure`
  ADD CONSTRAINT `jointure_idExercice_foreign` FOREIGN KEY (`idExercice`) REFERENCES `exercice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jointure_idProgramme_foreign` FOREIGN KEY (`idProgramme`) REFERENCES `programme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `seances_idProgramme_foreign` FOREIGN KEY (`idProgramme`) REFERENCES `programme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
