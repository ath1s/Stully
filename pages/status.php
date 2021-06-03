<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status->Call test</title>
</head>
<body>
    <form method="POST" action="../php/change_status.php">
        <label for="status">Kies je status: </label>
        <select name="status" id="status">
            <option value="offline">Offline</option>
            <option value="online">Online</option>
            <option value="available">Available</option>
        </select>
        <input type="submit" value="Verander status">
    </form>
    <br>
    <?php
        echo $_GET["error"] . $_GET["success"];
        require_once("../classes/Account.php");
        $status = new Account();

        if ($status->getStatus($_SESSION["username"]) == "available") {
            $_SESSION["available"] == true;
            if ($status->statusCheck()[0] == 'no-user') {
                echo "<a href='../coffeecall/sender/call.php?id=" . $_SESSION["username"] ."'>Maak call</a>";
            } else if (count($status->statusCheck()) < 2 && $status->statusCheck()[0] == $_SESSION["username"]) {
                echo "<a href='../coffeecall/sender/call.php?id=" . $_SESSION["username"] ."'>Maak call</a>";
            } else {
                echo "<a href='../coffeecall/receiver/call.php?id=" . $status->statusCheck()[0] ."'>Maak call</a>";
            }
        } else {
            echo "Verander je status naar 'available' om een call te maken!";
        }

    ?>
</body>
</html>