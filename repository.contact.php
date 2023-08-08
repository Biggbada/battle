<?php

function createDb($db)
{
  $db->query(
    'CREATE TABLE `contact` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`prenom` VARCHAR(70) NOT NULL COLLATE `utf8mb4_unicode_ci`,
	`email` VARCHAR(70) NOT NULL COLLATE `utf8mb4_unicode_ci`,
	`nom` VARCHAR(70) NOT NULL COLLATE `utf8mb4_unicode_ci`,
	`message` TEXT NOT NULL COLLATE `utf8mb4_unicode_ci`,
	PRIMARY KEY (`id`) USING BTREE,
	CONSTRAINT `email` CHECK ((`email` like _utf8mb4\`%_@__%.__%\`))
)
COLLATE=`utf8mb4_unicode_ci`
ENGINE=InnoDB
;
'
  );
}
