<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './classes/player.class.php';
require './classes/fight.class.php';
require './classes/db.class.php';
require './repository.php';
session_start();

$db = SPDO::getInstance();
dump($_SESSION['log']);
$selectDatas = $db->query('SELECT * FROM players');
$datas = $selectDatas->fetchAll();
$player = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
$adversaire = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']); // $db->query('DROP TABLE players');
if (($player->health) > ($adversaire->health)) {
    $player->comment = $player->name . " est le vainqueur avec " . $player->health . " points de vie et " . $player->mana . " points de mana";
    $adversaire->comment = $adversaire->name . " a perdu le combat...";
    $_SESSION['log'] = ($_SESSION['log'] . " / " . $player->comment . " / " . $adversaire->comment . " / ");
    SPDO::setWinner($_SESSION["p1_id"], $_SESSION['log'], $_SESSION['fight_id']);
}
if (($player->health) < ($adversaire->health)) {
    $player->comment = $player->name . " a perdu le combat...";
    $adversaire->comment = $adversaire->name . " est le vainqueur avec " . $adversaire->health . " points de vie et " . $adversaire->mana . " points de mana";
    $_SESSION['log'] = ($_SESSION['log'] . " / " . $player->comment . " / " . $adversaire->comment . " / ");
    SPDO::setWinner($_SESSION["p2_id"], $_SESSION['log'], $_SESSION['fight_id']);
}
session_destroy();
// // if (($player->health) === ($adversaire->health)) {
// //     $player->comment = "Match nul !";
// //     $adversaire->comment = "Match nul !";
// //     SPDO::setWinner($db, "0", $_SESSION['log'], $_SESSION['fight_id']);
// // }
// $_SESSION['log'] = ($_SESSION['log'] . " / " . $player->comment . " / " . $adversaire->comment . " / "); 
?>

<head>
    <title>Battle</title>
    <link rel="stylesheet" href="public/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <div class="container">
        <audio id="fight-song" src="fight.mp3"></audio>
        <audio id="hadoudken-song" src="Haduken.mp3"></audio>
        <audio id="fatality-song" src="fatality.mp3"></audio>
        <div id="Resultats" class="row center">
            <h1>Résultat</h1>
            <p>
                <?php



                ?>
            </p>
            <div class="col-6 ">
                <div class="position-relative float-end">
                    <img id="player" src="https://api.dicebear.com/6.x/avataaars/svg?accessoriesProbability=0&flip=false&seed=<?= $player->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar float-end" alt="Avatar" class="avatar float-end">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $player->health ?>
                    </span>
                    <ul>
                        <li>Name : <?= $player->name ?></li>
                        <li>Attaque : <?= $player->power ?></li>
                        <li>Mana : <?= $player->mana ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-6" id="adversaire">
                <div class="position-relative float-start">
                    <img src="https://api.dicebear.com/6.x/pixel-art/svg?flip=true&seed=<?= $adversaire->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar">
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                        <?= $adversaire->health ?>
                    </span>
                    <ul>
                        <li>Name : <?= $adversaire->name ?></li>
                        <li>Attaque : <?= $adversaire->power ?></li>
                        <li>Mana : <?= $adversaire->mana ?></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <form class="d-flex justify-content-center" action="./index.php" method="post">
                    <input name="restart" type="submit" value="Nouveau combat">
                </form>
            </div>
        </div>
        <div id="combats">
            <h2>Combat</h2>
            <ul>
                <li><i class="fa-solid fa-khanda p-1"><?= $player->comment ?></i></li>
                <li><i class="fa-solid fa-khanda p-1"><?= $adversaire->comment ?></i></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <h2>Voir les stats</h2>
        <form action="./charts.php" method="post">
            <input type="submit" value="charts" act>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let submitRestart = document.querySelector("#restart");
            let alreadyPlaySongRestart = false;
            if (submitRestart) {
                submitRestart.addEventListener("click", function(event) {
                    if (alreadyPlaySongRestart)
                        return true;
                    event.preventDefault();
                    let fatality_song = document.getElementById("fatality-song");
                    fatality_song.play();
                    alreadyPlaySongRestart = true;
                    setTimeout(function() {
                        submitRestart.click();
                    }, 2000);
                })
            }
        })
    </script>
</body>