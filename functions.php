<?php

function setSession($fighters, $fightID)
{
    $fighters[0] = (array)$fighters[0];
    $fighters[1] = (array)$fighters[1];
    $_SESSION['p1_id'] = $fighters[0]['id'];
    $_SESSION['p1_name'] = $fighters[0]['name'];
    $_SESSION['p1_pow'] = $fighters[0]['initial_pow'];
    $_SESSION['p1_mana'] = $fighters[0]['initial_mana'];
    $_SESSION['p1_health'] = $fighters[0]['initial_health'];
    $_SESSION['p2_id'] = $fighters[1]['id'];
    $_SESSION['p2_name'] = $fighters[1]['name'];
    $_SESSION['p2_pow'] = $fighters[1]['initial_pow'];
    $_SESSION['p2_mana'] = $fighters[1]['initial_mana'];
    $_SESSION['p2_health'] = $fighters[1]['initial_health'];
    $_SESSION['fight_id'] = $fightID;
}

// function getSession(): array
// {
//     $playerOne = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
//     $playerTwo = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']);
// }
function getBestPlayer()
{
    $db = SPDO::getInstance();
    $bestPlayers = $db->prepare('SELECT id_victory, COUNT(id_victory)FROM fights GROUP BY id_victory ORDER BY COUNT(*) DESC');
    dump($bestPlayers);
    $bestPlayers->execute();
    dump($bestPlayers);
    // $bestPlayers->setFetchMode(PDO::FETCH_CLASS, 'Player');
    dump($bestPlayers);
    // $bestPlayers->setFetchMode(PDO::FETCH_CLASS, 'Player');
    // return $bestPlayers->fetch();
}
