<?php
require_once 'classes/Account.php';

//Account testen

$username = "pan";
$password1 = "wachtwoord";
$password2 = "wachtwoord";
$email = "sAN@jaNsen.nl ";

$newpwd = "wechtwoord";

$mysqli = new Account();
$mysqli->register($username, $password1, $password2, $email);
//if ($mysqli->inloggen($username, $password1)) {
//    echo "logged in";
//}

if ($available = $mysqli->changeStatus($username, 'available')) {
    echo "<br>available users: ";
    foreach ($available as $user) {
        echo $user . "<br>";
    }
}

$mysqli->logout($username);