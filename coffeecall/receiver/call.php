<?php
session_start();
require_once("../../classes/Account.php");
require_once("../../classes/Dbconnectie.php");
$status = new Account();
$status->changeStatus($_SESSION["username"], "oncall");
$status->changeStatus($_GET["id"], "oncall");
$_SESSION["username2"] = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<span>Username: </span><span id="roomname"><?php echo $_GET['id']; ?></span>
    <button onclick="joinCall()">Join Call</button>
        <div id="video-call-div">
            <video id="remote-video" autoplay></video>
            <video muted id="local-video" autoplay></video>
            <div class="call-action-div">
                <button onclick="muteVideo()">Mute Video</button>
                <button onclick="muteAudio()">Mute Audio</button>
                <button onclick="window.location.href='../../php/redirect2.php'">leave call</button>
            </div>
        </div>
        <script src="receiver.js"></script>
</body>
</html>