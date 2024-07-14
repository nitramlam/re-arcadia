CREATE DATABASE IF NOT EXISTS arcadia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use arcadia;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS habitat (
    habitat_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    commentaire_habitat TEXT,
    image_path VARCHAR(255)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insérer des données dans la table habitat
INSERT INTO habitat (nom, description, commentaire_habitat, image_path) VALUES 
('Savane', 'Une grande plaine herbeuse, souvent parsemée d\'arbres dispersés.', 'propre.', 'assets/savane-habitats.png'),
('Jungle', 'Une forêt dense et humide avec une grande biodiversité.', 'sale', 'assets/jungle-habitats.png'),
('Marais', 'Une zone humide souvent inondée, riche en biodiversité aquatique.', 'propre.', 'assets/marais-habitats.png');
CREATE TABLE IF NOT EXISTS service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icons_path VARCHAR(255)
);


-- Insérer des données dans la table service
INSERT INTO service (nom, description, icons_path) VALUES
('Restaurant', 'Découvrez notre zoo de manière enrichissante avec un restaurant proposant des produits locaux et biologiques, des visites guidées interactives gratuites qui vous plongent dans l\'univers captivant de nos animaux, et des circuits en petit train électrique respectueux de notre écosystème.', NULL),
('Visite guidée', 'Participez à nos visites guidées gratuites, où nos guides passionnés vous feront découvrir les comportements et les habitats de nos animaux. Une expérience éducative enrichissante pour toute la famille, à ne pas manquer lors de votre visite !\n\nPour réserver votre visite guidée, utilisez notre formulaire de contact en ligne. Assurez-vous de réserver au moins 24 heures à l\'avance.', NULL),
('Visite en train', 'Plongez dans une aventure captivante à bord de notre petit train écologique, et laissez-vous transporter dans une expérience immersive et enrichissante.\n\nTarif : 2 € par personne.\nPour plus de détails, veuillez vous renseigner à l\'accueil lors de votre visite.', NULL);

CREATE TABLE IF NOT EXISTS horaires (
    horaire_id INT AUTO_INCREMENT PRIMARY KEY,
    ouverture TIME NOT NULL,
    fermeture TIME NOT NULL
);

-- Insertion d'une seule ligne dans la table horaires
INSERT INTO horaires (ouverture, fermeture) VALUES
('08:00:00', '18:00:00');

CREATE TABLE IF NOT EXISTS animal (
    animal_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    espece VARCHAR(255) NOT NULL,
    etat_general VARCHAR(255),
    regime VARCHAR(255),
    poids DECIMAL(6, 2),
    sexe VARCHAR(10),
    derniere_visite DATE,
    commentaire VARCHAR(255),
    continent_origine VARCHAR(255),
    age INT,
    habitat VARCHAR(255),
    grammage DECIMAL(6, 2),
    description VARCHAR(1000),
    date_heure_passage_employe DATETIME,
    grammage_donne DECIMAL(6, 2),
    nourriture_donnee VARCHAR(255)
);

INSERT INTO animal (nom, espece, etat_general, description, regime, poids, sexe, derniere_visite, commentaire, continent_origine, age, habitat, grammage, date_heure_passage_employe, grammage_donne, nourriture_donnee)
VALUES 
    ('Tichou', 'jaguar d\'Amazonie', 'En bonne santé', 'Le jaguar d\'Amazonie est le plus grand félin d\'Amérique, reconnaissable à sa robe jaune doré tachetée de noir. Prédateur solitaire des forêts tropicales, il se nourrit principalement de grands mammifères tels que les cerfs, les tapirs et les capybaras. Il joue un rôle crucial en régulant les populations de proies et en maintenant l\'équilibre écologique de son habitat menacé par la déforestation.', 'Protéine', 70.00, 'F', '2024-02-01', NULL, 'Amérique du Sud', 4, 'Jungle', 3.00, '2024-02-15 10:00:00', 2.50, 'Protéine'),

    ('Oscar', 'lion d\'Afrique', 'En bonne santé', 'Le lion d\'Afrique (Panthera leo) règne sur les vastes étendues de la savane africaine. Connu pour sa majestueuse crinière et sa puissante stature, ce prédateur social vit en groupes appelés fiertés. Les lions de la savane chassent en coopération, ciblant des proies telles que les zèbres, les gnous et les antilopes. Symbole de force et de courage, le lion joue un rôle crucial dans l\'écosystème en régulant les populations d\'herbivores.', 'Protéine', 300.00, 'M', '2024-02-01', NULL, 'Afrique', 5, 'Savane', 10.00, '2024-02-15 10:30:00', 9.00, 'Protéine'),

    ('Hinata', 'panthère de Floride', 'En bonne santé', 'La panthère de Floride (Puma concolor coryi) est une sous-espèce rare et protégée du puma, reconnaissable à sa robe beige et à ses taches. Adaptée à son habitat marécageux unique, elle se nourrit principalement de cerfs, de sangliers et d\'autres petits mammifères. La panthère de Floride est un symbole de conservation, représentant les efforts pour protéger les espèces en danger et leurs habitats fragiles.', 'Protéine', 110.00, 'F', '2024-02-01', NULL, 'Amérique du Nord', 2, 'Marais', 6.00, '2024-02-15 11:00:00', 5.50, 'Protéine'),

    ('Weasley', 'paresseux', 'En bonne santé','Le paresseux à trois doigts est un mammifère des forêts tropicales d\'Amérique centrale et du Sud. Connus pour leur lenteur et leur régime à base de feuilles, ils sont essentiels à la dispersion des graines et à la biodiversité, symbolisant la conservation des habitats fragiles.', 'Graines', 5.00, 'M', '2024-02-01', NULL, 'Amérique du Sud', 0, 'Jungle', 0.50, '2024-02-15 11:30:00', 0.40, 'Graines'),

    ('Léonard', 'éléphant d\'Afrique', 'En bonne santé','L\'éléphant d\'Afrique, emblème des savanes et des forêts subsahariennes, est vital pour l\'écosystème en tant qu\'ingénieur du paysage et disperseur de graines. Malheureusement menacé par le braconnage et la perte d\'habitat, sa conservation est essentielle pour préserver la biodiversité africaine.', 'Graines', 1500.00, 'M', '2024-02-01', NULL, 'Afrique', 45, 'Jungle', 15.00, '2024-02-15 12:00:00', 14.00, 'Graines'),

    ('Mariette', 'lamantin des Everglades', 'En bonne santé','Le lamantin des Everglades (Trichechus manatus latirostris) est une sous-espèce de lamantin qui vit exclusivement dans les eaux douces et les marais des Everglades en Floride. Reconnaissable à sa taille imposante et ses nageoires larges, il joue un rôle crucial dans l\'écosystème de cet habitat unique, mais il est gravement menacé par la perte d\'habitat et d\'autres menaces. Des mesures de conservation sont essentielles pour assurer sa survie.', 'Graines', 300.00, 'F', '2024-02-01', NULL, 'Amérique du Nord', 17, 'Marais', 2.00, '2024-02-15 12:30:00', 1.80, 'Graines'),

    ('Euridice', 'anaconda vert', 'En bonne santé','L\'anaconda vert (Eunectes murinus) est un serpent géant de l\'Amazonie, célèbre pour sa taille impressionnante et son régime alimentaire principalement composé de poissons, d\'oiseaux et parfois de petits mammifères. Essentiel à l\'équilibre écologique des marécages et des rivières, il joue un rôle crucial dans la régulation des populations de ses proies.', 'Protéine', 3.00, 'F', '2024-02-01', NULL, 'Amérique du Sud', 5, 'Marais', 0.30, '2024-02-15 13:00:00', 0.25, 'Protéine'),

    ('Richard', 'lézard à crête du désert', 'En bonne santé','Le lézard à crête du désert (Stellagama stellio) est une espèce répandue dans les régions semi-arides et les savanes d\'Afrique du Nord, du Moyen-Orient et de l\'Asie. Reconnaissable par sa crête d\'épines et ses couleurs variant du gris au brun, il se nourrit d\'insectes et de petits mammifères. Ce lézard est connu pour sa capacité à grimper habilement sur les surfaces rocheuses et à se fondre dans son environnement pour se camoufler des prédateurs.', 'Protéine', 1.00, 'F', '2024-02-01', NULL, 'Afrique', 7, 'Savane', 0.20, '2024-02-15 13:30:00', 0.15, 'Protéine'),

    ('Renee', 'alligator des Everglades', 'En bonne santé','Les alligators des Everglades (Alligator mississippiensis) sont des prédateurs emblématiques des marécages de Floride. Ils se distinguent par leur peau écailleuse et leurs puissantes mâchoires, adaptées à la chasse de poissons, de reptiles et de petits mammifères. Jouant un rôle crucial dans l\'écosystème. Leur conservation est essentielle face aux menaces croissantes de perte d\'habitat et de conflits avec les humains.', 'Protéine', 300.00, 'M', '2024-02-01', NULL, 'Amérique du Nord', 20, 'Marais', 15.00, '2024-02-15 14:00:00', 14.00, 'Protéine'),

     ('Gurky', 'toucan toco', 'En bonne santé','Les toucans d\'Amazonie, connus sous le nom scientifique Ramphastos toco, contribuent à la richesse de la biodiversité amazonienne en jouant un rôle crucial dans la dispersion des graines des fruits qu\'ils consomment. Leur présence dans les canopées des forêts tropicales favorise la régénération des espèces végétales et soutient la diversité des habitats. En tant qu\'indicateurs de l\'état de santé des écosystèmes, ils sont essentiels pour la conservation des vastes réseaux écologiques de l\'Amazonie.', 'Graines', 4.00, 'M', '2024-02-01', NULL, 'Amérique du Sud', 3, 'Jungle', 1.00, '2024-02-15 14:30:00', 0.90, 'Graines'),

    ('Dorothee', 'autruche d\'Afrique', 'En bonne santé','Les autruches d\'Afrique, Struthio camelus, sont les plus grands oiseaux terrestres, parfaitement adaptés aux vastes savanes arides. Leur plumage brun-gris les aide à se fondre dans leur environnement, et elles se nourrissent principalement de végétation et de graines.', 'Graines', 30.00, 'F', '2024-02-01', NULL, 'Afrique', 4, 'Savane', 2.00, '2024-02-15 15:00:00', 1.80, 'Graines'),

    ('Narsil', 'héron cendré des Everglades', 'En bonne santé','Le héron cendré des Everglades, connu sous son nom scientifique Ardea herodias, est une espèce emblématique des marais et des zones humides de Floride. Reconnaissable à son plumage cendré, à son long cou et à ses pattes jaunes, il se nourrit principalement de poissons, de grenouilles et d\'insectes qu\'il chasse avec agilité dans les eaux peu profondes. Ce héron joue un rôle crucial dans l\'écosystème en régulant les populations de poissons et en contribuant à la biodiversité des habitats aquatiques.', 'Protéine', 10.00, 'M', '2024-02-01', NULL, 'Amérique du Nord', 11, 'Marais', 2.00, '2024-02-15 15:30:00', 1.80, 'Protéine');

CREATE TABLE IF NOT EXISTS AVIS (
    avis_id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50),
    commentaire VARCHAR(50),
    isVisible BOOL,
    isApproved BOOL DEFAULT false
);

INSERT INTO AVIS (pseudo, commentaire, isVisible, isApproved) VALUES
('martin', 'super visite', true, true),
('jules', 'yessai', true, true);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('employe', 'veterinaire', 'administateur') 
);
INSERT INTO utilisateurs (email, password, role)
VALUES
('veterinaire@example.com', 'veto', 'veterinaire'),
('employe@example.com','employe', 'employe'),
('josearcadia33@gmail.com' , 'jose','administateur');


ALTER TABLE habitat CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE service CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE horaires CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE animal CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE AVIS CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE utilisateurs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;




