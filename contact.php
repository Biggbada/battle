<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

require './classes/contact.class.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
dump($_ENV);
// dump(getenv());
// On vérifie que la méthode POST est utilisée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    dump($_POST);
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if (empty($_POST['recaptcha-response'])) {
        header('Location: index.php');
    } else {
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $_ENV['API_KEY'] . "&response={$_POST['recaptcha-response']}";

        // On vérifie si curl est installé
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        } else {
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }

        // On vérifie qu'on a une réponse
        if (empty($response) || is_null($response)) {
            header('Location: ./contact.php');
        } else {
            $data = json_decode($response);
            if ($data->success) {
                if (
                    isset($_POST['first-name']) && !empty(['first-name']) &&
                    isset($_POST['last-name']) && !empty(['last-name']) &&
                    isset($_POST['email']) && !empty(['email']) &&
                    isset($_POST['message']) && !empty(['message'])
                ) {
                    $nom = strip_tags($_POST['first-name']);
                    $prenom = strip_tags($_POST['last-name']);
                    $email = strip_tags($_POST['email']);
                    $message = htmlspecialchars($_POST['message']);


                    $submitedContact = new Contact($nom, $prenom, $email, $message);
                    $submitedContact = SPDO::setContact($nom, $prenom, $email, $message);
                    echo ('message de ' . $prenom .
                        ' envoyé');
                }
            } else {
                http_response_code(405);
                echo ('Méthode non autorisée');
            }
        }
    }
}
?>


<html>

<head>
    <title>Formulaire de contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LejS44nAAAAAMlhcZpX9rIKctRxch9MscVsOoy3"></script>
</head>

<body>
    <form action="./contact.php" method="POST" class="form-control" id="contact-form">
        <div class="row">
            <div class="col-6">
                <label for="first-name" class="form-label">Nom</label>
                <input type="text" name="first-name" id="first-name" class="form-control">
            </div>
            <div class="col-6">
                <label for="last-name" class="form-label">Prénom</label>
                <input type="text" name="last-name" id="last-name" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="email" class="form-label">email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
        </div>
        <div class="row">
            <label for="message" class="form-label">Votre message:</label>
            <input type="text" name="message" id="message" class="form-control">
        </div>
        <div class="row">
            <br />
            <button class="g-recaptcha" id="submit-btn" type="submit" name="submit-btn">Submit</button>
        </div>
        <input type="hidden" id="recaptchaResponse" name="recaptcha-response">


    </form>
    <script src="https://www.google.com/recaptcha/api.js?render=6LejS44nAAAAAMlhcZpX9rIKctRxch9MscVsOoy3"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LejS44nAAAAAMlhcZpX9rIKctRxch9MscVsOoy3', {
                action: 'contact'
            }).then(function(token) {
                console.log('test');
                document.getElementById('recaptchaResponse').value = token
            });
        });
    </script>
</body>

</html>