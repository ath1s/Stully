<?php
require_once("Dbconnectie.php");
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $con = new Dbconnectie();
    $mysql = $con->getConnection();
    if($_POST["vote"] == "upvote"){
        $stmt = $mysql->prepare("UPDATE comments SET punten = punten + 1 WHERE comment_id = ?");
        $stmt->bind_param("i", $_POST["id"]);
        if($stmt->execute()){
            header("Location:../pages/post.php?id=" . $_POST["post_id"]);
        }else{
            echo "er is iets mis gegaan";
        }
    }
}
?>