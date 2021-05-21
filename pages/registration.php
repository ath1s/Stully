<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stully - Registratie</title>
</head>
<body>
    <form method="POST" action="../php/verify_registration.php">
        <h1>Registratie</h1>
        <input type="text" placeholder="Gebruikersnaam" name="username">
        <input type="password" placeholder="Wachtwoord" name="password1">
        <input type="password" placeholder="Herhaling wachtwoord" name="password2">
        <input type="email" placeholder="E-mail" name="email">
        <input type="submit" value="Login">
        <?php
            echo "<h2 style='color:red;'>" . $_GET["error"] . "</h2>";
        ?>
    </form>
</body>
</html>