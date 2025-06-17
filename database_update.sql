-- Création de la table des sections
CREATE TABLE IF NOT EXISTS sections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des niveaux
CREATE TABLE IF NOT EXISTS niveaux (
    id INT PRIMARY KEY AUTO_INCREMENT,
    section_id INT,
    nom VARCHAR(50) NOT NULL,
    difficulte INT NOT NULL,
    points_requis INT DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES sections(id)
);

-- Modification de la table questions
ALTER TABLE questions
ADD COLUMN section_id INT,
ADD COLUMN niveau_id INT,
ADD COLUMN temps_reponse INT DEFAULT 60,
ADD FOREIGN KEY (section_id) REFERENCES sections(id),
ADD FOREIGN KEY (niveau_id) REFERENCES niveaux(id);

-- Création de la table de progression des utilisateurs
CREATE TABLE IF NOT EXISTS progression_utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    section_id INT,
    niveau_id INT,
    points INT DEFAULT 0,
    date_completion TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (section_id) REFERENCES sections(id),
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id)
);

-- Création de la table des sessions QCM
CREATE TABLE IF NOT EXISTS sessions_qcm (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    section_id INT,
    niveau_id INT,
    date_debut TIMESTAMP,
    date_fin TIMESTAMP,
    score INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (section_id) REFERENCES sections(id),
    FOREIGN KEY (niveau_id) REFERENCES niveaux(id)
);

-- Création de la table des connexions utilisateur (pour le graphique GitHub-like)
CREATE TABLE IF NOT EXISTS connexions_utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    date_connexion TIMESTAMP,
    duree_session INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insertion des sections par défaut
INSERT INTO sections (nom, description) VALUES
('PHP et JavaScript', 'Questions sur PHP et JavaScript'),
('Linux', 'Questions sur Linux'),
('Langage C', 'Questions sur le langage C');

-- Insertion des niveaux par défaut pour chaque section
INSERT INTO niveaux (section_id, nom, difficulte, points_requis) VALUES
(1, 'Débutant', 1, 0),
(1, 'Intermédiaire', 2, 100),
(1, 'Avancé', 3, 200),
(2, 'Débutant', 1, 0),
(2, 'Intermédiaire', 2, 100),
(2, 'Avancé', 3, 200),
(3, 'Débutant', 1, 0),
(3, 'Intermédiaire', 2, 100),
(3, 'Avancé', 3, 200); 