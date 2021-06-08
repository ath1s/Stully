<?php
    session_start();
    require_once("../classes/Account.php");
    $status_change = new Account();

    if ($status_change->changeStatus($_SESSION["username"], $_GET["status"])) {
        header("Location: ../pages/timeline.php");
    } else {
        header("Location: ../pages/timeline.php");
    }
?>