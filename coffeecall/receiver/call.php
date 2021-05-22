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
            <video muted id="local-video" autoplay></video>
            <video id="remote-video" autoplay></video>
            <div class="call-action-div">
                <button onclick="muteVideo()">Mute Video</button>
                <button onclick="muteAudio()">Mute Audio</button>
            </div>
        </div>
        <script src="receiver.js"></script>
</body>
</html>