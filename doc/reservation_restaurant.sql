-- phpMyAdmin SQL Dump
-- version 5.2.3-1.fc43
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 jan. 2026 à 18:01
-- Version du serveur : 10.11.15-MariaDB
-- Version de PHP : 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservation_restaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `mdp`) VALUES
(1, 'admin', '$2y$10$z574Am6yXMu0MbWx8QBCcu4WFu1Dpc8k6AKMDCjFKjgcPMtDNTEsy');

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

CREATE TABLE `creneaux` (
  `id` int(11) NOT NULL,
  `heure` varchar(5) NOT NULL,
  `service` enum('midi','soir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `creneaux`
--

INSERT INTO `creneaux` (`id`, `heure`, `service`) VALUES
(1, '13:00', 'midi'),
(2, '20:00', 'soir'),
(3, '21:00', 'soir'),
(4, '14:00', 'midi'),
(5, '12:00', 'midi'),
(6, '12:30', 'midi'),
(7, '13:30', 'midi'),
(8, '14:30', 'midi'),
(9, '15:00', 'midi'),
(10, '15:30', 'midi'),
(11, '16:30', 'midi'),
(12, '20:30', 'soir'),
(13, '21:30', 'soir'),
(14, '22:00', 'soir'),
(16, '22:30', 'soir');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `nom_client` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `date_reservation` date NOT NULL,
  `creneau_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `nombre_personnes` int(11) NOT NULL,
  `commentaires` text DEFAULT NULL,
  `statut` enum('en_attente','confirmee','annulee') DEFAULT 'en_attente',
  `code_confirmation` varchar(10) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `nom_client`, `email`, `telephone`, `date_reservation`, `creneau_id`, `table_id`, `nombre_personnes`, `commentaires`, `statut`, `code_confirmation`, `date_creation`) VALUES
(1, 'client1', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-28', 1, 5, 5, NULL, 'confirmee', 'WPoSq3gs07', '2026-01-25 19:15:29'),
(2, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-27', 3, 5, 2, '', 'confirmee', 'rlmGfa8NdJ', '2026-01-26 09:47:42'),
(3, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-27', 14, 5, 2, '', 'en_attente', '', '2026-01-26 12:13:57'),
(4, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-27', 3, 7, 2, '', 'en_attente', '', '2026-01-26 16:27:42'),
(5, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-27', 3, 8, 2, '', 'annulee', '', '2026-01-26 16:28:11'),
(6, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-27', 6, 5, 4, '', 'en_attente', '', '2026-01-26 16:38:43'),
(7, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-28', 5, 5, 2, '', 'en_attente', '', '2026-01-27 09:54:52'),
(8, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-28', 5, 5, 2, '', 'en_attente', NULL, '2026-01-27 09:55:00'),
(9, 'Zakaria bouskif', 'super-admin@gmail.com', '', '2026-01-30', 16, 5, 2, 'dsdsds', 'en_attente', NULL, '2026-01-29 09:53:31'),
(10, 'Zakaria bouskif', 'za_bouskif@etu.enset-media.ac.ma', '', '2026-01-31', 9, 8, 6, '', 'en_attente', NULL, '2026-01-30 10:06:02');

-- --------------------------------------------------------

--
-- Structure de la table `tables_restaurant`
--

CREATE TABLE `tables_restaurant` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `capacite` int(11) NOT NULL,
  `zone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tables_restaurant`
--

INSERT INTO `tables_restaurant` (`id`, `numero`, `capacite`, `zone`) VALUES
(5, 1, 4, 'A'),
(7, 2, 4, 'B'),
(8, 3, 6, 'C'),
(11, 4, 8, 'Ac');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `creneaux`
--
ALTER TABLE `creneaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creneau_id` (`creneau_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Index pour la table `tables_restaurant`
--
ALTER TABLE `tables_restaurant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `tables_restaurant`
--
ALTER TABLE `tables_restaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`creneau_id`) REFERENCES `creneaux` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables_restaurant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
