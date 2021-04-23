<?php
require_once 'classes/Account.php';

//Registratie testen

$username = "jan ";
$password1 = "wachtwoord";
$password2 = "wachtwoord";
$email = "jAN@jaNsssen.nl ";

$mysqli = new Account();
$mysqli->register($username, $password1, $password2, $email);