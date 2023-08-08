<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './classes/player.class.php';
require './functions.php';
require './classes/fight.class.php';
require './classes/db.class.php';
require './repository.php';
session_start();

//cas d'une entrée depuis le formulaire d'inscription des  joueurs
if (isset($_POST['fight'])) {

    if (is_numeric($_POST["player-id"])) {
        // jai selectionner un player qui existe en base, j'ai l'id, faut que j'aille chercher le player en bdd
        $player = SPDO::getPlayer($_POST["player-id"]);
    } else {
        //je verifie que le nom est pas deja existant en base
        $player = SPDO::getPlayerByName($_POST["player-name"]);

        if ($player) {
            // je retourne sur la page je previent le mec ca existe deja
            header('Location: ./index.php?error=exist');
        } else {
            // j'ai des info sur toutes les data du player et faut que je le créer en base
            $player_id = SPDO::setPlayer($_POST["player-name"], $_POST["player-mana"], $_POST["player-health"], $_POST["player-power"]);
            $player = SPDO::getPlayer($player_id);
        }
    }

    if (is_numeric($_POST["adversaire-id"])) {
        // jai selectionner un player qui existe en base, j'ai l'id, faut que j'aille chercher le player en bdd
        $adversaire = SPDO::getPlayer($_POST["adversaire-id"]);
    } else {
        //je verifie que le nom est pas deja existant en base
        $adversaire = SPDO::getPlayerByName($_POST["adversaire-name"]);

        if ($adversaire) {
            // je retourne sur la page je previent le mec ca existe deja
            header('Location: ./index.php?error=exist');
        } else {
            // j'ai des info sur toutes les data du player et faut que je le créer en base
            $adversaire_id = SPDO::setPlayer($_POST["adversaire-name"], $_POST["adversaire-mana"], $_POST["adversaire-health"], $_POST["adversaire-power"]);
            $adversaire = SPDO::getPlayer($adversaire_id);
        }
    }

    $fight_id = SPDO::setFight($player, $adversaire);
    setSession([$player, $adversaire], $fight_id);
    dump($_SESSION);
}

//cas d'une arrive depuis un clic sur attaque




if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['attaque'])) {

    // dump($_SESSION['log']);
    // $selectDatas = $db->query('SELECT * FROM players');
    // $datas = $selectDatas->fetchAll();
    $player = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
    $adversaire = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']);
    $player->attack($adversaire);
    $random = rand(0, 1);
    $_SESSION['p2_mana'] = $adversaire->mana;
    $_SESSION['p2_health'] = $adversaire->health;
    if ($adversaire->health <= 0) {

        header('Location: ./resultat.php');
    }
    if (($adversaire->health < 50) && ($random === 1)) {
        $iscured = $adversaire->cure();
        if ($iscured === false) {
            $adversaire->attack($player);
            $_SESSION['p1_mana'] = $player->mana;
            $_SESSION['p1_health'] = $player->health;
        }
    } else {
        $adversaire->attack($player);
        $_SESSION['p1_mana'] = $player->mana;
        $_SESSION['p1_health'] = $player->health;
        if ($player->health <= 0) {
            header('Location: ./resultat.php');
        }
    }
    // SPDO::updateDB($db, $player, $adversaire);
    if (isset($_SESSION['log'])) {
        $_SESSION['log'] = ($_SESSION['log'] . " / " . $player->comment . " / " . $adversaire->comment . " / ");
    } else {
        $_SESSION['log'] = ($player->comment . " / " . $adversaire->comment . " / ");
    }
}

//cas d'une arrivée depuis un clic sur se soigner
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['soin'])) {
    $player = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
    $adversaire = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']);

    $isCured = $player->cure();
    $_SESSION['p1_mana'] = $player->mana;
    $_SESSION['p1_health'] = $player->health;

    if ($isCured === false) {
        $player->attack($adversaire);
        if ($adversaire->health <= 0) {

            header('Location: ./resultat.php');
        }
        if (($adversaire->health < 50) && ($random === 1)) {
            $iscured = $adversaire->cure();
            if ($iscured === false) {
                $adversaire->attack($player);
                $_SESSION['p1_mana'] = $player->mana;
                $_SESSION['p1_health'] = $player->health;
            }
        } else {
            $adversaire->attack($player);
            $_SESSION['p1_mana'] = $player->mana;
            $_SESSION['p1_health'] = $player->health;
            if ($player->health <= 0) {
                header('Location: ./resultat.php');
            }
        }

        $player->attack($adversaire);
    } else {
        $adversaire->attack($player);
        $_SESSION['player1'] = $player;

        if ($player->health < 0) {
            echo "end of game";
            header('Location: ./resultat.php');
        }
    }
    // SPDO::updateDB($db, $player, $adversaire);
}

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
        <div id="match" class="row gx-5">
            <h2>Match</h2>
            <div class="col-6 ">
                <div class="position-relative float-end">
                    <img id="player" src="https://api.dicebear.com/6.x/avataaars/svg?accessoriesProbability=0&flip=false&seed=<?= $player->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar float-end">
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
            <div id="combats">
                <h2>Combat</h2>
                <ul>


                    <?php if (isset($player->comment)) { ?>
                        <li><i class="fa-solid fa-khanda p-1"><?= $player->comment ?></i></li><?php } ?>
                    <?php if (isset($adversaire->comment)) { ?>
                        <li><i class="fa-solid fa-khanda p-1"><?= $adversaire->comment ?></i></li><?php } ?>
                    </li>

                </ul>
                <form id='actionForm' action="attack.php" method="post">
                    <div class="d-flex justify-content-center">
                        <input id="attaque" name="attaque" type="submit" value="Attaquer">
                        <input name="soin" type="submit" value="Se soigner">
                    </div>
                </form>
                <form action="./resultat.php" method="post" id="restart" name="restart">
                    <div class="d-flex justify-content-center">
                        <input id="restart" name="restart" type="submit" value="Stopper le combat">
                    </div>
                </form>
            </div>
            <style>
                .avatar {
                    vertical-align: middle;
                    width: 100px;
                    border-radius: 50%;
                }
            </style>
            <script>
                document.addEventListener("DOMContentLoaded", function() {


                    let submitAttaque = document.querySelector("#attaque");
                    let alreadyPlaySong = false;
                    if (submitAttaque) {
                        submitAttaque.addEventListener("click", function(event) {
                            if (alreadyPlaySong)
                                return true;
                            event.preventDefault();
                            let player = document.querySelector("#player")
                            player.classList.add("animate__animated");
                            player.classList.add("animate__rubberBand");
                            submitAttaque.classList.add("animate__animated");
                            submitAttaque.classList.add("animate__rubberBand");
                            setTimeout(function() {
                                submitAttaque.classList.remove("animate__rubberBand");
                                player.classList.remove("animate__rubberBand");
                            }, 1000);
                            let hadouken_song = document.getElementById("hadoudken-song");
                            hadouken_song.play();
                            alreadyPlaySong = true;
                            setTimeout(function() {
                                submitAttaque.click();
                            }, 1000);
                        })
                    }


                });
            </script>
        </div>
    </div>
</body>