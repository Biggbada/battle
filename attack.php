<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './classes/player.class.php';
require './classes/fight.class.php';
require './classes/db.class.php';
require './repository.php';
session_start();

$db = SPDO::getInstance();

//cas d'une entrée depuis le formulaire d'inscription des  joueurs
if (isset($_POST['fight'])) {
    // createDb($db);

    //player 1

    if (is_numeric($_POST["player-id"])) {
        // jai selectionner un player qui existe en base, j'ai l'id, faut que j'aille chercher le player en bdd
        $result = $db->prepare("SELECT * from players WHERE id=:id");
        $result->execute([':id' => $_POST['player-id']]);
        $selectedPlayer = $result->fetchAll();
        $playerOne = new Player($selectedPlayer[0]['name'], $selectedPlayer[0]['initial_mana'], $selectedPlayer[0]['initial_health'], $selectedPlayer[0]['initial_pow']);
    } else {
        //je verifie que le nom est pas deja existant en base
        $requete = $db->prepare("SELECT `name` FROM players WHERE name=:name");
        $requete->execute([':name' => $_POST['player-name']]);
        $searchedPlayer = $requete->fetch();
        $exist = is_array($searchedPlayer);

        if ($exist) {
            // je retourne sur la page je previent le mec ca existe deja
            header('Location: ./index.php?error=exist');
            echo ('le player ' . $_POST['player-name'] . " existe déja");
        } else {
            // j'ai des info sur toutes les data du player et faut que je le créer en base
            $playerOne = new Player($_POST['player-name'], $_POST['player-attaque'], $_POST['player-mana'], $_POST['player-sante'],);
            $insert = $db->prepare('INSERT INTO players(`name`, initial_mana, initial_health, initial_pow) VALUES(:playerName, :mana, :health, :power)');
            $insert->bindParam(':playerName', $playerOne->name);
            $insert->bindParam(':mana', $playerOne->mana);
            $insert->bindParam(':health', $playerOne->health);
            $insert->bindParam(':power', $playerOne->power);
            $insert->execute();
        }
    }


    //player 2

    if (is_numeric($_POST["adversaire-id"])) {
        // jai selectionner un player qui existe en base, j'ai l'id, faut que j'aille chercher le player en bdd
        $result = $db->query("SELECT * from players WHERE id=" . $_POST["adversaire-id"]);
        $selectedPlayer = $result->fetchAll();
        $playerTwo = new Player($selectedPlayer[0]['name'], $selectedPlayer[0]['initial_mana'], $selectedPlayer[0]['initial_health'], $selectedPlayer[0]['initial_pow']);
    } else {
        //je verifie que le nom est pas deja existant en base
        $requete = $db->prepare("SELECT `name` FROM players WHERE name=:name");
        $requete->execute([':name' => $_POST['adversaire-name']]);
        $searchedPlayer = $requete->fetch();
        $exist = is_array($searchedPlayer);
        // $exist = false;

        if ($exist) {
            // je retourne sur la page je previent le mec ca existe deja
            header('Location: ./index.php');
            echo ('le player ' . $_POST['player-name'] . " existe déja");
        } else {
            // j'ai des info sur toutes les data du player et faut que je le créer en base
            $playerTwo = new Player($_POST['adversaire-name'], $_POST['adversaire-attaque'], $_POST['adversaire-mana'], $_POST['adversaire-sante'],);
            $insert = $db->prepare('INSERT INTO players(`name`, initial_mana, initial_health, initial_pow) VALUES(:playerName, :mana, :health, :power)');
            $insert->bindParam(':playerName', $playerTwo->name);
            $insert->bindParam(':mana', $playerTwo->mana);
            $insert->bindParam(':health', $playerTwo->health);
            $insert->bindParam(':power', $playerTwo->power);
            $insert->execute();
        }
    }
    // $createFight = $db->prepare('INSERT INTO fights (id_p2) VALUES (:id_pl2)');
    // $createFight->execute([':id_pl2' => $selectedPlayer[0]['id']]);

    // créer un fight avec player et adversaire

    $findFighters = $db->prepare('SELECT * FROM players WHERE name=:name1 OR name=:name2');
    $findFighters->execute([':name1' => $playerOne->name, ':name2' => $playerTwo->name]);
    $fighters = $findFighters->fetchAll();
    $createFight = $db->prepare('INSERT INTO fights (id_p1, id_p2) VALUES (:id_pl1, :id_pl2)');
    $createFight->execute([':id_pl1' => $fighters[0]['id'], ':id_pl2' => $fighters[1]['id']]);
    $fightID = intval($db->lastInsertId());

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

//cas d'une arrive depuis un clic sur attaque




if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['attaque'])) {
    // $selectDatas = $db->query('SELECT * FROM players');
    // $datas = $selectDatas->fetchAll();
    $playerOne = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
    $playerTwo = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']);
    $playerOne->attack($playerTwo);
    $random = rand(0, 1);
    $_SESSION['p2_mana'] = $playerTwo->mana;
    $_SESSION['p2_health'] = $playerTwo->health;
    // todo 

    if ($playerTwo->health <= 0) {

        header('Location: ./resultat.php');
    }
    if (($playerTwo->health < 50) && ($random === 1)) {
        $iscured = $playerTwo->cure();
        if ($iscured === false) {
            $playerTwo->attack($playerOne);
            $_SESSION['p1_mana'] = $playerOne->mana;
            $_SESSION['p1_health'] = $playerOne->health;
        }
    } else {
        $playerTwo->attack($playerOne);
        $_SESSION['p1_mana'] = $playerOne->mana;
        $_SESSION['p1_health'] = $playerOne->health;
        if ($playerOne->health <= 0) {
            header('Location: ./resultat.php');
        }
    }
    // SPDO::updateDB($db, $playerOne, $playerTwo);
    if (isset($_SESSION['log'])) {
        $_SESSION['log'] = ($_SESSION['log'] . " / " . $playerOne->comment . " / " . $playerTwo->comment . " / ");
    } else {
        $_SESSION['log'] = ($playerOne->comment . " / " . $playerTwo->comment . " / ");
    }
}

//cas d'une arrivée depuis un clic sur se soigner
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['soin'])) {
    $playerOne = new Player($_SESSION['p1_name'], $_SESSION['p1_pow'], $_SESSION['p1_mana'], $_SESSION['p1_health']);
    $playerTwo = new Player($_SESSION['p2_name'], $_SESSION['p2_pow'], $_SESSION['p2_mana'], $_SESSION['p2_health']);

    $isCured = $playerOne->cure();
    $_SESSION['p1_mana'] = $playerOne->mana;
    $_SESSION['p1_health'] = $playerOne->health;

    if ($isCured === false) {
        $playerOne->attack($playerTwo);
        if ($playerTwo->health <= 0) {

            header('Location: ./resultat.php');
        }
        if (($playerTwo->health < 50) && ($random === 1)) {
            $iscured = $playerTwo->cure();
            if ($iscured === false) {
                $playerTwo->attack($playerOne);
                $_SESSION['p1_mana'] = $playerOne->mana;
                $_SESSION['p1_health'] = $playerOne->health;
            }
        } else {
            $playerTwo->attack($playerOne);
            $_SESSION['p1_mana'] = $playerOne->mana;
            $_SESSION['p1_health'] = $playerOne->health;
            if ($playerOne->health <= 0) {
                header('Location: ./resultat.php');
            }
        }

        $playerOne->attack($playerTwo);
    } else {
        $playerTwo->attack($playerOne);
        $_SESSION['player1'] = $playerOne;

        if ($playerOne->health < 0) {
            echo "end of game";
            header('Location: ./resultat.php');
        }
    }
    // SPDO::updateDB($db, $playerOne, $playerTwo);
}

dump("player one", $playerOne);
dump("player two", $playerTwo);

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
                    <img id="player" src="https://api.dicebear.com/6.x/avataaars/svg?accessoriesProbability=0&flip=false&seed=<?= $playerOne->name ?>&backgroundColor=b6e3f4" alt="Avatar" class="avatar float-end">
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
            <div id="combats">
                <h2>Combat</h2>
                <ul>


                    <?php if (isset($playerOne->comment)) { ?>
                        <li><i class="fa-solid fa-khanda p-1"><?= $playerOne->comment ?></i></li><?php } ?>
                    <?php if (isset($playerTwo->comment)) { ?>
                        <li><i class="fa-solid fa-khanda p-1"><?= $playerTwo->comment ?></i></li><?php } ?>
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