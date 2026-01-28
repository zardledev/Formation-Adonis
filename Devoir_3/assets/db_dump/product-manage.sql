-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 déc. 2025 à 04:42
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `product-manage`
--
CREATE DATABASE IF NOT EXISTS `product-manage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `product-manage`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_nom` varchar(255) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_nom`) VALUES
(1, 'Livres'),
(2, 'Informatique'),
(3, 'Jeux vidéo'),
(4, 'Electro-Ménager'),
(5, 'Mode'),
(6, 'Jardin');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `images_nom` varchar(255) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`image_id`, `images_nom`) VALUES
(3, 'assets/uploads/Capture d\'écran 2025-11-28 134800.png'),
(4, 'assets/uploads/test_delete_2_1.txt'),
(5, 'assets/uploads/test_delete_2_2.txt'),
(6, 'assets/uploads/Capture d\'écran 2025-11-28 010218.png'),
(7, 'assets/uploads/Capture d\'écran 2025-11-25 154024.png'),
(8, 'assets/uploads/Capture d\'écran 2025-11-25 163141.png'),
(9, 'assets/uploads/Capture d\'écran 2025-11-27 182001.png'),
(11, 'assets/uploads/Capture d\'écran 2025-11-28 020848.png'),
(12, 'assets/uploads/Capture d\'écran 2025-11-28 021206.png'),
(13, 'assets/uploads/Capture d\'écran 2025-11-28 021514.png'),
(14, 'assets/uploads/Capture d\'écran 2025-11-28 021555.png'),
(15, 'assets/uploads/Capture d\'écran 2025-11-28 021617.png');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) NOT NULL,
  `description_produit` text NOT NULL,
  `prix_produit` float NOT NULL,
  `produit_categorie` int(11) NOT NULL,
  `produit_reference` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`),
  UNIQUE KEY `produit_reference` (`produit_reference`),
  KEY `produit_categorie` (`produit_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits_images`
--

DROP TABLE IF EXISTS `produits_images`;
CREATE TABLE IF NOT EXISTS `produits_images` (
  `produits_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`produits_id`,`image_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_references`
--

DROP TABLE IF EXISTS `produit_references`;
CREATE TABLE IF NOT EXISTS `produit_references` (
  `reference_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_nom` varchar(255) NOT NULL,
  PRIMARY KEY (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(255) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `role_user` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`produit_categorie`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produit_references_ibfk_1` FOREIGN KEY (`produit_reference`) REFERENCES `produit_references` (`reference_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produits_images`
--
ALTER TABLE `produits_images`
  ADD CONSTRAINT `produits_images_ibfk_1` FOREIGN KEY (`produits_id`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produits_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
