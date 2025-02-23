-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 14 oct. 2024 à 09:53
-- Version du serveur :  8.0.18
-- Version de PHP :  7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ecole`
--

-- --------------------------------------------------------

--
-- Structure de la table `anne_scollaires`
--

DROP TABLE IF EXISTS `anne_scollaires`;
CREATE TABLE IF NOT EXISTS `anne_scollaires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `anne_scollaires`
--

INSERT INTO `anne_scollaires` (`id`, `designation`, `statut`, `created_at`, `updated_at`) VALUES
(1, '2021-2022', 0, '2024-06-19 11:28:25', '2024-06-19 12:09:14'),
(2, '2022-2023', 0, '2024-06-19 11:32:10', '2024-08-28 18:18:23'),
(3, '2023-2024', 1, '2024-06-19 11:48:42', '2024-08-28 18:18:27');

-- --------------------------------------------------------

--
-- Structure de la table `avenues`
--

DROP TABLE IF EXISTS `avenues`;
CREATE TABLE IF NOT EXISTS `avenues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idQuartier` int(11) NOT NULL,
  `nomAvenue` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avenues`
--

INSERT INTO `avenues` (`id`, `idQuartier`, `nomAvenue`, `created_at`, `updated_at`) VALUES
(1, 2, 'Tmk', '2023-09-04 11:30:39', '2023-09-04 11:30:39'),
(2, 2, 'Mushunganya', '2023-09-04 11:31:11', '2023-09-04 11:31:11'),
(3, 1, 'autres', '2023-09-04 11:34:01', '2023-09-04 11:34:01'),
(4, 8, 'De la frontière', '2024-01-13 02:10:39', '2024-01-13 02:10:39'),
(5, 7, 'Bougainvillier', '2024-01-13 02:12:39', '2024-01-13 02:12:39'),
(6, 26, 'Autre', '2024-01-15 07:25:53', '2024-01-15 07:25:53'),
(7, 24, 'Autre', '2024-01-15 07:26:11', '2024-01-15 07:26:11'),
(8, 23, 'Autre', '2024-01-15 07:26:35', '2024-01-15 07:26:35'),
(9, 17, 'Autre', '2024-01-15 07:26:57', '2024-01-15 07:26:57'),
(10, 15, 'Autre', '2024-01-15 07:27:21', '2024-01-15 07:27:21'),
(11, 14, 'Autre', '2024-01-15 07:27:42', '2024-06-11 17:57:03'),
(12, 9, 'autre', '2024-01-15 07:28:09', '2024-01-15 07:28:09'),
(13, 8, 'Autre', '2024-01-15 07:28:52', '2024-01-15 07:28:52'),
(14, 7, 'Autre', '2024-01-15 07:29:22', '2024-01-15 07:29:22'),
(15, 5, 'Autre', '2024-01-15 07:29:41', '2024-01-15 07:29:41'),
(16, 20, 'autre', '2024-01-15 07:30:07', '2024-01-15 07:30:07'),
(17, 19, 'Autre', '2024-01-15 07:30:38', '2024-01-15 07:30:38'),
(18, 18, 'Autre', '2024-01-15 07:31:34', '2024-01-15 07:31:34'),
(19, 20, 'Autre', '2024-01-15 07:32:06', '2024-01-15 07:32:06'),
(20, 19, 'Autre', '2024-01-15 07:32:29', '2024-01-15 07:32:29'),
(21, 18, 'Autre', '2024-01-15 07:33:07', '2024-01-15 07:33:07'),
(22, 16, 'Autre', '2024-01-15 07:35:24', '2024-01-15 07:35:24'),
(23, 13, 'Autre', '2024-01-15 07:36:09', '2024-01-15 07:36:09'),
(24, 12, 'Autre', '2024-01-15 07:36:55', '2024-01-15 07:36:55'),
(25, 10, 'Autre', '2024-01-15 07:37:48', '2024-01-15 07:37:48'),
(26, 4, 'Autre', '2024-01-15 07:38:09', '2024-01-15 07:38:09'),
(27, 3, 'autre', '2024-01-15 07:38:36', '2024-01-15 07:38:36'),
(28, 2, 'Autre', '2024-01-15 07:39:06', '2024-01-15 07:39:06'),
(29, 28, 'Autre', '2024-04-05 04:04:50', '2024-04-05 04:04:50'),
(30, 27, 'Autre', '2024-04-05 04:05:14', '2024-04-05 04:05:14'),
(31, 2, 'Autre', '2024-04-06 04:01:24', '2024-04-06 04:01:24'),
(32, 3, 'Autre', '2024-04-06 04:01:44', '2024-04-06 04:01:44'),
(33, 4, 'Autre', '2024-04-06 04:01:59', '2024-04-06 04:01:59'),
(34, 10, 'Autre', '2024-04-06 04:02:15', '2024-04-06 04:02:15'),
(35, 11, 'Autre', '2024-04-06 04:02:29', '2024-04-06 04:02:29'),
(36, 25, 'Autre', '2024-04-06 04:05:36', '2024-04-06 04:05:36'),
(37, 12, 'Autre', '2024-04-06 04:06:01', '2024-04-06 04:06:01'),
(38, 13, 'Autre', '2024-04-06 04:07:14', '2024-04-06 04:07:14'),
(39, 16, 'Autre', '2024-04-06 04:07:57', '2024-04-06 04:07:57'),
(40, 18, 'Autre', '2024-04-06 04:08:12', '2024-04-06 04:08:12'),
(41, 19, 'Autre', '2024-04-06 04:08:26', '2024-06-11 17:52:51'),
(42, 2, 'Mulinga', '2024-06-20 15:32:00', '2024-06-20 15:32:00');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomClasse` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nomClasse`, `created_at`, `updated_at`) VALUES
(1, '1ere Année', '2024-06-19 12:16:07', '2024-06-19 12:16:07'),
(2, '2ième Année', '2024-06-19 12:16:32', '2024-06-19 12:16:32'),
(3, '3ième Année', '2024-06-19 12:16:43', '2024-06-19 12:16:43'),
(4, '4ième Année', '2024-06-19 12:16:50', '2024-06-19 12:16:50'),
(6, '5ième Année', '2024-08-24 06:00:54', '2024-08-24 06:00:54'),
(7, '6ième Année', '2024-08-24 06:01:25', '2024-08-24 06:01:25'),
(8, '7ième Année', '2024-08-24 06:01:38', '2024-08-24 06:01:38'),
(9, '8ième Année', '2024-08-24 06:01:53', '2024-08-24 06:01:53');

-- --------------------------------------------------------

--
-- Structure de la table `clautures`
--

DROP TABLE IF EXISTS `clautures`;
CREATE TABLE IF NOT EXISTS `clautures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idAnne` bigint(20) UNSIGNED DEFAULT NULL,
  `idOption` bigint(20) UNSIGNED DEFAULT NULL,
  `idSection` bigint(20) UNSIGNED DEFAULT NULL,
  `idClasse` bigint(20) UNSIGNED DEFAULT NULL,
  `refMois` int(11) DEFAULT NULL,
  `mois` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effectifClasse` int(11) NOT NULL DEFAULT '0',
  `effectifAbandon` int(11) NOT NULL DEFAULT '0',
  `effectifTotal` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clautures_idanne_foreign` (`idAnne`),
  KEY `clautures_idoption_foreign` (`idOption`),
  KEY `clautures_idsection_foreign` (`idSection`),
  KEY `clautures_idclasse_foreign` (`idClasse`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clautures`
--

INSERT INTO `clautures` (`id`, `idAnne`, `idOption`, `idSection`, `idClasse`, `refMois`, `mois`, `effectifClasse`, `effectifAbandon`, `effectifTotal`, `created_at`, `updated_at`) VALUES
(2, 3, 1, 1, 1, 9, NULL, 8, 1, 7, '2024-08-17 17:08:42', '2024-08-17 17:12:18'),
(3, 3, 2, 2, 1, 9, NULL, 2, 1, 1, '2024-08-17 17:18:03', '2024-08-17 17:18:03'),
(4, 3, 1, 1, 1, 10, NULL, 8, 0, 8, '2024-08-17 17:24:15', '2024-08-17 17:24:15'),
(5, 3, 1, 1, 1, 11, NULL, 8, 0, 8, '2024-08-17 17:24:50', '2024-08-17 17:24:50'),
(6, 3, 1, 1, 1, 12, NULL, 8, 0, 8, '2024-08-17 17:25:16', '2024-08-17 17:25:16'),
(7, 3, 1, 1, 1, 1, NULL, 8, 0, 8, '2024-08-17 17:25:34', '2024-08-17 17:25:34'),
(8, 3, 1, 1, 1, 2, NULL, 8, 0, 8, '2024-08-17 17:26:04', '2024-08-17 17:26:04'),
(9, 3, 1, 1, 1, 3, NULL, 8, 0, 8, '2024-08-17 17:26:21', '2024-08-17 17:26:21'),
(10, 3, 1, 1, 1, 4, NULL, 8, 0, 8, '2024-08-17 17:26:41', '2024-08-17 17:26:41'),
(11, 3, 1, 1, 1, 5, NULL, 8, 0, 8, '2024-08-17 17:27:01', '2024-08-17 17:27:01'),
(12, 3, 1, 1, 1, 6, NULL, 8, 1, 7, '2024-08-17 17:27:24', '2024-08-17 17:27:24');

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

DROP TABLE IF EXISTS `communes`;
CREATE TABLE IF NOT EXISTS `communes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idVille` int(11) NOT NULL,
  `nomCommune` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id`, `idVille`, `nomCommune`, `created_at`, `updated_at`) VALUES
(1, 1, 'Goma', '2023-09-04 11:25:06', '2023-09-04 11:25:06'),
(2, 1, 'Karisimbi', '2023-09-04 11:25:24', '2023-09-04 11:25:24'),
(3, 2, 'Kasuku', '2023-09-04 11:25:51', '2023-09-04 11:25:51'),
(4, 2, 'Mikelenge', '2023-09-04 11:27:05', '2024-06-11 17:44:45');

-- --------------------------------------------------------

--
-- Structure de la table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomDivision` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `divisions`
--

INSERT INTO `divisions` (`id`, `nomDivision`, `created_at`, `updated_at`) VALUES
(1, 'A', '2024-06-19 12:36:41', '2024-06-19 12:36:41'),
(2, 'B', '2024-06-19 12:36:45', '2024-06-19 12:36:45'),
(3, 'C', '2024-06-19 12:36:49', '2024-06-19 12:36:49'),
(4, 'D', '2024-06-19 12:36:53', '2024-06-19 12:36:53'),
(5, 'E', '2024-06-19 12:36:57', '2024-06-19 12:36:57'),
(6, 'F', '2024-06-19 12:37:01', '2024-06-19 12:37:01');

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

DROP TABLE IF EXISTS `eleves`;
CREATE TABLE IF NOT EXISTS `eleves` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idAvenue` bigint(20) UNSIGNED NOT NULL,
  `nomEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postNomEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preNomEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etatCivilEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexeEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomPere` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomMere` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numPere` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numMere` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photoEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `numAdresseEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateNaisEleve` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eleves_idavenue_foreign` (`idAvenue`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleves`
--

INSERT INTO `eleves` (`id`, `idAvenue`, `nomEleve`, `postNomEleve`, `preNomEleve`, `etatCivilEleve`, `sexeEleve`, `nomPere`, `nomMere`, `numPere`, `numMere`, `photoEleve`, `codeEleve`, `created_at`, `updated_at`, `numAdresseEleve`, `dateNaisEleve`) VALUES
(1, 1, 'Jeremi', 'Kambale', 'lola', 'Celibataire', 'M', 'Kambale sumaili', 'sifa sumaili', '0998734234', '0997834233', '1718833276.jpg', '331215665', '2024-06-19 19:12:57', '2024-06-19 19:41:16', '12', '2007-09-01'),
(2, 5, 'Patrick', 'selemani', 'lupaya', 'Celibataire', 'M', 'lupaya mputu', 'jolie Mputu', '0970524665', '0817883541', '1718891859.jpg', '1566677619', '2024-06-19 19:17:44', '2024-06-20 11:57:39', '34', '2006-04-01'),
(3, 5, 'tuta', 'pascal', 'Jeremie', 'Celibataire', 'M', 'tutu kasera', 'masika tutu', '0997843223', '085432134', '1718833199.jpg', '47344734', '2024-06-19 19:20:17', '2024-06-19 19:39:59', '44', '2004-04-01'),
(4, 2, 'Gabriel', 'kabumba', 'sefu', 'Celibataire', 'M', 'kabumba', 'sifa bernadette', '0997821345', '0816772345', '1718833155.jpg', '1839766669', '2024-06-19 19:22:04', '2024-06-19 19:39:15', '2332', '2006-04-01'),
(5, 2, 'Bijoux', 'tebete', 'bernadette', 'Celibataire', 'F', 'Tebete', 'Zahabu', '0997812343', '0996123452', '1718833142.jpg', '194143024', '2024-06-19 19:24:58', '2024-06-19 19:39:02', '323', '2008-04-01'),
(7, 15, 'Birindwa', 'jolie', 'binja', 'Celibataire', 'F', 'Birindwa roger', 'chirezi birindwa', '0970524665', '0817883541', '1718833046.jpg', '769084006', '2024-06-19 19:30:01', '2024-06-19 19:37:26', '23', '2006-09-01'),
(8, 12, 'Nehema', 'sefu', 'Abigael', 'Celibataire', 'F', 'Jeremie', 'Jolie', '081783484434', '0994434345', '1718833387.jpg', '1124395129', '2024-06-19 19:42:53', '2024-06-19 19:43:07', '09', '2005-04-01'),
(9, 15, 'Henriette', 'jusele', 'kasereka', 'Marié(e)', 'F', 'Kasereka', 'masika', '0997823456', '0997534443', '1718835456.jpg', '365682046', '2024-06-19 20:14:03', '2024-06-19 20:24:33', '334', '2007-01-01'),
(10, 5, 'laini', 'seluwa', 'kakule', 'Celibataire', 'F', 'Kakule misa', 'masika kakule', '099332453', '0851232123', '1718892052.jpg', '1964960515', '2024-06-20 12:00:31', '2024-06-20 12:00:52', '56', '2002-04-01'),
(11, 42, 'Nicole', 'kamango', 'Henriette', 'Celibataire', 'F', 'kamango', 'julienne', '0817883541', '0970524665', 'avatar.png', '1208546875', '2024-06-20 15:33:35', '2024-06-20 16:03:04', '025', '2005-01-01'),
(12, 15, 'John sefu', 'Abedi', 'jupiter', 'Celibataire', 'M', 'Abedi', 'Rehema Mbuma', '0817883423', '0993464343', 'avatar.png', '572136816', '2024-08-18 07:45:37', '2024-08-18 07:57:55', '23', '2008-08-18');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEleve` bigint(20) UNSIGNED NOT NULL,
  `idAnne` bigint(20) UNSIGNED NOT NULL,
  `idOption` bigint(20) UNSIGNED NOT NULL,
  `idClasse` bigint(20) UNSIGNED NOT NULL,
  `idDivision` bigint(20) UNSIGNED NOT NULL,
  `dateInscription` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codeInscription` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reductionPaiement` double DEFAULT '0',
  `fraisinscription` double NOT NULL DEFAULT '30',
  `restoreinscription` double NOT NULL DEFAULT '0',
  `paie` double NOT NULL DEFAULT '0',
  `reste` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `inscriptions_ideleve_foreign` (`idEleve`),
  KEY `inscriptions_idanne_foreign` (`idAnne`),
  KEY `inscriptions_idoption_foreign` (`idOption`),
  KEY `inscriptions_idclasse_foreign` (`idClasse`),
  KEY `inscriptions_iddivision_foreign` (`idDivision`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id`, `idEleve`, `idAnne`, `idOption`, `idClasse`, `idDivision`, `dateInscription`, `codeInscription`, `created_at`, `updated_at`, `reductionPaiement`, `fraisinscription`, `restoreinscription`, `paie`, `reste`) VALUES
(1, 5, 3, 2, 1, 1, '2024-06-19', '482731652', '2024-06-20 17:17:47', '2024-06-20 17:18:38', 0, 30, 0, 0, 0),
(2, 7, 3, 1, 1, 1, '2024-06-20', '597460983', '2024-06-20 17:22:33', '2024-08-14 08:41:31', 10, 30, 0, 20, 200),
(3, 4, 3, 1, 1, 1, '2024-06-20', '1486031754', '2024-06-20 17:24:40', '2024-06-20 17:24:40', 0, 30, 0, 85, 135),
(4, 9, 3, 1, 1, 1, '2024-06-20', '344827264', '2024-06-20 17:24:59', '2024-06-20 17:24:59', 0, 30, 0, 0, 0),
(5, 1, 3, 1, 1, 1, '2024-06-20', '1982781020', '2024-06-20 17:25:24', '2024-06-20 17:25:24', 0, 30, 0, 0, 0),
(6, 10, 3, 1, 1, 1, '2024-06-20', '1548483362', '2024-06-20 17:25:45', '2024-06-20 17:25:45', 0, 30, 0, 0, 0),
(7, 8, 3, 1, 1, 1, '2024-06-20', '1662465789', '2024-06-20 17:26:07', '2024-08-14 10:18:25', 10, 30, 0, 0, 0),
(8, 11, 3, 1, 1, 1, '2024-06-20', '350714540', '2024-06-20 17:26:23', '2024-06-20 17:26:23', 0, 30, 0, 0, 0),
(9, 2, 3, 1, 1, 1, '2024-06-20', '270089677', '2024-06-20 17:26:41', '2024-08-14 10:24:10', 50, 30, 0, 0, 0),
(11, 3, 3, 2, 1, 1, '2024-06-20', '1266820220', '2024-06-20 17:28:29', '2024-06-20 17:28:29', 0, 30, 0, 0, 0),
(12, 12, 3, 1, 1, 1, '2024-08-18', '1660054344', '2024-08-18 07:46:08', '2024-08-24 06:06:58', 0, 30, 0, 0, 0),
(13, 5, 3, 1, 2, 1, '2024-09-17', '997065931', '2024-09-17 03:15:22', '2024-09-19 03:01:01', 10, 0, 0, 0, 0),
(14, 3, 3, 2, 4, 1, '2024-09-18', '1434439677', '2024-09-18 17:29:14', '2024-09-18 17:29:46', 5, 0, 0, 5, 925),
(15, 1, 3, 2, 4, 1, '2024-09-18', '261235256', '2024-09-18 18:59:13', '2024-09-18 18:59:38', 0.5, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2022_01_14_120826_create_roles_table', 1),
(7, '2022_01_29_121045_create_sites_table', 2),
(8, '2022_05_31_105154_create_pays_table', 3),
(9, '2022_05_31_113453_create_provinces_table', 3),
(10, '2022_09_19_142233_create_villes_table', 3),
(11, '2022_09_20_053623_create_communes_table', 3),
(12, '2022_09_20_074025_create_quartiers_table', 3),
(13, '2022_09_20_083452_create_avenues_table', 3),
(14, '2024_06_12_124725_create_eleves_table', 4),
(15, '2024_06_12_135009_create_anne_scollaires_table', 5),
(16, '2024_06_12_142636_create_classes_table', 5),
(17, '2024_06_12_150959_create_divisions_table', 5),
(18, '2024_06_12_155039_create_sections_table', 6),
(19, '2024_06_12_161104_create_options_table', 7),
(20, '2024_06_12_164153_create_inscriptions_table', 7),
(21, '2024_06_12_172509_create_presences_table', 7),
(22, '2024_08_07_130600_create_type_tranches_table', 8),
(23, '2024_08_07_132616_create_tranches_table', 8),
(25, '2024_08_08_095115_create_previsions_table', 8),
(26, '2024_08_14_141737_create_clautures_table', 9),
(27, '2024_08_17_150912_create_mois_scolaires_table', 10),
(28, '2024_08_17_150913_create_tvente_fournisseur_table', 11),
(29, '2024_08_17_150914_create_tvente_categorie_produit_table', 11),
(30, '2024_08_17_150915_create_tvente_produit_table', 12),
(31, '2024_08_17_150916_create_tvente_entete_entree_table', 12),
(33, '2024_08_17_150918_create_tvente_entete_requisition_table', 12),
(38, '2024_08_17_150923_create_tvente_taux_table', 12),
(39, '2024_08_17_150924_create_tfin_typeposition_table', 12),
(40, '2024_08_17_150925_create_ttype_mouvement_table', 12),
(41, '2024_08_17_150926_create_tconf_modepaiement_table', 12),
(42, '2024_08_17_150927_create_tfin_typeoperation_table', 12),
(43, '2024_08_17_150928_create_tfin_classe_table', 12),
(44, '2024_08_17_150929_create_tfin_typecompte_table', 12),
(45, '2024_08_17_150930_create_tfin_compte_table', 12),
(46, '2024_08_17_150931_create_tfin_souscompte_table', 12),
(47, '2024_08_17_150932_create_tfin_ssouscompte_table', 12),
(48, '2024_08_17_150932_create_tt_treso_categorie_rubrique_table', 12),
(49, '2024_08_17_150933_create_tt_treso_rubrique_table', 12),
(50, '2024_08_17_150934_create_tt_treso_provenance_table', 12),
(51, '2024_08_17_150935_create_tt_treso_bloc_table', 12),
(52, '2024_08_17_150936_create_tconf_banque', 12),
(53, '2024_08_17_150937_create_tcompte_table', 12),
(54, '2024_08_17_150938_create_tdepense_table', 12),
(55, '2024_08_17_150939_create_tfin_entete_operationcompte_table', 12),
(56, '2024_08_17_150940_create_tfin_detail_operationcompte_table', 12),
(57, '2024_08_17_150941_create_tfin_cloture_comptabilite_table', 12),
(58, '2024_08_17_150942_create_tt_treso_entete_etatbesoin_table', 12),
(59, '2024_08_17_150943_create_ttreso_entete_angagement_table', 12),
(60, '2024_08_17_150944_create_tt_treso_detail_angagement_table', 12),
(61, '2024_08_17_150945_create_tt_treso_detail_etatbesoin_table', 12),
(62, '2024_08_17_150946_create_tfin_cloture_caisse', 12),
(63, '2024_08_17_150947_create_tvente_paiement_table', 13),
(64, '2024_08_17_150948_create_paiements_table', 13),
(65, '2024_08_17_150919_create_tvente_detail_entree_table', 14),
(66, '2024_08_17_150920_create_tvente_detail_vente_table', 14),
(67, '2024_08_17_150921_create_tvente_detail_requisition_table', 14),
(68, '2024_08_17_150917_create_tvente_entete_vente_table', 15),
(69, '2024_09_28_055744_create_tannexe_depense_table', 16);

-- --------------------------------------------------------

--
-- Structure de la table `mois_scolaires`
--

DROP TABLE IF EXISTS `mois_scolaires`;
CREATE TABLE IF NOT EXISTS `mois_scolaires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomMois` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mois_scolaires`
--

INSERT INTO `mois_scolaires` (`id`, `nomMois`, `created_at`, `updated_at`) VALUES
(1, 'Janvier', '2024-08-17 14:26:17', '2024-08-17 14:26:17'),
(2, 'Février', '2024-08-17 14:26:29', '2024-08-17 14:26:29'),
(3, 'Mars', '2024-08-17 14:26:35', '2024-08-17 14:26:35'),
(4, 'Avril', '2024-08-17 14:26:43', '2024-08-17 14:26:43'),
(5, 'Mai', '2024-08-17 14:26:49', '2024-08-17 14:26:49'),
(6, 'Juin', '2024-08-17 14:26:53', '2024-08-17 14:26:53'),
(7, 'Juillet', '2024-08-17 14:26:58', '2024-08-17 14:26:58'),
(8, 'Août', '2024-08-17 14:27:06', '2024-08-17 14:28:04'),
(9, 'Septembre', '2024-08-17 14:27:12', '2024-08-17 14:27:12'),
(10, 'Octobre', '2024-08-17 14:27:19', '2024-08-17 14:27:19'),
(11, 'Novembre', '2024-08-17 14:27:25', '2024-08-17 14:27:25'),
(12, 'Décembre', '2024-08-17 14:27:33', '2024-08-17 14:27:44');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSection` bigint(20) UNSIGNED NOT NULL,
  `nomOption` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `options_idsection_foreign` (`idSection`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id`, `idSection`, `nomOption`, `created_at`, `updated_at`) VALUES
(1, 1, 'Primaire', '2024-06-19 14:06:10', '2024-08-24 06:09:10'),
(2, 2, 'Maternelle', '2024-06-19 14:07:23', '2024-08-24 06:09:18'),
(4, 3, 'Secondaire', '2024-06-19 14:08:07', '2024-08-24 06:09:48');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTranche` bigint(20) UNSIGNED DEFAULT NULL,
  `idFrais` bigint(20) UNSIGNED DEFAULT NULL,
  `idInscription` bigint(20) UNSIGNED DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `datePaiement` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codePaiement` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idUser` bigint(20) UNSIGNED DEFAULT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etatPaiement` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paiements_idtranche_foreign` (`idTranche`),
  KEY `paiements_idfrais_foreign` (`idFrais`),
  KEY `paiements_idinscription_foreign` (`idInscription`),
  KEY `paiements_iduser_foreign` (`idUser`),
  KEY `paiements_refbanque_foreign` (`refBanque`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `idTranche`, `idFrais`, `idInscription`, `montant`, `datePaiement`, `codePaiement`, `idUser`, `refBanque`, `numeroBordereau`, `etatPaiement`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 20, '2024-09-02', '2024-09-13429', 27, 1, '000', 1, '2024-09-02 03:48:20', '2024-09-02 03:50:30'),
(2, 1, 1, 14, 5, '2024-09-18', '2024-09-382012', 27, 1, '00000', 1, '2024-09-18 18:33:11', '2024-09-18 18:33:20');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `nomPays`, `created_at`, `updated_at`) VALUES
(1, 'RDC', '2023-09-04 11:06:39', '2024-06-11 17:11:24'),
(3, 'Rwanda', '2024-01-13 01:35:10', '2024-01-13 01:35:10'),
(4, 'Burundi', '2024-01-13 01:35:22', '2024-01-13 01:35:22'),
(5, 'Ouganda', '2024-01-13 01:35:30', '2024-01-13 01:35:30'),
(6, 'Kenya', '2024-01-13 01:35:39', '2024-01-13 01:35:39'),
(7, 'Tanzanie', '2024-01-13 01:35:47', '2024-01-13 01:35:47');

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

DROP TABLE IF EXISTS `presences`;
CREATE TABLE IF NOT EXISTS `presences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idInscription` bigint(20) UNSIGNED NOT NULL,
  `date_entree` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_sortie` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_presence` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mouvement` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presences_idinscription_foreign` (`idInscription`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `presences`
--

INSERT INTO `presences` (`id`, `idInscription`, `date_entree`, `date_sortie`, `statut_presence`, `motif`, `created_at`, `updated_at`, `mouvement`, `date1`, `date2`) VALUES
(12, 4, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:16:26', '2024-06-22 15:16:26', 'Arrivé', '2024-06-22 17:16:26', NULL),
(13, 6, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:40:56', '2024-06-22 15:40:56', 'Arrivé', '2024-06-22 17:40:56', NULL),
(14, 7, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:41:06', '2024-06-22 15:41:06', 'Arrivé', '2024-06-22 17:41:06', NULL),
(15, 9, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:41:46', '2024-06-22 15:41:46', 'Arrivé', '2024-06-22 17:41:46', NULL),
(16, 11, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:41:52', '2024-06-22 15:41:52', 'Arrivé', '2024-06-22 17:41:52', NULL),
(17, 1, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:42:02', '2024-06-22 15:42:02', 'Arrivé', '2024-06-22 17:42:02', NULL),
(18, 3, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:42:09', '2024-06-22 15:42:09', 'Arrivé', '2024-06-22 17:42:09', NULL),
(19, 5, '2024-06-22', NULL, 'Présent(e)', NULL, '2024-06-22 15:42:18', '2024-06-22 15:42:18', 'Arrivé', '2024-06-22 17:42:18', NULL),
(20, 8, '2024-06-22', NULL, 'Excusé(e)', 'Malade', '2024-06-22 15:42:22', '2024-06-22 15:49:40', 'Arrivé', '2024-06-22 17:49:40', ' 17:49:40'),
(22, 1, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 09:49:07', '2024-06-25 09:49:07', 'Arrivé', '2024-06-25 11:49:07', NULL),
(23, 4, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 09:50:50', '2024-06-25 09:50:50', 'Arrivé', '2024-06-25 11:50:50', NULL),
(24, 7, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 09:51:59', '2024-06-25 09:51:59', 'Arrivé', '2024-06-25 11:51:59', NULL),
(25, 3, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 09:53:19', '2024-06-25 09:53:19', 'Arrivé', '2024-06-25 11:53:19', NULL),
(26, 9, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 09:56:54', '2024-06-25 09:56:54', 'Arrivé', '2024-06-25 11:56:54', NULL),
(27, 5, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 10:08:58', '2024-06-25 10:08:58', 'Arrivé', '2024-06-25 12:08:58', NULL),
(28, 8, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 10:09:07', '2024-06-25 10:09:07', 'Arrivé', '2024-06-25 12:09:07', NULL),
(31, 8, '2024-06-23', NULL, 'Présent(e)', NULL, '2024-06-25 12:05:34', '2024-06-25 12:05:34', 'Arrivé', '2024-06-23 14:05:34', NULL),
(32, 8, '2024-06-24', NULL, 'Absent(e)', NULL, '2024-06-25 12:06:01', '2024-06-25 12:06:01', 'Arrivé', '2024-06-24 14:06:01', NULL),
(33, 8, '2024-06-21', NULL, 'Excusé(e)', 'Maladie: Bas ventre', '2024-06-25 12:06:45', '2024-06-25 12:06:45', 'Arrivé', '2024-06-21 14:06:45', ' 14:06:45'),
(34, 2, '2024-06-25', NULL, 'Présent(e)', NULL, '2024-06-25 12:16:25', '2024-06-25 12:16:25', 'Arrivé', '2024-06-25 14:16:25', NULL),
(35, 2, '2024-06-24', NULL, 'Présent(e)', NULL, '2024-06-25 12:17:13', '2024-06-25 12:17:13', 'Arrivé', '2024-06-24 14:17:13', NULL),
(36, 2, '2024-06-23', NULL, 'Absent(e)', NULL, '2024-06-25 12:17:28', '2024-06-25 12:17:28', 'Arrivé', '2024-06-23 14:17:28', NULL),
(37, 2, '2024-06-22', '2024-06-25', 'Excusé(e)', 'Made', '2024-06-25 12:17:49', '2024-06-25 12:17:49', 'Arrivé', '2024-06-22 14:17:49', '2024-06-25 14:17:49'),
(38, 2, '2024-06-21', NULL, 'Présent(e)', NULL, '2024-06-25 12:18:07', '2024-06-25 12:18:07', 'Arrivé', '2024-06-21 14:18:07', NULL),
(39, 2, '2024-06-20', NULL, 'Présent(e)', NULL, '2024-06-25 12:18:14', '2024-06-25 12:18:14', 'Arrivé', '2024-06-20 14:18:14', NULL),
(40, 2, '2024-06-19', NULL, 'Présent(e)', NULL, '2024-06-25 12:18:21', '2024-06-25 12:18:21', 'Arrivé', '2024-06-19 14:18:20', NULL),
(41, 2, '2024-06-18', NULL, 'Présent(e)', NULL, '2024-06-25 12:18:29', '2024-06-25 12:18:29', 'Arrivé', '2024-06-18 14:18:28', NULL),
(42, 6, '2024-07-01', NULL, 'Présent(e)', NULL, '2024-07-01 07:48:19', '2024-07-01 07:48:19', 'Arrivé', '2024-07-01 09:48:19', NULL),
(43, 4, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:33:35', '2024-08-08 11:33:35', 'Arrivé', '2024-08-08 13:33:35', NULL),
(44, 7, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:34:18', '2024-08-08 11:34:18', 'Arrivé', '2024-08-08 13:34:18', NULL),
(45, 3, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:20', '2024-08-08 11:35:20', 'Arrivé', '2024-08-08 13:35:19', NULL),
(46, 5, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:26', '2024-08-08 11:35:26', 'Arrivé', '2024-08-08 13:35:26', NULL),
(47, 1, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:29', '2024-08-08 11:35:29', 'Arrivé', '2024-08-08 13:35:29', NULL),
(48, 2, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:34', '2024-08-08 11:35:34', 'Arrivé', '2024-08-08 13:35:34', NULL),
(49, 6, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:39', '2024-08-08 11:35:39', 'Arrivé', '2024-08-08 13:35:39', NULL),
(50, 9, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:35:52', '2024-08-08 11:35:52', 'Arrivé', '2024-08-08 13:35:52', NULL),
(51, 8, '2024-08-08', NULL, 'Présent(e)', NULL, '2024-08-08 11:36:00', '2024-08-08 11:36:00', 'Arrivé', '2024-08-08 13:36:00', NULL),
(52, 12, '2024-08-18', NULL, 'Présent(e)', NULL, '2024-08-18 07:46:42', '2024-08-18 07:46:42', 'Arrivé', '2024-08-18 09:46:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `previsions`
--

DROP TABLE IF EXISTS `previsions`;
CREATE TABLE IF NOT EXISTS `previsions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTranche` bigint(20) UNSIGNED DEFAULT NULL,
  `idFrais` bigint(20) UNSIGNED DEFAULT NULL,
  `idClasse` bigint(20) UNSIGNED DEFAULT NULL,
  `idAnne` bigint(20) UNSIGNED DEFAULT NULL,
  `idOption` bigint(20) UNSIGNED DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `etatPrevision` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_debit_prev` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_fin_prev` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `previsions_idtranche_foreign` (`idTranche`),
  KEY `previsions_idfrais_foreign` (`idFrais`),
  KEY `previsions_idclasse_foreign` (`idClasse`),
  KEY `previsions_idanne_foreign` (`idAnne`),
  KEY `previsions_idoption_foreign` (`idOption`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `previsions`
--

INSERT INTO `previsions` (`id`, `idTranche`, `idFrais`, `idClasse`, `idAnne`, `idOption`, `montant`, `etatPrevision`, `created_at`, `updated_at`, `date_debit_prev`, `date_fin_prev`) VALUES
(1, 1, 1, 1, 3, 2, 75, 0, '2024-08-08 12:56:03', '2024-08-08 12:56:03', '2024-09-01', '2024-11-01'),
(2, 1, 1, 1, 3, 1, 75, 0, '2024-08-09 06:37:39', '2024-08-09 06:37:39', '2024-09-01', '2024-11-01'),
(3, 1, 1, 2, 3, 1, 50, 0, '2024-08-09 06:51:48', '2024-08-09 06:51:48', '2024-09-01', '2024-11-01'),
(4, 1, 1, 3, 3, 1, 50, 0, '2024-08-09 06:51:52', '2024-08-09 06:51:52', '2024-09-01', '2024-11-01'),
(5, 1, 1, 4, 3, 1, 50, 0, '2024-08-09 06:51:55', '2024-08-09 06:51:55', '2024-09-01', '2024-11-01'),
(6, 2, 1, 1, 3, 1, 50, 0, '2024-08-09 06:52:01', '2024-08-09 06:52:01', '2024-11-01', '2025-01-01'),
(7, 2, 1, 2, 3, 1, 50, 0, '2024-08-09 06:52:05', '2024-08-09 06:52:05', '2024-11-01', '2025-01-01'),
(8, 2, 1, 3, 3, 1, 50, 0, '2024-08-09 06:52:09', '2024-08-09 06:52:09', '2024-11-01', '2025-01-01'),
(9, 2, 1, 4, 3, 1, 50, 0, '2024-08-09 06:52:17', '2024-08-09 06:52:17', '2024-11-01', '2025-01-01'),
(10, 3, 1, 1, 3, 1, 50, 0, '2024-08-09 06:52:35', '2024-08-09 06:52:35', '2025-01-01', '2025-03-01'),
(11, 3, 1, 2, 3, 1, 50, 0, '2024-08-09 06:52:38', '2024-08-09 06:52:38', '2025-01-01', '2025-03-01'),
(12, 3, 1, 3, 3, 1, 50, 0, '2024-08-09 06:52:41', '2024-08-09 06:52:41', '2025-01-01', '2025-03-01'),
(13, 3, 1, 4, 3, 1, 50, 0, '2024-08-09 06:52:45', '2024-08-09 06:52:45', '2025-01-01', '2025-03-01'),
(14, 1, 1, 1, 3, 4, 50, 0, '2024-08-09 06:55:46', '2024-08-09 06:55:46', '2024-09-01', '2024-11-01'),
(15, 1, 1, 2, 3, 4, 50, 0, '2024-08-09 06:55:50', '2024-08-09 06:55:50', '2024-09-01', '2024-11-01'),
(16, 1, 1, 3, 3, 4, 50, 0, '2024-08-09 06:55:54', '2024-08-09 06:55:54', '2024-09-01', '2024-11-01'),
(17, 1, 1, 1, 3, 2, 50, 0, '2024-08-09 06:56:13', '2024-08-09 06:56:13', '2024-09-01', '2024-11-01'),
(18, 1, 1, 2, 3, 2, 50, 0, '2024-08-09 06:56:16', '2024-08-09 06:56:16', '2024-09-01', '2024-11-01'),
(19, 1, 1, 3, 3, 2, 50, 0, '2024-08-09 06:56:19', '2024-08-09 06:56:19', '2024-09-01', '2024-11-01'),
(22, 2, 1, 3, 3, 2, 50, 0, '2024-08-09 06:56:38', '2024-08-09 06:56:38', '2024-11-01', '2025-01-01'),
(23, 2, 1, 2, 3, 2, 50, 0, '2024-08-09 06:56:40', '2024-08-09 06:56:40', '2024-11-01', '2025-01-01'),
(24, 2, 1, 1, 3, 2, 50, 0, '2024-08-09 06:56:43', '2024-08-09 06:56:43', '2024-11-01', '2025-01-01'),
(25, 3, 1, 1, 3, 2, 75, 0, '2024-08-09 06:56:49', '2024-08-09 06:56:49', '2025-01-01', '2025-03-01'),
(26, 3, 1, 2, 3, 2, 75, 0, '2024-08-09 06:56:52', '2024-08-09 06:56:52', '2025-01-01', '2025-03-01'),
(27, 3, 1, 3, 3, 2, 75, 0, '2024-08-09 06:56:55', '2024-08-09 06:56:55', '2025-01-01', '2025-03-01'),
(42, 1, 6, 4, 3, 1, 30, 0, '2024-08-09 06:59:48', '2024-08-09 06:59:48', '2024-09-01', '2024-11-01'),
(43, 1, 6, 3, 3, 1, 15, 0, '2024-08-09 06:59:57', '2024-08-09 06:59:57', '2024-09-01', '2024-11-01'),
(44, 1, 6, 2, 3, 1, 15, 0, '2024-08-09 07:00:00', '2024-08-09 07:00:00', '2024-09-01', '2024-11-01'),
(45, 1, 6, 1, 3, 1, 15, 0, '2024-08-09 07:00:02', '2024-08-09 07:00:02', '2024-09-01', '2024-11-01'),
(46, 1, 6, 1, 3, 1, 15, 0, '2024-08-09 07:02:12', '2024-08-09 07:02:12', '2024-09-01', '2024-11-01'),
(47, 2, 2, 1, 3, 1, 15, 0, '2024-08-09 07:03:59', '2024-08-09 07:03:59', '2024-11-01', '2025-01-01'),
(48, 2, 2, 2, 3, 1, 15, 0, '2024-08-09 07:04:02', '2024-08-09 07:04:02', '2024-11-01', '2025-01-01'),
(49, 2, 2, 3, 3, 1, 15, 0, '2024-08-09 07:04:04', '2024-08-09 07:04:04', '2024-11-01', '2025-01-01'),
(50, 2, 2, 4, 3, 1, 15, 0, '2024-08-09 07:04:08', '2024-08-09 07:04:08', '2024-11-01', '2025-01-01'),
(51, 2, 3, 1, 3, 4, 10, 0, '2024-08-09 07:04:27', '2024-08-09 07:04:27', '2024-11-01', '2025-01-01'),
(52, 2, 3, 2, 3, 4, 10, 0, '2024-08-09 07:04:30', '2024-08-09 07:04:30', '2024-11-01', '2025-01-01'),
(53, 2, 3, 3, 3, 4, 10, 0, '2024-08-09 07:04:32', '2024-08-09 07:04:32', '2024-11-01', '2025-01-01'),
(54, 2, 3, 4, 3, 4, 10, 0, '2024-08-09 07:04:34', '2024-08-09 07:04:34', '2024-11-01', '2025-01-01'),
(61, 1, 1, 4, 3, 2, 930, 0, '2024-09-18 17:27:22', '2024-09-18 17:27:22', '2024-09-18', '2024-09-22');

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPays` int(11) NOT NULL,
  `nomProvince` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `idPays`, `nomProvince`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nord kivu', '2023-09-04 11:09:30', '2023-09-04 11:12:12'),
(2, 1, 'Maniema', '2023-09-04 11:09:47', '2023-09-04 11:09:47'),
(4, 1, 'Kinshasa', '2024-01-13 01:40:32', '2024-01-13 01:40:32'),
(5, 1, 'Sud-Kivu', '2024-01-13 01:41:00', '2024-01-13 01:41:00');

-- --------------------------------------------------------

--
-- Structure de la table `quartiers`
--

DROP TABLE IF EXISTS `quartiers`;
CREATE TABLE IF NOT EXISTS `quartiers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCommune` int(11) NOT NULL,
  `nomQuartier` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quartiers`
--

INSERT INTO `quartiers` (`id`, `idCommune`, `nomQuartier`, `created_at`, `updated_at`) VALUES
(2, 2, 'Mabanga sud', '2023-09-04 11:28:03', '2023-09-04 11:28:03'),
(3, 2, 'Mabanga nord', '2023-09-04 11:28:34', '2023-09-04 11:28:42'),
(4, 2, 'Katoyi', '2023-09-04 11:29:10', '2023-09-04 11:29:10'),
(5, 1, 'Kyeshero', '2023-09-04 11:29:32', '2024-01-15 07:11:08'),
(7, 1, 'Les volcans', '2024-01-13 01:56:55', '2024-01-13 01:56:55'),
(8, 1, 'Katindo', '2024-01-13 01:57:12', '2024-01-13 01:57:12'),
(9, 1, 'Himbi 1', '2024-01-15 07:12:03', '2024-01-15 07:22:02'),
(10, 2, 'Murara', '2024-01-15 07:12:31', '2024-01-15 07:12:31'),
(11, 2, 'Turunga', '2024-01-15 07:13:37', '2024-01-15 07:39:36'),
(12, 2, 'Majengo', '2024-01-15 07:13:58', '2024-01-15 07:13:58'),
(13, 2, 'Kasika', '2024-01-15 07:14:29', '2024-01-15 07:14:29'),
(14, 1, 'Mugunga', '2024-01-15 07:15:19', '2024-01-15 07:15:19'),
(15, 1, 'CCLK', '2024-01-15 07:15:34', '2024-01-15 07:15:34'),
(16, 2, 'Bujovu', '2024-01-15 07:16:47', '2024-01-15 07:17:48'),
(17, 1, 'Mapendo', '2024-01-15 07:17:05', '2024-01-15 07:17:05'),
(18, 2, 'Kahembe', '2024-01-15 07:17:41', '2024-01-15 07:17:41'),
(19, 2, 'Katoyi', '2024-01-15 07:18:12', '2024-01-15 07:18:12'),
(20, 2, 'Katindo 2', '2024-01-15 07:18:45', '2024-01-15 07:18:45'),
(21, 2, 'Buhene', '2024-01-15 07:19:11', '2024-01-15 07:19:11'),
(22, 2, 'Don bosco ngangi', '2024-01-15 07:19:29', '2024-01-15 07:19:29'),
(23, 1, 'Himbi 2', '2024-01-15 07:21:50', '2024-01-15 07:21:50'),
(24, 1, 'Nyarubande', '2024-01-15 07:22:33', '2024-01-15 07:22:33'),
(25, 2, 'Autre', '2024-01-15 07:23:18', '2024-01-15 07:23:18'),
(26, 1, 'Autre', '2024-01-15 07:23:39', '2024-01-15 07:23:39'),
(27, 2, 'Virunga', '2024-04-05 04:03:48', '2024-04-05 04:03:48'),
(28, 2, 'Ndosho', '2024-04-05 04:04:09', '2024-06-11 17:49:38');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2023-08-25 09:55:35', '2024-06-10 12:26:18'),
(2, 'User', '2023-08-25 09:55:35', '2023-08-25 09:07:32'),
(3, 'Member', '2024-06-10 12:33:22', '2024-06-10 12:33:37');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomSection` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `nomSection`, `created_at`, `updated_at`) VALUES
(1, 'Primaire', '2024-06-19 12:24:40', '2024-08-24 06:08:45'),
(2, 'Maternelle', '2024-06-19 12:24:54', '2024-08-24 06:08:34'),
(3, 'Secondaire', '2024-06-19 12:25:18', '2024-08-24 06:08:15');

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objectif` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `politique` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `condition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sites`
--

INSERT INTO `sites` (`id`, `nom`, `description`, `email`, `adresse`, `tel1`, `tel2`, `tel3`, `token`, `about`, `mission`, `objectif`, `politique`, `condition`, `logo`, `facebook`, `linkedin`, `twitter`, `youtube`, `created_at`, `updated_at`) VALUES
(1, 'Lycée moderne les élites', 'Lycée moderne les élites Système est une application de gestion des données scolaires', 'lycemoderne@gmail.com', 'Goma commune de Karisimbi,  quartier Mabanga sud, avenue mushanganya', '+243817883541', '+243854543870', '+243970524665', NULL, NULL, 'mission', 'objectif', 'politique', 'condition', '1692963266.jpg', 'https://web.facebook.com/dreamofdrc', NULL, NULL, NULL, '2023-08-25 09:22:16', '2024-08-10 09:16:46');

-- --------------------------------------------------------

--
-- Structure de la table `tannexe_depense`
--

DROP TABLE IF EXISTS `tannexe_depense`;
CREATE TABLE IF NOT EXISTS `tannexe_depense` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms_annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refDepense` bigint(20) UNSIGNED NOT NULL,
  `annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tannexe_depense_refdepense_foreign` (`refDepense`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tannexe_depense`
--

INSERT INTO `tannexe_depense` (`id`, `noms_annexe`, `refDepense`, `annexe`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ACHAT DES MATERIELS DE CHANTIER', 14, '1727549595.png', '', 'NON', 'user', '2024-09-28 16:53:16', '2024-09-28 16:53:16');

-- --------------------------------------------------------

--
-- Structure de la table `tcompte`
--

DROP TABLE IF EXISTS `tcompte`;
CREATE TABLE IF NOT EXISTS `tcompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refMvt` bigint(20) UNSIGNED NOT NULL,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcompte_refmvt_foreign` (`refMvt`),
  KEY `tcompte_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tcompte`
--

INSERT INTO `tcompte` (`id`, `designation`, `refMvt`, `refSscompte`, `created_at`, `updated_at`) VALUES
(1, 'PAIEMENT DES FRAIS SCOLAIRES', 1, 4, '2024-09-02 07:15:35', '2024-09-02 07:15:35'),
(2, 'VENTES DES FOURNITURES SCOLAIRES', 1, 4, '2024-09-02 07:15:59', '2024-09-02 07:15:59'),
(3, 'PAIEMENT AGENTS', 2, 5, '2024-09-02 07:19:41', '2024-09-02 07:19:41'),
(4, 'CONTRUCTIONS', 2, 5, '2024-09-02 07:20:14', '2024-09-02 07:20:14'),
(5, 'DEPENSES DIVERSES', 2, 5, '2024-09-02 07:20:45', '2024-09-02 07:20:45');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_banque`
--

DROP TABLE IF EXISTS `tconf_banque`;
CREATE TABLE IF NOT EXISTS `tconf_banque` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_banque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numerocompte` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tconf_banque_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_banque`
--

INSERT INTO `tconf_banque` (`id`, `nom_banque`, `numerocompte`, `nom_mode`, `refSscompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 'CAISSE', '00000000000', 'CASH', 3, 'Roger Admin', '2024-09-02 03:33:24', '2024-09-02 03:33:24'),
(2, 'EQUITY BANK', '23009876545678', 'BANQUE', 2, 'Roger Admin', '2024-09-02 03:34:31', '2024-09-02 03:34:31'),
(3, 'ROW BANK', '5670098765456', 'BANQUE', 2, 'Roger Admin', '2024-09-02 03:34:58', '2024-09-02 03:34:58');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_modepaiement`
--

DROP TABLE IF EXISTS `tconf_modepaiement`;
CREATE TABLE IF NOT EXISTS `tconf_modepaiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_modepaiement`
--

INSERT INTO `tconf_modepaiement` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'CASH', '2024-09-02 03:15:01', '2024-09-02 03:15:01'),
(2, 'BANQUE', '2024-09-02 03:15:15', '2024-09-02 03:15:15');

-- --------------------------------------------------------

--
-- Structure de la table `tdepense`
--

DROP TABLE IF EXISTS `tdepense`;
CREATE TABLE IF NOT EXISTS `tdepense` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `montant` double NOT NULL DEFAULT '0',
  `montantLettre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `motif` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateOperation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `refMvt` int(11) DEFAULT NULL,
  `refCompte` int(11) DEFAULT NULL,
  `modepaie` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `refBanque` bigint(20) DEFAULT NULL,
  `numeroBordereau` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `taux_dujour` double DEFAULT NULL,
  `AcquitterPar` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `StatutAcquitterPar` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'NON',
  `DateAcquitterPar` datetime DEFAULT NULL,
  `ApproCoordi` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `StatutApproCoordi` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'NON',
  `DateApproCoordi` datetime DEFAULT NULL,
  `numeroBE` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '00000',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted` varchar(5) NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tdepense`
--

INSERT INTO `tdepense` (`id`, `created_at`, `updated_at`, `montant`, `montantLettre`, `motif`, `dateOperation`, `refMvt`, `refCompte`, `modepaie`, `refBanque`, `numeroBordereau`, `taux_dujour`, `AcquitterPar`, `StatutAcquitterPar`, `DateAcquitterPar`, `ApproCoordi`, `StatutApproCoordi`, `DateApproCoordi`, `numeroBE`, `author`, `deleted`, `author_deleted`) VALUES
(1, '2023-09-18 01:27:07', '2023-09-18 01:27:07', 3, 'USD', 'VENTES RESTO&BAR', '2023-09-13', 1, 1, 'CASH', 1, '00000000', 2300, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'administrateur', 'NON', NULL),
(2, '2023-09-18 01:27:07', '2023-09-18 01:27:07', 100, 'USD', 'RESERVATIONS CHAMBRE', '2023-09-13', 1, 2, 'CASH', 1, '00000000', 2300, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'administrateur', 'NON', NULL),
(3, '2023-09-18 01:27:07', '2023-09-18 01:27:07', 395, 'USD', 'RESERVATIONS SALLE', '2023-09-13', 1, 3, 'CASH', 1, '00000000', 2300, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'administrateur', 'NON', NULL),
(4, '2023-09-18 01:27:07', '2023-09-18 01:27:07', 5, 'USD', 'RESERVATIONS SALLE', '2023-09-13', 1, 4, 'CASH', 1, '00000000', 2300, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'administrateur', 'NON', NULL),
(5, '2023-09-18 01:45:51', '2023-09-18 01:46:01', 60, '60', 'PAIEMENT TAXES DE L\'ETAT', '2023-09-13', 2, 7, 'BANQUE', 2, '0000000', 2300, 'administrateur', 'OUI', '2023-09-18 00:00:00', 'administrateur', 'OUI', '2023-09-18 00:00:00', 'BE20239001', 'administrateur', 'NON', NULL),
(6, '2023-09-18 02:34:31', '2023-09-18 02:34:31', 20, '20', 'ENTREE', '2023-09-18', 1, 6, 'CASH', 1, '00000', 2300, NULL, 'NON', NULL, NULL, 'NON', NULL, NULL, 'administrateur', 'NON', NULL),
(7, '2024-09-02 07:24:58', '2024-09-02 07:25:29', 200, 'DEUX CENTS', 'VENTE DES SERVICES', '2024-09-02', 1, 2, 'CASH', 1, '000', 2800, 'Roger Admin', 'OUI', '2024-09-02 00:00:00', 'Roger Admin', 'OUI', '2024-09-02 00:00:00', NULL, 'Roger Admin', 'NON', NULL),
(8, '2024-09-02 09:00:16', '2024-09-02 09:00:25', 0, 'DEUX CENTS', 'ACHAT MATERIELS', '2024-09-02', 2, 5, 'CASH', 1, '000', 2800, 'Roger Admin', 'OUI', '2024-09-02 00:00:00', 'Roger Admin', 'OUI', '2024-09-02 00:00:00', 'BE20249003', 'Roger Admin', 'NON', NULL),
(9, '2024-09-02 09:23:42', '2024-09-02 09:23:42', 32, 'USD', 'VENTES RESTO&BAR', '2024-09-02', 1, 2, 'CASH', 1, '00000000', 2800, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'Roger Admin', 'NON', NULL),
(10, '2024-09-02 09:28:37', '2024-09-02 09:28:37', 32, 'USD', 'VENTES RESTO&BAR', '2024-09-02', 1, 2, 'CASH', 1, '00000000', 2800, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'Roger Admin', 'NON', NULL),
(11, '2024-09-02 09:34:42', '2024-09-02 09:34:42', 32, 'USD', 'VENTES RESTO&BAR', '2024-09-02', 1, 2, 'CASH', 1, '00000000', 2800, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'Roger Admin', 'NON', NULL),
(12, '2024-09-02 09:37:06', '2024-09-02 09:37:06', 32, 'USD', 'VENTES RESTO&BAR', '2024-09-02', 1, 2, 'CASH', 1, '00000000', 2800, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'Roger Admin', 'NON', NULL),
(13, '2024-09-02 09:37:06', '2024-09-02 11:32:56', 20, 'USD', 'PAIEMENT FRAIS SCOLAIRE', '2024-09-02', 1, 1, 'CASH', 1, '00000000', 2800, 'Roger Admin', 'OUI', '2024-09-02 00:00:00', 'Roger Admin', 'OUI', '2024-09-02 00:00:00', '00000', 'Roger Admin', 'NON', NULL),
(14, '2024-09-02 11:27:04', '2024-09-02 11:28:38', 30, 'TRENTE', 'RESTAURATION AGENT', '2024-09-03', 2, 5, 'CASH', 1, '000', 2800, 'Roger Admin', 'OUI', '2024-09-02 00:00:00', 'Roger Admin', 'OUI', '2024-09-02 00:00:00', '0000', 'Roger Admin', 'NON', NULL),
(15, '2024-09-16 19:32:59', '2024-09-16 19:32:59', 48, 'USD', 'VENTES RESTO&BAR', '2024-09-16', 1, 2, 'CASH', 1, '00000000', 2800, NULL, 'NON', NULL, NULL, 'NON', NULL, '00000', 'Roger Admin', 'NON', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tfin_classe`
--

DROP TABLE IF EXISTS `tfin_classe`;
CREATE TABLE IF NOT EXISTS `tfin_classe` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_classe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_classe`
--

INSERT INTO `tfin_classe` (`id`, `nom_classe`, `numero_classe`, `author`, `created_at`, `updated_at`) VALUES
(1, 'TRESORERIE', '5', 'Roger Admin', '2024-09-02 03:16:51', '2024-09-02 03:17:38'),
(2, 'CHARGE DIVERSE', '6', 'Roger Admin', '2024-09-02 03:17:11', '2024-09-02 03:17:11'),
(3, 'PRODUIT', '7', 'Roger Admin', '2024-09-02 03:17:54', '2024-09-02 03:17:54');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_cloture_caisse`
--

DROP TABLE IF EXISTS `tfin_cloture_caisse`;
CREATE TABLE IF NOT EXISTS `tfin_cloture_caisse` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `date_cloture` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_cloture` double NOT NULL,
  `taux_dujour` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_cloture_caisse_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_cloture_caisse`
--

INSERT INTO `tfin_cloture_caisse` (`id`, `refSscompte`, `date_cloture`, `montant_cloture`, `taux_dujour`, `author`, `created_at`, `updated_at`) VALUES
(1, 0, '2024-09-02', 0, 2800, 'Roger Admin', '2024-09-02 09:37:06', '2024-09-02 09:37:06'),
(2, 0, '2024-09-16', 0, 2800, 'Roger Admin', '2024-09-16 19:32:59', '2024-09-16 19:32:59');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_cloture_comptabilite`
--

DROP TABLE IF EXISTS `tfin_cloture_comptabilite`;
CREATE TABLE IF NOT EXISTS `tfin_cloture_comptabilite` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numerOperation` int(11) NOT NULL,
  `dateCloture` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tauxdujour` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_cloture_comptabilite`
--

INSERT INTO `tfin_cloture_comptabilite` (`id`, `numerOperation`, `dateCloture`, `tauxdujour`, `author`, `created_at`, `updated_at`) VALUES
(1, 0, '2024-09-02', 2800, 'Roger Admin', '2024-09-02 10:03:49', '2024-09-02 10:03:49');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_compte`
--

DROP TABLE IF EXISTS `tfin_compte`;
CREATE TABLE IF NOT EXISTS `tfin_compte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClasse` bigint(20) UNSIGNED NOT NULL,
  `refTypecompte` bigint(20) UNSIGNED NOT NULL,
  `refPosition` bigint(20) UNSIGNED NOT NULL,
  `nom_compte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_compte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_compte_refclasse_foreign` (`refClasse`),
  KEY `tfin_compte_reftypecompte_foreign` (`refTypecompte`),
  KEY `tfin_compte_refposition_foreign` (`refPosition`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_compte`
--

INSERT INTO `tfin_compte` (`id`, `refClasse`, `refTypecompte`, `refPosition`, `nom_compte`, `numero_compte`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'CAISSE', '57', 'Roger Admin', '2024-09-02 03:19:58', '2024-09-02 03:19:58'),
(2, 1, 1, 1, 'BANQUE', '52', 'Roger Admin', '2024-09-02 03:20:16', '2024-09-02 03:20:16'),
(3, 3, 1, 2, 'PRODUIT', '70', 'Roger Admin', '2024-09-02 03:20:44', '2024-09-02 03:20:44'),
(4, 2, 2, 1, 'CHARGES DIVERSES', '60', 'Roger Admin', '2024-09-02 03:21:10', '2024-09-02 03:21:10');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_detail_operationcompte`
--

DROP TABLE IF EXISTS `tfin_detail_operationcompte`;
CREATE TABLE IF NOT EXISTS `tfin_detail_operationcompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteOperation` bigint(20) UNSIGNED NOT NULL,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `typeOperation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montantOpration` double NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_detail_operationcompte_refenteteoperation_foreign` (`refEnteteOperation`),
  KEY `tfin_detail_operationcompte_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_detail_operationcompte`
--

INSERT INTO `tfin_detail_operationcompte` (`id`, `refEnteteOperation`, `refSscompte`, `typeOperation`, `montantOpration`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'DEBIT', 200, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(2, 1, 4, 'CREDIT', 200, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(3, 2, 5, 'DEBIT', 0, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(4, 2, 3, 'CREDIT', 0, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(5, 3, 3, 'DEBIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(6, 3, 4, 'CREDIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(7, 4, 3, 'DEBIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(8, 4, 4, 'CREDIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(9, 5, 3, 'DEBIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(10, 5, 4, 'CREDIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(11, 6, 3, 'DEBIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(12, 6, 4, 'CREDIT', 32, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(13, 7, 3, 'DEBIT', 20, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(14, 7, 4, 'CREDIT', 20, 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_entete_operationcompte`
--

DROP TABLE IF EXISTS `tfin_entete_operationcompte`;
CREATE TABLE IF NOT EXISTS `tfin_entete_operationcompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refTresorerie` bigint(20) UNSIGNED NOT NULL,
  `libelleOperation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOpration` date NOT NULL,
  `numOpereation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tauxdujour` double NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_entete_operationcompte_reftresorerie_foreign` (`refTresorerie`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_entete_operationcompte`
--

INSERT INTO `tfin_entete_operationcompte` (`id`, `refTresorerie`, `libelleOperation`, `dateOpration`, `numOpereation`, `tauxdujour`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'VENTES DES FOURNITURES SCOLAIRES', '2024-09-02', '7', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(2, 1, 'DEPENSES DIVERSES', '2024-09-02', '8', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(3, 1, 'VENTES DES FOURNITURES SCOLAIRES', '2024-09-02', '9', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(4, 1, 'VENTES DES FOURNITURES SCOLAIRES', '2024-09-02', '10', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(5, 1, 'VENTES DES FOURNITURES SCOLAIRES', '2024-09-02', '11', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(6, 1, 'VENTES DES FOURNITURES SCOLAIRES', '2024-09-02', '12', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49'),
(7, 1, 'PAIEMENT DES FRAIS SCOLAIRES', '2024-09-02', '13', 2800, 'Roger Admin', 'NON', 'user', '2024-09-02 10:03:49', '2024-09-02 10:03:49');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_souscompte`
--

DROP TABLE IF EXISTS `tfin_souscompte`;
CREATE TABLE IF NOT EXISTS `tfin_souscompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refCompte` bigint(20) UNSIGNED NOT NULL,
  `nom_souscompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_souscompte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_souscompte_refcompte_foreign` (`refCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_souscompte`
--

INSERT INTO `tfin_souscompte` (`id`, `refCompte`, `nom_souscompte`, `numero_souscompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'CAISSE', '57.1', 'Roger Admin', '2024-09-02 03:21:33', '2024-09-02 03:21:33'),
(2, 2, 'BANQUE', '52.1', 'Roger Admin', '2024-09-02 03:21:54', '2024-09-02 03:21:54'),
(3, 3, 'PRODUIT', '70.1', 'Roger Admin', '2024-09-02 03:22:12', '2024-09-02 03:22:12'),
(4, 4, 'CHARGES DIVERSES', '60.1', 'Roger Admin', '2024-09-02 03:22:45', '2024-09-02 03:22:45');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_ssouscompte`
--

DROP TABLE IF EXISTS `tfin_ssouscompte`;
CREATE TABLE IF NOT EXISTS `tfin_ssouscompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refSousCompte` bigint(20) UNSIGNED NOT NULL,
  `nom_ssouscompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_ssouscompte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tfin_ssouscompte_refsouscompte_foreign` (`refSousCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_ssouscompte`
--

INSERT INTO `tfin_ssouscompte` (`id`, `refSousCompte`, `nom_ssouscompte`, `numero_ssouscompte`, `author`, `created_at`, `updated_at`) VALUES
(2, 2, 'BANQUE', '52.1.1', 'Roger Admin', '2024-09-02 03:23:50', '2024-09-02 03:23:50'),
(3, 1, 'CAISSE', '57.1.1', 'Roger Admin', '2024-09-02 03:24:00', '2024-09-02 03:24:00'),
(4, 3, 'PRODUIT', '70.1.1', 'Roger Admin', '2024-09-02 03:24:33', '2024-09-02 03:24:33'),
(5, 4, 'CHARGES DIVERSES', '60.1.1', 'Roger Admin', '2024-09-02 03:25:18', '2024-09-02 03:25:18');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typecompte`
--

DROP TABLE IF EXISTS `tfin_typecompte`;
CREATE TABLE IF NOT EXISTS `tfin_typecompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typecompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_typecompte`
--

INSERT INTO `tfin_typecompte` (`id`, `nom_typecompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 'ACTIF', 'Roger Admin', '2024-09-02 03:18:43', '2024-09-02 03:18:54'),
(2, 'PASSIF', 'Roger Admin', '2024-09-02 03:19:02', '2024-09-02 03:19:02');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typeoperation`
--

DROP TABLE IF EXISTS `tfin_typeoperation`;
CREATE TABLE IF NOT EXISTS `tfin_typeoperation` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typeoperation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_typeoperation`
--

INSERT INTO `tfin_typeoperation` (`id`, `nom_typeoperation`, `author`, `created_at`, `updated_at`) VALUES
(1, 'DEBUT', 'Roger Admin', '2024-09-04 07:57:26', '2024-09-04 07:57:26'),
(2, 'CREDIT', 'Roger Admin', '2024-09-04 07:57:40', '2024-09-04 07:57:40');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typeposition`
--

DROP TABLE IF EXISTS `tfin_typeposition`;
CREATE TABLE IF NOT EXISTS `tfin_typeposition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typeposition` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_typeposition`
--

INSERT INTO `tfin_typeposition` (`id`, `nom_typeposition`, `author`, `created_at`, `updated_at`) VALUES
(1, 'D', 'Roger Admin', '2024-09-02 03:19:25', '2024-09-02 03:19:25'),
(2, 'C', 'Roger Admin', '2024-09-02 03:19:31', '2024-09-02 03:19:31');

-- --------------------------------------------------------

--
-- Structure de la table `tranches`
--

DROP TABLE IF EXISTS `tranches`;
CREATE TABLE IF NOT EXISTS `tranches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomTranche` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tranches`
--

INSERT INTO `tranches` (`id`, `nomTranche`, `created_at`, `updated_at`) VALUES
(1, 'Première Tranche', '2024-08-08 12:17:26', '2024-08-08 12:18:05'),
(2, 'Deuxième Tranche', '2024-08-08 12:17:44', '2024-08-08 12:17:44'),
(3, 'Trosième Tranche', '2024-08-08 12:17:58', '2024-08-08 12:17:58');

-- --------------------------------------------------------

--
-- Structure de la table `ttreso_entete_angagement`
--

DROP TABLE IF EXISTS `ttreso_entete_angagement`;
CREATE TABLE IF NOT EXISTS `ttreso_entete_angagement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refProvenance` int(11) NOT NULL,
  `refBloc` int(11) NOT NULL,
  `motif` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dateEngagement` datetime NOT NULL,
  `refCaisse` int(11) NOT NULL,
  `montant` double NOT NULL DEFAULT '0',
  `dateValiderDemandeur` datetime DEFAULT NULL,
  `StatutValiderDemandeur` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderDemandeur` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateValidertDivision` datetime DEFAULT NULL,
  `StatutValiderDivision` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderDivision` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateAtesterDivision` datetime DEFAULT NULL,
  `StatutAtesterDivision` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Atesterterdivision` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateValiderTresorerie` datetime DEFAULT NULL,
  `ValiderStatuttresorerie` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderTresorerie` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateAtesterTresorerie` datetime DEFAULT NULL,
  `StatutAtesterTresorerie` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `AtesterterTresorier` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateValiderAdministration` datetime DEFAULT NULL,
  `ValiderStatutAdministration` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderAdministrateur` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateAtesterAdministration` datetime DEFAULT NULL,
  `StatutAtesterAdministration` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `AtesterterAdministrateur` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateValiderDirection` datetime DEFAULT NULL,
  `ValiderStatutDirection` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderDirecteur` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateAtesterDirection` datetime DEFAULT NULL,
  `StatutAtesterDirection` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `AtesterterDirecteur` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateValidertGerant` datetime DEFAULT NULL,
  `ValiderStatutGerant` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ValiderGerant` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateAtesterGerant` datetime DEFAULT NULL,
  `StatutAtesterGerant` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `AtesterterGerant` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `refEtatbesoin` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted` varchar(5) NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ttreso_entete_angagement_refprovenance_foreign` (`refProvenance`),
  KEY `ttreso_entete_angagement_refbloc_foreign` (`refBloc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ttreso_entete_angagement`
--

INSERT INTO `ttreso_entete_angagement` (`id`, `refProvenance`, `refBloc`, `motif`, `dateEngagement`, `refCaisse`, `montant`, `dateValiderDemandeur`, `StatutValiderDemandeur`, `ValiderDemandeur`, `dateValidertDivision`, `StatutValiderDivision`, `ValiderDivision`, `dateAtesterDivision`, `StatutAtesterDivision`, `Atesterterdivision`, `dateValiderTresorerie`, `ValiderStatuttresorerie`, `ValiderTresorerie`, `dateAtesterTresorerie`, `StatutAtesterTresorerie`, `AtesterterTresorier`, `dateValiderAdministration`, `ValiderStatutAdministration`, `ValiderAdministrateur`, `dateAtesterAdministration`, `StatutAtesterAdministration`, `AtesterterAdministrateur`, `dateValiderDirection`, `ValiderStatutDirection`, `ValiderDirecteur`, `dateAtesterDirection`, `StatutAtesterDirection`, `AtesterterDirecteur`, `dateValidertGerant`, `ValiderStatutGerant`, `ValiderGerant`, `dateAtesterGerant`, `StatutAtesterGerant`, `AtesterterGerant`, `refEtatbesoin`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'ACHAT', '2023-09-14 00:00:00', 2, 0, '2023-09-14 00:00:00', 'OUI', 'administrateur', '2023-09-14 00:00:00', 'OUI', 'administrateur', NULL, NULL, NULL, '2023-09-14 00:00:00', 'OUI', 'administrateur', NULL, NULL, NULL, '2023-09-14 00:00:00', 'OUI', 'administrateur', NULL, NULL, NULL, '2023-09-14 00:00:00', 'OUI', 'administrateur', NULL, NULL, NULL, '2023-09-14 00:00:00', 'OUI', 'administrateur', NULL, NULL, NULL, '00000', 'administrateur', 'NON', NULL, '2023-09-14 04:51:32', '2023-09-14 04:52:16'),
(2, 1, 2, 'ACHAT', '2023-10-10 00:00:00', 1, 0, '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '2023-10-10 00:00:00', 'OUI', 'administrateur', '00000', 'administrateur', 'NON', NULL, '2023-10-10 03:16:26', '2023-10-10 03:16:26'),
(3, 1, 2, 'ACHAT MATERIELS', '2024-09-02 00:00:00', 1, 0, '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '2024-09-02 00:00:00', 'OUI', 'Roger Admin', '001', 'Roger Admin', 'NON', NULL, '2024-09-02 08:26:03', '2024-09-02 08:26:03');

-- --------------------------------------------------------

--
-- Structure de la table `ttypemouvement`
--

DROP TABLE IF EXISTS `ttypemouvement`;
CREATE TABLE IF NOT EXISTS `ttypemouvement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `designation` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ttypemouvement`
--

INSERT INTO `ttypemouvement` (`id`, `created_at`, `updated_at`, `designation`) VALUES
(1, '2022-10-22 22:00:00', '2022-10-22 22:00:00', 'PRODUIT'),
(2, '2022-10-22 22:00:00', '2022-10-22 22:00:00', 'CHARGE');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_bloc`
--

DROP TABLE IF EXISTS `tt_treso_bloc`;
CREATE TABLE IF NOT EXISTS `tt_treso_bloc` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `desiBloc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_bloc`
--

INSERT INTO `tt_treso_bloc` (`id`, `desiBloc`, `created_at`, `updated_at`) VALUES
(1, 'DIVISION', '2023-09-14 04:25:32', '2023-09-14 04:25:32'),
(2, 'SERVICE', '2023-09-14 04:25:38', '2023-09-14 04:25:38');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_categorie_rubrique`
--

DROP TABLE IF EXISTS `tt_treso_categorie_rubrique`;
CREATE TABLE IF NOT EXISTS `tt_treso_categorie_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NomCateRubrique` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_categorie_rubrique`
--

INSERT INTO `tt_treso_categorie_rubrique` (`id`, `NomCateRubrique`, `created_at`, `updated_at`) VALUES
(1, 'APPROVISIONNEMENT', '2023-09-14 04:26:14', '2023-09-14 04:32:33'),
(2, 'ACHAT', '2023-09-14 04:26:21', '2023-09-14 04:32:16');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_detail_angagement`
--

DROP TABLE IF EXISTS `tt_treso_detail_angagement`;
CREATE TABLE IF NOT EXISTS `tt_treso_detail_angagement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntete` int(11) NOT NULL,
  `refRubrique` int(11) NOT NULL,
  `Qte` double NOT NULL,
  `PU` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_detail_angagement_refentete_foreign` (`refEntete`),
  KEY `tt_treso_detail_angagement_refrubrique_foreign` (`refRubrique`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tt_treso_detail_angagement`
--

INSERT INTO `tt_treso_detail_angagement` (`id`, `refEntete`, `refRubrique`, `Qte`, `PU`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 30, '2023-09-14 04:51:51', '2023-09-14 04:51:51'),
(2, 3, 2, 3, 20, '2024-09-02 08:31:39', '2024-09-02 08:31:39');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_detail_etatbesoin`
--

DROP TABLE IF EXISTS `tt_treso_detail_etatbesoin`;
CREATE TABLE IF NOT EXISTS `tt_treso_detail_etatbesoin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntete` int(11) NOT NULL,
  `refRubrique` int(11) NOT NULL,
  `Qte` double NOT NULL,
  `PU` double NOT NULL,
  `service_beneficiaire` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_detail_etatbesoin_refentete_foreign` (`refEntete`),
  KEY `tt_treso_detail_etatbesoin_refrubrique_foreign` (`refRubrique`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_detail_etatbesoin`
--

INSERT INTO `tt_treso_detail_etatbesoin` (`id`, `refEntete`, `refRubrique`, `Qte`, `PU`, `service_beneficiaire`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 30, 'INFORMATIQUES', 'administrateur', '2023-09-14 04:44:50', '2023-09-14 04:44:50'),
(2, 1, 1, 2, 30, 'INFORMATIQUES', 'Roger Admin', '2024-09-02 08:24:28', '2024-09-02 08:24:28');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_entete_etatbesoin`
--

DROP TABLE IF EXISTS `tt_treso_entete_etatbesoin`;
CREATE TABLE IF NOT EXISTS `tt_treso_entete_etatbesoin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refProvenance` int(11) NOT NULL,
  `motifDepense` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DateElaboration` datetime DEFAULT NULL,
  `AcquitterPar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StatutAcquitterPar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `DateAcquitterPar` datetime DEFAULT NULL,
  `ApproCoordi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StatutApproCoordi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `DateApproCoordi` datetime DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_entete_etatbesoin_refprovenance_foreign` (`refProvenance`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_entete_etatbesoin`
--

INSERT INTO `tt_treso_entete_etatbesoin` (`id`, `refProvenance`, `motifDepense`, `DateElaboration`, `AcquitterPar`, `StatutAcquitterPar`, `DateAcquitterPar`, `ApproCoordi`, `StatutApproCoordi`, `DateApproCoordi`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'ACHAT', '2023-09-14 00:00:00', 'administrateur', 'OUI', '2023-09-14 00:00:00', 'administrateur', 'OUI', '2023-09-14 00:00:00', 'administrateur', '2023-09-14 04:38:25', '2023-09-14 05:04:04');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_provenance`
--

DROP TABLE IF EXISTS `tt_treso_provenance`;
CREATE TABLE IF NOT EXISTS `tt_treso_provenance` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomProvenance` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeProvenance` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_provenance`
--

INSERT INTO `tt_treso_provenance` (`id`, `nomProvenance`, `codeProvenance`, `created_at`, `updated_at`) VALUES
(1, 'INFORMATIQUES', '0000INFO', '2023-09-14 04:24:47', '2023-09-14 04:24:47'),
(2, 'RESTO BAR', '00000RB', '2023-09-14 04:25:17', '2023-09-14 04:25:17');

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_rubrique`
--

DROP TABLE IF EXISTS `tt_treso_rubrique`;
CREATE TABLE IF NOT EXISTS `tt_treso_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refcateRubrik` int(11) NOT NULL,
  `desiRubriq` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeRubriq` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_rubrique_refcaterubrik_foreign` (`refcateRubrik`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tt_treso_rubrique`
--

INSERT INTO `tt_treso_rubrique` (`id`, `refcateRubrik`, `desiRubriq`, `codeRubriq`, `created_at`, `updated_at`) VALUES
(1, 2, 'ACHAT DES MARIELS', '00000', '2023-09-14 04:33:03', '2023-09-14 04:33:03'),
(2, 2, 'ACHAT DES CONSOMMABLES', '0000', '2023-09-14 04:33:30', '2023-09-14 04:33:30');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_categorie_produit`
--

DROP TABLE IF EXISTS `tvente_categorie_produit`;
CREATE TABLE IF NOT EXISTS `tvente_categorie_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_categorie_produit`
--

INSERT INTO `tvente_categorie_produit` (`id`, `designation`, `author`, `created_at`, `updated_at`) VALUES
(1, 'UNIFORME', 'Roger Admin', '2024-09-02 01:50:45', '2024-09-02 01:50:45'),
(2, 'OBJET CLASSIQUE', 'Roger Admin', '2024-09-02 02:10:47', '2024-09-02 02:10:47');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_entree`
--

DROP TABLE IF EXISTS `tvente_detail_entree`;
CREATE TABLE IF NOT EXISTS `tvente_detail_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteEntree` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puEntree` double(50,2) NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double(50,2) NOT NULL,
  `qteEntree` double(50,2) NOT NULL,
  `unite_paquet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Par Pièce',
  `puPaquet` double(50,2) NOT NULL DEFAULT '0.00',
  `qtePaquet` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_entree_refenteteentree_foreign` (`refEnteteEntree`),
  KEY `tvente_detail_entree_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_entree`
--

INSERT INTO `tvente_detail_entree` (`id`, `refEnteteEntree`, `refProduit`, `puEntree`, `devise`, `taux`, `qteEntree`, `unite_paquet`, `puPaquet`, `qtePaquet`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12.00, 'USD', 0.00, 20.00, 'Par Pièce', 12.00, 20.00, 'Roger Admin', '2024-09-02 02:28:48', '2024-09-02 02:28:48'),
(2, 2, 3, 10.00, 'USD', 2800.00, 30.00, 'Par Pièce', 10.00, 30.00, 'Roger Admin', '2024-09-02 04:18:55', '2024-09-02 04:18:55'),
(3, 2, 2, 10.00, 'USD', 2800.00, 10.00, 'Par Pièce', 10.00, 10.00, 'Roger Admin', '2024-09-02 04:19:12', '2024-09-02 04:19:12');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_requisition`
--

DROP TABLE IF EXISTS `tvente_detail_requisition`;
CREATE TABLE IF NOT EXISTS `tvente_detail_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteCmd` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puCmd` double(50,2) NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double(50,2) NOT NULL,
  `qteCmd` double(50,2) NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_requisition_refentetecmd_foreign` (`refEnteteCmd`),
  KEY `tvente_detail_requisition_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_requisition`
--

INSERT INTO `tvente_detail_requisition` (`id`, `refEnteteCmd`, `refProduit`, `puCmd`, `devise`, `taux`, `qteCmd`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12.00, 'USD', 2800.00, 30.00, 'Roger Admin', '2024-09-02 02:52:51', '2024-09-02 02:52:51'),
(2, 2, 1, 12.00, 'USD', 2800.00, 50.00, 'Roger Admin', '2024-09-02 04:38:13', '2024-09-02 04:38:13'),
(3, 2, 2, 10.00, 'USD', 2800.00, 100.00, 'Roger Admin', '2024-09-02 04:38:29', '2024-09-02 04:38:29'),
(5, 3, 1, 12.00, 'USD', 2800.00, 2.00, 'Roger Admin', '2024-09-18 19:16:00', '2024-09-18 19:16:00'),
(6, 3, 2, 10.00, 'USD', 2800.00, 2.00, 'Roger Admin', '2024-09-18 19:16:15', '2024-09-18 19:16:15');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_vente`
--

DROP TABLE IF EXISTS `tvente_detail_vente`;
CREATE TABLE IF NOT EXISTS `tvente_detail_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puVente` double(50,2) NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double(50,2) NOT NULL,
  `qteVente` double(50,2) NOT NULL,
  `unite_paquet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Par Pièce',
  `puPaquet` double(50,2) NOT NULL DEFAULT '0.00',
  `qtePaquet` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_vente_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_detail_vente_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_vente`
--

INSERT INTO `tvente_detail_vente` (`id`, `refEnteteVente`, `refProduit`, `puVente`, `devise`, `taux`, `qteVente`, `unite_paquet`, `puPaquet`, `qtePaquet`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12.00, 'USD', 2800.00, 2.00, 'Par Pièce', 12.00, 2.00, 'Roger Admin', '2024-09-02 02:42:12', '2024-09-02 02:42:12'),
(2, 2, 3, 10.00, 'USD', 2800.00, 2.00, 'Par Pièce', 10.00, 2.00, 'Roger Admin', '2024-09-02 04:22:30', '2024-09-02 04:22:30'),
(3, 2, 1, 12.00, 'USD', 2800.00, 1.00, 'Par Pièce', 12.00, 1.00, 'Roger Admin', '2024-09-02 04:22:50', '2024-09-02 04:22:50'),
(4, 3, 1, 12.00, 'USD', 2800.00, 4.00, 'Par Pièce', 12.00, 4.00, 'Roger Admin', '2024-09-16 19:32:02', '2024-09-16 19:32:02');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_entree`
--

DROP TABLE IF EXISTS `tvente_entete_entree`;
CREATE TABLE IF NOT EXISTS `tvente_entete_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `dateEntree` date NOT NULL,
  `libelle` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_entree_reffournisseur_foreign` (`refFournisseur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_entree`
--

INSERT INTO `tvente_entete_entree` (`id`, `refFournisseur`, `dateEntree`, `libelle`, `montant`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-09-02', 'XXX', 240.00, 'Roger Admin', '2024-09-02 02:19:00', '2024-09-02 02:19:00'),
(2, 1, '2024-09-02', 'XXX', 400.00, 'Roger Admin', '2024-09-02 04:18:12', '2024-09-02 04:18:12');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_requisition`
--

DROP TABLE IF EXISTS `tvente_entete_requisition`;
CREATE TABLE IF NOT EXISTS `tvente_entete_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `dateCmd` date NOT NULL,
  `libelle` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_requisition_reffournisseur_foreign` (`refFournisseur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_requisition`
--

INSERT INTO `tvente_entete_requisition` (`id`, `refFournisseur`, `dateCmd`, `libelle`, `montant`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-09-02', 'xxx', 360.00, 'Roger Admin', '2024-09-02 02:52:33', '2024-09-02 02:52:33'),
(2, 1, '2024-09-02', 'xxx', 1600.00, 'Roger Admin', '2024-09-02 04:37:49', '2024-09-02 04:37:49'),
(3, 1, '2024-09-02', 'xxx', 44.00, 'Roger Admin', '2024-09-02 18:02:53', '2024-09-02 18:02:53');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_vente`
--

DROP TABLE IF EXISTS `tvente_entete_vente`;
CREATE TABLE IF NOT EXISTS `tvente_entete_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double(50,2) NOT NULL DEFAULT '0.00',
  `paie` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_vente_refclient_foreign` (`refClient`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_vente`
--

INSERT INTO `tvente_entete_vente` (`id`, `refClient`, `dateVente`, `libelle`, `montant`, `paie`, `author`, `created_at`, `updated_at`) VALUES
(1, 2, '2024-09-02', 'Vente des Prosuits', 24.00, 0.00, 'Roger Admin', '2024-09-02 02:38:40', '2024-09-02 02:38:40'),
(2, 3, '2024-09-02', 'Vente des Prosuits', 32.00, 32.00, 'Roger Admin', '2024-09-02 04:20:50', '2024-09-02 04:20:50'),
(3, 5, '2024-09-16', 'Vente des Prosuits', 48.00, 48.00, 'Roger Admin', '2024-09-16 19:31:39', '2024-09-16 19:31:39');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_fournisseur`
--

DROP TABLE IF EXISTS `tvente_fournisseur`;
CREATE TABLE IF NOT EXISTS `tvente_fournisseur` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_fournisseur`
--

INSERT INTO `tvente_fournisseur` (`id`, `noms`, `contact`, `mail`, `adresse`, `author`, `created_at`, `updated_at`) VALUES
(1, 'ATELIER 1', '0992992063', 'atelier@gmail.com', 'Goma', 'Roger Admin', '2024-09-02 02:18:45', '2024-09-02 02:18:45');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_paiement`
--

DROP TABLE IF EXISTS `tvente_paiement`;
CREATE TABLE IF NOT EXISTS `tvente_paiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double(50,2) NOT NULL,
  `date_paie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libellepaie` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double(50,2) NOT NULL DEFAULT '0.00',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_paiement_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_paiement_refbanque_foreign` (`refBanque`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_paiement`
--

INSERT INTO `tvente_paiement` (`id`, `refEnteteVente`, `montant_paie`, `date_paie`, `modepaie`, `libellepaie`, `refBanque`, `numeroBordereau`, `devise`, `taux`, `author`, `created_at`, `updated_at`) VALUES
(1, 2, 32.00, '2024-09-02', 'CASH', 'Paiement Facture', 1, '000000', 'USD', 2800.00, 'Roger Admin', '2024-09-02 04:31:48', '2024-09-02 04:31:48'),
(2, 3, 48.00, '2024-09-16', 'CASH', 'Paiement Facture', 1, '000000000', 'USD', 2800.00, 'Roger Admin', '2024-09-16 19:32:35', '2024-09-16 19:32:35');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_produit`
--

DROP TABLE IF EXISTS `tvente_produit`;
CREATE TABLE IF NOT EXISTS `tvente_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double(50,2) NOT NULL,
  `qte` double(50,2) NOT NULL DEFAULT '0.00',
  `qte_unite` double(50,2) NOT NULL DEFAULT '1.00',
  `refCategorie` bigint(20) UNSIGNED NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_produit_refcategorie_foreign` (`refCategorie`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_produit`
--

INSERT INTO `tvente_produit` (`id`, `designation`, `pu`, `qte`, `qte_unite`, `refCategorie`, `devise`, `taux`, `unite`, `author`, `created_at`, `updated_at`) VALUES
(1, 'CHEMISE BLANCHE', 12.00, 13.00, 1.00, 1, 'USD', '0', 'Pièce', 'Roger Admin', '2024-09-02 02:17:31', '2024-09-02 02:17:31'),
(2, 'CULLOTE', 10.00, 10.00, 1.00, 1, 'USD', '0', 'Pièce', 'Roger Admin', '2024-09-02 02:17:53', '2024-09-02 02:17:53'),
(3, 'JUPE', 10.00, 28.00, 1.00, 1, 'USD', '2800', 'Pièce', 'Roger Admin', '2024-09-02 04:17:24', '2024-09-02 04:17:24');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_taux`
--

DROP TABLE IF EXISTS `tvente_taux`;
CREATE TABLE IF NOT EXISTS `tvente_taux` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `taux` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_taux`
--

INSERT INTO `tvente_taux` (`id`, `taux`, `author`, `created_at`, `updated_at`) VALUES
(1, 2800, 'Roger Admin', '2024-09-02 02:30:11', '2024-09-02 02:30:11');

-- --------------------------------------------------------

--
-- Structure de la table `type_tranches`
--

DROP TABLE IF EXISTS `type_tranches`;
CREATE TABLE IF NOT EXISTS `type_tranches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomTypeTranche` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_tranches`
--

INSERT INTO `type_tranches` (`id`, `nomTypeTranche`, `created_at`, `updated_at`) VALUES
(1, 'Frais de Scolarité', '2024-08-08 12:15:17', '2024-08-09 06:40:07'),
(2, 'Visite Informatique', '2024-08-08 12:15:44', '2024-08-08 12:16:12'),
(3, 'Sortie buhimba', '2024-08-08 12:16:33', '2024-08-08 12:16:33'),
(5, 'Frais scolaire', '2024-08-09 06:40:12', '2024-08-09 06:40:12'),
(6, 'Frais technique', '2024-08-09 06:40:25', '2024-08-09 06:40:25');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `telephone`, `adresse`, `avatar`, `sexe`, `id_role`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(27, 'Roger Admin', 'admin@gmail.com', NULL, '$2y$10$4yJJ9kTio.ZCT.1v681DV.mILvP4qvmDoPDb38gK5mYwdWDkTlueO', '0817883541', 'Goma, katindo', '1718039089.jpg', 'M', 1, 1, 'pPsP5gStDjpQLWYSwjIXLavNNsoTZgZztyN2P3W3QhLCNDnxh359QLTcOzlP', NULL, '2024-08-28 19:55:29'),
(28, 'Yuma kayanda', 'yuma@gmail.com', NULL, '$2y$10$MrgZU2DZlxi32lPCxFXYze.ROR35yRkqjqm1EvKzrrWYsybIsC0b2', '0996712321', 'Goma', '1692966953.jpg', 'M', 2, 1, 'VLazCyC9zgNx53v6SH0nMPgiXkOSk0QfinpprejVPj5nVytuYiItpIzcg7Xd', NULL, '2023-08-25 11:15:17'),
(29, 'Gloria nehema', 'user@gmail.com', NULL, '$2y$10$mXpH1OQ2i52.njbA0jLJhec3qqKuabqpOaebunp8kMHL5QrEsEpGG', '0817883413', 'Goma', '1692964850.jpg', 'F', 2, 0, '$2y$10$REBOC4EB7xgEKYqVtZTNKuoxwRo47KQ4mhtDJC7WLUBBjP3U9qdLy', NULL, '2023-08-25 10:00:50'),
(30, 'Drey Mukuka Member', 'member@gmail.com', NULL, '$2y$10$oRX9bQyRU4MXVVOOxYpUxeKjGVn/MMcQHeP5fTc2IIRMozGP0bYWe', '0854543870', 'Goma', 'avatar.png', 'M', 3, 1, '$2y$10$Pg4XRius5o.3xdYwnIj3ruxzD8RsFhAV0FpjFc4JlS0xazNwACJXu', NULL, '2024-06-10 14:14:14'),
(31, 'Patrick ponyon', 'patrick@gmail.com', NULL, '$2y$10$VgHEh8bNkJtbMAUXbqcPTOJl5V/h9vRo5VQ6bCNi9M3PNaeXI65xa', '0970524665', NULL, 'avatar.png', 'M', 2, 0, '$2y$10$x/dWs6TkdOwzf54QHd8WU..iZmAtTm6IjH8IdTJClydTVKQuZcRGu', NULL, NULL),
(32, 'Jean Pierre', 'jp@gmail.com', NULL, '$2y$10$WXeNotf/EON87BCi9ggBbuRDG21AQsFidRrz9UVkSjQNxv2IzLL7C', '0970524665', NULL, 'avatar.png', 'M', 2, 1, '$2y$10$ZdZYPXiFZEMMQ8A35rYXIu6zZF50RtKdK8W.cuaioKlv3zTL4TmKu', NULL, '2024-06-10 14:01:40');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProvince` int(11) NOT NULL,
  `nomVille` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `idProvince`, `nomVille`, `created_at`, `updated_at`) VALUES
(1, 1, 'Goma', '2023-09-04 11:23:48', '2023-09-04 11:23:48'),
(2, 2, 'Kindu', '2023-09-04 11:24:02', '2023-09-04 11:27:17'),
(4, 5, 'Bukavu', '2024-01-13 01:41:31', '2024-01-13 01:41:31'),
(5, 5, 'Butembo', '2024-01-13 01:49:02', '2024-01-13 01:49:02');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clautures`
--
ALTER TABLE `clautures`
  ADD CONSTRAINT `clautures_idanne_foreign` FOREIGN KEY (`idAnne`) REFERENCES `anne_scollaires` (`id`),
  ADD CONSTRAINT `clautures_idclasse_foreign` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `clautures_idoption_foreign` FOREIGN KEY (`idOption`) REFERENCES `options` (`id`),
  ADD CONSTRAINT `clautures_idsection_foreign` FOREIGN KEY (`idSection`) REFERENCES `sections` (`id`);

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_idavenue_foreign` FOREIGN KEY (`idAvenue`) REFERENCES `avenues` (`id`);

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_idanne_foreign` FOREIGN KEY (`idAnne`) REFERENCES `anne_scollaires` (`id`),
  ADD CONSTRAINT `inscriptions_idclasse_foreign` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `inscriptions_iddivision_foreign` FOREIGN KEY (`idDivision`) REFERENCES `divisions` (`id`),
  ADD CONSTRAINT `inscriptions_ideleve_foreign` FOREIGN KEY (`idEleve`) REFERENCES `eleves` (`id`),
  ADD CONSTRAINT `inscriptions_idoption_foreign` FOREIGN KEY (`idOption`) REFERENCES `options` (`id`);

--
-- Contraintes pour la table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_idsection_foreign` FOREIGN KEY (`idSection`) REFERENCES `sections` (`id`);

--
-- Contraintes pour la table `presences`
--
ALTER TABLE `presences`
  ADD CONSTRAINT `presences_idinscription_foreign` FOREIGN KEY (`idInscription`) REFERENCES `inscriptions` (`id`);

--
-- Contraintes pour la table `previsions`
--
ALTER TABLE `previsions`
  ADD CONSTRAINT `previsions_idanne_foreign` FOREIGN KEY (`idAnne`) REFERENCES `anne_scollaires` (`id`),
  ADD CONSTRAINT `previsions_idclasse_foreign` FOREIGN KEY (`idClasse`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `previsions_idfrais_foreign` FOREIGN KEY (`idFrais`) REFERENCES `type_tranches` (`id`),
  ADD CONSTRAINT `previsions_idoption_foreign` FOREIGN KEY (`idOption`) REFERENCES `options` (`id`),
  ADD CONSTRAINT `previsions_idtranche_foreign` FOREIGN KEY (`idTranche`) REFERENCES `tranches` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
