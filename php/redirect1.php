<?php
session_start();
require_once("../classes/Account.php");
$status = new Account;
if($_SESSION["loggedin"] == true){
    if($status->getStatus($_SESSION["username"]) == "oncall" || $status->getStatus($_SESSION["username"]) == "available"){
        $status->changeStatus($_SESSION["username"], "online");
        $status->changeStatus($_SESSION["username2"], "online");
        header("location:../pages/status.php");
    }else{
        header("Location:../pages/status.php");
    }
}else{
    header("location:../index.php");
}