<?php
require_once 'classes/Registration.php';

//Registratie testen

$username = "jan ";
$password1 = "wachtwoord";
$password2 = "wachtwoord";
$email = "jAN@jaNsen.nl ";

$mysqli = new Registration();
$mysqli->register($username, $password1, $password2, $email);