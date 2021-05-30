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
        >
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
            <button class="btn btn-outline-secondary float-left m-2 shadow-sm" type="submit" value="Logout">
                Logout
            </button>
        </form>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary float-right m-2 shadow-sm" data-toggle="modal" data-target="#postModal">
            Post
        </button>
        
        <?php
            require_once("../classes/Account.php");

            $account = new Account();

            if ($account->getStatus($_SESSION["username"]) == 'available') {
                ?>
                    <button type="button" onclick="window.location.href = 'status.php'" class="btn btn-primary float-right m-2 shadow-sm">
                        Video call
                    </button>
                <?php
            } else {
                ?>
                    <button type="button" onclick="alert('Verander je status naar available om een call te maken!')" class="btn btn-disabled float-right m-2 shadow-sm">
                        Video call
                    </button>
                <?php
            }
        ?>
    </nav>

    <!-- Post Modal -->
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
                <aside class="container rounded border shadow-sm">
                    <div class="row pt-3 pl-1 pr-3">
                        <img class="col rounded-circle" style="height: 150px; width: 150px;" src="../assets/img/profile-placeholder.png" alt="Profile picture">
                    </div>
                    <div class="row pt-3 pl-1 pr-3">
                        <h4 class="col">Welkom, <?php echo $_SESSION['username'] ?></h4>
                    </div>
                    <div class="row pt-3 pl-3 pr-3">
                        <ul class="col list-group">
                            <li class="list-group-item">Bekijk profiel</li>
                            <li class="list-group-item">Instellingen</li>
                            <li class="list-group-item">Recente post</li>
                        </ul>
                    </div>
                    <div class="row pt-3 pl-1 pr-3">
                        <h5 class="col">Puntensaldo: </h5>
                        <p class="col">0</p>
                    </div>
                    <div class="row pt-3 pl-3 pr-3">
                        <button class="col btn btn-disabled shadow-sm mb-3" style="text-decoration: line-through;" onclick="alert('Coming soon!');">Ga naar shop</button>
                    </div>
                </aside>
            </div>
            <div class="col-lg-10">
                <div class="container post-bgcolor rounded mx-auto scroll-post">
                    <?php
                        require_once('../classes/Post.php');

                        $post = new Post();
                        
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['upload'] == 'Post') {
                            if(!empty($_POST["title"]) && !empty($_POST["code"] && !empty($_POST["subtext"]))){
                            $info = $post->htmlSpecialCharArray($_POST);
                            $post->createPost($_SESSION['username'], $info);
                            }
                        }

                    $posts = $post->getPosts();
                    if (!empty($posts)) {
                        foreach ($posts as $item) {
                                echo '<div class="card mb-3 shadow-sm" style="background: white; opacity: none;">';
                                echo '<div class="card-body">';

                                echo '<h4 class="card-title">' . $item["title"] . '</h4>';
                                echo '<p class="card-text">' . $item["code"] . '</p>';
                                echo '<p class="card-text">' . $item["subtext"] . '</p>';
                                echo '<p class="card-text text-info">' . $item["timestamp"] . '</p>';
                                echo '<a href="post.php?id=' . $item["post_id"] . '" class="btn btn-outline-primary">Reageer</a>';

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