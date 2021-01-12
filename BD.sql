-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 12 jan. 2021 à 18:01
-- Version du serveur :  10.4.16-MariaDB
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `annonce`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id` int(11) NOT NULL,
  `titre` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id`, `titre`, `description`, `actif`, `created_at`, `user_id`) VALUES
(3, 'book', 'description book', 1, '2020-12-19 23:20:37', 1),
(4, 'application web par PHP', 'PHP est un des langages les plus utilisés dans le développement , 75% des sites web existe sont crées par le php ', 1, '2021-01-06 21:51:43', 1),
(6, 'application web par javaEE', 'java EE c\'est un langage backend c.-à-d. il travaille au coté serveur   z ', 1, '2021-01-06 21:54:47', 1),
(20, 'imrane', 'imrane oulamine', 1, '2021-01-09 20:24:39', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `password` varchar(250) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '["ROLES_USER"]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`email`, `id_user`, `password`, `roles`) VALUES
('younessolm@gmail.com', 1, '$argon2i$v=19$m=65536,t=4,p=1$eGNYdmI2V2tIL1h6VTZyZg$f7Zdl513yL+yQ5kYiYiXVo2W5c2zGPOl0O0o6p+GYFw', '[\"ROLES_ADMIN\"]'),
('younessolmaine@gmail.com', 2, '$argon2i$v=19$m=65536,t=4,p=1$UFNxWE1YVVNMRmoxUlJGRQ$xMTumuEnGb5MPX2ezWSLoeuEz0/JfWapHMIQmL+HUmY', '[\"ROLES_USER\"]');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
