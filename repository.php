<?php

function createDb($db)
{
    $db->query('CREATE TABLE `players` (
        `playerName` VARCHAR(25) NOT NULL,
        `power` INT NOT NULL,
        `mana` INT NOT NULL,
        `health` INT NOT NULL,
        `comment` VARCHAR(150) NOT NULL DEFAULT ' . ',
    )');
}
