-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 21 mars 2018 à 13:41
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kitten_wars`
--

-- --------------------------------------------------------

--
-- Structure de la table `fights`
--

DROP TABLE IF EXISTS `fights`;
CREATE TABLE IF NOT EXISTS `fights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `winner_id` int(11) NOT NULL,
  `loser_id` int(11) NOT NULL,
  `fight_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fights`
--

INSERT INTO `fights` (`id`, `winner_id`, `loser_id`, `fight_date`) VALUES
(1, 2, 3, '2018-03-07 15:50:35'),
(2, 3, 2, '2018-03-07 15:50:42'),
(3, 3, 2, '2018-03-07 15:50:44'),
(4, 3, 2, '2018-03-07 15:50:45'),
(5, 3, 2, '2018-03-07 15:50:47'),
(6, 2, 3, '2018-03-07 15:50:49'),
(7, 1, 21, '2018-03-07 16:43:44'),
(8, 1, 21, '2018-03-07 16:44:11'),
(9, 1, 21, '2018-03-07 16:44:17'),
(10, 21, 1, '2018-03-07 16:44:37'),
(11, 21, 1, '2018-03-07 16:44:47'),
(12, 21, 1, '2018-03-07 16:44:53'),
(13, 12, 22, '2018-03-07 17:06:40'),
(15, 27, 14, '2018-03-07 18:06:10'),
(16, 1, 2, '2018-03-07 18:20:59'),
(17, 18, 22, '2018-03-07 18:22:04'),
(18, 22, 1, '2018-03-08 14:49:43'),
(19, 1, 2, '2018-03-12 10:21:20'),
(20, 2, 34, '2018-03-12 10:21:59'),
(21, 9, 2, '2018-03-12 15:57:05'),
(22, 2, 3, '2018-03-12 15:59:17'),
(23, 3, 2, '2018-03-12 16:04:16'),
(24, 3, 12, '2018-03-12 16:04:52'),
(25, 2, 3, '2018-03-12 16:32:17'),
(26, 3, 2, '2018-03-12 16:35:45'),
(27, 3, 9, '2018-03-12 16:35:53'),
(28, 36, 16, '2018-03-12 16:36:35'),
(29, 16, 13, '2018-03-12 16:36:44'),
(31, 11, 18, '2018-03-12 16:39:00'),
(32, 9, 2, '2018-03-12 16:39:05'),
(33, 36, 9, '2018-03-12 16:39:15'),
(34, 11, 9, '2018-03-12 16:39:22'),
(35, -1, 34, '2018-03-12 17:27:54'),
(37, 22, 1, '2018-03-12 17:33:20'),
(38, 37, 29, '2018-03-12 17:33:37'),
(40, 8, 9, '2018-03-13 09:35:40'),
(41, 15, 16, '2018-03-13 09:35:50'),
(42, 23, 2, '2018-03-13 17:26:47'),
(43, 3, 1, '2018-03-19 13:33:03');

-- --------------------------------------------------------

--
-- Structure de la table `kitten`
--

DROP TABLE IF EXISTS `kitten`;
CREATE TABLE IF NOT EXISTS `kitten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `cuteness` int(11) NOT NULL DEFAULT '0',
  `power` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `quote` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `kitten`
--

INSERT INTO `kitten` (`id`, `name`, `cuteness`, `power`, `balance`, `created_at`, `avatar`, `quote`) VALUES
(1, 'Kahlan', 99, 10, -1, '2018-03-01 14:08:00', 'kahlan.jpg', 'J\'ai le coeur sur la patte'),
(2, 'Chii', 2, 80, -6, '2018-03-01 14:08:52', 'chii.jpg', 'Tout pour te faire chiier'),
(3, 'Chatoune', 61, 60, 6, '2018-03-01 15:40:10', 'default.jpg', NULL),
(4, 'Felix', 10, 80, 0, '2018-03-01 15:40:54', 'default.jpg', NULL),
(5, 'Titi', 50, 44, 1, '2018-03-01 15:40:54', 'default.jpg', NULL),
(6, 'Mimi', 80, 10, 0, '2018-03-01 15:45:03', 'default.jpg', NULL),
(7, 'Neko', 100, 60, 0, '2018-03-01 15:45:03', 'default.jpg', NULL),
(8, 'Tigrou', 80, 46, 1, '2018-03-01 15:45:03', 'default.jpg', NULL),
(9, 'Chipie', 8, 48, -2, '2018-03-01 15:45:03', 'default.jpg', NULL),
(10, 'Kitty', 70, 48, 0, '2018-03-01 15:45:03', 'default.jpg', NULL),
(11, 'Princesse', 25, 78, 2, '2018-03-01 15:45:03', 'default.jpg', NULL),
(12, 'Caramel', 68, 45, 0, '2018-03-01 15:45:03', 'default.jpg', NULL),
(13, 'Gribouille', 48, 39, -1, '2018-03-01 15:45:03', 'default.jpg', NULL),
(14, 'Reglisse', 15, 23, -1, '2018-03-02 15:06:54', 'default.jpg', NULL),
(15, 'Sushi', 87, 56, 1, '2018-03-02 15:06:54', 'default.jpg', NULL),
(16, 'Bambou', 48, 56, -1, '2018-03-02 15:08:05', 'default.jpg', NULL),
(17, 'Kiwi', 89, 45, 0, '2018-03-02 15:08:05', 'default.jpg', NULL),
(18, 'Flocon', 48, 55, 0, '2018-03-02 15:08:05', 'default.jpg', NULL),
(20, 'Minouche', 89, 48, 0, '2018-03-02 15:08:05', 'default.jpg', NULL),
(21, 'Kipette', 80, 48, 0, '2018-03-06 14:35:00', 'default.jpg', 'Prout'),
(22, 'Cacahuète', 40, 25, 0, '2018-03-06 15:58:40', 'default.jpg', 'Le beurre, c\'est la vie'),
(23, 'Manège', 48, 30, 1, '2018-03-06 15:58:40', 'default.jpg', 'Et paf'),
(24, 'Samba', 48, 89, 0, '2018-03-06 15:59:26', 'default.jpg', NULL),
(26, 'Nougat', 50, 50, 0, '2018-03-07 12:39:12', 'default.jpg', NULL),
(27, 'Nougatine', 50, 50, 1, '2018-03-07 12:39:12', 'default.jpg', NULL),
(28, 'Marsupilami', 48, 99, 0, '2018-03-08 14:51:16', 'default.jpg', NULL),
(29, 'Dédé', 5, 41, -1, '2018-03-08 15:41:07', 'default.jpg', 'C\'est moi dédé'),
(30, 'Whiskas', 1, 74, 0, '2018-03-08 16:04:01', 'default.jpg', 'Le roi des croquettes'),
(31, 'Rondelé', 64, 78, 0, '2018-03-08 16:51:10', 'default.jpg', NULL),
(33, 'Chocolat', 87, 87, 0, '2018-03-08 16:58:59', 'default.jpg', NULL),
(34, 'Grumpy', 5, 88, -1, '2018-03-08 17:02:14', 'Grumpy.jpg', 'I had fun once, it was awful'),
(35, 'Nullos', 50, 44, 0, '2018-03-12 10:26:47', 'default.jpg', NULL),
(36, 'Boubi', 99, 100, 2, '2018-03-12 10:27:17', 'default.jpg', NULL),
(37, 'Apostrophe', 78, 38, 1, '2018-03-12 10:32:25', 'default.jpg', 'L\'apostrophe'),
(38, 'Ronron', 89, 59, 0, '2018-03-12 10:33:33', 'default.jpg', 'Rrrrr'),
(39, 'Feignant', 78, 25, 0, '2018-03-12 10:36:07', 'default.jpg', NULL),
(40, 'King', 75, 65, 0, '2018-03-12 10:36:45', 'default.jpg', NULL),
(41, 'Juju', 87, 67, 0, '2018-03-12 12:05:06', 'default.jpg', NULL),
(42, 'Sapin', 89, 78, 0, '2018-03-12 12:11:07', 'default.jpg', NULL),
(43, 'Question', 41, 7, 0, '2018-03-12 12:19:55', 'default.jpg', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
