-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 01 déc. 2025 à 17:37
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
-- Base de données : `base_test`
--
CREATE DATABASE IF NOT EXISTS `base_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `base_test`;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(255) NOT NULL,
  `description_produit` text DEFAULT NULL,
  `prix_produit` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom_produit`, `description_produit`, `prix_produit`) VALUES
(1, 'Produit 1', 'Exemple de produit 1', 10.50),
(2, 'Produit 2', 'Exemple de produit 2', 25.90),
(3, 'Produit 3', 'Exemple de produit 3', 7.30),
(4, 'Produit 4', 'Exemple de produit 4', 15.00),
(5, 'Produit 5', 'Exemple de produit 5', 50.75),
(6, 'Produit 6', 'Exemple de produit 6', 99.99),
(7, 'Produit 7', 'Exemple de produit 7', 5.20),
(8, 'Produit 8', 'Exemple de produit 8', 12.40),
(9, 'Produit 9', 'Exemple de produit 9', 30.00),
(10, 'Produit 10', 'Exemple de produit 10', 45.60);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `email_user`, `password_user`, `role_user`, `is_active`) VALUES
(6, 'julianboi.pro@gmail.com', '$2y$10$ahx7ytcL1xRRkMw01PwVNO3nGLw.DJpaNuC531gSRnknQU1SvavVa', 1, 1),
(7, 'boi.julian@yahoo.com', '$2y$10$hjBZBRanlE7vFkbdlU1IRuO/h07TkRbBEe4/ZscI7ZuDBLTV1z73W', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
