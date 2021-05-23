<?php
    session_start();
    require_once("../classes/Account.php");

    $verification = new Account();
    if ($verification->inloggen($_POST["username"], $_POST["password"])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $_POST["username"];
        $status_change = new Account();
        $status_change->changeStatus($_SESSION["username"], "online");
        header("Location: ../pages/timeline.php");
    } else {
        header("Location: ../index.php?error=Dit%20zijn%20de%20verkeerde%20gegevens.");
    }
?>