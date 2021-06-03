<?php
session_start();
require_once("../../classes/Account.php");
require_once("../../classes/Dbconnectie.php");
$status = new Account();
$status->changeStatus($_SESSION["username"], "oncall");
$status->changeStatus($_GET["id"], "oncall");
$_SESSION["username2"] = $_GET["id"];
?>

<!-- <!DOCTYPE html>
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
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - call</title>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/esm/popper-utils.js"></script>
    <script src="https://use.fontawesome.com/390a5dcccb.js"></script>
    <link rel="stylesheet" href="../../dist/css/main.css">
</head>
<body>
    <nav class="clearfix border nav-bgcolor">
        <button class="btn btn-secondary float-left m-2 shadow-sm" onclick="window.location.href = '../../pages/timeline.php'">
            Terug
        </button>
    </nav>

    <div class="modal fade" id="callModal">
        <div class="modal-post modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Call</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <button onclick="joinRoom();" class="btn btn-primary" data-toggle="modal" data-target="#callModal">Join room</button>
            </div>
            
        </div>
        </div>
    </div>

    <main class="container-fluid rounded main-bgcolor mh-100 pt-3 pb-3" style="height: 100vh;">
        <span style="display: none;" id="roomname"><?php echo $_GET['id']; ?></span>
        <div id="video-call-div" class="clearfix" style="width: 100vw;">
            <video class="float-left" muted id="local-video" autoplay></video>
            <video class="float-right" id="remote-video" autoplay></video>
            <div class="call-action-div"></div>
        </div>

        <!-- Control row -->
        <div class="row" id="control">
            <div class="col-sm mt-3">
                <button onclick="muteVideo();" class="btn btn-primary mr-3">Aan/uit video</button>
                <button onclick="muteAudio();" class="btn btn-primary mr-3">Demp microfoon</button>
                <button onclick="leaveRoom();" class="btn btn-outline-danger mr-3">Verlaat gesprek</button>
            </div>
        </div>
    </main>

    <script>
        const elControl = document.getElementById('control');
        elControl.style.visibility = 'hidden';

        function joinRoom() {
            joinCall();

            elControl.style.visibility = 'visible';
        }

        function leaveRoom() {
            muteAudio();
            muteVideo();

            window.location.href = '../../php/redirect1.php';
        }
    </script>
    
    <script src="receiver.js"></script>
    <script>
        $(document).ready(function() {
            $('#callModal').modal('show');
        });
    </script>
</body>
</html>