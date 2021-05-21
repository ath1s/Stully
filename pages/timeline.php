<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
</head>
<body>
        <?php
            require_once('../classes/Timeline.php');

            $timeline = new Timeline();
            
            for ($i = 0; $i < count($timeline->getPosts()); $i++) {
                echo "<table style='border:1px solid black'>";
                echo "<tr><td style='background-color:lightblue;'>" . $timeline->getPosts()[$i]["title"] . "</td></tr>";
                echo "<tr><td>" . $timeline->getPosts()[$i]["code"] . "</td></tr>";
                echo "<tr><td style='background-color:lightblue;'>" . $timeline->getPosts()[$i]["subtext"] . "</td></tr>";
                echo "<tr><td>" . $timeline->getPosts()[$i]["timestamp"] . "</td></tr>";
                echo "<tr><td style='background-color:lightblue;'><a href='post.php?id=" . $timeline->getPosts()[$i]["post_id"] . "'>antwoord</a></td></tr>";
                echo "</table><br>";
            ;}
        ?>
</body>
</html>