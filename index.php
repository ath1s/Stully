<?php
session_start();
if($_SESSION["loggedin"] == true){
    header("Location:pages/timeline.php");
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/esm/popper-utils.js"></script>
    <script src="https://use.fontawesome.com/390a5dcccb.js"></script>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <div class="modal-dialog text-center">
        <div class="col-sm-9 main-section">
            <div class="modal-content">
                <div class="col-12 headtext">
                    <h1>Login</h1>
                </div>
                <div class="col-12 form-input">
                    <form method="POST" action="php/verify_login.php">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Gebruikersnaam">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Wachtwoord">
                        </div>
                        <input type="submit" class="btn btn-success" value="Login">
                    </form>
                </div>

                <div class="col-12 register">
                    <a href="pages/registration.php">Nog geen account? Registreer nu!</a>
                    <?php
                        echo "<p style='color:red;'>" . $_GET["error"] . "</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>