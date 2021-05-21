<?php
    session_start();
    require_once("../classes/Account.php");

    $verification = new Account();
    if ($verification->register($_POST["username"], $_POST["password1"], $_POST["password2"], $_POST["email"])) {
        header("Location: ../index.php?accountmade=Je%20account%20is%20aangemaakt.%20Je%20kan%20nu%20inloggen.");
    } else {
        header("Location: ../pages/registration.php?error=Dit%20zijn%20de%20verkeerde%20gegevens.");
    }
?>