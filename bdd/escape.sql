-- Création de la base de données
CREATE DATABASE IF NOT EXISTS escapegame;
USE escapegame;

-- Configuration
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Structure des tables
CREATE TABLE user_type (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type_utilisateur VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(15),
    type_utilisateur INT,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_utilisateur) REFERENCES user_type(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE themes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE salles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    image LONGBLOB,
    theme_id INT,
    description TEXT,
    duree INT NOT NULL,
    nb_joueurs_min INT NOT NULL,
    nb_joueurs_max INT NOT NULL,
    prix INT NOT NULL,
    FOREIGN KEY (theme_id) REFERENCES themes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE horaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    salle_id INT,
    heure_debut DATETIME NOT NULL,
    heure_fin DATETIME NOT NULL,
    disponible BOOLEAN DEFAULT true,
    FOREIGN KEY (salle_id) REFERENCES salles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE status_res (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etat VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    salle_id INT,
    horaire_id INT,
    nb_participants INT NOT NULL,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    prix_total INT NOT NULL,
    status_id INT DEFAULT 1,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (salle_id) REFERENCES salles(id),
    FOREIGN KEY (horaire_id) REFERENCES horaires(id),
    FOREIGN KEY (status_id) REFERENCES status_res(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE gamemaster_status (
    id INT PRIMARY KEY AUTO_INCREMENT,
    statut_desc VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE gamemaster_assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reservation_id INT,
    gamemaster_id INT,
    statutGM INT,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (gamemaster_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (statutGM) REFERENCES gamemaster_status(id),
    CONSTRAINT unique_gamemaster_reservation UNIQUE (reservation_id, gamemaster_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Données initiales
INSERT INTO user_type (type_utilisateur) VALUES
    ('Utilisateur'),
    ('gamemaster'),
    ('admin');

INSERT INTO status_res (etat) VALUES
    ('En Attente'),
    ('Validée'),
    ('Annulée');

INSERT INTO gamemaster_status (statut_desc) VALUES
    ('Disponible'),
    ('En service'),
    ('Indisponible');

INSERT INTO themes (nom, description) VALUES
    ('Mystère', 'Découvrez les mystères de l\'univers'),
    ('Aventure', 'Partez à l\'aventure'),
    ('Horreur', 'Faites face à vos peurs');

INSERT INTO salles (nom, theme_id, description, duree, nb_joueurs_min, nb_joueurs_max, prix) VALUES
    ('La Crypte', 1, 'Enigme et mystère', 60, 2, 6, 20),
    ('La Jungle', 2, 'Survivrez-vous à la jungle', 60, 2, 6, 20),
    ('La Maison Hantee', 3, 'Faites face à vos peurs', 60, 2, 6, 20);

INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, type_utilisateur) VALUES
    ('admin', 'admin', 'admin@gmail.com', '$2y$10$L9j3h0xXZjkE3qsF9WPfbefko7e7FQhT2fIg1Z1xiu1d9tISVY0v2', '9999999999', 3);
    ('gm', 'gm', 'gm@gmail.com', '$2y$10$L9j3h0xXZjkE3qsF9WPfbefko7e7FQhT2fIg1Z1xiu1d9tISVY0v2', '9999999999', 2);

--update
/*
update utilisateurs set type_utilisateur = 2 where id = 2;
*/

COMMIT;
