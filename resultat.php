<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './classes/player.class.php';
require './classes/db.class.php';

$db = SPDO::getInstance();
$selectDatas = $db->query('SELECT * FROM players');
$datas = $selectDatas->fetchAll();
$playerOne = new Player($datas[0]['playerName'], $datas[0]['power'], $datas[0]['mana'], $datas[0]['health'], $datas[0]['comment']);
$playerTwo = new Player($datas[1]['playerName'], $datas[1]['power'], $datas[1]['mana'], $datas[1]['health'], $datas[1]['comment']);
$db->query('DROP TABLE players');

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
                if (($playerOne->health) > ($playerTwo->health)) {
                    echo "$playerOne->name est le vainqueur";
                }
                if (($playerOne->health) < ($playerTwo->health)) {
                    echo "$playerTwo->name est le vainqueur";
                }
                if (($playerOne->health) === ($playerTwo->health)) {
                    echo "Match nul !!!";
                }
                ?>
            </p>
            <div class="col-6 ">
                <div class="position-relative float-end">
                    <img id="player" src="https://api.dicebear.com/6.x/avataaars/svg?accessoriesProbability=0&flip=false&seed=<?= $playerOne->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar float-end" alt="Avatar" class="avatar float-end">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $playerOne->health ?>
                    </span>
                    <ul>
                        <li>Name : <?= $playerOne->name ?></li>
                        <li>Attaque : <?= $playerOne->power ?></li>
                        <li>Mana : <?= $playerOne->mana ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-6" id="adversaire">
                <div class="position-relative float-start">
                    <img src="https://api.dicebear.com/6.x/pixel-art/svg?flip=true&seed=<?= $playerTwo->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar">
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                        <?= $playerTwo->health ?>
                    </span>
                    <ul>
                        <li>Name : <?= $playerTwo->name ?></li>
                        <li>Attaque : <?= $playerTwo->power ?></li>
                        <li>Mana : <?= $playerTwo->mana ?></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <form class="d-flex justify-content-center" action="./index.php" method="post">
                    <input name="restart" type="submit" value="Nouveau combat">
                </form>
            </div>
        </div>
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