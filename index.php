<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - Login</title>
</head>
<body>
    <form method="POST" action="php/verify_login.php">
        <h1>Login</h1>
        <input type="text" placeholder="Gebruikersnaam" name="username">
        <input type="password" placeholder="Wachtwoord" name="password">
        <input type="submit" value="Login">
        <?php
            echo "<h2 style='color:green;'>" . $_GET["accountmade"] . "</h2>";
            echo "<h2 style='color:red;'>" . $_GET["error"] . "</h2>";
        ?>
    </form>
    <p>heb je nog geen account <a href="pages/registration.php">account registeren</a></p>
</body>
</html>