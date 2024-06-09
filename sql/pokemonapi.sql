-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 09 juin 2024 à 04:58
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
-- Base de données : `pokemonapi`
--

-- --------------------------------------------------------

--
-- Structure de la table `move`
--

CREATE TABLE `move` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `classification` varchar(2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `power` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  `max_pp` int(11) NOT NULL,
  `current_pp` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `effect` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `move_pokemon`
--

CREATE TABLE `move_pokemon` (
  `move_id` int(11) NOT NULL,
  `pokemon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL,
  `national_number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`types`)),
  `level` int(11) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `current_hp` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `sprite` longtext DEFAULT NULL,
  `pre_evolution_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pokemon`
--

INSERT INTO `pokemon` (`id`, `national_number`, `name`, `types`, `level`, `max_hp`, `current_hp`, `attack`, `defense`, `speed`, `description`, `sprite`, `pre_evolution_id`) VALUES
(1, 1, 'Bulbizarre', '[\"Grass\",\"Poison\"]', 5, 45, 45, 49, 49, 45, 'Bulbizarre is a small, quadruped Pokémon that has blue-green skin with darker blue-green spots.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png', NULL),
(2, 2, 'Herbizarre', '[\"Grass\",\"Poison\"]', 16, 60, 60, 62, 63, 60, 'Herbizarre is a quadruped Pokémon similar to a dinosaur with blue-green skin.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/002.png', 1),
(3, 3, 'Florizarre', '[\"Grass\",\"Poison\"]', 32, 80, 80, 82, 83, 80, 'Florizarre is a large, quadruped Pokémon that has a flower blooming on its back.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/003.png', 2),
(4, 4, 'Salamèche', '[\"Fire\"]', 5, 39, 39, 52, 43, 65, 'Salamèche is a bipedal, reptilian Pokémon with a primarily orange body and blue eyes.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/004.png', NULL),
(5, 5, 'Reptincel', '[\"Fire\"]', 16, 58, 58, 64, 58, 80, 'Reptincel is a bipedal, reptilian Pokémon with a primarily orange body.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/005.png', 4),
(6, 6, 'Dracaufeu', '[\"Fire\",\"Flying\"]', 36, 78, 78, 84, 78, 100, 'Dracaufeu is a large, dragon-like Pokémon that flies majestically in the sky.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/006.png', 5),
(7, 7, 'Carapuce', '[\"Water\"]', 5, 44, 44, 48, 65, 43, 'Carapuce is a small, bipedal, turtle-like Pokémon with a blue body and a long, curled tail.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/007.png', NULL),
(8, 8, 'Carabaffe', '[\"Water\"]', 16, 59, 59, 63, 80, 58, 'Carabaffe is a bipedal, indigo turtle-like Pokémon.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/008.png', 7),
(9, 9, 'Tortank', '[\"Water\"]', 36, 79, 79, 83, 100, 78, 'Tortank is a large, bipedal turtle-like Pokémon with a blue body and a brown shell.', 'https://assets.pokemon.com/assets/cms2/img/pokedex/full/009.png', 8);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'test@test.fr', '[]', '$2y$13$NjxeQAwwzNMngVEIbRG1Du090gw9P6hbCrT1vXYRl154Hgfn8dXYC'),
(2, 'test2@test.fr', '[\"ROLE_ADMIN\"]', '$2y$13$IseDoaAoC5EnJRkbx3oHqOy6.URz7TS.Yhv40F04Rzes0IWL6IOMO');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `move`
--
ALTER TABLE `move`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `move_pokemon`
--
ALTER TABLE `move_pokemon`
  ADD PRIMARY KEY (`move_id`,`pokemon_id`),
  ADD KEY `IDX_901156A46DC541A8` (`move_id`),
  ADD KEY `IDX_901156A42FE71C3E` (`pokemon_id`);

--
-- Index pour la table `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62DC90F3DA97744` (`pre_evolution_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `move`
--
ALTER TABLE `move`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `move_pokemon`
--
ALTER TABLE `move_pokemon`
  ADD CONSTRAINT `FK_901156A42FE71C3E` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_901156A46DC541A8` FOREIGN KEY (`move_id`) REFERENCES `move` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pokemon`
--
ALTER TABLE `pokemon`
  ADD CONSTRAINT `FK_62DC90F3DA97744` FOREIGN KEY (`pre_evolution_id`) REFERENCES `pokemon` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
