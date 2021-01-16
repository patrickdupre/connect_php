-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 12 jan. 2021 à 15:53
-- Version du serveur :  10.5.8-MariaDB
-- Version de PHP : 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_user`
--
CREATE DATABASE IF NOT EXISTS `db_user` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_user`;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `ut_pseudo` char(20) NOT NULL DEFAULT '' COMMENT 'Pseudo',
  `ut_nom` varchar(63) DEFAULT NULL COMMENT 'nom',
  `ut_prenom` varchar(63) DEFAULT NULL COMMENT 'prenom',
  `ut_mp` char(10) NOT NULL DEFAULT '',
  `ut_mail` char(50) NOT NULL DEFAULT '',
  `ut_phrase` varchar(254) NOT NULL COMMENT 'Mot de passe crypté'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ut_pseudo`, `ut_nom`, `ut_prenom`, `ut_mp`, `ut_mail`, `ut_phrase`) VALUES
('bpassela', 'PASSELANDE', 'Bleuenn', 'azerty', '', '$2b$12$PFj7oZ2SyAoda8RSDFL7deIIoDZqxLm85H35LvagDUZIY6rQFBwwa'),
('cheu', 'HEU', 'Christophe', '26031990', 'cheu@sio2.edu', '$2b$12$.fY.2zpf77.r.BNHHdG9oOWJYO75DDVyDDsj28l7O2QzjlO0e9SrO'),
('dmoesa', 'MOESA', 'Diego', '09101990', 'dmoesa@sio2.edu', '$2b$12$ZRLXj2ZjvPOajeeyeJ0I..KnR62vAC39RVUCxfTPBiY2LyQMDxyqq'),
('Etudiant', 'Etudiant', 'Visiteur', 'Visiteur', 'visiteur@sio.edu', '$2b$12$PoQ9lOOwtD.nPgHXsIG24uF6YEwLeVQiLtwSNhBIHcbRVKJw.XCxy');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ut_pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
