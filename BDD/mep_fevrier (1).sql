-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 27 fév. 2018 à 09:27
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepclient`
--

INSERT INTO `mepclient` (`id_client`, `nomfamille`, `prenom`, `adresse1`, `codepostal`, `ville`, `mail`, `pass`, `tel`) VALUES
(1, 'Delaroche', 'Dominique', NULL, NULL, 'Montreuil-Juigné', 'dominique.delaroche49@gmail.com', 'cefiidd', NULL),
(2, 'vinet', 'jerome', NULL, '49000', 'Angers', 'vinet.jerome@gmail.com', 'cefiijv', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mepcommande`
--

DROP TABLE IF EXISTS `mepcommande`;
CREATE TABLE IF NOT EXISTS `mepcommande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `date_commande` date DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepcommande`
--

INSERT INTO `mepcommande` (`id_commande`, `date_commande`, `heure`) VALUES
(1, '2018-02-26', '19h00'),
(2, '2018-02-26', '20h00');

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
(1, 2);

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
(4, 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mepproduit`
--

INSERT INTO `mepproduit` (`id_produit`, `typeproduit`, `nom`, `prix`) VALUES
(1, NULL, 'pizza 4 fromages', 10.00),
(2, NULL, 'soda', 2.00);

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
  PRIMARY KEY (`id_aliment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
