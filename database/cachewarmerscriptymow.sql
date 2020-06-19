-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 19 jun 2020 om 07:26
-- Serverversie: 8.0.18
-- PHP-versie: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cachewarmerscriptymow`
--
CREATE DATABASE IF NOT EXISTS `cachewarmerscriptymow` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `cachewarmerscriptymow`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `errors`
--

DROP TABLE IF EXISTS `errors`;
CREATE TABLE IF NOT EXISTS `errors` (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `website_id` bigint(11) UNSIGNED NOT NULL,
  `error` varchar(255) DEFAULT NULL,
  `created_at` varchar(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `frameworks`
--

DROP TABLE IF EXISTS `frameworks`;
CREATE TABLE IF NOT EXISTS `frameworks` (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `frameworks`
--

INSERT INTO `frameworks` (`id`, `name`) VALUES
(1, 'Magento'),
(2, 'Wordpress');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `script_session`
--

DROP TABLE IF EXISTS `script_session`;
CREATE TABLE IF NOT EXISTS `script_session` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `session_url_sitemap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `session_sitemap_url_count` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `website_url_id` bigint(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_url_id` (`website_url_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `script_session_urls`
--

DROP TABLE IF EXISTS `script_session_urls`;
CREATE TABLE IF NOT EXISTS `script_session_urls` (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` bigint(11) UNSIGNED NOT NULL,
  `sitemap_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'MaCr', 'Info@yoeripille.be', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `websites`
--

DROP TABLE IF EXISTS `websites`;
CREATE TABLE IF NOT EXISTS `websites` (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `batch` int(11) UNSIGNED DEFAULT NULL,
  `framework_id` bigint(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `framework_id` (`framework_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `websites`
--

INSERT INTO `websites` (`id`, `name`, `url`, `path`, `batch`, `framework_id`, `active`) VALUES
(1, 'YMOW', 'https://www.yourmindourwork.be', '/sitemap.xml', 15, 0, 1),
(2, 'Me Drive', 'https://medrive.be', '/sitemap_index_nl', 25, 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
