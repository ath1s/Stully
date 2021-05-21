<?php
require_once("../classes/Post.php");
session_start();
if($_SESSION["loggedin"] != true){
    header("Location:../index.php");
}
$post= new Post();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $converted = $post->htmlSpecialCharArray($_POST);
    $comment = $converted["comment"];
    $username = $converted["username"];
    $post_id = $converted["post_id"];
    if($post->addComment($comment,$username,$post_id) == true){
        header("refresh:0;url=post.php?id=$post_id");
    }else{
        var_dump($post);
    }
}
?>