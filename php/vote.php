<?php
require_once ("../classes/Post.php");
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $post = new Post();

    if($_POST["vote"] == "upvote") {
        if ($post->upvote($_POST["id"])) {
            header("Location:../pages/post.php?id=" . $_POST["post_id"]);
        } else "er is iets mis gegaan";
    }
}
?>