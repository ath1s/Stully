<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && $_POST['delete'] == 'delete') {
    require_once ('../classes/Post.php');
    $post = new Post();

    if ($post->deletePost($_POST['postid'])) {
        header("Location: ../pages/timeline.php");
    } else {
        echo "er is iets mis gegaan";
        echo "<a href='../pages/timeline.php '>Ga naar de timeline</a>";
    }
} else {

}