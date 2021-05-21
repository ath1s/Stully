<?php
session_start();
if($_SESSION["loggedin"] != true){
    header("Location:../index.php");
}
require_once('../classes/Dbconnectie.php');
$conn = new Dbconnectie();
$mysql = $conn->getConnection();
$stmt = $mysql->prepare("SELECT username FROM account WHERE account_id = (SELECT account_id FROM posts where post_id = ?);");
$stmt->bind_param("i", htmlspecialchars($_GET["id"]));
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["username"];?>'s post</title>
</head>
<body>
        <?php
            require_once('../classes/Post.php');

            $post = new Post();
            if(count($post->showPost(htmlspecialchars($_GET["id"]))) > 0){
                $show = $post->showPost(htmlspecialchars($_GET["id"]));
                echo "<table style='border:1px solid black'>";
                echo "<tr><th style='font-size:30px;background-color:lightblue;'>" . $show[0]["title"] . "</th></tr>";
                echo "<tr><td style='font-size:15px;'>" . $row["username"] . "</td></tr>";
                echo "<tr><td style='font-size:20px;background-color:lightblue;'>" . $show[0]["code"] . "</td></tr>";
                echo "<tr><td style='font-size:20px;'>" . $show[0]["subtext"] . "</td></tr>";
                echo "<tr><td style='font-size:20px;background-color:lightblue;'>" . $show[0]["timestamp"] . "</td></tr>";
                echo "</table><br>";
            }
            if (!empty($post->showComments(htmlspecialchars($_GET["id"])))){
                for ($i = 0; $i < count($post->showComments(htmlspecialchars($_GET["id"]))); $i++) {
                    $stmt1 = $mysql->query("SELECT username FROM account WHERE account_id =" . $post->showComments(htmlspecialchars($_GET['id']))[$i]['account_id'] . ";");
                    $row = $stmt1->fetch_array(MYSQLI_ASSOC);
                    echo "<table style='border:1px solid black'>";
                    echo "<tr><td style='background-color:lightblue;'>" . $post->showComments(htmlspecialchars($_GET["id"]))[$i]["comment"] . "</td></tr>";
                    echo "<tr><td>" . $row["username"] . "</td></tr>";
                    echo "<tr><td style='background-color:lightblue;'>" . $post->showComments(htmlspecialchars($_GET["id"]))[$i]["punten"] . "</td></tr>";
                    echo"<tr><td>
                    <form action='../classes/vote.php' method='post'>
                    <input type='hidden' name='post_id' value='" . $_GET["id"] . "'>
                    <input type='hidden' name='id' value='" . $post->showComments(htmlspecialchars($_GET["id"]))[$i]["comment_id"] . "'>
                    <input type='hidden' name='vote' value='upvote'>
                    <input type='submit' value='upvote'>
                    </form></tr></td>";
                    echo "</table><br>";
                }
            } else {
                echo "Maak de eerste comment!";
            }
        ?>
        <form action="comment.php" method="post">
        <input type="text" name="comment" placeholder="zet hier uw comment">
        <input type="hidden" name="username" value="<?echo $_SESSION["username"];?>">
        <input type="hidden" name="post_id" value="<?echo htmlspecialchars($_GET["id"]);?>">
        <input type="submit" value="comment">
        </form>
</body>
</html>