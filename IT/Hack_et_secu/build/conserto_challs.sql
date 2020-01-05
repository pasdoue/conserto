-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 02 Janvier 2020 à 13:39
-- Version du serveur :  5.7.28-0ubuntu0.18.04.4
-- Version de PHP :  7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `conserto_challs`
--

-- --------------------------------------------------------

--
-- Structure de la table `chall`
--

CREATE TABLE `chall` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `hint` text NOT NULL,
  `solution` varchar(50) NOT NULL,
  `level` varchar(10) NOT NULL DEFAULT 'easy',
  `points` int(11) NOT NULL DEFAULT '0',
  `domain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `chall`
--

INSERT INTO `chall` (`id`, `name`, `description`, `hint`, `solution`, `level`, `points`, `domain_id`) VALUES
(1, 'hidden_in_plain_sight.txt', 'Nous avons entendu dire que vous aviez quelques notions dans le langage local. Nous comptons sur vous pour comprendre ce que notre agent a bien voulu nous dire!', 'Albert finit toujours premier de la classe', 'ConserTocestsyMpaS', 'easy', 10, 8),
(2, 'horrible_consert(o).wav', 'Il parait que vous êtes dans une société de concert ? Aidez-nous à comprendre la personne qui joue au synthétiseur. Tenez, des boules quies!', 'Serais-ce un fantome que je vois ???? Oo', 'QuelConserto...PasTresJoli...', 'medium', 20, 8),
(3, 'possible_payload.png', 'Un message serait caché dans l\'affiche de la société. Trouvez le pour qu\'on sache qui a voulu nuire à notre image!', 'Il semblerait que les moyens classiques d\'observation d\'une image ne soient pas la solution...', 'P@yl0ad_c4n_b3_uggly', 'easy', 20, 8),
(4, 'not_secured_connection.pcapng', 'Une personne a essayé de se connecter sur un de nos serveurs ultra secret... Nous avons pu intercepter une trace réseau. Donnez nous son mot de passe.', 'Je me demande quel protocole n\'est pas sécurisé dedans', 'ch4ll_5ucc33d_ftp_n0t_s3cur3', 'easy', 10, 6),
(5, 'les_gaulois.txt', 'Oooooh Marty! Regarde, nous sommes retourné en 200 après JC. Mais qu\'est-ce que ce Gaulois essaye de nous dire ???', 'Raaaaa ces romains ils me rendent fou Marty!', 'W34k_C3s4r_crypt0', 'medium', 20, 3),
(6, 'bombaaaaa.py', 'Chers Consertiens, l\'heure est grave... Un employé a posé une bombe. Nous avons pu récupérer son code source mais l\'équipe de déminage ne comprend rien à la programmation... Vous êtes notre seul espoir (faites vite!)', 'Ces noms de variable je n\'y comprends rien... Wire et LED de *****', 'deQuoiPeterUnCable', 'hard', 30, 5),
(7, 'sources.html', '', 'Tout est dans le titre mon capitaine!', 'H3xad3cim4l_is_us3d_4_l0t', 'easy', 10, 1),
(8, 'lock_picking', 'Le butin de la société a été volé par des ravisseurs. Nous avons retrouvé le coffret mais impossible de le déverouiller...<br>Nous avons besoin de quelqu\'un qui connaisse le crochetage de serrure et on nous a dit que c\'était vous la personne de la situation!<br>Une serrure d\'essai est a votre disposition pour vous entrainer! Bon courage!', 'J\'espère que vous n\'avez pas deux mains gauches !', 'e4sy_l0ck_p1ck1ng', 'medium', 20, 5),
(9, 'cookies.php', 'Votre grand-mère fait la cuisine. Elle a laissé les desserts sans surveillance! <br>\r\nC\'est le moment de s\'en emparer! Devenez l\'admin du dessert ;)', 'Désolé pas cette fois-ci ! ', 'C00ki3s_4re_g00d', 'easy', 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `chall_team_tern`
--

CREATE TABLE `chall_team_tern` (
  `id` int(11) NOT NULL,
  `id_chall` int(11) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `domains`
--

CREATE TABLE `domains` (
  `image_format` varchar(5) NOT NULL DEFAULT 'png',
  `css_style` varchar(20) NOT NULL DEFAULT 'text_secu_domain1',
  `written` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `domains`
--

INSERT INTO `domains` (`image_format`, `css_style`, `written`, `name`, `id`) VALUES
('png', 'text_secu_domain2', 1, 'client web', 1),
('png', 'text_secu_domain1', 0, 'cracking', 2),
('png', 'text_secu_domain2', 1, 'cryptanalyse', 3),
('png', 'text_secu_domain1', 0, 'forensic', 4),
('png', 'text_secu_domain1', 1, 'misc', 5),
('jpg', 'text_secu_domain1', 1, 'reseau', 6),
('png', 'text_secu_domain2', 0, 'serveur web', 7),
('jpg', 'text_secu_domain3', 1, 'steganographie', 8);

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `team`
--

INSERT INTO `team` (`id`, `name`, `score`, `password`) VALUES
(6, 'test', 0, 'test');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `chall`
--
ALTER TABLE `chall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `domain_id` (`domain_id`);

--
-- Index pour la table `chall_team_tern`
--
ALTER TABLE `chall_team_tern`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chall` (`id_chall`),
  ADD KEY `id_team` (`id_team`);

--
-- Index pour la table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `chall`
--
ALTER TABLE `chall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `chall_team_tern`
--
ALTER TABLE `chall_team_tern`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `chall`
--
ALTER TABLE `chall`
  ADD CONSTRAINT `chall_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`);

--
-- Contraintes pour la table `chall_team_tern`
--
ALTER TABLE `chall_team_tern`
  ADD CONSTRAINT `chall_team_tern_ibfk_1` FOREIGN KEY (`id_chall`) REFERENCES `chall` (`id`),
  ADD CONSTRAINT `chall_team_tern_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
