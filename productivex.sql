-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 16 juin 2023 à 02:56
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `productivex`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `entreprise_id_id` int(11) NOT NULL,
  `formule_id_id` int(11) NOT NULL,
  `debut_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `fin_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tache_id_id` int(11) NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230614201706', '2023-06-15 21:29:48', 28585),
('DoctrineMigrations\\Version20230614222006', '2023-06-15 21:30:17', 630),
('DoctrineMigrations\\Version20230615193225', '2023-06-15 21:32:34', 71);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `entreprise_id_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poste` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debutcontrat_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `fincontrat_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `sigle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denomination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `user_id_id`, `sigle`, `denomination`, `adresse`, `logo`) VALUES
(1, 1, 'ESGIS', 'markes', 'vMGFFGF', 'b1c864025de9d982e0b7c40dd77abe03.png');

-- --------------------------------------------------------

--
-- Structure de la table `formule`
--

CREATE TABLE `formule` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:dateinterval)',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `status_id_id` int(11) NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `objectif`
--

CREATE TABLE `objectif` (
  `id` int(11) NOT NULL,
  `status_id_id` int(11) NOT NULL,
  `objectif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `status_id_id` int(11) NOT NULL,
  `entreprise_id_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:dateinterval)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debut_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `fin_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rappel`
--

CREATE TABLE `rappel` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL,
  `rappel_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recommandation`
--

CREATE TABLE `recommandation` (
  `id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conseil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_journalier`
--

CREATE TABLE `suivi_journalier` (
  `id` int(11) NOT NULL,
  `objectif_id_id` int(11) NOT NULL,
  `rappel_id_id` int(11) NOT NULL,
  `user_id_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `status_id_id` int(11) NOT NULL,
  `projet_id_id` int(11) NOT NULL,
  `employe_id_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:dateinterval)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debut_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `fin_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numtel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `numtel`, `created_at`, `is_verified`) VALUES
(1, 'danieldedo182@gmail.com', '[\"ROLE_USER\",\"ROLE_ENT\"]', '$2y$13$nt92//x88qP17UaAoKS9M.N.xKq5JEa05xjdzuSPCn8UDe6YYRo.y', '45876785', '2023-06-16 02:10:51', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_351268BBDAC5BE2B` (`entreprise_id_id`),
  ADD KEY `IDX_351268BBD9B357CE` (`formule_id_id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BC9D86650F` (`user_id_id`),
  ADD KEY `IDX_67F068BC727ACA70` (`parent_id`),
  ADD KEY `IDX_67F068BCE0894996` (`tache_id_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F804D3B99D86650F` (`user_id_id`),
  ADD KEY `IDX_F804D3B9DAC5BE2B` (`entreprise_id_id`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D19FA609D86650F` (`user_id_id`);

--
-- Index pour la table `formule`
--
ALTER TABLE `formule`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BF5476CA9D86650F` (`user_id_id`),
  ADD KEY `IDX_BF5476CA881ECFA7` (`status_id_id`);

--
-- Index pour la table `objectif`
--
ALTER TABLE `objectif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E2F86851881ECFA7` (`status_id_id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_50159CA9881ECFA7` (`status_id_id`),
  ADD KEY `IDX_50159CA9DAC5BE2B` (`entreprise_id_id`);

--
-- Index pour la table `rappel`
--
ALTER TABLE `rappel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_303A29C99D86650F` (`user_id_id`);

--
-- Index pour la table `recommandation`
--
ALTER TABLE `recommandation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suivi_journalier`
--
ALTER TABLE `suivi_journalier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_956A07D97258AF93` (`objectif_id_id`),
  ADD KEY `IDX_956A07D9B4B78D97` (`rappel_id_id`),
  ADD KEY `IDX_956A07D99D86650F` (`user_id_id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93872075881ECFA7` (`status_id_id`),
  ADD KEY `IDX_93872075D4E271E1` (`projet_id_id`),
  ADD KEY `IDX_93872075325980C0` (`employe_id_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formule`
--
ALTER TABLE `formule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `objectif`
--
ALTER TABLE `objectif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rappel`
--
ALTER TABLE `rappel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recommandation`
--
ALTER TABLE `recommandation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivi_journalier`
--
ALTER TABLE `suivi_journalier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `FK_351268BBD9B357CE` FOREIGN KEY (`formule_id_id`) REFERENCES `formule` (`id`),
  ADD CONSTRAINT `FK_351268BBDAC5BE2B` FOREIGN KEY (`entreprise_id_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `commentaire` (`id`),
  ADD CONSTRAINT `FK_67F068BC9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_67F068BCE0894996` FOREIGN KEY (`tache_id_id`) REFERENCES `tache` (`id`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `FK_F804D3B99D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F804D3B9DAC5BE2B` FOREIGN KEY (`entreprise_id_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `FK_D19FA609D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_BF5476CA881ECFA7` FOREIGN KEY (`status_id_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `FK_BF5476CA9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `objectif`
--
ALTER TABLE `objectif`
  ADD CONSTRAINT `FK_E2F86851881ECFA7` FOREIGN KEY (`status_id_id`) REFERENCES `status` (`id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_50159CA9881ECFA7` FOREIGN KEY (`status_id_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `FK_50159CA9DAC5BE2B` FOREIGN KEY (`entreprise_id_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `rappel`
--
ALTER TABLE `rappel`
  ADD CONSTRAINT `FK_303A29C99D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `suivi_journalier`
--
ALTER TABLE `suivi_journalier`
  ADD CONSTRAINT `FK_956A07D97258AF93` FOREIGN KEY (`objectif_id_id`) REFERENCES `objectif` (`id`),
  ADD CONSTRAINT `FK_956A07D99D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_956A07D9B4B78D97` FOREIGN KEY (`rappel_id_id`) REFERENCES `rappel` (`id`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `FK_93872075325980C0` FOREIGN KEY (`employe_id_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_93872075881ECFA7` FOREIGN KEY (`status_id_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `FK_93872075D4E271E1` FOREIGN KEY (`projet_id_id`) REFERENCES `projet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
