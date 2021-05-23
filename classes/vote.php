<?php
require_once("Dbconnectie.php");
require_once ("Post.php");
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $con = new Dbconnectie();
    $mysql = $con->getConnection();

    $post = new Post();

    if($_POST["vote"] == "upvote"){
        $stmt = $mysql->prepare("UPDATE comments SET punten = punten + 1 WHERE comment_id = ?");
        $stmt->bind_param("i", $_POST["id"]);
        if($stmt->execute()){
            $stmt = $mysql->prepare("SELECT username FROM account WHERE account_id = (SELECT account_id FROM comments WHERE comment_id = ?)");
            $stmt->bind_param("i", $_POST["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $commentuser = $result->fetch_array(MYSQLI_ASSOC)['username'];

            $post->updatePoints($commentuser, 1);
            header("Location:../pages/post.php?id=" . $_POST["post_id"]);
        }else{
            echo "er is iets mis gegaan";
        }
    }
}
?>