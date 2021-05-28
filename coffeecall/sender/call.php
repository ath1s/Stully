<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sender</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <button onclick="sendUsername()">Send</button>
    <button onclick="startCall()">Start Call</button>
    <span>Username: </span><span id="roomname"><?php echo $_GET['id']; ?></span>
    <div id="video-call-div">
            <video muted id="local-video" autoplay></video>
            <video id="remote-video" autoplay></video>
            <div class="call-action-div">
                <button onclick="muteVideo()">Mute Video</button>
                <button onclick="muteAudio()">Mute Audio</button>
                <button onclick="window.location.href='../../php/redirect1.php'">leave call</button>
            </div>
        </div>
        <script>
            console.log(document.getElementById("id").innerText);
        </script>
        <script src="sender.js"></script>
</body>
</html>