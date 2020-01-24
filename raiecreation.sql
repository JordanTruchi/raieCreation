-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 24 jan. 2020 à 19:45
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
-- Base de données :  `raiecreation`
--
CREATE DATABASE IF NOT EXISTS `raiecreation` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `raiecreation`;

-- --------------------------------------------------------

--
-- Structure de la table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_user` (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appointment`
--

INSERT INTO `appointment` (`id`, `id_user`, `dateTime`) VALUES
(1, 1, '2020-01-25 14:26:18'),
(2, 1, '2020-01-24 10:28:13'),
(11, 2, '2020-01-30 14:26:15'),
(12, 2, '2020-01-30 14:26:15'),
(13, 2, '2020-01-30 14:26:15'),
(14, 2, '2020-01-30 14:26:15'),
(15, 9, '2020-01-24 00:28:00'),
(16, 9, '2020-01-23 23:15:00');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `telephone`) VALUES
(1, 'Truchi', 'Jordan', 'j.truchi@free.fr', '0661033450'),
(2, 'Anthony', 'Anthony', 'Anthony@Anthony.fr', '0661033450'),
(9, 'dddd', 'dd', 'dd', 'ddd');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `FK_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
