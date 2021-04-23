<?php
require_once 'classes/Account.php';

//Registratie testen

$username = "janss";
$password1 = "wachtwoord";
$password2 = "wachtwoord";
$email = "jANs@jaNssssen.nl ";

$newpwd = "wechtwoord";

$mysqli = new Account();
$mysqli->register($username, $password1, $password2, $email);
if ($mysqli->inloggen($username, $newpwd)) {
    echo "logged in";
}
//if ($mysqli->resetPassword($username, $password1, $newpwd, $newpwd)) {
//    echo "wachtwoord veranderd";
//}