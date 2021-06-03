<?php
session_start();
require_once("../classes/Account.php");
$status_change = new Account();
$status_change->changeStatus($_SESSION["username"], "offline");
session_unset();
session_destroy();
header("Location:../index.php");