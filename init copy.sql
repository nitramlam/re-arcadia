SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `animal`;
DROP TABLE IF EXISTS `AVIS`;
DROP TABLE IF EXISTS `habitat`;
DROP TABLE IF EXISTS `horaires`;
DROP TABLE IF EXISTS `service`;
DROP TABLE IF EXISTS `utilisateurs`;

CREATE TABLE `animal` (
  `animal_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `espece` varchar(255) NOT NULL,
  `etat_general` varchar(255) DEFAULT NULL,
  `regime` varchar(255) DEFAULT NULL,
  `poids` decimal(6,2) DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `derniere_visite` date DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `continent_origine` varchar(255) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `habitat` varchar(255) DEFAULT NULL,
  `grammage` decimal(6,2) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `date_heure_passage_employe` datetime DEFAULT NULL,
  `grammage_donne` decimal(6,2) DEFAULT NULL,
  `nourriture_donnee` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `page_personnalisee_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`animal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=25;

INSERT INTO `animal` (`nom`, `espece`, `etat_general`, `regime`, `poids`, `sexe`, `derniere_visite`, `commentaire`, `continent_origine`, `age`, `habitat`, `grammage`, `description`, `date_heure_passage_employe`, `grammage_donne`, `nourriture_donnee`, `image_path`, `page_personnalisee_url`) 
VALUES ('AnimalTest', 'EspèceTest', 'ok', 'herbivore', 0.00, 'M', '2024-01-01', 'RAS', 'Afrique', 1, 'savane', 0.00, 'description test', '2024-01-01 10:00:00', 0.00, 'feuilles', '/img/test.png', '/animaux_pages/animal_test.php');

CREATE TABLE `AVIS` (
  `avis_id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) DEFAULT NULL,
  `commentaire` varchar(50) DEFAULT NULL,
  `isVisible` tinyint(1) DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`avis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6;

INSERT INTO `AVIS` (`pseudo`, `commentaire`, `isVisible`, `isApproved`) 
VALUES ('test', 'avis test', 1, 1);

CREATE TABLE `habitat` (
  `habitat_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `commentaire_habitat` text,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`habitat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=8;

INSERT INTO `habitat` (`nom`, `description`, `commentaire_habitat`, `image_path`) 
VALUES ('habitat test', 'description test', 'rien à signaler', '/images/test.png');

CREATE TABLE `horaires` (
  `horaire_id` int NOT NULL AUTO_INCREMENT,
  `ouverture` time NOT NULL,
  `fermeture` time NOT NULL,
  PRIMARY KEY (`horaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2;

INSERT INTO `horaires` (`ouverture`, `fermeture`) 
VALUES ('08:00:00', '18:00:00');

CREATE TABLE `service` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icons_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4;

INSERT INTO `service` (`nom`, `description`, `icons_path`) 
VALUES ('service test', 'description test service', '/imageServices/test.jpg');

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employe','veterinaire','administrateur') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=11;

INSERT INTO `utilisateurs` (`email`, `password`, `role`) 
VALUES ('josearcadia33@gmail.com', '$2a$12$adN4kCf9XtBjPmLKMNJNzOoOX.RKAxkWzDHkEHFCFC16uP8ktrv6y', 'administrateur');

COMMIT;