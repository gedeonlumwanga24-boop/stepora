-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql200.byetcluster.com
-- Généré le :  ven. 27 fév. 2026 à 05:23
-- Version du serveur :  11.4.10-MariaDB
-- Version de PHP :  7.2.22
USE projet_boutique;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `if0_41126945_stepora`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `session_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `email`, `password`, `created_at`, `last_login`, `session_end`) VALUES
(1, 'KALUGE', 'gedeonlumwanga24@gmail.com', '$2y$10$aHn.vUf5UoKSfZuDnDorR.YP.RtnG8IvE6atVxcguKJkzAeGF5WYe', '2026-02-02 10:16:50', '2026-02-25 14:40:54', '2026-02-23 09:24:17'),
(2, 'GEDEON', 'gedeonlumwanga@gmail.com', '$2y$10$muPsU9ZV5hH6XUQdFYPc/uAtg6GlyJ77SU4fGBJArnZwDY0ZHYhz.', '2026-02-02 14:02:21', '2026-02-08 23:22:48', '2026-02-09 01:09:55');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `email`, `mot_de_passe`, `created_at`) VALUES
(1, 'kaluge', 'gedeonlumwanga24@gmail.com', '$2y$10$4BILa1Nv1DWiGcKhqprZeerkRVw4dC/psMEGjBzxglspqNpcrpzj6', '2026-01-28 08:16:20'),
(2, 'RAYAN', 'rayan@gmail.com', '$2y$10$SjyGHCMy2Nmw6nEVB6Fjy.8Fb/73nQrjmjSkC.u1fmJGSuxAX9t0K', '2026-01-28 10:06:32'),
(15, 'Justin', 'just@gmail.com', '$2y$10$XMV3nqOou4m4tNjMKHsXs.cSBVeiHSCN2x0Z2QX4to3IPagCcIisy', '2026-02-11 12:13:09'),
(17, 'Joshua', 'joshua@gmail.com', '$2y$10$ZMtq4MlhZewMLEWnod498uHkNcfA3IHk5yAMxqikM3PYYj1O92WLm', '2026-02-11 14:28:07'),
(18, 'kaluge', 'kaluge@gmail.com', '$2y$10$BP7KVWcMitYkXP9NDMNJS.i61RTXTX2MtFcd5Z7fmLRVNSi7VcXK.', '2026-02-11 20:21:38');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  `statut` enum('en attente','validée','livrée') NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `email`, `prenom`, `nom`, `adresse`, `code_postal`, `ville`, `telephone`, `total`, `date_commande`, `statut`) VALUES
(3, 'gedeonlumwanga24@gmail.com', 'gedeon', 'kaluge', 'lubumbashi', '3333', 'LUSHI', '0970297987', '245000.00', '2026-02-02 09:40:23', 'livrée'),
(4, 'kaluge@gmail.com', 'KALUGE', 'kaluge', 'lubumbashi', '3333', 'LUSHI', '0970297987', '30000.00', '2026-02-02 10:13:39', 'validée'),
(5, 'kaluge@gmail.com', 'KALUGE', 'kaluge', 'lubumbashi', '3333', 'LUSHI', '0970297987', '25000.00', '2026-02-02 10:21:29', 'livrée'),
(6, 'kaluge24@gmail.com', 'GEDEON', 'KALUGE', 'Lush, commune: lushi, Qt: Craa, Av: police, N° 5', '12345', 'Lubumbashi', '+243 970297987', '110000.00', '2026-02-02 19:01:14', 'en attente'),
(7, 'gedeonlumwanga24@gmail.com', 'GEDEON', 'GEDEON', 'LUSHI, CRAA', '22222', 'LUSHI', '0970297987', '70000.00', '2026-02-02 19:51:05', 'validée'),
(9, 'gedeonlumwanga24@gmail.com', 'Gedeon', 'Lumwanga', 'ghghgh', '22222', 'LUSHI', '0970297987', '60000.00', '2026-02-06 11:51:22', 'livrée'),
(10, 'kaluge@gmail.com', 'KALUGE', 'kaluge', 'lubumbashi', '3333', 'LUSHI', '0970297987', '305000.00', '2026-02-06 22:45:12', 'en attente'),
(11, 'kaluge@gmail.com', 'KALUGE', 'kaluge', 'lubumbashi', '3333', 'LUSHI', '0970297987', '330000.00', '2026-02-06 22:48:39', 'en attente'),
(12, 'gedeonlumwanga24@gmail.com', 'Gedeon', 'Lumwanga', 'ghghgh', '22222', 'LUSHI', '0970297987', '80000.00', '2026-02-07 15:47:46', 'livrée'),
(15, 'kaluge@gmail.com', 'KALUGE', 'kaluge', 'lubumbashi', '245', 'LUBUMBASHI', '0970297987', '80000.00', '2026-02-10 00:01:21', 'en attente'),
(16, 'jeefnkutwa1@gmail.com', 'JEEF', 'NKUTWA', 'RWASHI', '44444', 'LUBUMBASHI', '0984761209', '40000.00', '2026-02-10 10:34:31', 'en attente'),
(17, 'gedeonlumwanga24@gmail.com', 'Gedeon', 'Lumwanga', 'Craa, av: la police, N°11', '12345', 'Lubumbashi ', '0970297987', '60000.00', '2026-02-11 10:48:14', 'en attente'),
(18, 'gedeonlumwanga24@gmail.com', 'gedeon', 'kaluge', 'lubumbashi', '245', 'LUBUMBASHI', '0970297987', '110000.00', '2026-02-11 12:16:10', 'en attente'),
(19, 'gedeonlumwanga24@gmail.com', 'gedeon', 'kaluge', 'lubumbashi', '245', 'LUBUMBASHI', '0970297987', '70000.00', '2026-02-11 12:20:00', 'en attente'),
(20, 'graciaskapela545@gmail.com', 'Gracias', 'Kapela', 'Av 23 douane ', '123', 'Lushi ', '0992515000', '50000.00', '2026-02-11 23:08:38', 'en attente'),
(21, 'elvinkyungu.75@gmail.com', 'Elvin', 'Kyungu', 'Lubumbashi, commune annexe, Quartier Kalebuka, Rue Kolwezi 13.', '75001', 'Lubumbashi, Katanga', '0846899101', '60000.00', '2026-02-11 23:57:13', 'en attente'),
(22, 'gedeonlumwanga24@gmail.com', 'Gedeon', 'Lumwanga', 'Craa, av: la police, N°11', '12345', 'Lubumbashi', '0970297987', '140000.00', '2026-02-19 06:45:45', 'livrée'),
(23, 'gedeonlumwanga24@gmail.com', 'gedeon', 'kaluge', 'lubumbashi', '245', 'LUBUMBASHI', '0970297987', '120000.00', '2026-02-23 09:23:47', 'livrée');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produits`
--

CREATE TABLE `commande_produits` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `nom_produit` varchar(255) DEFAULT NULL,
  `taille` varchar(50) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `commande_id`, `nom_produit`, `taille`, `quantite`, `prix`, `image`) VALUES
(3, 3, 'nocta blanche', '40', 1, '30000.00', '1769622717_W NIKE SHOX TL(1).png'),
(4, 3, 'air max', '40', 1, '25000.00', '1769594524_NIKE AIR MAX 90(3).png'),
(5, 3, 'AIR JORDAN 1', '40', 1, '70000.00', '1769554916_AIR JORDAN 1 MID(1).png'),
(6, 3, 'nocta blanche', '39', 1, '20000.00', '1769554535_nocta-blanche.jpg'),
(7, 3, 'AIR JORDAN 1 MID SE.png', '41', 1, '40000.00', '1769554095_AIR JORDAN 1 MID SE.png'),
(8, 3, 'nocta blanche', '41', 2, '30000.00', '1769622717_W NIKE SHOX TL(1).png'),
(9, 4, 'nocta blanche', '40', 1, '30000.00', '1769622717_W NIKE SHOX TL(1).png'),
(10, 5, 'air max', '40', 1, '25000.00', '1769594524_NIKE AIR MAX 90(3).png'),
(11, 6, 'AIR FORCE ONE  LV', '40', 1, '70000.00', '1770032522_AIR_FORCE_1__07_LV8.png'),
(12, 6, 'AIR JORDAN 1 MID SE.png', '40', 1, '40000.00', '1769554095_AIR JORDAN 1 MID SE.png'),
(13, 7, 'AIR FORCE ONE  LV', '40', 1, '70000.00', '1770032522_AIR_FORCE_1__07_LV8.png'),
(16, 9, 'NIKE AIR MAX 95', '40', 1, '60000.00', '1770103070_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png'),
(17, 10, 'NIKE AIR MAX 95', '40', 1, '60000.00', '1770103070_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png'),
(18, 10, 'AIR JORDAN 1 LOW', '40', 1, '40000.00', '1770297691_AIR_JORDAN_1_LOW_SE.png'),
(19, 10, 'AIR FORCE ONE  BLANCHE', '41', 1, '50000.00', '1770058402_AIR_FORCE_1__07_FLYEASE_4_.png'),
(20, 10, 'AIR FORCE ONE  LV', '41', 1, '70000.00', '1770032522_AIR_FORCE_1__07_LV8.png'),
(21, 10, 'air max', '40', 1, '25000.00', '1769594524_NIKE AIR MAX 90(3).png'),
(22, 10, 'NIKE AIR MAX 95', '40', 1, '60000.00', '1770103070_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png'),
(23, 11, 'NIKE AIR MAX 95', '42', 1, '60000.00', '1770103070_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png'),
(24, 11, 'AIR JORDAN 1 LOW', '42', 1, '40000.00', '1770297691_AIR_JORDAN_1_LOW_SE.png'),
(25, 11, 'AIR FORCE ONE  BLANCHE', '41', 1, '50000.00', '1770058402_AIR_FORCE_1__07_FLYEASE_4_.png'),
(26, 11, 'JORDAN 4 RETRO', '41', 1, '40000.00', '1769553090_AIR FORCE 1 \'07.png'),
(27, 11, 'JORDAN 4 RETRO', '42', 1, '40000.00', '1769552645_AIR JORDAN 4 RETRO OG FC(0).png'),
(28, 11, 'AIR JORDAN 1 MID SE.png', '42', 1, '40000.00', '1769554095_AIR JORDAN 1 MID SE.png'),
(29, 11, 'NIKE AIR MAX 95', '42', 1, '60000.00', '1770103070_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png'),
(30, 12, 'AIR JORDAN 1 MID SE.png', '40', 1, '40000.00', '1769554095_AIR JORDAN 1 MID SE.png'),
(31, 12, 'AIR JORDAN 1 LOW', '40', 1, '40000.00', '1770297691_AIR_JORDAN_1_LOW_SE.png'),
(34, 15, 'W NIKE SHOX TL', '40', 1, '80000.00', '1770585477_W_NIKE_SHOX_TL.png'),
(35, 16, 'AIR JORDAN 4', '42', 1, '40000.00', '1770540593_AIR_JORDAN_4_RETRO_OG_FC.png'),
(36, 17, 'AIR FORCE ONE  LV BLC', '40', 1, '60000.00', '1770584860_NIKE_AIR_FORCE_1__07_LV8_7_.png'),
(37, 18, 'AIR JORDAN 4 RM', '40', 1, '50000.00', '1770548242_AIR_JORDAN_4_RM__GS__11_.png'),
(38, 18, 'AIR FORCE ONE  LV BLC', '41', 1, '60000.00', '1770584860_NIKE_AIR_FORCE_1__07_LV8_7_.png'),
(39, 19, 'AIR MAX 95 BIG BUBBLE ZIP', '40', 1, '70000.00', '1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP.png'),
(40, 20, 'AIR MAX PLUS', '42', 1, '50000.00', '1770548543_AIR_MAX_PLUS_1_.png'),
(41, 21, 'AIR FORCE ONE  LV BLC', '43', 1, '60000.00', '1770584860_NIKE_AIR_FORCE_1__07_LV8_7_.png'),
(42, 22, 'AIR FORCE 1  LV', '40', 1, '60000.00', '1770584681_NIKE_AIR_FORCE_1__07_LV8_0_.png'),
(43, 22, 'W NIKE SHOX TL', '40', 1, '80000.00', '1770585477_W_NIKE_SHOX_TL.png'),
(44, 23, 'W NIKE SHOX TL', '40', 1, '80000.00', '1770585477_W_NIKE_SHOX_TL.png'),
(45, 23, 'AIR FORCE ONE', '40', 1, '40000.00', '1770548094_AIR_FORCE_1_LV8_1__GS_.png');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sujet` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `ip_client` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `nom`, `email`, `sujet`, `message`, `ip_client`, `created_at`) VALUES
(1, 'RAYAN', 'rayan@gmail.com', 'Commande', 'comment pour ma commande', '::1', '2026-01-28 10:08:08'),
(2, 'KALUGE', 'gedeon@gmail.com', 'Livraison', 'la position de ma commande', '::1', '2026-01-28 17:56:38'),
(4, 'kaluge', 'gedeonlumwanga24@gmail.com', 'Commande', 'Bonjour c\'est moi votre client j\'ai besoin de me renseigné sur ma commande que j\'ai passer il y a trois jours quelle est la position ?', '::1', '2026-02-04 12:27:19'),
(5, 'kaluge', 'gedeonlumwanga24@gmail.com', 'Commande', 'Bonjour c\'est moi votre client j\'ai besoin de me renseigné sur ma commande que j\'ai passer il y a trois jours quelle est la position ?', '::1', '2026-02-04 12:37:24'),
(6, 'kaluge', 'gedeonlumwanga24@gmail.com', 'Commande', 'La posision de ma commande', '::1', '2026-02-05 12:12:31'),
(7, 'kaluge', 'gedeonlumwanga24@gmail.com', 'Livraison', 'Bonjour Mr juste pour me renseigné sur votre mode de livraison et des régions que vous livrés', '::1', '2026-02-07 20:28:10'),
(8, 'Gédéon lumwanga', 'gedeonlumwanga24@gmail.com', 'Paiement', 'C\'est carré ?', '41.77.221.227', '2026-02-11 13:15:26'),
(9, 'kaluge', 'gedeonlumwanga24@gmail.com', 'Livraison', 'Bonjour Mr comment vous livré les commandes à lubumbashi', '41.77.221.169', '2026-02-11 20:17:21');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image_principale` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `tailles` varchar(50) DEFAULT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `image_principale`, `images`, `tailles`, `categorie`, `created_at`) VALUES
(23, 'AIR FORCE 1 GTX VIBRAM', 'Discret polyvalent', '40000.00', '1770539042_AIR_FORCE_1_GTX_VIBRAM.png', '1770539042_AIR_FORCE_1_GTX_VIBRAM.png,1770539042_AIR_FORCE_1_GTX_VIBRAM_0_.png,1770539042_AIR_FORCE_1_GTX_VIBRAM_1_.png,1770539042_AIR_FORCE_1_GTX_VIBRAM_2_.png,1770539042_AIR_FORCE_1_GTX_VIBRAM_3_.png,1770539042_AIR_FORCE_1_GTX_VIBRAM.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 08:24:02'),
(24, 'AIR FORCE ONE  O7', 'discret passe partout', '45000.00', '1770539368_AIR_FORCE_1__07.png', '1770539368_AIR_FORCE_1__07.png,1770539368_AIR_FORCE_1__07_0_.png,1770539368_AIR_FORCE_1__07_1_.png,1770539368_AIR_FORCE_1__07_2_.png,1770539368_AIR_FORCE_1__07_3_.png,1770539368_AIR_FORCE_1__07_4_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 08:29:28'),
(25, 'AIR FORCE ONE  LOW JS', 'classique', '50000.00', '1770539553_AIR_FORCE_1_LOW_JS__GS__3_.png', '1770539553_AIR_FORCE_1_LOW_JS__GS__3_.png,1770539553_AIR_FORCE_1_LOW_JS__GS__0_.png,1770539553_AIR_FORCE_1_LOW_JS__GS__1_.png,1770539553_AIR_FORCE_1_LOW_JS__GS__2_.png,1770539553_AIR_FORCE_1_LOW_JS__GS__4_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 08:32:33'),
(27, 'AIR FORCE 1 GS', 'Diversifié', '45000.00', '1770540038_NIKE_AIR_FORCE_1_GS.png', '1770540038_NIKE_AIR_FORCE_1_GS.png,1770540038_NIKE_AIR_FORCE_1_GS_0_.png,1770540038_NIKE_AIR_FORCE_1_GS_2_.png,1770540038_NIKE_AIR_FORCE_1_GS_3_.png,1770540038_NIKE_AIR_FORCE_1_GS_4_.png,1770540038_NIKE_AIR_FORCE_1_GS_5_.png,1770540038_NIKE_AIR_FORCE_1_GS_6_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 08:40:38'),
(28, 'JORDAN SPIZIKE LOW', 'Lourd', '60000.00', '1770540226_JORDAN_SPIZIKE_LOW_GS.png', '1770540226_JORDAN_SPIZIKE_LOW_GS.png,1770540226_JORDAN_SPIZIKE_LOW_GS_0_.png,1770540226_JORDAN_SPIZIKE_LOW_GS_1_.png,1770540226_JORDAN_SPIZIKE_LOW_GS_2_.png,1770540226_JORDAN_SPIZIKE_LOW_GS_3_.png,1770540226_JORDAN_SPIZIKE_LOW_GS_4_.png,1770540226_JORDAN_SPIZIKE_LOW_GS_5_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 08:43:46'),
(29, 'AIR JORDAN 4', 'Marquant', '45000.00', '1770540376_JORDAN_SPIZIKE_LOW_3_.png', '1770540376_JORDAN_SPIZIKE_LOW_3_.png,1770540376_JORDAN_SPIZIKE_LOW_0_.png,1770540376_JORDAN_SPIZIKE_LOW_1_.png,1770540376_JORDAN_SPIZIKE_LOW_2_.png,1770540376_JORDAN_SPIZIKE_LOW_4_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 08:46:16'),
(30, 'AIR JORDAN 4', 'Marquant', '40000.00', '1770540593_AIR_JORDAN_4_RETRO_OG_FC.png', '1770540593_AIR_JORDAN_4_RETRO_OG_FC.png,1770540593_AIR_JORDAN_4_RETRO_OG_FC_0_.png,1770540593_AIR_JORDAN_4_RETRO_OG_FC_1_.png,1770540593_AIR_JORDAN_4_RETRO_OG_FC.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 08:49:53'),
(31, 'AIR JORDAN 1 LOW', 'Intempérant', '60000.00', '1770540747_AIR_JORDAN_1_MID_SE.png', '1770540747_AIR_JORDAN_1_MID_SE.png,1770540747_AIR_JORDAN_1_MID_SE_0_.png,1770540747_AIR_JORDAN_1_MID_SE_1_.png,1770540747_AIR_JORDAN_1_MID_SE.png', '38,39,40,41,42,43,44', '', '2026-02-08 08:52:27'),
(32, 'NIKE DUNK LOW RETRO', 'Discrétion classique', '60000.00', '1770540992_NIKE_DUNK_LOW_RETRO_PRM.png', '1770540992_NIKE_DUNK_LOW_RETRO_PRM.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_0_.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_2_.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_3_.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_4_.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_5_.png,1770540992_NIKE_DUNK_LOW_RETRO_PRM_6_.png', '38,39,40,41,42,43,44', 'Sneakers', '2026-02-08 08:56:32'),
(33, 'NIKE COURT VISION LO P', 'Lifestyle', '60000.00', '1770541194_NIKE_COURT_VISION_LO_P_NB_7_.png', '1770541194_NIKE_COURT_VISION_LO_P_NB_7_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_8_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_10_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_11_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_12_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_13_.png,1770541194_NIKE_COURT_VISION_LO_P_NB_14_.png', '38,39,40,41,42,43,44', 'Sneakers-Lifestyle', '2026-02-08 08:59:54'),
(34, 'NIKE COURT VISION LO P', 'Lifestyle', '60000.00', '1770541436_NIKE_COURT_VISION_LO_P_NB_3_.png', '1770541436_NIKE_COURT_VISION_LO_P_NB_3_.png,1770541436_NIKE_COURT_VISION_LO_P_NB_1_.png,1770541436_NIKE_COURT_VISION_LO_P_NB_2_.png,1770541436_NIKE_COURT_VISION_LO_P_NB_4_.png,1770541436_NIKE_COURT_VISION_LO_P_NB_5_.png,1770541436_NIKE_COURT_VISION_LO_P_NB_6_.png', '38,39,40,41,42,43,44', 'Sneakers-Lifestyle', '2026-02-08 09:03:56'),
(35, 'AIR JORDAN 4 SPIZIKE', 'légende urbaine', '450000.00', '1770541613_JORDAN_SPIZIKE_LOW.png', '1770541613_JORDAN_SPIZIKE_LOW.png,1770541613_JORDAN_SPIZIKE_LOW_0_.png,1770541613_JORDAN_SPIZIKE_LOW_1_.png,1770541613_JORDAN_SPIZIKE_LOW_2_.png,1770541613_JORDAN_SPIZIKE_LOW_3_.png,1770541613_JORDAN_SPIZIKE_LOW_4_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 09:06:53'),
(36, 'NIKE DUNK LOW BW', 'Intemporel', '50000.00', '1770541807_NIKE_DUNK_LOW_RETRO.png', '1770541807_NIKE_DUNK_LOW_RETRO.png,1770541807_NIKE_DUNK_LOW_RETRO_1_.png,1770541807_NIKE_DUNK_LOW_RETRO_2_.png,1770541807_NIKE_DUNK_LOW_RETRO_3_.png,1770541807_NIKE_DUNK_LOW_RETRO_4_.png', '38,39,40,41,42,43,44', 'Sneakers', '2026-02-08 09:10:07'),
(37, 'NIKE AIR MAX 90', 'Infiltrer', '55000.00', '1770541989_NIKE_AIR_MAX_90.png', '1770541989_NIKE_AIR_MAX_90.png,1770541989_NIKE_AIR_MAX_90_0_.png,1770541989_NIKE_AIR_MAX_90_1_.png,1770541989_NIKE_AIR_MAX_90_2_.png,1770541989_NIKE_AIR_MAX_90_3_.png,1770541989_NIKE_AIR_MAX_90_4_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 09:13:09'),
(38, 'NIKE AIR MAX 95 BIG BUBBLE', 'Identité', '70000.00', '1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE.png', '1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_0_.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_1_.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_2_.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_3_.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_4_.png,1770542167_NIKE_AIR_MAX_95_BIG_BUBBLE_5_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 09:16:07'),
(39, 'NIKE SHOX TL GRIS', 'Imposante', '80000.00', '1770542343_NIKE_SHOX_TL_3_.png', '1770542343_NIKE_SHOX_TL_3_.png,1770542343_NIKE_SHOX_TL_4_.png,1770542343_NIKE_SHOX_TL_5_.png,1770542343_NIKE_SHOX_TL_6_.png,1770542343_NIKE_SHOX_TL_7_.png,1770542343_NIKE_SHOX_TL_8_.png,1770542343_NIKE_SHOX_TL_9_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 09:19:03'),
(40, 'NIKE SHOX TL NOIRE', 'Imposante', '80000.00', '1770542472_NIKE_SHOX_TL_2_.png', '1770542472_NIKE_SHOX_TL_2_.png,1770542472_NIKE_SHOX_TL_0_.png,1770542472_NIKE_SHOX_TL_1_.png,1770542472_NIKE_SHOX_TL_2_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 09:21:12'),
(41, 'AIR MAX 95 BIG BUBBLE ZIP', 'Big zip', '70000.00', '1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP.png', '1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP.png,1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_0_.png,1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_1_.png,1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_2_.png,1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_3_.png,1770542870_AIR_MAX_95_BIG_BUBBLE_ZIP_SP_4_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 09:27:50'),
(42, 'AIR FORCE ONE  LV', 'collaboration', '40000.00', '1770547928_AIR_FORCE_1__07_LV8.png', '1770547928_AIR_FORCE_1__07_LV8.png,1770547928_AIR_FORCE_1__07_LV8_0_.png,1770547928_AIR_FORCE_1__07_LV8_1_.png,1770547928_AIR_FORCE_1__07_LV8_2_.png,1770547928_AIR_FORCE_1__07_LV8_3_.png,1770547928_AIR_FORCE_1__07_LV8_4_.png,1770547928_AIR_FORCE_1__07_LV8_5_.png,1770547928_AIR_FORCE_1__07_LV8_6_.png', '38,39,40,41,42,43,44', 'Sneakers-Lifestyle', '2026-02-08 10:52:08'),
(43, 'AIR FORCE ONE', 'Collaboration', '40000.00', '1770548094_AIR_FORCE_1_LV8_1__GS_.png', '1770548094_AIR_FORCE_1_LV8_1__GS_.png,1770548094_AIR_FORCE_1_LV8_1__GS__0_.png,1770548094_AIR_FORCE_1_LV8_1__GS__1_.png,1770548094_AIR_FORCE_1_LV8_1__GS__2_.png,1770548094_AIR_FORCE_1_LV8_1__GS__3_.png,1770548094_AIR_FORCE_1_LV8_1__GS__4_.png,1770548094_AIR_FORCE_1_LV8_1__GS__5_.png,1770548094_AIR_FORCE_1_LV8_1__GS__6_.png', '38,39,40,41,42,43,44', 'Sneakers-Lifestyle', '2026-02-08 10:54:54'),
(44, 'AIR JORDAN 4 RM', 'RM', '50000.00', '1770548242_AIR_JORDAN_4_RM__GS__11_.png', '1770548242_AIR_JORDAN_4_RM__GS__11_.png,1770548242_AIR_JORDAN_4_RM__GS__1_.png,1770548242_AIR_JORDAN_4_RM__GS__2_.png,1770548242_AIR_JORDAN_4_RM__GS__4_.png,1770548242_AIR_JORDAN_4_RM__GS__5_.png,1770548242_AIR_JORDAN_4_RM__GS__9_.png,1770548242_AIR_JORDAN_4_RM__GS__10_.png,1770548242_AIR_JORDAN_4_RM__GS__12_.png,1770548242_AIR_JORDAN_4_RM__GS__13_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 10:57:22'),
(45, 'AIR JORDAN 4', 'Jordan', '50000.00', '1770548418_AIR_JORDAN_4_RM_3_.png', '1770548418_AIR_JORDAN_4_RM_3_.png,1770548418_AIR_JORDAN_4_RM_0_.png,1770548418_AIR_JORDAN_4_RM_1_.png,1770548418_AIR_JORDAN_4_RM_2_.png,1770548418_AIR_JORDAN_4_RM_4_.png,1770548418_AIR_JORDAN_4_RM_5_.png,1770548418_AIR_JORDAN_4_RM_6_.png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 11:00:18'),
(46, 'AIR MAX PLUS', '', '50000.00', '1770548543_AIR_MAX_PLUS_1_.png', '1770548543_AIR_MAX_PLUS_1_.png,1770548543_AIR_MAX_PLUS_0_.png,1770548543_AIR_MAX_PLUS_1_.png,1770548543_AIR_MAX_PLUS_2_.png,1770548543_AIR_MAX_PLUS_3_.png,1770548543_AIR_MAX_PLUS_4_.png,1770548543_AIR_MAX_PLUS.png', '38,39,40,41,42,43,44', 'Sneakers', '2026-02-08 11:02:23'),
(47, 'NIKE DUNK LOW', 'Dunk', '40000.00', '1770548667_NIKE_DUNK_LOW.png', '1770548667_NIKE_DUNK_LOW.png,1770548667_NIKE_DUNK_LOW_1_.png,1770548667_NIKE_DUNK_LOW_2_.png,1770548667_NIKE_DUNK_LOW_3_.png,1770548667_NIKE_DUNK_LOW_4_.png,1770548667_NIKE_DUNK_LOW_5_.png,1770548667_NIKE_DUNK_LOW_6_.png,1770548667_NIKE_DUNK_LOW_7_.png', '38,39,40,41,42,43,44', 'Sneakers', '2026-02-08 11:04:27'),
(49, 'AIR FORCE ONE  BLANCHE', 'légende classique', '45000.00', '1770583817_AIR_FORCE_1__07_FLYEASE.png', '1770583817_AIR_FORCE_1__07_FLYEASE.png,1770583817_AIR_FORCE_1__07_FLYEASE_1_.png,1770583817_AIR_FORCE_1__07_FLYEASE_3_.png,1770583817_AIR_FORCE_1__07_FLYEASE_4_.png,1770583817_AIR_FORCE_1__07_FLYEASE_5_.png,1770583817_AIR_FORCE_1__07_FLYEASE_6_.png,1770583817_AIR_FORCE_1__07_FLYEASE_7_.png,1770584331_AIR FORCE 1 \'07 FLYEASE(0).png', '38,39,40,41,42,43,44', 'baskets', '2026-02-08 20:50:17'),
(50, 'NIKE SHOX TL BLANC', 'TL', '70000.00', '1770584040_W_NIKE_SHOX_TL_7_.png', '1770584040_W_NIKE_SHOX_TL_7_.png,1770584040_W_NIKE_SHOX_TL_8_.png,1770584040_W_NIKE_SHOX_TL_9_.png,1770584040_W_NIKE_SHOX_TL_10_.png,1770584040_W_NIKE_SHOX_TL_11_.png,1770584040_W_NIKE_SHOX_TL_12_.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 20:54:00'),
(51, 'AIR FORCE 1  LV', 'Collaboration', '60000.00', '1770584681_NIKE_AIR_FORCE_1__07_LV8_0_.png', '1770584681_NIKE_AIR_FORCE_1__07_LV8_0_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_1_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_2_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_3_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_4_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_5_.png,1770584681_NIKE_AIR_FORCE_1__07_LV8_6_.png', '38,39,40,41,42,43,44', 'Sneakers-Lifestyle', '2026-02-08 21:04:41'),
(52, 'AIR FORCE ONE  LV BLC', 'Collaboration', '60000.00', '1770584860_NIKE_AIR_FORCE_1__07_LV8_7_.png', '1770584860_NIKE_AIR_FORCE_1__07_LV8_7_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_8_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_9_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_10_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_11_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_12_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_13_.png,1770584860_NIKE_AIR_FORCE_1__07_LV8_14_.png', '38,39,40,41,42,43,44', 'Sneakers', '2026-02-08 21:07:40'),
(53, 'W NIKE SHOX TL', 'TL', '80000.00', '1770585477_W_NIKE_SHOX_TL.png', '1770585477_W_NIKE_SHOX_TL.png,1770585477_W_NIKE_SHOX_TL_0_.png,1770585477_W_NIKE_SHOX_TL_3_.png,1770585477_W_NIKE_SHOX_TL_4_.png,1770585477_W_NIKE_SHOX_TL_5_.png,1770585477_W_NIKE_SHOX_TL_12_.png,1770585477_W_NIKE_SHOX_TL.png', '38,39,40,41,42,43,44', 'Baskets urbaines', '2026-02-08 21:17:57');

-- --------------------------------------------------------

--
-- Structure de la table `produit_images`
--

CREATE TABLE `produit_images` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_tailles`
--

CREATE TABLE `produit_tailles` (
  `produit_id` int(11) NOT NULL,
  `taille_id` int(11) NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tailles`
--

CREATE TABLE `tailles` (
  `id` int(11) NOT NULL,
  `valeur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tailles`
--

INSERT INTO `tailles` (`id`, `valeur`) VALUES
(1, '38'),
(2, '39'),
(3, '40'),
(4, '41'),
(5, '42'),
(6, '43'),
(7, '44');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit_images`
--
ALTER TABLE `produit_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produit_tailles`
--
ALTER TABLE `produit_tailles`
  ADD PRIMARY KEY (`produit_id`,`taille_id`),
  ADD KEY `taille_id` (`taille_id`);

--
-- Index pour la table `tailles`
--
ALTER TABLE `tailles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `produit_images`
--
ALTER TABLE `produit_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tailles`
--
ALTER TABLE `tailles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit_images`
--
ALTER TABLE `produit_images`
  ADD CONSTRAINT `produit_images_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit_tailles`
--
ALTER TABLE `produit_tailles`
  ADD CONSTRAINT `produit_tailles_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produit_tailles_ibfk_2` FOREIGN KEY (`taille_id`) REFERENCES `tailles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
