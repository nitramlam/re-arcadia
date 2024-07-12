-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database:3306
-- Généré le : jeu. 11 juil. 2024 à 18:08
-- Version du serveur : 8.4.1
-- Version de PHP : 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `arcadia`
--

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `animal_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `espece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_general` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poids` decimal(6,2) DEFAULT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `derniere_visite` date DEFAULT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent_origine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `habitat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grammage` decimal(6,2) DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`animal_id`, `nom`, `espece`, `etat_general`, `regime`, `poids`, `sexe`, `derniere_visite`, `commentaire`, `continent_origine`, `age`, `habitat`, `grammage`, `description`) VALUES
(1, 'Tichou', 'jaguar d\'Amazonie', 'En bonne santÃ©', 'ProtÃ©ine', 70.00, 'F', '2024-02-01', NULL, 'AmÃ©rique du Sud', 4, 'Jungle', 3.00, 'Le jaguar d\'Amazonie est le plus grand fÃ©lin d\'AmÃ©rique, reconnaissable Ã  sa robe jaune dorÃ© tachetÃ©e de noir. PrÃ©dateur solitaire des forÃªts tropicales, il se nourrit principalement de grands mammifÃ¨res tels que les cerfs, les tapirs et les capybaras. Il joue un rÃ´le crucial en rÃ©gulant les populations de proies et en maintenant l\'Ã©quilibre Ã©cologique de son habitat menacÃ© par la dÃ©forestation.'),
(2, 'Oscar', 'lion d\'Afrique', 'En bonne santÃ©', 'ProtÃ©ine', 300.00, 'M', '2024-02-01', NULL, 'Afrique', 5, 'Savane', 10.00, 'Le lion d\'Afrique (Panthera leo) rÃ¨gne sur les vastes Ã©tendues de la savane africaine. Connu pour sa majestueuse criniÃ¨re et sa puissante stature, ce prÃ©dateur social vit en groupes appelÃ©s fiertÃ©s. Les lions de la savane chassent en coopÃ©ration, ciblant des proies telles que les zÃ¨bres, les gnous et les antilopes. Symbole de force et de courage, le lion joue un rÃ´le crucial dans l\'Ã©cosystÃ¨me en rÃ©gulant les populations d\'herbivores.'),
(3, 'Hinata', 'panthÃ¨re de Floride', 'En bonne santÃ©', 'ProtÃ©ine', 110.00, 'F', '2024-02-01', NULL, 'AmÃ©rique du Nord', 2, 'Marais', 6.00, 'La panthÃ¨re de Floride (Puma concolor coryi) est une sous-espÃ¨ce rare et protÃ©gÃ©e du puma, reconnaissable Ã  sa robe beige et Ã  ses taches. AdaptÃ©e Ã  son habitat marÃ©cageux unique, elle se nourrit principalement de cerfs, de sangliers et d\'autres petits mammifÃ¨res. La panthÃ¨re de Floride est un symbole de conservation, reprÃ©sentant les efforts pour protÃ©ger les espÃ¨ces en danger et leurs habitats fragiles.'),
(4, 'Weasley', 'paresseux', 'En bonne santÃ©', 'Graines', 5.00, 'M', '2024-02-01', NULL, 'AmÃ©rique du Sud', 0, 'Jungle', 0.50, 'Le paresseux Ã  trois doigts est un mammifÃ¨re des forÃªts tropicales d\'AmÃ©rique centrale et du Sud. Connus pour leur lenteur et leur rÃ©gime Ã  base de feuilles, ils sont essentiels Ã  la dispersion des graines et Ã  la biodiversitÃ©, symbolisant la conservation des habitats fragiles.'),
(5, 'LÃ©onard', 'Ã©lÃ©phant d\'Afrique', 'En bonne santÃ©', 'Graines', 1500.00, 'M', '2024-02-01', NULL, 'Afrique', 45, 'Jungle', 15.00, 'L\'Ã©lÃ©phant d\'Afrique, emblÃ¨me des savanes et des forÃªts subsahariennes, est vital pour l\'Ã©cosystÃ¨me en tant qu\'ingÃ©nieur du paysage et disperseur de graines. Malheureusement menacÃ© par le braconnage et la perte d\'habitat, sa conservation est essentielle pour prÃ©server la biodiversitÃ© africaine.'),
(6, 'Mariette', 'lamantin des Everglades', 'En bonne santÃ©', 'Graines', 300.00, 'F', '2024-02-01', NULL, 'AmÃ©rique du Nord', 17, 'Marais', 2.00, 'Le lamantin des Everglades (Trichechus manatus latirostris) est une sous-espÃ¨ce de lamantin qui vit exclusivement dans les eaux douces et les marais des Everglades en Floride. Reconnaissable Ã  sa taille imposante et ses nageoires larges, il joue un rÃ´le crucial dans l\'Ã©cosystÃ¨me de cet habitat unique, mais il est gravement menacÃ© par la perte d\'habitat et d\'autres menaces. Des mesures de conservation sont essentielles pour assurer sa survie.'),
(7, 'Euridice', 'anaconda vert', 'En bonne santÃ©', 'ProtÃ©ine', 3.00, 'F', '2024-02-01', NULL, 'AmÃ©rique du Sud', 5, 'Marais', 0.30, 'L\'anaconda vert (Eunectes murinus) est un serpent gÃ©ant de l\'Amazonie, cÃ©lÃ¨bre pour sa taille impressionnante et son rÃ©gime alimentaire principalement composÃ© de poissons, d\'oiseaux et parfois de petits mammifÃ¨res. Essentiel Ã  l\'Ã©quilibre Ã©cologique des marÃ©cages et des riviÃ¨res, il joue un rÃ´le crucial dans la rÃ©gulation des populations de ses proies.'),
(8, 'Richard', 'lÃ©zard Ã  crÃªte du dÃ©sert', 'En bonne santÃ©', 'ProtÃ©ine', 1.00, 'F', '2024-02-01', NULL, 'Afrique', 7, 'Savane', 0.20, 'Le lÃ©zard Ã  crÃªte du dÃ©sert (Stellagama stellio) est une espÃ¨ce rÃ©pandue dans les rÃ©gions semi-arides et les savanes d\'Afrique du Nord, du Moyen-Orient et de l\'Asie. Reconnaissable par sa crÃªte d\'Ã©pines et ses couleurs variant du gris au brun, il se nourrit d\'insectes et de petits mammifÃ¨res. Ce lÃ©zard est connu pour sa capacitÃ© Ã  grimper habilement sur les surfaces rocheuses et Ã  se fondre dans son environnement pour se camoufler des prÃ©dateurs.'),
(9, 'Renee', 'alligator des Everglades', 'En bonne santÃ©', 'ProtÃ©ine', 300.00, 'M', '2024-02-01', NULL, 'AmÃ©rique du Nord', 20, 'Marais', 15.00, 'Les alligators des Everglades (Alligator mississippiensis) sont des prÃ©dateurs emblÃ©matiques des marÃ©cages de Floride. Ils se distinguent par leur peau Ã©cailleuse et leurs puissantes mÃ¢choires, adaptÃ©es Ã  la chasse de poissons, de reptiles et de petits mammifÃ¨res. Jouant un rÃ´le crucial dans l\'Ã©cosystÃ¨me. Leur conservation est essentielle face aux menaces croissantes de perte d\'habitat et de conflits avec les humains.'),
(10, 'Gurky', 'toucan toco', 'En bonne santÃ©', 'Graines', 4.00, 'M', '2024-02-01', NULL, 'AmÃ©rique du Sud', 3, 'Jungle', 1.00, 'Les toucans d\'Amazonie, connus sous le nom scientifique Ramphastos toco, contribuent Ã  la richesse de la biodiversitÃ© amazonienne en jouant un rÃ´le crucial dans la dispersion des graines des fruits qu\'ils consomment. Leur prÃ©sence dans les canopÃ©es des forÃªts tropicales favorise la rÃ©gÃ©nÃ©ration des espÃ¨ces vÃ©gÃ©tales et soutient la diversitÃ© des habitats. En tant qu\'indicateurs de l\'Ã©tat de santÃ© des Ã©cosystÃ¨mes, ils sont essentiels pour la conservation des vastes rÃ©seaux Ã©cologiques de l\'Amazonie.'),
(11, 'Dorothee', 'autruche d\'Afrique', 'En bonne santÃ©', 'Graines', 30.00, 'F', '2024-02-01', NULL, 'Afrique', 4, 'Savane', 2.00, 'Les autruches d\'Afrique, Struthio camelus, sont les plus grands oiseaux terrestres, parfaitement adaptÃ©s aux vastes savanes arides. Leur plumage brun-gris les aide Ã  se fondre dans leur environnement, et elles se nourrissent principalement de vÃ©gÃ©tation et de graines.'),
(12, 'Narsil', 'hÃ©ron cendrÃ© des Everglades', 'En bonne santÃ©', 'ProtÃ©ine', 10.00, 'M', '2024-02-01', NULL, 'AmÃ©rique du Nord', 11, 'Marais', 2.00, 'Le hÃ©ron cendrÃ© des Everglades, connu sous son nom scientifique Ardea herodias, est une espÃ¨ce emblÃ©matique des marais et des zones humides de Floride. Reconnaissable Ã  son plumage cendrÃ©, Ã  son long cou et Ã  ses pattes jaunes, il se nourrit principalement de poissons, de grenouilles et d\'insectes qu\'il chasse avec agilitÃ© dans les eaux peu profondes. Ce hÃ©ron joue un rÃ´le crucial dans l\'Ã©cosystÃ¨me en rÃ©gulant les populations de poissons et en contribuant Ã  la biodiversitÃ© des habitats aquatiques.');

-- --------------------------------------------------------

--
-- Structure de la table `AVIS`
--

CREATE TABLE `AVIS` (
  `avis_id` int NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `commentaire` varchar(50) DEFAULT NULL,
  `isVisible` tinyint(1) DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `AVIS`
--

INSERT INTO `AVIS` (`avis_id`, `pseudo`, `commentaire`, `isVisible`, `isApproved`) VALUES
(1, 'martin', 'super visite', 1, 1),
(2, 'jules', 'yessai', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `habitat`
--

CREATE TABLE `habitat` (
  `habitat_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaire_habitat` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `habitat`
--

INSERT INTO `habitat` (`habitat_id`, `nom`, `description`, `commentaire_habitat`, `image_path`) VALUES
(1, 'Savane', 'Une grande plaine herbeuse, souvent parsemÃ©e d\'arbres dispersÃ©s.', 'propre.', 'assets/savane-habitats.png'),
(2, 'Jungle', 'Une forÃªt dense et humide avec une grande biodiversitÃ©.', 'sale', 'assets/jungle-habitats.png'),
(3, 'Marais', 'Une zone humide souvent inondÃ©e, riche en biodiversitÃ© aquatique.', 'propre.', 'assets/marais-habitats.png');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `service_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icons_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`service_id`, `nom`, `description`, `icons_path`) VALUES
(1, 'Restaurant', 'DÃ©couvrez notre zoo de maniÃ¨re enrichissante avec un restaurant proposant des produits locaux et biologiques, des visites guidÃ©es interactives gratuites qui vous plongent dans l\'univers captivant de nos animaux, et des circuits en petit train Ã©lectrique respectueux de notre Ã©cosystÃ¨me.', NULL),
(2, 'Visite guidÃ©e', 'Participez Ã  nos visites guidÃ©es gratuites, oÃ¹ nos guides passionnÃ©s vous feront dÃ©couvrir les comportements et les habitats de nos animaux. Une expÃ©rience Ã©ducative enrichissante pour toute la famille, Ã  ne pas manquer lors de votre visite !\n\nPour rÃ©server votre visite guidÃ©e, utilisez notre formulaire de contact en ligne. Assurez-vous de rÃ©server au moins 24 heures Ã  l\'avance.', NULL),
(3, 'Visite en train', 'Plongez dans une aventure captivante Ã  bord de notre petit train Ã©cologique, et laissez-vous transporter dans une expÃ©rience immersive et enrichissante.\n\nTarif : 2 â‚¬ par personne.\nPour plus de dÃ©tails, veuillez vous renseigner Ã  l\'accueil lors de votre visite.', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employe','veterinaire','administateur') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `email`, `password`, `role`) VALUES
(1, 'veterinaire@example.com', 'veto', 'veterinaire'),
(2, 'employe@example.com', 'employe', 'employe'),
(3, 'josearcadia33@gmail.com', 'jose', 'administateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animal_id`);

--
-- Index pour la table `AVIS`
--
ALTER TABLE `AVIS`
  ADD PRIMARY KEY (`avis_id`);

--
-- Index pour la table `habitat`
--
ALTER TABLE `habitat`
  ADD PRIMARY KEY (`habitat_id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `animal_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `AVIS`
--
ALTER TABLE `AVIS`
  MODIFY `avis_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `habitat`
--
ALTER TABLE `habitat`
  MODIFY `habitat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
