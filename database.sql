-- Création de la base de données
CREATE DATABASE IF NOT EXISTS qcm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE qcm;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Table des sections
CREATE TABLE IF NOT EXISTS sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT
);

-- Table des niveaux
CREATE TABLE IF NOT EXISTS niveaux (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    difficulte INT NOT NULL,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
);

-- Table des questions
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    niveau_id INT NOT NULL,
    question TEXT NOT NULL,
    reponse1 TEXT NOT NULL,
    reponse2 TEXT NOT NULL,
    reponse3 TEXT NOT NULL,
    reponse4 TEXT NOT NULL,
    bonne_reponse TEXT NOT NULL,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id) ON DELETE CASCADE
);

-- Table des résultats
CREATE TABLE IF NOT EXISTS resultats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    section_id INT NOT NULL,
    niveau_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id) ON DELETE CASCADE
);

-- Insertion des sections
INSERT INTO sections (nom, description) VALUES
('PHP', 'Questions sur le langage PHP et ses fonctionnalités'),
('JavaScript', 'Questions sur JavaScript et le développement web front-end'),
('Linux', 'Questions sur le système d''exploitation Linux et ses commandes'),
('C', 'Questions sur le langage de programmation C');

-- Insertion des niveaux pour chaque section
INSERT INTO niveaux (section_id, nom, description, difficulte) VALUES
-- PHP
(1, 'Débutant', 'Bases du PHP', 1),
(1, 'Intermédiaire', 'Fonctions et objets en PHP', 2),
(1, 'Avancé', 'Programmation orientée objet et frameworks PHP', 3),
-- JavaScript
(2, 'Débutant', 'Bases de JavaScript', 1),
(2, 'Intermédiaire', 'DOM et événements', 2),
(2, 'Avancé', 'AJAX et frameworks JavaScript', 3),
-- Linux
(3, 'Débutant', 'Commandes de base Linux', 1),
(3, 'Intermédiaire', 'Gestion des fichiers et permissions', 2),
(3, 'Avancé', 'Scripts shell et administration système', 3),
-- C
(4, 'Débutant', 'Bases du langage C', 1),
(4, 'Intermédiaire', 'Pointeurs et structures', 2),
(4, 'Avancé', 'Programmation système et optimisation', 3);

-- Création d'un utilisateur admin par défaut (mot de passe: admin123)
INSERT INTO utilisateurs (username, password, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'admin');

-- Table des connexions utilisateur
CREATE TABLE IF NOT EXISTS connexions_utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- Table de progression utilisateur
CREATE TABLE IF NOT EXISTS progression_utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    section_id INT NOT NULL,
    niveau_id INT NOT NULL,
    score_max INT DEFAULT 0,
    derniere_tentative TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id) ON DELETE CASCADE,
    UNIQUE KEY unique_progression (user_id, section_id, niveau_id)
);

-- Table des sessions QCM
CREATE TABLE IF NOT EXISTS sessions_qcm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    section_id INT NOT NULL,
    niveau_id INT NOT NULL,
    score INT NOT NULL DEFAULT 0,
    date_debut TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_fin TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE,
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id) ON DELETE CASCADE
);

-- Table des réponses utilisateur
CREATE TABLE IF NOT EXISTS reponses_utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    question_id INT NOT NULL,
    reponse VARCHAR(255) NOT NULL,
    est_correcte BOOLEAN NOT NULL,
    temps_reponse INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES sessions_qcm(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
); 