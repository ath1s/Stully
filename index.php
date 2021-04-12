<?php
require_once 'classes/Dbconnectie.php';

//Database connectie testen
$mysqli = new Dbconnectie();
if ($mysqli->connect_error) {
    echo "Not connected, error: " . $mysqli->connect_error;
}
else {
    echo "Connected.";
}