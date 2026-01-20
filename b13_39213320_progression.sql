-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 jan. 2026 à 15:45
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
  `estActif` int NOT NULL DEFAULT '1',
  `ordre` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `exercice`
--

INSERT INTO `exercice` (`id`, `libelle`, `charge`, `nbSeries`, `estActif`, `ordre`) VALUES
(1, 'Développé couché', 65, 3, 1, 1),
(2, 'Tirage vertical', 65, 3, 1, 2),
(3, 'Développé incliné', 42.5, 3, 1, 3),
(4, 'Extensions lombaires', 32.5, 3, 1, 4),
(5, 'Elévations frontales', 12, 3, 1, 5),
(6, 'Développé militaire', 12, 3, 1, 6),
(7, 'Elévations penchées', 10, 3, 1, 7),
(8, 'Extensions bras droits', 27.5, 3, 1, 8),
(9, 'Curls biceps assis', 12, 3, 1, 9),
(10, 'Curls marteau assis', 14, 3, 1, 10),
(11, 'Extensions triceps bas', 22.5, 3, 1, 11),
(12, 'Extensions triceps haut', 17.5, 3, 1, 12),
(13, 'Squats à la barre', 65, 3, 1, 1),
(14, 'Leg extensions', 60, 3, 1, 2),
(15, 'RDL', 67.5, 3, 1, 3),
(16, 'Extensions mollets', 130, 3, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `jointure`
--

CREATE TABLE `jointure` (
  `id` int UNSIGNED NOT NULL,
  `idProgramme` int UNSIGNED DEFAULT NULL,
  `idExercice` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `jointure`
--

INSERT INTO `jointure` (`id`, `idProgramme`, `idExercice`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 2, 13),
(14, 2, 14),
(15, 2, 15),
(16, 2, 16);

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
(13, '2026-01-18-000001', 'App\\Database\\Migrations\\CreateBase', 'default', 'App', 1768920312, 1),
(14, '2026-01-18-000002', 'App\\Database\\Migrations\\CreateSeances', 'default', 'App', 1768920312, 1),
(15, '2026-01-18-000003', 'App\\Database\\Migrations\\CreatePerformances', 'default', 'App', 1768920312, 1);

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
(1, 1, 1, 1, 8, 65),
(2, 1, 1, 2, 10, 65),
(3, 1, 1, 3, 10, 65),
(4, 1, 2, 1, 11, 65),
(5, 1, 2, 2, 12, 65),
(6, 1, 2, 3, 8, 65),
(7, 1, 3, 1, 8, 42.5),
(8, 1, 3, 2, 10, 42.5),
(9, 1, 3, 3, 8, 42.5),
(10, 1, 4, 1, 10, 32.5),
(11, 1, 4, 2, 10, 32.5),
(12, 1, 4, 3, 10, 32.5),
(13, 1, 5, 1, 11, 12),
(14, 1, 5, 2, 10, 12),
(15, 1, 5, 3, 7, 12),
(16, 1, 6, 1, 8, 12),
(17, 1, 6, 2, 12, 12),
(18, 1, 6, 3, 7, 12),
(19, 1, 7, 1, 8, 10),
(20, 1, 7, 2, 10, 10),
(21, 1, 7, 3, 10, 10),
(22, 1, 8, 1, 8, 27.5),
(23, 1, 8, 2, 8, 27.5),
(24, 1, 8, 3, 6, 27.5),
(25, 1, 9, 1, 9, 12),
(26, 1, 9, 2, 12, 12),
(27, 1, 9, 3, 7, 12),
(28, 1, 10, 1, 12, 14),
(29, 1, 10, 2, 8, 14),
(30, 1, 10, 3, 6, 14),
(31, 1, 11, 1, 10, 22.5),
(32, 1, 11, 2, 9, 22.5),
(33, 1, 11, 3, 6, 22.5),
(34, 1, 12, 1, 8, 17.5),
(35, 1, 12, 2, 12, 17.5),
(36, 1, 12, 3, 10, 17.5),
(37, 2, 13, 1, 11, 65),
(38, 2, 13, 2, 8, 65),
(39, 2, 13, 3, 9, 65),
(40, 2, 14, 1, 9, 60),
(41, 2, 14, 2, 11, 60),
(42, 2, 14, 3, 7, 60),
(43, 2, 15, 1, 9, 67.5),
(44, 2, 15, 2, 10, 67.5),
(45, 2, 15, 3, 9, 67.5),
(46, 2, 16, 1, 9, 130),
(47, 2, 16, 2, 10, 130),
(48, 2, 16, 3, 7, 130);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
