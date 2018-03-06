-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 06 mars 2018 à 09:51
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
-- Base de données :  `mep_fevrier`
--

-- --------------------------------------------------------

--
-- Structure de la table `mepadmin`
--

DROP TABLE IF EXISTS `mepadmin`;
CREATE TABLE IF NOT EXISTS `mepadmin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepadmin`
--

INSERT INTO `mepadmin` (`id_admin`, `login`, `mdp`) VALUES
(1, 'admin', 'aDmiN');

-- --------------------------------------------------------

--
-- Structure de la table `mepclient`
--

DROP TABLE IF EXISTS `mepclient`;
CREATE TABLE IF NOT EXISTS `mepclient` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nomfamille` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `adresse1` varchar(255) DEFAULT NULL,
  `codepostal` varchar(10) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `pass` varchar(25) DEFAULT NULL,
  `tel` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepclient`
--

INSERT INTO `mepclient` (`id_client`, `nomfamille`, `prenom`, `adresse1`, `codepostal`, `ville`, `mail`, `pass`, `tel`) VALUES
(1, 'Delaroche', 'Dominique', NULL, NULL, 'Montreuil-Juigné', 'dominique.delaroche49@gmail.com', 'cefiidd', NULL),
(2, 'vinet', 'jerome', NULL, '49000', 'Angers', 'vinet.jerome@gmail.com', 'cefiijv', NULL),
(3, 'brun', 'tom', '34 rue de buffon', '49000', 'Angers', 'tombrun49@gmail.com', 'cefiitom', '0689070108');

-- --------------------------------------------------------

--
-- Structure de la table `mepcommande`
--

DROP TABLE IF EXISTS `mepcommande`;
CREATE TABLE IF NOT EXISTS `mepcommande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `date_commande` date DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  `traitement` int(11) DEFAULT '0',
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepcommande`
--

INSERT INTO `mepcommande` (`id_commande`, `date_commande`, `heure`, `traitement`) VALUES
(1, '2018-02-26', '19h00', 0),
(2, '2018-02-26', '20h00', 0),
(18, '2018-02-28', '10:13:40', 0),
(19, '2018-02-28', '10:17:08', 1),
(20, '2018-02-28', '11:26:30', 0),
(21, '2018-02-28', '12:13:10', 0),
(22, '2018-02-28', '12:17:55', 0),
(23, '2018-02-28', '12:49:19', 1),
(24, '2018-02-28', '13:06:15', 0),
(25, '2018-02-28', '13:06:38', 0),
(26, '2018-02-28', '13:07:14', 0),
(27, '2018-02-28', '13:07:31', 1),
(28, '2018-02-28', '13:11:32', 0),
(29, '2018-02-28', '13:11:44', 0),
(30, '2018-02-28', '13:12:39', 0),
(31, '2018-02-28', '13:14:00', 0),
(32, '2018-02-28', '13:35:14', 0),
(33, '2018-02-28', '13:35:50', 0),
(34, '2018-02-28', '13:52:04', 0),
(35, '2018-02-28', '13:52:48', 0),
(36, '2018-02-28', '13:54:30', 1),
(37, '2018-03-01', '14:32:02', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mepcommandeclient`
--

DROP TABLE IF EXISTS `mepcommandeclient`;
CREATE TABLE IF NOT EXISTS `mepcommandeclient` (
  `id_client` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_client`,`id_commande`),
  KEY `FK_mepcommander_id_commande` (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepcommandeclient`
--

INSERT INTO `mepcommandeclient` (`id_client`, `id_commande`) VALUES
(1, 1),
(1, 2),
(2, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(3, 31),
(3, 32),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37);

-- --------------------------------------------------------

--
-- Structure de la table `meplignecommande`
--

DROP TABLE IF EXISTS `meplignecommande`;
CREATE TABLE IF NOT EXISTS `meplignecommande` (
  `quantite` int(11) DEFAULT NULL,
  `id_produit` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`,`id_commande`),
  KEY `FK_meplignecommande_id_commande` (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `meplignecommande`
--

INSERT INTO `meplignecommande` (`quantite`, `id_produit`, `id_commande`) VALUES
(2, 1, 1),
(1, 1, 2),
(1, 1, 18),
(2, 1, 37),
(2, 4, 18),
(2, 4, 19),
(1, 4, 20),
(1, 4, 24),
(1, 4, 25),
(1, 4, 26),
(1, 4, 27),
(1, 4, 28),
(1, 4, 29),
(1, 4, 30),
(1, 4, 31),
(1, 4, 32),
(1, 4, 33),
(1, 4, 34),
(1, 4, 35),
(1, 4, 36),
(1, 5, 18),
(1, 5, 37),
(1, 6, 18),
(1, 7, 19),
(1, 7, 20),
(1, 7, 21),
(1, 7, 22),
(1, 7, 23);

-- --------------------------------------------------------

--
-- Structure de la table `mepproduit`
--

DROP TABLE IF EXISTS `mepproduit`;
CREATE TABLE IF NOT EXISTS `mepproduit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `typeproduit` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prix` float(5,2) NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepproduit`
--

INSERT INTO `mepproduit` (`id_produit`, `typeproduit`, `nom`, `prix`) VALUES
(1, NULL, 'quatrefromage', 12.00),
(2, NULL, 'macrout', 5.00),
(3, NULL, 'margarita', 10.00),
(4, NULL, 'napolitaine', 13.00),
(5, NULL, 'cocacola', 2.00),
(6, NULL, 'oasis', 3.00),
(7, NULL, 'icetea', 3.50),
(8, NULL, 'painchoco', 2.00),
(9, NULL, 'glace', 4.00);

-- --------------------------------------------------------

--
-- Structure de la table `mepproduitmodifstockaliment`
--

DROP TABLE IF EXISTS `mepproduitmodifstockaliment`;
CREATE TABLE IF NOT EXISTS `mepproduitmodifstockaliment` (
  `id_produit` int(11) NOT NULL,
  `id_aliment` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`,`id_aliment`),
  KEY `FK_mepproduitmodifstockaliment_id_aliment` (`id_aliment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mepproduitmodifstockemballage`
--

DROP TABLE IF EXISTS `mepproduitmodifstockemballage`;
CREATE TABLE IF NOT EXISTS `mepproduitmodifstockemballage` (
  `id_produit` int(11) NOT NULL,
  `id_emballage` int(11) NOT NULL,
  PRIMARY KEY (`id_produit`,`id_emballage`),
  KEY `FK_mepproduitmodifstockemballage_id_emballage` (`id_emballage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mepstockaliment`
--

DROP TABLE IF EXISTS `mepstockaliment`;
CREATE TABLE IF NOT EXISTS `mepstockaliment` (
  `id_aliment` int(11) NOT NULL AUTO_INCREMENT,
  `type_aliment` varchar(255) DEFAULT NULL,
  `nom_aliment` varchar(255) DEFAULT NULL,
  `stock_aliment` int(11) DEFAULT NULL,
  `ref` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_aliment`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepstockaliment`
--

INSERT INTO `mepstockaliment` (`id_aliment`, `type_aliment`, `nom_aliment`, `stock_aliment`, `ref`) VALUES
(1, '', 'tomates', 550, 'ART0001'),
(2, 'céréales', 'farine', 2995, 'ART0006'),
(3, NULL, 'fromage', 265, 'ART0002');

-- --------------------------------------------------------

--
-- Structure de la table `mepstockemballage`
--

DROP TABLE IF EXISTS `mepstockemballage`;
CREATE TABLE IF NOT EXISTS `mepstockemballage` (
  `id_emballage` int(11) NOT NULL AUTO_INCREMENT,
  `type_emballage` varchar(255) DEFAULT NULL,
  `nom_emballage` varchar(255) DEFAULT NULL,
  `stock_emballage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_emballage`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepstockemballage`
--

INSERT INTO `mepstockemballage` (`id_emballage`, `type_emballage`, `nom_emballage`, `stock_emballage`) VALUES
(1, NULL, 'boiteapizza', 25),
(2, NULL, 'trepiedpizza', 25);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mepcommandeclient`
--
ALTER TABLE `mepcommandeclient`
  ADD CONSTRAINT `FK_mepcommander_id_client` FOREIGN KEY (`id_client`) REFERENCES `mepclient` (`id_client`),
  ADD CONSTRAINT `FK_mepcommander_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `mepcommande` (`id_commande`);

--
-- Contraintes pour la table `meplignecommande`
--
ALTER TABLE `meplignecommande`
  ADD CONSTRAINT `FK_meplignecommande_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `mepcommande` (`id_commande`),
  ADD CONSTRAINT `FK_meplignecommande_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `mepproduit` (`id_produit`);

--
-- Contraintes pour la table `mepproduitmodifstockaliment`
--
ALTER TABLE `mepproduitmodifstockaliment`
  ADD CONSTRAINT `FK_mepproduitmodifstockaliment_id_aliment` FOREIGN KEY (`id_aliment`) REFERENCES `mepstockaliment` (`id_aliment`),
  ADD CONSTRAINT `FK_mepproduitmodifstockaliment_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `mepproduit` (`id_produit`);

--
-- Contraintes pour la table `mepproduitmodifstockemballage`
--
ALTER TABLE `mepproduitmodifstockemballage`
  ADD CONSTRAINT `FK_mepproduitmodifstockemballage_id_emballage` FOREIGN KEY (`id_emballage`) REFERENCES `mepstockemballage` (`id_emballage`),
  ADD CONSTRAINT `FK_mepproduitmodifstockemballage_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `mepproduit` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
