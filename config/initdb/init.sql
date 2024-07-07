CREATE TABLE IF NOT EXISTS HABITAT (
    habitat_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    commentaire_habitat TEXT,
    image_data BLOB
);

INSERT INTO HABITAT (nom, description, commentaire_habitat, image_data) VALUES 
('Savane', 'Une grande plaine herbeuse, souvent parsemée d arbres disperses.', 'Climat chaud avec saisons seches et humides.', LOAD_FILE('/docker-entrypoint-initdb.d/assets/savane-habitats.png')),
('Jungle', 'Une foret dense et humide avec une grande biodiversite.', 'Climat tropical avec de fortes precipitations.', NULL),
('Marais', 'Une zone humide souvent inondee, riche en biodiversite aquatique.', 'Terrain marecageux avec une vegetation specifique.', NULL);
