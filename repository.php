<?php

function createDb($db)
{
    $db->query(
        'CREATE TABLE IF NOT EXISTS `players` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_mana` int NOT NULL ,
  `initial_health` int NOT NULL ,
  `initial_pow` int NOT NULL ,
  PRIMARY KEY (`id`));

CREATE TABLE IF NOT EXISTS `fights` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `battle_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_p1` bigint NOT NULL,
  `id_p2` bigint NOT NULL,
  `id_victory` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_fights_players` (`id_p1`),
  KEY `FK_fights_players_2` (`id_p2`),
  KEY `FK_fights_victory` (`id_victory`),
  CONSTRAINT `FK_fights_players` FOREIGN KEY (`id_p1`) REFERENCES `players` (`id`),
  CONSTRAINT `FK_fights_players_2` FOREIGN KEY (`id_p2`) REFERENCES `players` (`id`),
  CONSTRAINT `FK_fights_victory` FOREIGN KEY (`id_victory`) REFERENCES `players` (`id`),
  CONSTRAINT `CC1` CHECK ((`id_p1` <> `id_p2`)),
  CONSTRAINT `CC2` CHECK ((`id_victory` in (`id_p1`,`id_p2`)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
    );
}
