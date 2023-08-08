<?php
require_once __DIR__ . '/vendor/autoload.php';
require './classes/player.class.php';
require './classes/fight.class.php';
require './classes/db.class.php';

$players = SPDO::getPlayers();
?>


<html lang="fr">

<head>
    <title>Battle</title>
    <link rel="stylesheet" href="public/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="./index.js" defer></script>

</head>

<body>
    <div class="container">
        <audio id="fight-song" src="fight.mp3"></audio>
        <audio id="hadoudken-song" src="Haduken.mp3"></audio>
        <audio id="fatality-song" src="fatality.mp3"></audio>
        <h1 class="animate__animated animate__rubberBand">Battle</h1>
        <div id="prematch">
            <form id='formFight' action="attack.php" method="post">
                <div>
                    Joueur <br>
                    <div class="row">
                        <div class="col-6">
                            <select name="player-id" id="player1selector">
                                <option value="">Select player</option>

                                <?php foreach ($players as $player) { ?>
                                    <option value=<?= $player['id'] ?>><?= $player['name'] ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" required id="player-name" name="player-name">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Attaque</label>
                            <input type="number" class="form-control" value="100" required id="player-attaque" name="player-attaque">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Mana</label>
                            <input type="number" class="form-control" value="100" required id="player-mana" name="player-mana">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Santé</label>
                            <input type="number" class="form-control" value="100" required id="player-sante" name="player-sante">
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                    Adversaire <br>
                    <div class="row">
                        <div class="col-6">
                            <select name="adversaire-id" id="player2selector">
                                <option value="">Select player</option>

                                <?php foreach ($players as $player) { ?>
                                    <option value=<?= $player['id'] ?>><?= $player['name'] ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" required id="adversaire-name" name="adversaire-name">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Attaque</label>
                            <input type="number" class="form-control" value="100" required id="adversaire-attaque" name="adversaire-attaque">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Mana</label>
                            <input type="number" class="form-control" value="100" required id="adversaire-mana" name="adversaire-mana">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Santé</label>
                            <input type="number" class="form-control" value="100" required id="adversaire-sante" name="adversaire-sante">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="d-flex justify-content-center">
                        <input id="fight" name="fight" type="submit" value="FIGHT">
                    </div>
                </div>
            </form>
        </div>



</body>


</html>