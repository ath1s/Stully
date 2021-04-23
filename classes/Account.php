<?php
require_once 'Dbconnectie.php';

class Account
{
    private $mysqli;

    public function __construct()
    {
        $con = new Dbconnectie();
        $this->mysqli = $con->getConnection();
    }

    public function register($username, $password1, $password2, $email)
    {
        if ($password1 === $password2) {
            if ($this->checkDuplicateEmail($email) && $this->checkDuplicateUsername($username)) {
                $username = trim($this->mysqli->real_escape_string($username));
                $password = $this->mysqli->real_escape_string($password1);
                $email = trim(strtolower($this->mysqli->real_escape_string($email)));
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->mysqli->prepare("INSERT INTO account(username, password_hash, email, punten, status)VALUES(?, ?, ?, 0, 'offline')");
                $stmt->bind_param("sss", $username, $hash, $email);
                if ($stmt->execute()) {
                    return true;
                } else {
                    return $this->mysqli->error;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkDuplicateEmail($email)
    {
        $email = trim(strtolower($this->mysqli->real_escape_string($email)));
        $stmt = $this->mysqli->prepare("SELECT email FROM account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkDuplicateUsername($username)
    {
        $username = trim($this->mysqli->real_escape_string($username));
        $stmt = $this->mysqli->prepare("SELECT username FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
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

    public function resetPassword($username)
    {

    }
}