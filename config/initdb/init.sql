CREATE TABLE IF NOT EXISTS HABITAT (
    habitat_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    commentaire_habitat TEXT
);

INSERT INTO HABITAT (nom, description, commentaire_habitat) VALUES 
('Savane', 'Une grande plaine herbeuse, souvent parsemée d arbres dispersés.', 'Climat chaud avec saisons sèches et humides.'),
('Jungle', 'Une forêt dense et humide avec une grande biodiversité.', 'Climat tropical avec de fortes précipitations.'),
('Marais', 'Une zone humide souvent inondée, riche en biodiversité aquatique.', 'Terrain marécageux avec une végétation spécifique.');