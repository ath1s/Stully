<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && $_POST['edit'] == 'Edit') {
    if (!empty($_POST['title']) && !empty($_POST['code']) && !empty($_POST['subtext'])) {
        require_once('../classes/Post.php');
        $post = new Post();
        $converted = $post->htmlSpecialCharArray($_POST);
        if ($post->editPost($_POST['postid'], $converted)) {
            header("Location: ../pages/post.php?id=" . $_POST['postid']);
        }
    }
    echo "er is iets mis gegaan<br>";
    echo "<a href='../pages/timeline.php '>Ga naar de timeline</a>";
} else {
    header("Location: ../pages/timeline.php");
}