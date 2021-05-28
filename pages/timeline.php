<?
session_start();
if($_SESSION["loggedin"] != true){
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - Timeline</title>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/esm/popper-utils.js"></script>
    <script src="https://use.fontawesome.com/390a5dcccb.js"></script>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <nav class="clearfix border nav-bgcolor">
        <form action="../php/logout.php">
            <button class="btn btn-secondary float-left m-2 shadow-sm" type="submit" value="Logout">
                Logout
            </button>
        </form>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary float-right m-2 shadow-sm" data-toggle="modal" data-target="#postModal">
            Post
        </button>
        
        <button type="button" onclick="window.location.href = 'status.php'" class="btn btn-primary float-right m-2 shadow-sm">
            Video call
        </button>
    </nav>

    <!-- The Modal -->
    <div class="modal fade" id="postModal">
        <div class="modal-post modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Post je probleem</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input class="form-control" type="text" placeholder="Voer je titel in:" name="title">
                    </div>
                    <div class="form-group">
                        <label for="code">Probleem:</label>
                        <textarea class="form-control" type="text" placeholder="Voer je probleem in:" name="code"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="subtext">Beschrijving:</label>
                        <textarea class="form-control" type="text" placeholder="Voer je beschrijving in:" name="subtext"></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit" name="upload" value="Post">Post</button>
                </form>
            </div>
            
        </div>
        </div>
    </div>

    <main class="container-fluid rounded main-bgcolor mh-100 pt-3">
        <div class="row">
            <div class="col-sm-auto">
                <aside class="container rounded border border-dark">
                    <div class="container">
                        Placeholder
                    </div>
                </aside>
            </div>
            <div class="col-lg-10">
                <div class="container post-bgcolor rounded mx-auto scroll-post">
                    <?php
                        require_once('../classes/Timeline.php');
                        require_once('../classes/Post.php');

                        $post = new Post();
                        
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['upload'] == 'Post') {
                            if(!empty($_POST["title"]) && !empty($_POST["code"] && !empty($_POST["subtext"]))){
                            $info = $post->htmlSpecialCharArray($_POST);
                            $post->createPost($_SESSION['username'], $info);
                            }
                        }

                        $timeline = new Timeline();
                        if (!empty($timeline->getPosts())) {
                            for ($i = 0; $i < count($timeline->getPosts()); $i++) {
                                echo '<div class="card mb-3 shadow-sm" style="background: white; opacity: none;">';
                                echo '<div class="card-body">';
                                echo '<h4 class="card-title">' . $timeline->getPosts()[$i]["title"] . '</h4>';
                                echo '<p class="card-text">' . $timeline->getPosts()[$i]["subtext"] . '</p>';
                                echo '<p class="card-text">' . $timeline->getPosts()[$i]["timestamp"] . '</p>';
                                echo '<a href="post.php?id=' . $timeline->getPosts()[$i]["post_id"] . '" class="card-link">React</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>