<?php
require_once("../classes/Posts.php");
session_start();
if($_SESSION["loggedin"] != true){
    header("Location:../index.php");
}
$post= new Post();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $comment = htmlspecialchars($_POST["comment"]);
    $username = htmlspecialchars($_POST["username"]);
    $post_id = htmlspecialchars($_POST["post_id"]);
    if($post->addComment($comment,$username,$post_id) == true){
        header("refresh:0;url=post.php?id=$post_id");
    }else{
        var_dump($post);
    }
}
?>