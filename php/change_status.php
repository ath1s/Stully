<?php
    session_start();
    require_once("../classes/Account.php");
    $status_change = new Account();

    if ($status_change->changeStatus($_SESSION["username"], $_POST["status"])) {
        header("Location: ../pages/status.php?succes=Je%20status%20is%20gewijzigd.");
    } else {
        header("Location: ../pages/status.php?error=Er%20is%20iets%20misgegaan.");
    }
?>