<?php
require_once 'classes/Account.php';

//Account testen

$username = "san";
$password1 = "wachtwoord";
$password2 = "wachtwoord";
$email = "jAN@jaNsen.nl ";

$newpwd = "wechtwoord";

    $mysqli = new Account();
//    $mysqli->register($username, $password1, $password2, $email);
if ($mysqli->inloggen($username, $password1)) {
    echo "logged in<br>";
}

//$mysqli->resetPassword($username, $password1, $newpwd, $newpwd);

if ($match = $mysqli->changeStatus($username, 'available')) {
    echo "<br>You've been matched with: " . $match;
}
//echo $mysqli->getStatus($username);
//echo $mysqli->randomMatch($username);

$mysqli->logout($username);