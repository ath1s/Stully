<?php
require_once("../classes/Posts.php");
$post= new Post();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $comment = htmlspecialchars($_POST["comment"]);
    $account_id = htmlspecialchars($_POST["id"]);
    $post_id = htmlspecialchars($_POST["post_id"]);
    if($post->addComment($comment,$account_id,$post_id) == true){
        header("refresh:0;url=post.php?id=$post_id");
    }else{
        var_dump($post);
    }
}
?>