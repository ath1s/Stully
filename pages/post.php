<?php
session_start();
if($_SESSION["loggedin"] != true){
    header("Location:../index.php");
}
require_once('../classes/Dbconnectie.php');

require_once('../classes/Post.php');
$post = new Post();
$show = $post->showPost(htmlspecialchars($_GET["id"]));
$postaccountid = $show[0]["account_id"];
$postid = $show[0]["post_id"];

$conn = new Dbconnectie();
$mysql = $conn->getConnection();
$stmt = $mysql->prepare("SELECT username FROM account WHERE account_id = (SELECT account_id FROM posts where post_id = ?);");
$stmt->bind_param("i", htmlspecialchars($_GET["id"]));
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - <?php echo $row["username"];?>'s post</title>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/esm/popper-utils.js"></script>
    <script src="https://use.fontawesome.com/390a5dcccb.js"></script>
    <link rel="stylesheet" href="../dist/css/main.css">
    <link rel="stylesheet" href="../styles/post.css">
</head>
<body>
    <nav class="clearfix border nav-bgcolor">
        <form action="../php/logout.php">
            <button class="btn btn-outline-secondary float-left m-2 shadow-sm" type="submit" value="Logout">
                Logout
            </button>
        </form>

        <button class="btn btn-secondary float-left m-2 shadow-sm" onclick="window.location.href = 'timeline.php'">
            Terug
        </button>
        
        <button type="button" onclick="window.location.href = 'status.php'" class="btn btn-primary float-right m-2 shadow-sm">
            Video call
        </button>
    </nav>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-post modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Weet je het zeker?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <!-- Delete button -->
                    <form action="../php/delete.php" method="post">
                        <input type='hidden' name='accountid' value='<?php echo $accountid; ?>'>
                        <input type='hidden' name='postid' value='<?php echo $postid; ?>'>
                        <!-- Annuleer button -->
                        <button class="btn btn-primary shadow-sm mr-3" data-dismiss="modal">Annuleer</button>
                        <button class="btn btn-outline-danger shadow-sm" type='submit' name='delete' value='Delete'>Verwijder</button>
                    </form>
                </div>

            </div>
            
        </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-post modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Edit je probleem</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">

                <form action="../php/edit.php" method="post">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input class="form-control" type='text' name='title' placeholder='Verander je titel:' value='<?php echo $show[0]["title"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for="code">Probleem:</label>
                        <input class="form-control" type='text' name='code' placeholder='verander je code' value='<?php echo $show[0]["code"]; ?>'>
                    </div>
                    <div class="form-group">
                        <label for="subtext">Beschrijving:</label>
                        <input class="form-control" type='text' name='subtext' placeholder='verander je beschrijving' value='<?php echo $show[0]["subtext"]; ?>'>
                    </div>

                    <!-- Edit button -->
                    <input type='hidden' name='accountid' value='<?php echo $accountid; ?>'>
                    <input type='hidden' name='postid' value='<?php echo $postid; ?>'>
                    <input class="btn btn-primary shadow-sm" type='submit' name='edit' value='Edit'>

                    <!-- Delete modal button -->
                    <button class="btn btn-outline-danger shadow-sm float-right" type="button" data-toggle="modal" data-target="#deleteModal" data-dismiss="modal">Delete</button>
                    
                </form>

            </div>
            
        </div>
        </div>
    </div>

    <!-- React Modal -->
    <div class="modal fade" id="reactModal">
        <div class="modal-post modal-dialog modal-lg">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reageer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="comment.php">
                    <div class="form-group">
                        <label for="title">Comment:</label>
                        <input class="form-control" type="text" placeholder="Plaats uw comment:" name="comment">
                    </div>
                    <input type="hidden" name="username" value="<?echo $_SESSION["username"];?>">
                    <input type="hidden" name="post_id" value="<?echo htmlspecialchars($_GET["id"]);?>">

                    <button class="btn btn-primary" type="submit" name="upload" value="comment">Reageer</button>
                </form>
            </div>
            
        </div>
        </div>
    </div>
    <main class="container-fluid rounded main-bgcolor mh-100 pt-3 pb-3">

        <?php

                echo '<div class="card w-75 m-3 shadow-sm" style="background: white; opacity: none;">';
                echo '<div class="card-header">';
                echo '<h4 class="card-title">' . $show[0]["title"] . '</h4>';
                echo '<h5 class="card-subtitle text-muted"> Aangemaakt door: ' . $row["username"] . '</h5>';
                echo '</div>';
                echo '<div class="card-body">';
                echo '<p class="card-text"><strong>Probleem: </strong>' . $show[0]["code"] . '</p>';
                echo '<p class="card-text"><strong>Beschrijving: </strong>' . $show[0]["subtext"] . '</p>';
                echo '<p class="card-text text-info">' . $show[0]["timestamp"] . '</p>';
                echo '</div>';
                echo '</div>';
            
            ?> 

        <div class="row ml-3">

            <!-- React button -->
            <button class="btn btn-primary shadow-sm mr-3" data-toggle="modal" data-target="#reactModal">Reageer</button>
            
            <!-- Edit button -->
            <?php 
                $accountid = $post->getAccountId($_SESSION['username']);
                if ($accountid == $postaccountid
            //                voor wanneer roles worden gebruikt
            //                || $post->getAccountRole($_SESSIONs['username']) == 'admin'
                ) {
                    // Edit button
                    echo '<button class="btn btn-outline-primary shadow-sm mr-3" data-toggle="modal" data-target="#editModal">Edit</button>';
                }

            ?>

        </div>
        
        <div class="container ml-0 mt-5 mb-4" style="width: 225px;">
            <h4>Comments:</h4>
        </div>

        <div class="post-bgcolor rounded">

            <?php

            $comments = $post->showComments(htmlspecialchars($_GET["id"]));
            if (!empty($comments)) {
                foreach ($comments as $comment) {

                    $stmt = $mysql->query("SELECT username FROM account WHERE account_id = " . $comment['account_id'] . ";");
                    $commentaccount = $stmt->fetch_array(MYSQLI_ASSOC)["username"];

                    echo '<div class="card w-50 m-3 shadow-sm" style="background: white; opacity: none;">';
                    echo '<div class="card-header">';
                    echo '<h5 class="card-title m-n1">' . $commentaccount . '</h5>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<p class="card-text">' . $comment["comment"] . '</p>';
                    echo '<p class="card-text text-muted">Upvotes: ' . $comment["punten"] . '</p>';
                    echo '<p class="card-text text-info">' . $show[0]["timestamp"] . '</p>';
                    echo " <form action='../php/vote.php' method='post'>
                    <input type='hidden' name='post_id' value='" . $_GET["id"] . "'>
                    <input type='hidden' name='id' value='" . $comment["comment_id"] . "'>
                    <input type='hidden' name='vote' value='upvote'>
                    <input class='btn btn-outline-primary' type='submit' value='Upvote'>
                    </form></tr></td>";
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="card-body p-3"><h5>Maak de eerste comment!</h5></div>';
            }
        ?>
        </div>
    </main>
</body>
</html>