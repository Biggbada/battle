<?php

function setSession($fighters, $fightID)
{

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
