<?php
session_start();

require_once("../classes/Account.php");

$status = new Account();

if ($status->getStatus($_SESSION["username"]) == "available") {
    $_SESSION["available"] == true;
    if ($status->statusCheck()[0] == 'no-user') {
        header("Location: ../coffeecall/sender/call.php?id=" . $_SESSION['username']);
    } else if (count($status->statusCheck()) <= 1 && $status->statusCheck()[0] == $_SESSION["username"]) {
        header("Location: ../coffeecall/sender/call.php?id=" . $_SESSION['username']);
    } else {
        header("Location: ../coffeecall/receiver/call.php?id=" . $status->statusCheck()[1]);
    }
}