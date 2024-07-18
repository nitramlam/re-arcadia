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
    nourriture_donnee VARCHAR(255),
    image_path VARCHAR(255),
    page_personnalisee_url VARCHAR(255)

);


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
INSERT INTO utilisateurs (email, password, role) VALUES ('josearcadia333@gmail.com', 'jose', 'administateur');



ALTER TABLE habitat CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE service CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE horaires CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE animal CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE AVIS CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE utilisateurs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;




