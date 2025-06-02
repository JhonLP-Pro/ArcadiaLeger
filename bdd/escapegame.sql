-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 02 juin 2025 à 19:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `escapegame`
--

-- --------------------------------------------------------

--
-- Structure de la table `gamemaster_assignments`
--

CREATE TABLE `gamemaster_assignments` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `gamemaster_id` int(11) DEFAULT NULL,
  `statutGM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gamemaster_status`
--

CREATE TABLE `gamemaster_status` (
  `id` int(11) NOT NULL,
  `statut_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `gamemaster_status`
--

INSERT INTO `gamemaster_status` (`id`, `statut_desc`) VALUES
(1, 'Disponible'),
(2, 'En service'),
(3, 'Indisponible');

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `id` int(11) NOT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `heure_debut` datetime NOT NULL,
  `heure_fin` datetime NOT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `salle_id`, `heure_debut`, `heure_fin`, `disponible`) VALUES
(1, 1, '2024-01-01 10:00:00', '2024-01-01 11:00:00', 1),
(2, 2, '2024-01-01 10:00:00', '2024-01-01 11:00:00', 1),
(3, 3, '2024-01-01 10:00:00', '2024-01-01 11:00:00', 1),
(4, 2, '2025-03-18 16:00:00', '2025-03-18 18:00:00', 1),
(5, 1, '2025-03-19 10:00:00', '2025-03-19 11:00:00', 1),
(6, 1, '2025-06-09 09:00:00', '2025-06-09 11:00:00', 0),
(7, 1, '2025-06-10 09:00:00', '2025-06-10 11:00:00', 1),
(8, 1, '2025-06-11 09:00:00', '2025-06-11 11:00:00', 1),
(9, 1, '2025-06-12 09:00:00', '2025-06-12 11:00:00', 1),
(10, 1, '2025-06-13 09:00:00', '2025-06-13 11:00:00', 1),
(11, 1, '2025-06-14 09:00:00', '2025-06-14 11:00:00', 1),
(12, 1, '2025-06-15 09:00:00', '2025-06-15 11:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `horaire_id` int(11) DEFAULT NULL,
  `nb_participants` int(11) NOT NULL,
  `date_reservation` datetime DEFAULT current_timestamp(),
  `prix_total` int(11) NOT NULL,
  `status_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `utilisateur_id`, `salle_id`, `horaire_id`, `nb_participants`, `date_reservation`, `prix_total`, `status_id`) VALUES
(1, 1, 1, 4, 4, '2025-03-16 16:43:45', 60, 1),
(3, 8, 1, 6, 5, '2025-06-02 19:50:52', 20, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `image` longblob DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duree` int(11) NOT NULL,
  `nb_joueurs_min` int(11) NOT NULL,
  `nb_joueurs_max` int(11) NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `nom`, `image`, `theme_id`, `description`, `duree`, `nb_joueurs_min`, `nb_joueurs_max`, `prix`) VALUES
(1, 'La Crypte', NULL, 1, 'Enigme et mystère', 60, 2, 6, 20),
(2, 'La Jungle', NULL, 2, 'Survivrez-vous à la jungle', 60, 2, 6, 20),
(3, 'La Maison Hantee', NULL, 3, 'Faites face à vos peurs', 60, 2, 6, 20),
(4, 'testjava', NULL, NULL, 'testjava', 60, 3, 6, 60);

-- --------------------------------------------------------

--
-- Structure de la table `status_res`
--

CREATE TABLE `status_res` (
  `id` int(11) NOT NULL,
  `etat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `status_res`
--

INSERT INTO `status_res` (`id`, `etat`) VALUES
(1, 'En Attente'),
(2, 'Validée'),
(3, 'Annulée');

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `themes`
--

INSERT INTO `themes` (`id`, `nom`, `description`) VALUES
(1, 'Mystère', 'Découvrez les mystères de l\'univers'),
(2, 'Aventure', 'Partez à l\'aventure'),
(3, 'Horreur', 'Faites face à vos peurs');

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type_utilisateur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_type`
--

INSERT INTO `user_type` (`id`, `type_utilisateur`) VALUES
(1, 'Utilisateur'),
(2, 'gamemaster'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `type_utilisateur` int(11) DEFAULT NULL,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `telephone`, `type_utilisateur`, `date_inscription`) VALUES
(1, 'Doe', 'John', 'john.doe@escapegame.com', '12345', '0777777777', 1, '2025-03-16 16:42:24'),
(2, 'Doe', 'Jane', 'jane.doe@escapegame.com', '12345', '0777777778', 2, '2025-03-16 16:42:24'),
(3, 'Doe', 'Bob', 'bob.doe@escapegame.com', '12345', '0777777779', 1, '2025-03-16 16:42:24'),
(4, 'Doe', 'Alice', 'alice.doe@escapegame.com', '12345', '0777777780', 3, '2025-03-16 16:42:24'),
(5, 'testA', 'testA', 'testA@gmail.com', '12345', '0678985267', 2, '2025-03-17 10:55:01'),
(6, 'TestB', 'TestB', 'TestB@gmail.com', 't@testb20250317', '0765789865', 2, '2025-03-17 10:59:54'),
(7, 'Test', 'Test', 'T@gmail.com', 't@test20250317', '0676546789', 2, '2025-03-17 11:10:04'),
(8, 'uzumaki', 'naruto', 'uzumaki.naruto@gmail.com', '$2y$10$Hfj8lfT2tZi8tVpWgSItieI7TNClM452YOgyKjFPoKpanh8CueENu', '0612769828', 1, '2025-06-02 19:36:05'),
(9, 'uchiwa', 'Sasuke', 'uchiwa.sasuke@gmail.com', '$2y$10$NwNOaaJMZW0HTsJyqgJOCuQWSak1axKdBCjuxooITNOKwpNDWYnYC', '0787656399', 2, '2025-06-02 19:37:49'),
(10, 'admin', 'admin', 'admin@gmail.com', '$2y$10$L9j3h0xXZjkE3qsF9WPfbefko7e7FQhT2fIg1Z1xiu1d9tISVY0v2', '9999999999', 3, '2025-06-02 19:39:02');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `gamemaster_assignments`
--
ALTER TABLE `gamemaster_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_gamemaster_reservation` (`reservation_id`,`gamemaster_id`),
  ADD KEY `gamemaster_id` (`gamemaster_id`),
  ADD KEY `statutGM` (`statutGM`);

--
-- Index pour la table `gamemaster_status`
--
ALTER TABLE `gamemaster_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salle_id` (`salle_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `salle_id` (`salle_id`),
  ADD KEY `horaire_id` (`horaire_id`),
  ADD KEY `FK_statusRes` (`status_id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Index pour la table `status_res`
--
ALTER TABLE `status_res`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `type_utilisateur` (`type_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `gamemaster_assignments`
--
ALTER TABLE `gamemaster_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `gamemaster_status`
--
ALTER TABLE `gamemaster_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `status_res`
--
ALTER TABLE `status_res`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `gamemaster_assignments`
--
ALTER TABLE `gamemaster_assignments`
  ADD CONSTRAINT `gamemaster_assignments_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gamemaster_assignments_ibfk_2` FOREIGN KEY (`gamemaster_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `gamemaster_assignments_ibfk_3` FOREIGN KEY (`statutGM`) REFERENCES `gamemaster_status` (`id`);

--
-- Contraintes pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD CONSTRAINT `horaires_ibfk_1` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_statusRes` FOREIGN KEY (`status_id`) REFERENCES `status_res` (`id`),
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`horaire_id`) REFERENCES `horaires` (`id`);

--
-- Contraintes pour la table `salles`
--
ALTER TABLE `salles`
  ADD CONSTRAINT `salles_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`type_utilisateur`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
