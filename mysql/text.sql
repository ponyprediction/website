-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2015 at 11:23 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ponyprediction`
--

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

CREATE TABLE IF NOT EXISTS `text` (
`id` int(11) NOT NULL,
  `textId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `french` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `text`
--

INSERT INTO `text` (`id`, `textId`, `french`) VALUES
(1, 'home', 'Accueil'),
(2, 'home-h1', 'Bienvenue sur PonyPrediction !'),
(3, 'register', 'Inscription'),
(4, 'log-in', 'Connexion'),
(5, 'log-out', 'Déconnexion '),
(6, 'footer', 'Copyright © 2015 PonyPrediction'),
(7, 'home-p-0', 'Grâce à la puissance des réseaux de neurones alliée aux performances du calcul distribué, les courses hippiques n''auront plus de secret pour vous.'),
(8, 'home-h2-1', 'Calcul distribué ?'),
(9, 'home-p-1', 'Notre architecture unique s''appuie sur la participation de tous pour la réussite de chacun. '),
(10, 'home-neural-network-h2', 'Réseaux de neurones ?'),
(12, 'home-neural-network-p-1', 'Vouloir prévoir le résultats de courses hippique c''est très bien, mais comment procéder ? C''est la première question qu''on s''est posé chez PonyPrediction. Et comme on est plutôt économe de nos moyens, on s''est dit qu''il serait malin de faire travailler l''ordinateur à notre place. Quoi de mieux que les réseaux de neurones pour cela ? Pas grand chose à vrai dire. Mis à part peut-être faire appel aux statisticiens les plus renommés. Mais même eux font appel à des machines. Alors tant qu''à faire, autant se passer des intermédiraires.'),
(13, 'register-h1', 'Je veux m''inscrire !'),
(14, 'register-p-0', 'Pour s''inscrire, c''est très simple : il suffit de remplir tous les champs ci-dessous.'),
(15, 'username', 'Nom d''utilisateur'),
(16, 'password', 'Mot de passe'),
(17, 'confirmation', 'Confirmation'),
(18, 'email', 'Email'),
(19, 'username-empty', 'Vous ne pouvez pas laisser ce champs vide'),
(20, 'email-1-empty', 'Il est nécessaire de renseigner un email'),
(21, 'email-2-empty', 'Vous devez confirmer votre email'),
(22, 'password-1-empty', 'Un mot de passe est nécessaire pour protéger votre compte'),
(23, 'password-2-empty', 'Veuillez confirmer votre mot de passe'),
(24, 'password-different', 'Il semble que les mots de passes sont différents '),
(25, 'email-different', 'Les email sont différents'),
(26, 'email-1-invalid', 'Ceci n''est pas un email valide'),
(27, 'email-2-invalid', 'Cela n''est pas un email valide'),
(28, 'home-neural-network-p-2', 'C''est là qu''interviennent les réseaux des neurones. Comme le nom le suggère, il s''agit de s''inspirer du cerveau humain pour résoudre un problème, mais de manière informatique.'),
(29, 'username-unavailable', 'Ce nom d''utilisateur est déjà utilisé'),
(30, 'email-unavailable', 'Cet email est déjà utilisé'),
(32, 'registration-successful', 'Hourra ! Vous êtes maintenant un utilisateur de PonyPrediction. Enfin presque. Il vous reste juste à confirmer votre compte. Un email vous a été envoyé à cet effet. Soyer sûr de vérifier les spams, on ne sait jamais.'),
(33, 'error', 'Erreur'),
(34, '404', 'Erreur 404 : la page que vous demandez n''existe pas. Tristesse :''('),
(35, 'log-in-h1', 'Je me connecte '),
(36, 'password-empty', 'Il faut un mot de passe pour se connecter'),
(38, 'connection-failed', 'Impossible de se connecter. Peut-être que ce n''est pas le bon mot de passe. Ou alors vous vous êtes trompé d''identifiant.'),
(39, 'just-log-in', 'Bien le bonjour ! Heureux de vous revoir.'),
(40, 'just-log-out', 'Au revoir. Vous nous manquerez...'),
(41, '404-title', 'Erreur 404'),
(42, 'account', 'Compte '),
(43, 'language', 'Langue'),
(44, 'options', 'Options'),
(45, 'predictions', 'Prévisions'),
(46, 'change', 'Modifier'),
(47, 'new-username', 'Nouveau nom d''utilisateur'),
(48, 'new-email', 'Nouvel email'),
(49, 'current-password', 'Mot de passe actuel'),
(50, 'new-password', 'Nouveau mot de passe'),
(51, 'registration-failed', 'Nous n''avons pas réussi à vous enregistrer dans notre base de données. Peut-être qu''en réessayant ça marchera.'),
(52, 'send-email-failed', 'Impossible de vous envoyer l''email de confirmation. Étrange...'),
(53, 'email-confirmation-subject', 'PonyPrediction : validation de compte'),
(55, 'email-confirmation-message', 'Bonjour USERNAME,\r\n\r\nBienvenue chez PonyPrediction !\r\n\r\nPour valider votre email, c''est par là : URLEMAIL\r\n\r\nUne fois que vous aurez validé votre email, vous pourrez vous connecter en allant ici : URLACCOUNT'),
(56, 'confirmation-sucessful', 'Hourra ! Vous êtes officiellement membre de PonyPrediction ! Ça se fête. Et si vous vous connectiez ?'),
(57, 'confirmation-failed', 'Désolé, impossible de confirmer quoi que ce soit. Peut-être que le lien est invalide. Ou bien ce compte a déjà été confirmer. Dernière hypothèse : c''est nous qui sommes mauvais. Dans tous les cas, vous pouvez toujours réessayer plus tard. ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `text`
--
ALTER TABLE `text`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `textId` (`textId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `text`
--
ALTER TABLE `text`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
