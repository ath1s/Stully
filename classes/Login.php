<?php
require_once 'Dbconnectie.php';

class Login
{
    private $mysqli;

    public function __construct()
    {
        $con = new Dbconnectie();
        $this->mysqli = $con->getConnection();
    }

    public function inloggen($username, $password)
    {
        $stmt = $this->mysqli->prepare("SELECT password_hash FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(password_verify($password,$row["password_hash"])){
                return true;
            }else{
                return false;
            }
        } else {
            return $this->mysqli->error;
        }
    }
}