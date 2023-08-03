-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour battlev2
CREATE DATABASE IF NOT EXISTS `battlev2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `battlev2`;

-- Listage de la structure de table battlev2. fights
CREATE TABLE IF NOT EXISTS `fights` (
  `id-battle` bigint NOT NULL AUTO_INCREMENT,
  `battle_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_p1` bigint NOT NULL,
  `id_p2` bigint NOT NULL,
  `id_victory` bigint DEFAULT NULL,
  PRIMARY KEY (`id-battle`),
  KEY `FK_fights_players` (`id_p1`),
  KEY `FK_fights_players_2` (`id_p2`),
  KEY `FK_fights_players_3` (`id_victory`),
  CONSTRAINT `FK_fights_players` FOREIGN KEY (`id_p1`) REFERENCES `players` (`id`),
  CONSTRAINT `FK_fights_players_2` FOREIGN KEY (`id_p2`) REFERENCES `players` (`id`),
  CONSTRAINT `FK_fights_players_3` FOREIGN KEY (`id_victory`) REFERENCES `players` (`id`),
  CONSTRAINT `CC1` CHECK ((`id_p1` <> `id_p2`)),
  CONSTRAINT `CC2` CHECK ((`id_victory` in (`id_p1`,`id_p2`)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table battlev2. players
CREATE TABLE IF NOT EXISTS `players` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `initial_mana` int NOT NULL DEFAULT '0',
  `initial_health` int NOT NULL DEFAULT '0',
  `initial_pow` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Les données exportées n'étaient pas sélectionnées.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
