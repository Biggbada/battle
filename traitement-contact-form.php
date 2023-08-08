<?php
require './classes/contact.class.php';
// On vérifie que la méthode POST est utilisée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if (empty($_POST['recaptcha-response'])) {
        header('Location: index.php');
    } else {
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LcrJI0nAAAAAJ4XHQbQIq-TzaDRaqfgQ73AzhCa&response={$_POST['recaptcha-response']}";

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
            header('Location: index.php');
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
} else {
    http_response_code(405);
    echo 'Méthode non autorisée';
}
