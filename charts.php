<?php
require_once __DIR__ . '/vendor/autoload.php';
// require './index.php';
require './functions.php';
require './classes/player.class.php';
require './classes/fight.class.php';
require './classes/db.class.php';
require './repository.php';
session_start();

// SELECT id_victory, COUNT(id_victory)
// FROM fights
// GROUP BY id_victory
// ORDER BY COUNT(*) DESC

// $players = SPDO::getPlayers($db);

// $players->fetchAll();
// dump($players);
// $fightsHistory = SPDO::getFights();
// foreach ($fightsHistory as $key => $fights) {
//     dump($fights['id_victory']);
//     # code...
// }
$db = SPDO::getInstance();


$dbquery = $db->prepare('SELECT id_victory, COUNT(id_victory) AS idv FROM fights GROUP BY id_victory ORDER BY COUNT(*) DESC');
// dump($bestPlayers);
$dbquery->execute();
// dump($bestPlayers);
// $bestPlayers->fetch();
// dump($bestPlayers);

$bestPlayers = $dbquery->fetchAll();
// $bestPlayers->fetch();
dump($bestPlayers);
foreach ($bestPlayers as  $bestPlayer) {
    echo ($bestPlayer['id_victory']);
}
?>

<head>
    <title>Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="public/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <div>
        <canvas id="myChart">


            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php  ?>,
                        datasets: [{
                            label: '# of Votes',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

        </canvas>
    </div>

</body>