-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 26 nov. 2025 à 13:30
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetphpbdd`
--
CREATE DATABASE IF NOT EXISTS `projetphpbdd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `projetphpbdd`;

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

DROP TABLE IF EXISTS `collection`;
CREATE TABLE IF NOT EXISTS `collection` (
  `user_id` varchar(36) NOT NULL,
  `perso_id` varchar(36) NOT NULL,
  PRIMARY KEY (`user_id`,`perso_id`),
  KEY `fk_collection_perso` (`perso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `collection`
--

INSERT INTO `collection` (`user_id`, `perso_id`) VALUES
('6925a8323d823', '6926a93bbdac85.81416449');

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `urlImg` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `element`
--

INSERT INTO `element` (`id`, `name`, `urlImg`) VALUES
(20, 'feu', 'https://tse3.mm.bing.net/th/id/OIP.V4qYI1vGsxTvCY1cUHODmAHaJQ?rs=1&pid=ImgDetMain&o=7&rm=3'),
(21, 'Pyro', 'https://genshinimpact.wiki.fextralife.com/file/Genshin-Impact/pyro-element-genshin-impact-wiki-guide.png');

-- --------------------------------------------------------

--
-- Structure de la table `origin`
--

DROP TABLE IF EXISTS `origin`;
CREATE TABLE IF NOT EXISTS `origin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `urlImg` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `origin`
--

INSERT INTO `origin` (`id`, `name`, `urlImg`) VALUES
(80, 'bourgogne', 'https://tse3.mm.bing.net/th/id/OIP.diEDdNBYbreS_Jqe78M-4QHaE8?rs=1&pid=ImgDetMain&o=7&rm=3');

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE IF NOT EXISTS `personnage` (
  `id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `element_id` int DEFAULT NULL,
  `unitclass_id` int DEFAULT NULL,
  `origin_id` int DEFAULT NULL,
  `rarity` int NOT NULL,
  `urlImg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_personnage_element` (`element_id`),
  KEY `fk_personnage_unitclass` (`unitclass_id`),
  KEY `fk_personnage_origin` (`origin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`id`, `name`, `element_id`, `unitclass_id`, `origin_id`, `rarity`, `urlImg`) VALUES
('69233ee3262c94.78465627', 'hatim', 20, 50, 80, 5, 'https://th.bing.com/th/id/R.77cbcf3a623f211f8f0fb62a2808d038?rik=QGTGtw9mHicEaw&pid=ImgRaw&r=0'),
('6926a93bbdac85.81416449', 'Diluc', 21, 51, 80, 4, 'https://i2.wp.com/images.genshin-builds.com/genshin/characters/diluc/image.png?strip=all&quality=100&w=160');

-- --------------------------------------------------------

--
-- Structure de la table `unitclass`
--

DROP TABLE IF EXISTS `unitclass`;
CREATE TABLE IF NOT EXISTS `unitclass` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `urlImg` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `unitclass`
--

INSERT INTO `unitclass` (`id`, `name`, `urlImg`) VALUES
(50, 'arc', 'https://th.bing.com/th/id/R.998a065009e70f552347d8cf376d7222?rik=o84NKPFiNtkCvA&pid=ImgRaw&r=0'),
(51, 'Epéiste', 'https://cdn.webshopapp.com/shops/305440/files/383955847/genshin-impact-epee-de-diluc-pierre-tombale-du-lou.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hash_pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `hash_pwd`) VALUES
('6925a8323d823', 'test', '$2y$10$Mf729U9f1jbzBf5od5kB8OTJcF59mMlfB1APD3Pje.bDe04hx23Li'),
('6925a8323d82e', 'admin', '$2y$10$kFmHD2LkHZfg5xJ59KmBLu0lM8i8VSWbGJ/1vfx0VvyWf/6B3JBlS');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `fk_collection_perso` FOREIGN KEY (`perso_id`) REFERENCES `personnage` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_collection_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD CONSTRAINT `fk_personnage_element` FOREIGN KEY (`element_id`) REFERENCES `element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personnage_origin` FOREIGN KEY (`origin_id`) REFERENCES `origin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personnage_unitclass` FOREIGN KEY (`unitclass_id`) REFERENCES `unitclass` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
