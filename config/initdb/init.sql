CREATE TABLE IF NOT EXISTS HABITAT (
    habitat_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    commentaire_habitat TEXT,
    image_path VARCHAR(255)
);

INSERT INTO HABITAT (nom, description, commentaire_habitat, image_path) VALUES 
('Savane', 'Une grande plaine herbeuse, souvent parsemée d arbres disperses.', 'Climat chaud avec saisons seches et humides.', 'assets/savane-habitats.png'),
('Jungle', 'Une foret dense et humide avec une grande biodiversite.', 'Climat tropical avec de fortes precipitations.', 'assets/jungle-habitats.png'),
('Marais', 'Une zone humide souvent inondee, riche en biodiversite aquatique.', 'Terrain marecageux avec une vegetation specifique.', 'assets/marais-habitats.png');


CREATE TABLE IF NOT EXISTS service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icons_path VARCHAR(255)
);

-- Insérer des données dans la table service
INSERT INTO service (nom, description) VALUES
('Restaurant', 'Découvrez notre zoo de manière enrichissante avec un restaurant proposant des produits locaux et biologiques, des visites guidées interactives gratuites qui vous plongent dans l univers captivant de nos animaux. et des circuits en petit train électrique respectueux de notre écosystème.'),
('Visite guidée', 'Participez à nos visites guidées gratuites, où nos guides passionnés vous feront découvrir les comportements et les habitats de nos animaux. Une expérience éducative enrichissante pour toute la famille, à ne pas manquer lors de votre visite !\n\nPour réserver votre visite guidée, utilisez notre formulaire de contact en ligne. Assurez-vous de réserver au moins 24 heures à l avance.'),
('Visite en train', 'Plongez dans une aventure captivante à bord de notre petit train écologique, et laissez-vous transporter dans une expérience immersive et enrichissante.\n\nTarif : 2 € par Personne\nPour plus de détails, veuillez vous renseigner à l\accueil lors de votre visite.');
