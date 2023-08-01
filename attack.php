<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './classes/player.class.php';
require './classes/db.class.php';

// session_start();


$db = SPDO::getInstance();

//cas d'une entrée depuis le formulaire d'inscription des  joueurs
if (($_SERVER['REQUEST_METHOD'] == 'POST') && !isset($_POST['attaque']) && !isset($_POST['soin']) && !isset($_POST['restart'])) {
    $playerOne = new Player($_POST['player-name'], $_POST['player-attaque'], $_POST['player-mana'], $_POST['player-sante']);
    $playerTwo = new Player($_POST['adversaire-name'], $_POST['adversaire-attaque'], $_POST['adversaire-mana'], $_POST['adversaire-sante']);


    $db->query('CREATE TABLE `players` (
        `playerName` VARCHAR(25) NOT NULL,
        `power` INT NOT NULL,
        `mana` INT NOT NULL,
        `health` INT NOT NULL,
        `comment` VARCHAR(150) NULL DEFAULT NULL
    )');
    $dbInsertPlayer = $db->prepare("INSERT INTO players(playerName, power, mana, health) VALUES (:playerName, :power, :mana, :health)");
    $dbInsertPlayer->bindParam(':playerName', $_POST['player-name']);
    $dbInsertPlayer->bindParam(':power', $_POST['player-attaque']);
    $dbInsertPlayer->bindParam(':mana', $_POST['player-mana']);
    $dbInsertPlayer->bindParam(':health', $_POST['player-sante']);
    $dbInsertPlayer->execute();
    $dbInsertAdversaire = $db->prepare("INSERT INTO players(playerName, power, mana, health) VALUES (:playerName, :power, :mana, :health)");
    $dbInsertAdversaire->bindParam(':playerName', $_POST['adversaire-name']);
    $dbInsertAdversaire->bindParam(':power', $_POST['adversaire-attaque']);
    $dbInsertAdversaire->bindParam(':mana', $_POST['adversaire-mana']);
    $dbInsertAdversaire->bindParam(':health', $_POST['adversaire-sante']);
    $dbInsertAdversaire->execute();

    // dump($db);
    $selectDatas = $db->query('SELECT * FROM players');
    $datas = $selectDatas->fetchAll();

    // dump($datas);
    echo $datas[0]['playerName'];
}

//cas d'une arrive depuis un clic sur attaque
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['attaque'])) {
    $selectDatas = $db->query('SELECT * FROM players');
    $datas = $selectDatas->fetchAll();
    $playerOne = new Player($datas[0]['playerName'], $datas[0]['power'], $datas[0]['mana'], $datas[0]['health']);
    $playerTwo = new Player($datas[1]['playerName'], $datas[1]['power'], $datas[1]['mana'], $datas[1]['health']);

    $playerOne->attack($playerTwo);
    $random = rand(0, 1);
    // dump($random);

    if ($playerTwo->health <= 0) {
        header('Location: ./resultat.php');
    }
    if (($playerTwo->health < 50) && ($random === 1)) {
        $iscured = $playerTwo->cure();
        if ($iscured === false) {
            $playerTwo->attack($playerOne);
        }
    } else {
        $playerTwo->attack($playerOne);
        $_SESSION['player1'] = $playerOne;
        if ($playerOne->health <= 0) {
            echo "end of game";
            header('Location: ./resultat.php');
        }
    }
    SPDO::updateDB($db, $playerOne, $playerTwo);
}

//cas d'une arrivée depuis un clic sur se soigner
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['soin'])) {
    $selectDatas = $db->query('SELECT * FROM players');
    $datas = $selectDatas->fetchAll();
    $playerOne = new Player($datas[0]['playerName'], $datas[0]['power'], $datas[0]['mana'], $datas[0]['health']);
    $playerTwo = new Player($datas[1]['playerName'], $datas[1]['power'], $datas[1]['mana'], $datas[1]['health']);
    $isCured = $playerOne->cure();
    if ($isCured === false) {
        return;
    } else {
        $playerTwo->attack($playerOne);
        $_SESSION['player1'] = $playerOne;

        if ($playerOne->health < 0) {
            echo "end of game";
            header('Location: ./resultat.php');
        }
    }
    SPDO::updateDB($db, $playerOne, $playerTwo);
}




// if (isset($_SESSION['player1'])) {
//     $playerOne = $_SESSION['player1'];
//     $playerTwo = $_SESSION['player2'];
//     if (($playerOne->health < 0) || ($playerTwo->health < 0)) {
//         echo "end of game";
//         header('Location: ./resultat.php');
//     }
// }
// if (($_SERVER['REQUEST_METHOD'] == 'POST') && !isset($_POST['attaque']) && !isset($_POST['soin'])) {

//     $playerOne = new Player($_POST['player-name'], $_POST['player-attaque'], $_POST['player-mana'], $_POST['player-sante']);
//     $playerTwo = new Player($_POST['adversaire-name'], $_POST['adversaire-attaque'], $_POST['adversaire-mana'], $_POST['adversaire-sante']);
//     $_SESSION['player1'] = $playerOne;
//     $_SESSION['player2'] = $playerTwo;
// }
// if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['soin'])) {
//     $playerOne = $_SESSION['player1'];
//     $playerTwo = $_SESSION['player2'];
//     $isCured = $playerOne->cure();
//     if ($isCured === false) {
//         return;
//     } else {
//         $playerTwo->attack($playerOne);
//         $_SESSION['player1'] = $playerOne;

//         if ($playerOne->health < 0) {
//             echo "end of game";
//             header('Location: ./resultat.php');
//         }
//     }
// }
?>

<div id="match" class="row gx-5">
    <h2>Match</h2>
    <div class="col-6 ">
        <div class="position-relative float-end">
            <img id="player" src="https://api.dicebear.com/6.x/lorelei/svg?flip=false&seed=test" alt="Avatar" class="avatar float-end">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

            </span>
            <ul>
                <li>Name : <?= $playerOne->name ?></li>
                <li>Attaque : <?= $playerOne->power ?></li>
                <li>Mana : <?= $playerOne->mana ?></li>
                <li>Vie : <?= $playerOne->health ?></li>
            </ul>
        </div>
    </div>
    <div class="col-6" id="adversaire">
        <div class="position-relative float-start">
            <img src="https://api.dicebear.com/6.x/lorelei/svg?flip=true&seed=test2" alt="Avatar" class="avatar">
            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">

            </span>
            <ul>
                <li>Name : <?= $playerTwo->name ?></li>
                <li>Attaque : <?= $playerTwo->power ?></li>
                <li>Mana : <?= $playerTwo->mana ?></li>
                <li>Vie : <?= $playerTwo->health ?></li>
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
    <!-- <script>
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
    </script> -->